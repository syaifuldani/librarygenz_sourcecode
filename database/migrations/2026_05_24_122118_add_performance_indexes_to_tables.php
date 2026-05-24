<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds indexes on frequently queried columns to eliminate N+1 and slow scans.
     */
    public function up(): void
    {
        // borrowings: most queried by status, user_id, book_id, due_date
        Schema::table('borrowings', function (Blueprint $table) {
            if (!$this->indexExists('borrowings', 'borrowings_status_index')) {
                $table->index('status', 'borrowings_status_index');
            }
            if (!$this->indexExists('borrowings', 'borrowings_user_id_status_index')) {
                $table->index(['user_id', 'status'], 'borrowings_user_id_status_index');
            }
            if (!$this->indexExists('borrowings', 'borrowings_due_date_status_index')) {
                $table->index(['due_date', 'status'], 'borrowings_due_date_status_index');
            }
        });

        // fines: queried by status, borrowing_id
        Schema::table('fines', function (Blueprint $table) {
            if (!$this->indexExists('fines', 'fines_status_index')) {
                $table->index('status', 'fines_status_index');
            }
        });

        // activity_logs: queried by user_id, activity_type, created_at
        Schema::table('activity_logs', function (Blueprint $table) {
            if (!$this->indexExists('activity_logs', 'activity_logs_type_index')) {
                $table->index('activity_type', 'activity_logs_type_index');
            }
            if (!$this->indexExists('activity_logs', 'activity_logs_created_at_index')) {
                $table->index('created_at', 'activity_logs_created_at_index');
            }
        });

        // users: queried by status, role_id
        Schema::table('users', function (Blueprint $table) {
            if (!$this->indexExists('users', 'users_status_index')) {
                $table->index('status', 'users_status_index');
            }
        });

        // books: queried by category_id, stock
        Schema::table('books', function (Blueprint $table) {
            if (!$this->indexExists('books', 'books_stock_index')) {
                $table->index('stock', 'books_stock_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropIndex('borrowings_status_index');
            $table->dropIndex('borrowings_user_id_status_index');
            $table->dropIndex('borrowings_due_date_status_index');
        });

        Schema::table('fines', function (Blueprint $table) {
            $table->dropIndex('fines_status_index');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex('activity_logs_type_index');
            $table->dropIndex('activity_logs_created_at_index');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_status_index');
        });

        Schema::table('books', function (Blueprint $table) {
            $table->dropIndex('books_stock_index');
        });
    }

    /**
     * Check if an index already exists (SQLite-safe).
     */
    private function indexExists(string $table, string $indexName): bool
    {
        try {
            $indexes = \Illuminate\Support\Facades\DB::select("PRAGMA index_list({$table})");
            foreach ($indexes as $index) {
                if ($index->name === $indexName) {
                    return true;
                }
            }
        } catch (\Exception $e) {
            // Non-SQLite: assume index doesn't exist
        }
        return false;
    }
};
