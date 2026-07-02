<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    // Already fixed manually via fix:invoice-id-not-null command
}

public function down(): void
{
    // Not needed
}
};