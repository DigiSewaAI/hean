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
        Schema::create('hostels', function (Blueprint $table) {
    $table->id();
    $table->string('name_nepali');
    $table->string('name_english')->nullable();
    $table->string('operator_name');
    $table->string('district');
    $table->string('municipality');
    $table->string('ward');
    $table->string('street')->nullable();
    $table->string('contact');
    $table->text('description')->nullable();
    $table->boolean('approved')->default(false);
    $table->boolean('featured')->default(false);
    $table->boolean('visible')->default(true);
    $table->string('image')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hostels');
    }
};
