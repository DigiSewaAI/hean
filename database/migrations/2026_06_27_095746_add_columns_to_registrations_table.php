<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->foreignId('owner_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('hostel_id')->nullable()->constrained('hostels')->onDelete('set null');
            $table->enum('source', ['public', 'admin', 'import', 'renewal'])->default('public');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->string('pan')->nullable();
            $table->string('registration_number')->nullable();
        });
    }

    public function down()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropForeign(['hostel_id']);
            $table->dropColumn(['owner_id', 'hostel_id', 'source', 'submitted_at', 'approved_at', 'pan', 'registration_number']);
        });
    }
};