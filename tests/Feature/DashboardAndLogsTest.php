<?php

use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\ActivityLog;

beforeEach(function () {
    // Seed roles and initial data
    $this->seed(\Database\Seeders\DatabaseSeeder::class);
    
    // Retrieve seeded accounts
    $this->admin = User::where('email', 'admin@librarygenz.com')->first();
    $this->librarian = User::where('email', 'librarian@librarygenz.com')->first();
    $this->member = User::where('email', 'member@librarygenz.com')->first();
});

test('dashboards display correct real-time metrics for each role', function () {
    // 1. Admin Dashboard
    $responseAdmin = $this->actingAs($this->admin)->get(route('admin.dashboard'));
    $responseAdmin->assertStatus(200);
    $responseAdmin->assertSee('Admin LibraryGenz'); // Checks database username rendering
    $responseAdmin->assertSee('Total Pengguna');
    $responseAdmin->assertSee('Log Aktivitas Sistem');

    // 2. Librarian Dashboard
    $responseLibrarian = $this->actingAs($this->librarian)->get(route('librarian.dashboard'));
    $responseLibrarian->assertStatus(200);
    $responseLibrarian->assertSee('Ahmad Pustakawan');
    $responseLibrarian->assertSee('Katalog Buku');
    $responseLibrarian->assertSee('Persetujuan Pending');

    // 3. Member Dashboard
    $responseMember = $this->actingAs($this->member)->get(route('member.dashboard'));
    $responseMember->assertStatus(200);
    $responseMember->assertSee('Rian Permana');
    $responseMember->assertSee('Katalog Tersedia');
    $responseMember->assertSee('Sedang Dipinjam');
});


test('reports page authorization and data loading works', function () {
    // Admin has access
    $responseAdmin = $this->actingAs($this->admin)->get(route('reports.index'));
    $responseAdmin->assertStatus(200);
    $responseAdmin->assertSee('Analitik Data');
    $responseAdmin->assertSee('Tren Peminjaman Buku');


    // Librarian has access
    $responseLibrarian = $this->actingAs($this->librarian)->get(route('reports.index'));
    $responseLibrarian->assertStatus(200);

    // Member is forbidden
    $responseMember = $this->actingAs($this->member)->get(route('reports.index'));
    $responseMember->assertStatus(403);
});

test('activity logs page authorization and audit list works', function () {
    // Admin has access
    $responseAdmin = $this->actingAs($this->admin)->get(route('admin.activity-logs'));
    $responseAdmin->assertStatus(200);
    $responseAdmin->assertSee('Audit Trail');
    $responseAdmin->assertSee('Log Audit Keamanan');

    // Librarian is forbidden
    $responseLibrarian = $this->actingAs($this->librarian)->get(route('admin.activity-logs'));
    $responseLibrarian->assertStatus(403);

    // Member is forbidden
    $responseMember = $this->actingAs($this->member)->get(route('admin.activity-logs'));
    $responseMember->assertStatus(403);
});

test('activity log is generated on login', function () {
    // Log out first
    Auth::logout();

    // Perform login post request
    $response = $this->post('/login', [
        'email' => 'member@librarygenz.com',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('member.dashboard', absolute: false));

    // Assert login activity log exists
    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $this->member->id,
        'activity_type' => 'login',
    ]);
});

test('activity log is generated on borrowing lifecycle actions', function () {
    $book = Book::first();

    // 1. Borrow request
    $responseRequest = $this->actingAs($this->member)->post(route('borrowings.request', $book));
    $responseRequest->assertRedirect();

    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $this->member->id,
        'activity_type' => 'borrow_request',
    ]);

    $borrowing = Borrowing::where('user_id', $this->member->id)
        ->where('book_id', $book->id)
        ->where('status', 'requested')
        ->first();

    // 2. Approval
    $responseApprove = $this->actingAs($this->librarian)->post(route('borrowings.approve', $borrowing));
    $responseApprove->assertRedirect();

    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $this->librarian->id,
        'activity_type' => 'approval',
    ]);

    // 3. Checkout (Serah terima)
    $responseBorrow = $this->actingAs($this->librarian)->post(route('borrowings.borrow', $borrowing));
    $responseBorrow->assertRedirect();

    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $this->librarian->id,
        'activity_type' => 'approval',
    ]);

    // 4. Return
    $responseReturn = $this->actingAs($this->librarian)->post(route('borrowings.return', $borrowing));
    $responseReturn->assertRedirect();

    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $this->librarian->id,
        'activity_type' => 'return',
    ]);
});

test('activity log is generated on fine payment and waiving', function () {
    $book = Book::first();
    $borrowing = Borrowing::create([
        'user_id' => $this->member->id,
        'book_id' => $book->id,
        'status' => 'returned',
    ]);

    // Pay Fine log
    $fine1 = Fine::create([
        'borrowing_id' => $borrowing->id,
        'late_days' => 2,
        'amount' => 4000,
        'status' => 'unpaid',
    ]);

    $responsePay = $this->actingAs($this->librarian)->post(route('fines.pay', $fine1));
    $responsePay->assertRedirect();

    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $this->librarian->id,
        'activity_type' => 'fine_payment',
    ]);

    // Waive Fine log
    $fine2 = Fine::create([
        'borrowing_id' => $borrowing->id,
        'late_days' => 3,
        'amount' => 6000,
        'status' => 'unpaid',
    ]);

    $responseWaive = $this->actingAs($this->librarian)->post(route('fines.waive', $fine2), [
        'notes' => 'Alasan kemanusiaan.',
    ]);
    $responseWaive->assertRedirect();

    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $this->librarian->id,
        'activity_type' => 'fine_payment',
    ]);
});
