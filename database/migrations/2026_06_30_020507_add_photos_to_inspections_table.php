<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('inspections', function (Blueprint $table) {
        $table->json('photos')->nullable()->after('checklist');
    });
}

public function down()
{
    Schema::table('inspections', function (Blueprint $table) {
        $table->dropColumn('photos');
    });
}
};
