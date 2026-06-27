<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
    $table->id();
    $table->string('hostel_name');
    $table->string('operator_name');
    $table->string('district');
    $table->string('municipality');
    $table->string('ward');
    $table->string('street')->nullable();
    $table->string('contact');
    $table->text('documents')->nullable(); // store file paths as JSON
    $table->string('status')->default('pending'); // pending, approved, rejected, inspection
    $table->foreignId('inspector_id')->nullable()->constrained('users');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
