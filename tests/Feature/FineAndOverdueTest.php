<?php

use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    // Seed roles and initial data
    $this->seed(\Database\Seeders\DatabaseSeeder::class);
    
    // Retrieve seeded accounts
    $this->admin = User::where('email', 'admin@librarygenz.com')->first();
    $this->librarian = User::where('email', 'librarian@librarygenz.com')->first();
    $this->member = User::where('email', 'member@librarygenz.com')->first();
});

test('borrowing status becomes overdue on-the-fly when past due date', function () {
    $book = Book::first();
    
    // Create borrowing that is past due date (3 days ago)
    $borrowing = Borrowing::create([
        'user_id' => $this->member->id,
        'book_id' => $book->id,
        'borrow_date' => today()->subDays(10),
        'due_date' => today()->subDays(3),
        'status' => 'borrowed',
        'approved_by' => $this->librarian->id,
    ]);

    // Access manage page to trigger on-the-fly check
    $response = $this->actingAs($this->librarian)->get(route('borrowings.manage'));
    $response->assertStatus(200);

    // Assert status updated to overdue in database
    $this->assertDatabaseHas('borrowings', [
        'id' => $borrowing->id,
        'status' => 'overdue',
    ]);
});

test('fine is generated automatically upon returning a late book', function () {
    $book = Book::first();
    
    // Create borrowing that is past due date (5 days ago)
    $borrowing = Borrowing::create([
        'user_id' => $this->member->id,
        'book_id' => $book->id,
        'borrow_date' => today()->subDays(12),
        'due_date' => today()->subDays(5),
        'status' => 'borrowed',
        'approved_by' => $this->librarian->id,
    ]);

    // Mark as returned
    $response = $this->actingAs($this->librarian)->post(route('borrowings.return', $borrowing));
    $response->assertRedirect();



    // Assert status updated to returned
    $this->assertDatabaseHas('borrowings', [
        'id' => $borrowing->id,
        'status' => 'returned',
    ]);

    // Assert fine was created: 5 days * 2000 = 10000
    $this->assertDatabaseHas('fines', [
        'borrowing_id' => $borrowing->id,
        'late_days' => 5,
        'amount' => 10000,
        'status' => 'unpaid',
    ]);
});

test('member can view their personal fines list', function () {
    $book = Book::first();
    
    // Create late borrowing & return it to generate fine
    $borrowing = Borrowing::create([
        'user_id' => $this->member->id,
        'book_id' => $book->id,
        'borrow_date' => today()->subDays(10),
        'due_date' => today()->subDays(5),
        'status' => 'borrowed',
    ]);
    
    $this->actingAs($this->librarian)->post(route('borrowings.return', $borrowing));

    // Access personal fines page
    $response = $this->actingAs($this->member)->get(route('fines.history'));
    $response->assertStatus(200);
    $response->assertSee('Rp10.000');
});

test('librarian can process fine payment', function () {
    $book = Book::first();
    $borrowing = Borrowing::create([
        'user_id' => $this->member->id,
        'book_id' => $book->id,
        'status' => 'returned',
    ]);

    $fine = Fine::create([
        'borrowing_id' => $borrowing->id,
        'late_days' => 3,
        'amount' => 6000,
        'status' => 'unpaid',
    ]);

    // Process payment
    $response = $this->actingAs($this->librarian)->post(route('fines.pay', $fine));
    $response->assertRedirect();

    // Assert status updated to paid
    $this->assertDatabaseHas('fines', [
        'id' => $fine->id,
        'status' => 'paid',
    ]);
    $this->assertNotNull(Fine::find($fine->id)->paid_at);
});

test('librarian can waive fine with notes', function () {
    $book = Book::first();
    $borrowing = Borrowing::create([
        'user_id' => $this->member->id,
        'book_id' => $book->id,
        'status' => 'returned',
    ]);

    $fine = Fine::create([
        'borrowing_id' => $borrowing->id,
        'late_days' => 4,
        'amount' => 8000,
        'status' => 'unpaid',
    ]);

    // Process waive
    $response = $this->actingAs($this->librarian)->post(route('fines.waive', $fine), [
        'notes' => 'Dispensasi musibah banjir.',
    ]);
    $response->assertRedirect();

    // Assert status updated to waived
    $this->assertDatabaseHas('fines', [
        'id' => $fine->id,
        'status' => 'waived',
        'notes' => 'Dispensasi musibah banjir.',
    ]);
});

test('librarian and admin can view overdue list', function () {
    $response = $this->actingAs($this->librarian)->get(route('borrowings.overdue'));
    $response->assertStatus(200);

    $responseAdmin = $this->actingAs($this->admin)->get(route('borrowings.overdue'));
    $responseAdmin->assertStatus(200);
});

test('admin dashboard shows correct analytics denda', function () {
    // Retrieve manage page and check status
    $response = $this->actingAs($this->admin)->get(route('fines.manage'));
    $response->assertStatus(200);
    
    // Check if seeded stats are present (e.g. 4.000 paid, 10.000 waived, active late amount)
    $response->assertSee('Rp4.000');
    $response->assertSee('Rp10.000');
});
