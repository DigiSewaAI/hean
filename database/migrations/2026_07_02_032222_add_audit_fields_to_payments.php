<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->timestamp('verified_at')->nullable()->after('status');
            $table->unsignedBigInteger('verified_by')->nullable()->after('verified_at');
            $table->timestamp('refunded_at')->nullable()->after('verified_by');
            $table->unsignedBigInteger('refunded_by')->nullable()->after('refunded_at');
            $table->string('refund_reason')->nullable()->after('refunded_by');

            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('refunded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropForeign(['refunded_by']);
            $table->dropColumn(['verified_at', 'verified_by', 'refunded_at', 'refunded_by', 'refund_reason']);
        });
    }
};