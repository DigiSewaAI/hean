<?php

use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gallery_images', function (Blueprint $table) {
            $table->foreignId('album_id')->nullable()->after('id')
                  ->constrained('gallery_albums')->onDelete('cascade');
        });

        // --- Data Migration ---
        // Create albums from distinct event_name values
        $distinctEvents = GalleryImage::whereNotNull('event_name')
                                      ->distinct()
                                      ->pluck('event_name');

        foreach ($distinctEvents as $eventName) {
            $album = GalleryAlbum::create([
                'name' => $eventName,
                'slug' => \Illuminate\Support\Str::slug($eventName),
                'is_published' => true,
            ]);
            // Assign all images with this event_name to the album
            GalleryImage::where('event_name', $eventName)
                        ->update(['album_id' => $album->id]);
        }

        // For images with null event_name, create a default "Uncategorized" album
        $uncategorizedCount = GalleryImage::whereNull('event_name')->count();
        if ($uncategorizedCount > 0) {
            $defaultAlbum = GalleryAlbum::create([
                'name' => 'Uncategorized',
                'slug' => 'uncategorized',
                'is_published' => true,
            ]);
            GalleryImage::whereNull('event_name')
                        ->update(['album_id' => $defaultAlbum->id]);
        }

        // Now drop the event_name column
        Schema::table('gallery_images', function (Blueprint $table) {
            $table->dropColumn('event_name');
        });
    }

    public function down(): void
    {
        Schema::table('gallery_images', function (Blueprint $table) {
            $table->string('event_name')->nullable()->after('title');
            $table->dropForeign(['album_id']);
            $table->dropColumn('album_id');
        });
    }
};