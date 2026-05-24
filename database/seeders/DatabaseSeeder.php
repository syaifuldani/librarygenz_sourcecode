<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Administrator Account (role_id = 1)
        User::factory()->create([
            'name' => 'Admin LibraryGenz',
            'email' => 'admin@librarygenz.com',
            'password' => bcrypt('password'),
            'role_id' => 1,
        ]);

        // Seed Librarian Account (role_id = 2)
        User::factory()->create([
            'name' => 'Ahmad Pustakawan',
            'email' => 'librarian@librarygenz.com',
            'password' => bcrypt('password'),
            'role_id' => 2,
        ]);

        // Seed Member Account (role_id = 3)
        User::factory()->create([
            'name' => 'Rian Permana',
            'email' => 'member@librarygenz.com',
            'password' => bcrypt('password'),
            'role_id' => 3,
        ]);

        // Seed Categories
        $categories = [
            ['name' => 'Fiksi', 'slug' => 'fiksi'],
            ['name' => 'Sains & Teknologi', 'slug' => 'sains-teknologi'],
            ['name' => 'Sejarah', 'slug' => 'sejarah'],
            ['name' => 'Filsafat', 'slug' => 'filsafat'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::create($cat);
        }

        // Seed Books
        $fiksi = \App\Models\Category::where('slug', 'fiksi')->first()->id;
        $filsafat = \App\Models\Category::where('slug', 'filsafat')->first()->id;
        $sains = \App\Models\Category::where('slug', 'sains-teknologi')->first()->id;

        \App\Models\Book::create([
            'title' => 'Bumi Manusia',
            'slug' => 'bumi-manusia-' . time(),
            'author' => 'Pramoedya Ananta Toer',
            'category_id' => $fiksi,
            'stock' => 5,
            'description' => 'Bumi Manusia adalah buku pertama dari tetralogi buru karangan Pramoedya Ananta Toer. Mengisahkan perjuangan Minke di masa kolonial Belanda.',
        ]);

        \App\Models\Book::create([
            'title' => 'Laskar Pelangi',
            'slug' => 'laskar-pelangi-' . time(),
            'author' => 'Andrea Hirata',
            'category_id' => $fiksi,
            'stock' => 8,
            'description' => 'Kisah perjuangan sepuluh anak di Belitung dalam menempuh pendidikan dasar di bawah asuhan Ibu Muslimah.',
        ]);

        \App\Models\Book::create([
            'title' => 'Filosofi Teras',
            'slug' => 'filosofi-teras-' . time(),
            'author' => 'Henry Manampiring',
            'category_id' => $filsafat,
            'stock' => 12,
            'description' => 'Buku pengantar filsafat stoisisme yang dikemas secara praktis untuk membantu mengelola emosi negatif.',
        ]);

        $hawkingBook = \App\Models\Book::create([
            'title' => 'A Brief History of Time',
            'slug' => 'a-brief-history-of-time-' . time(),
            'author' => 'Stephen Hawking',
            'category_id' => $sains,
            'stock' => 3,
            'description' => 'Buku populer sains yang menjelaskan konsep-konsep kosmologi modern seperti lubang hitam, waktu, dan asal mula alam semesta.',
        ]);

        $member = User::where('email', 'member@librarygenz.com')->first();
        $admin = User::where('email', 'admin@librarygenz.com')->first();

        // 1. Active loan that is OVERDUE (due date is 3 days ago)
        \App\Models\Borrowing::create([
            'user_id' => $member->id,
            'book_id' => $hawkingBook->id,
            'borrow_date' => today()->subDays(10),
            'due_date' => today()->subDays(3),
            'status' => 'borrowed', // Will be marked as 'overdue' on the fly
            'approved_by' => $admin->id,
        ]);

        // 2. Active loan that is NOT overdue (due date is 5 days from now)
        $terasBook = \App\Models\Book::where('title', 'Filosofi Teras')->first();
        \App\Models\Borrowing::create([
            'user_id' => $member->id,
            'book_id' => $terasBook->id,
            'borrow_date' => today()->subDays(2),
            'due_date' => today()->addDays(5),
            'status' => 'borrowed',
            'approved_by' => $admin->id,
        ]);

        // 3. Historical loan with a PAID fine (2 days late)
        $bumiBook = \App\Models\Book::where('title', 'Bumi Manusia')->first();
        $borrowingPaid = \App\Models\Borrowing::create([
            'user_id' => $member->id,
            'book_id' => $bumiBook->id,
            'borrow_date' => today()->subDays(15),
            'due_date' => today()->subDays(8),
            'return_date' => today()->subDays(6),
            'status' => 'returned',
            'approved_by' => $admin->id,
        ]);

        \App\Models\Fine::create([
            'borrowing_id' => $borrowingPaid->id,
            'late_days' => 2,
            'amount' => 4000,
            'status' => 'paid',
            'paid_at' => today()->subDays(6),
            'notes' => 'Pembayaran tunai di meja pustakawan.',
        ]);

        // 4. Historical loan with a WAIVED fine (5 days late)
        $laskarBook = \App\Models\Book::where('title', 'Laskar Pelangi')->first();
        $borrowingWaived = \App\Models\Borrowing::create([
            'user_id' => $member->id,
            'book_id' => $laskarBook->id,
            'borrow_date' => today()->subDays(20),
            'due_date' => today()->subDays(13),
            'return_date' => today()->subDays(8),
            'status' => 'returned',
            'approved_by' => $admin->id,
        ]);

        \App\Models\Fine::create([
            'borrowing_id' => $borrowingWaived->id,
            'late_days' => 5,
            'amount' => 10000,
            'status' => 'waived',
            'notes' => 'Dispensasi karena sakit (surat terlampir diserahkan).',
        ]);

        // 5. Seed Activity Logs
        \App\Models\ActivityLog::create([
            'user_id' => $admin->id,
            'activity_type' => 'login',
            'description' => "Pengguna Admin LibraryGenz (admin) berhasil masuk ke dalam sistem.",
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0 Safari/537.36',
            'created_at' => today()->subDays(10),
        ]);

        \App\Models\ActivityLog::create([
            'user_id' => $member->id,
            'activity_type' => 'borrow_request',
            'description' => "Anggota Rian Permana mengajukan peminjaman buku: 'A Brief History of Time'.",
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0 Safari/537.36',
            'created_at' => today()->subDays(10),
        ]);

        \App\Models\ActivityLog::create([
            'user_id' => $admin->id,
            'activity_type' => 'approval',
            'description' => "Pustakawan menyetujui peminjaman buku 'A Brief History of Time' untuk anggota Rian Permana.",
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0 Safari/537.36',
            'created_at' => today()->subDays(10),
        ]);

        \App\Models\ActivityLog::create([
            'user_id' => $admin->id,
            'activity_type' => 'return',
            'description' => "Pustakawan memverifikasi pengembalian buku 'Bumi Manusia' dari anggota Rian Permana. Denda dihasilkan.",
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0 Safari/537.36',
            'created_at' => today()->subDays(6),
        ]);

        \App\Models\ActivityLog::create([
            'user_id' => $admin->id,
            'activity_type' => 'fine_payment',
            'description' => "Pustakawan memproses pembayaran denda sebesar Rp4.000 untuk anggota Rian Permana (Buku: 'Bumi Manusia').",
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0 Safari/537.36',
            'created_at' => today()->subDays(6),
        ]);
    }
}

