<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\ActivityLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductionHardeningTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $librarian;
    protected User $member;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles and initial database
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $this->admin     = User::where('email', 'admin@librarygenz.com')->first();
        $this->librarian = User::where('email', 'librarian@librarygenz.com')->first();
        $this->member    = User::where('email', 'member@librarygenz.com')->first();
    }

    // -------------------------------------------------------------------------
    // 1. User Management Hardening & Filtering
    // -------------------------------------------------------------------------

    public function test_admin_can_filter_users_by_registration_date(): void
    {
        // Change registration date for the member directly in database to bypass Eloquent timestamp override
        \DB::table('users')->where('id', $this->member->id)->update(['created_at' => now()->subDays(5)]);

        // Filter: reg_from is today -> Member shouldn't be listed
        $response1 = $this->actingAs($this->admin)
            ->get(route('admin.users.index', ['reg_from' => now()->format('Y-m-d')]));
        $response1->assertOk();
        $response1->assertDontSee($this->member->email);

        // Filter: reg_from is 6 days ago -> Member should be listed
        $response2 = $this->actingAs($this->admin)
            ->get(route('admin.users.index', ['reg_from' => now()->subDays(6)->format('Y-m-d')]));
        $response2->assertOk();
        $response2->assertSee($this->member->email);
    }

    public function test_admin_users_index_uses_custom_confirm_modal(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));
        $response->assertOk();
        $response->assertSee('confirmAction(');
        $response->assertDontSee("onclick=\"return confirm('Nonaktifkan");
    }

    // -------------------------------------------------------------------------
    // 2. Borrowing Status Filtering
    // -------------------------------------------------------------------------

    public function test_borrowing_management_supports_status_filtering(): void
    {
        $books = Book::take(2)->get();
        $book1 = $books[0];
        $book2 = $books[1];

        // Create an approved loan
        $approvedBorrowing = Borrowing::create([
            'user_id' => $this->member->id,
            'book_id' => $book1->id,
            'status' => 'approved',
        ]);

        // Create a rejected loan
        $rejectedBorrowing = Borrowing::create([
            'user_id' => $this->member->id,
            'book_id' => $book2->id,
            'status' => 'rejected',
        ]);

        // Filter by approved status
        $responseApproved = $this->actingAs($this->librarian)
            ->get(route('borrowings.manage', ['status' => 'approved']));
        $responseApproved->assertOk();
        // Should see the approved loan in active tab
        $responseApproved->assertSee($book1->title);
        // Should not see the rejected loan's book title
        $responseApproved->assertDontSee($book2->title);
    }

    // -------------------------------------------------------------------------
    // 3. Fines Overdue Duration Filtering & Member Pagination
    // -------------------------------------------------------------------------

    public function test_member_fines_history_is_paginated(): void
    {
        $book = Book::first();
        
        // Seed 12 unpaid fines to trigger pagination (10 per page)
        for ($i = 0; $i < 12; $i++) {
            $borrowing = Borrowing::create([
                'user_id' => $this->member->id,
                'book_id' => $book->id,
                'status' => 'returned',
            ]);
            Fine::create([
                'borrowing_id' => $borrowing->id,
                'late_days' => 5,
                'amount' => 10000,
                'status' => 'unpaid',
            ]);
        }

        $response = $this->actingAs($this->member)->get(route('fines.history'));
        $response->assertOk();
        // Verify pagination links exist
        $response->assertSee('unpaid_page=2');
    }

    public function test_fines_management_supports_overdue_duration_filtering(): void
    {
        $book = Book::first();

        $borrowing1 = Borrowing::create([
            'user_id' => $this->member->id,
            'book_id' => $book->id,
            'status' => 'returned',
        ]);
        // 5 days late (1-7 days category)
        $fineShort = Fine::create([
            'borrowing_id' => $borrowing1->id,
            'late_days' => 5,
            'amount' => 10000,
            'status' => 'unpaid',
        ]);

        $borrowing2 = Borrowing::create([
            'user_id' => $this->member->id,
            'book_id' => $book->id,
            'status' => 'returned',
        ]);
        // 10 days late (8-14 days category)
        $fineMedium = Fine::create([
            'borrowing_id' => $borrowing2->id,
            'late_days' => 10,
            'amount' => 20000,
            'status' => 'unpaid',
        ]);

        // Filter: 1-7 days
        $responseShort = $this->actingAs($this->librarian)
            ->get(route('fines.manage', ['overdue_duration' => '1-7']));
        $responseShort->assertOk();
        $responseShort->assertSee('5 hari');
        $responseShort->assertDontSee('10 hari');

        // Filter: 8-14 days
        $responseMedium = $this->actingAs($this->librarian)
            ->get(route('fines.manage', ['overdue_duration' => '8-14']));
        $responseMedium->assertOk();
        $responseMedium->assertSee('10 hari');
        $responseMedium->assertDontSee('5 hari');
    }

    // -------------------------------------------------------------------------
    // 4. Validation Hardening: Max 3 Active Loans
    // -------------------------------------------------------------------------

    public function test_member_cannot_borrow_more_than_3_books_simultaneously(): void
    {
        $books = Book::take(4)->get();
        $this->assertGreaterThanOrEqual(4, $books->count(), 'Test requires at least 4 books in database.');

        // Create a fresh member without pre-seeded active borrowings
        $memberRole = Role::where('name', 'member')->first();
        $freshMember = User::factory()->create([
            'role_id' => $memberRole->id,
        ]);

        // Request 3 books successfully
        for ($i = 0; $i < 3; $i++) {
            $response = $this->actingAs($freshMember)
                ->post(route('borrowings.request', $books[$i]));
            $response->assertRedirect();
        }

        // Try requesting the 4th book and verify the max borrow limit error
        $response4 = $this->actingAs($freshMember)
            ->post(route('borrowings.request', $books[3]));
        
        $response4->assertRedirect();
        $response4->assertSessionHas('error', 'Batas maksimal peminjaman aktif adalah 3 buku. Selesaikan peminjaman Anda saat ini terlebih dahulu.');
    }

    // -------------------------------------------------------------------------
    // 5. Audit Log Coverage: Profile & Password Updates
    // -------------------------------------------------------------------------

    public function test_profile_update_is_logged_in_activity_log(): void
    {
        $response = $this->actingAs($this->member)->patch(route('profile.update'), [
            'name' => 'Rian Permana Updated',
            'email' => 'rian.updated@example.com',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->member->id,
            'activity_type' => 'settings',
            'description' => 'Pengguna Rian Permana Updated memperbarui informasi profilnya.',
        ]);
    }

    public function test_password_update_is_logged_in_activity_log(): void
    {
        $response = $this->actingAs($this->member)->put(route('password.update'), [
            'current_password' => 'password',
            'password' => 'NewPassword99',
            'password_confirmation' => 'NewPassword99',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->member->id,
            'activity_type' => 'settings',
            'description' => 'Pengguna Rian Permana memperbarui kata sandi akunnya.',
        ]);
    }

    // -------------------------------------------------------------------------
    // 6. PDF Export Filtering Alignment
    // -------------------------------------------------------------------------

    public function test_pdf_user_export_aligns_with_filters(): void
    {
        // Access user export with status filter
        $response = $this->actingAs($this->admin)->get(route('reports.export.users', ['status' => 'active']));
        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_pdf_book_export_aligns_with_filters(): void
    {
        // Access book export with search filter
        $response = $this->actingAs($this->admin)->get(route('reports.export.books', ['search' => 'Laravel']));
        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }
}
