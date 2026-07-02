<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->index(['status', 'valid_until']);
            $table->index('pan');
            $table->index('contact');
            $table->index('email');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->index('status');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropIndex(['status', 'valid_until']);
            $table->dropIndex(['pan']);
            $table->dropIndex(['contact']);
            $table->dropIndex(['email']);
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};