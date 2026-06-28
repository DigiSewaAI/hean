<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Add columns only if they don't already exist
            if (!Schema::hasColumn('registrations', 'owner_id')) {
                $table->foreignId('owner_id')->nullable()->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('registrations', 'hostel_id')) {
                $table->foreignId('hostel_id')->nullable()->constrained('hostels')->onDelete('set null');
            }
            if (!Schema::hasColumn('registrations', 'source')) {
                $table->enum('source', ['public', 'admin', 'import', 'renewal'])->default('public');
            }
            if (!Schema::hasColumn('registrations', 'submitted_at')) {
                $table->timestamp('submitted_at')->nullable();
            }
            if (!Schema::hasColumn('registrations', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }
            if (!Schema::hasColumn('registrations', 'pan')) {
                $table->string('pan')->nullable();
            }
            if (!Schema::hasColumn('registrations', 'registration_number')) {
                $table->string('registration_number')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Drop columns if they exist (safe rollback)
            $columns = ['owner_id', 'hostel_id', 'source', 'submitted_at', 'approved_at', 'pan', 'registration_number'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('registrations', $column)) {
                    // For foreign keys, we need to drop the constraint first
                    if ($column === 'owner_id' || $column === 'hostel_id') {
                        $table->dropForeign([$column]);
                    }
                    $table->dropColumn($column);
                }
            }
        });
    }
};