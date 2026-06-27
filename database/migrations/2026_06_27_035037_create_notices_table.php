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
        Schema::create('notices', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('content');
    $table->date('date');
    $table->string('category')->nullable(); // Event, News, etc.
    $table->string('image')->nullable();
    $table->boolean('is_featured')->default(false);
    $table->boolean('is_published')->default(true);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
