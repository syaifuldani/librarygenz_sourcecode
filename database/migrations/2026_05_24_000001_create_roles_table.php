<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // 'admin', 'librarian', 'member'
            $table->string('label'); // 'Admin', 'Librarian', 'Member'
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert initial roles
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'label' => 'Admin',
                'description' => 'System administrator with full permissions.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'librarian',
                'label' => 'Librarian',
                'description' => 'Librarian responsible for book collections and borrowing workflows.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'member',
                'label' => 'Member',
                'description' => 'Registered library member who can search the catalog and borrow books.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
