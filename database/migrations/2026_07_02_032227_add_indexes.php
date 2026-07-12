<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ---- Registrations Table ----
        Schema::table('registrations', function (Blueprint $table) {
            // Check if both 'status' and 'valid_until' columns exist before creating composite index
            if (Schema::hasColumn('registrations', 'status') && Schema::hasColumn('registrations', 'valid_until')) {
                $table->index(['status', 'valid_until']);
            } elseif (Schema::hasColumn('registrations', 'status')) {
                // If only 'status' exists, create index on status alone
                $table->index('status');
            }

            // Indexes for columns that definitely exist (added earlier)
            if (Schema::hasColumn('registrations', 'pan')) {
                $table->index('pan');
            }
            if (Schema::hasColumn('registrations', 'contact')) {
                $table->index('contact');
            }
            if (Schema::hasColumn('registrations', 'email')) {
                $table->index('email');
            }
        });

        // ---- Payments Table ----
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'status')) {
                $table->index('status');
            }
        });

        // ---- Invoices Table ----
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'status')) {
                $table->index('status');
            }
        });
    }

    public function down(): void
    {
        // ---- Registrations ----
        Schema::table('registrations', function (Blueprint $table) {
            // Drop composite index only if it exists
            try {
                $table->dropIndex(['status', 'valid_until']);
            } catch (\Exception $e) {
                // Index might not exist, ignore
            }

            // Drop individual indexes
            try {
                $table->dropIndex(['pan']);
            } catch (\Exception $e) {
                // Ignore
            }
            try {
                $table->dropIndex(['contact']);
            } catch (\Exception $e) {
                // Ignore
            }
            try {
                $table->dropIndex(['email']);
            } catch (\Exception $e) {
                // Ignore
            }
        });

        // ---- Payments ----
        Schema::table('payments', function (Blueprint $table) {
            try {
                $table->dropIndex(['status']);
            } catch (\Exception $e) {
                // Ignore
            }
        });

        // ---- Invoices ----
        Schema::table('invoices', function (Blueprint $table) {
            try {
                $table->dropIndex(['status']);
            } catch (\Exception $e) {
                // Ignore
            }
        });
    }
};