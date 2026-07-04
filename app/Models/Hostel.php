<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hostel extends Model
{
    protected $fillable = [
        // Core details
        'name_nepali',
        'name_english',
        'operator_name',
        'contact',
        'description',

        // Address
        'province',
        'district',
        'municipality',
        'ward',
        'street',
        'landmark',

        // Facilities
        'type',
        'capacity',
        'rooms',
        'established_year',
        'email',
        'website',

        // Status
        'approved',
        'featured',
        'visible',

        // Relations
        'owner_id',
        'image',

        // ✅ नयाँ: ब्लक / भवन नाम (mass assignment को लागि)
        'block_name',

        // ❌ 'registration_number' यहाँ नराख्नुहोस् – यो model event बाट सेट हुन्छ
    ];

    protected $casts = [
        'approved' => 'boolean',
        'visible' => 'boolean',
        'featured' => 'boolean',
        'capacity' => 'integer',
        'rooms' => 'integer',
        'established_year' => 'integer',
    ];

    /**
     * The "booted" method of the model.
     * स्थायी दर्ता नम्बर आफैं जनरेट गर्ने (created event)
     */
    protected static function booted()
    {
        static::created(function ($hostel) {
            // यदि registration_number पहिले नै सेट भएको छैन भने मात्र उत्पन्न गर्ने
            if (is_null($hostel->registration_number)) {
                $year = $hostel->created_at->year;
                $sequence = str_pad($hostel->id, 6, '0', STR_PAD_LEFT);
                $hostel->registration_number = "HEAN-{$year}-{$sequence}";
                $hostel->saveQuietly(); // पुन: इभेन्ट नफायर गरी सेभ गर्ने
            }
        });
    }

    /**
     * स्ट्रिङलाई normalize गर्ने: trim, lower, multiple spaces हटाउने
     */
    protected static function normalizeString($str)
    {
        return preg_replace('/\s+/', ' ', strtolower(trim($str)));
    }

    /**
     * डुप्लिकेट होस्टल जाँच गर्ने (Normalized)
     * फिल्डहरू: name, district, municipality, ward, street, block (वैकल्पिक)
     * 
     * @param string $name         होस्टलको नाम (नेपाली वा अङ्ग्रेजी)
     * @param string $district     जिल्ला
     * @param string $municipality नगरपालिका
     * @param string $ward         वार्ड (number)
     * @param string $street       सडक
     * @param string|null $block   ब्लक / भवन नाम (वैकल्पिक)
     * @return bool
     */
    public static function checkDuplicate($name, $district, $municipality, $ward, $street, $block = null)
    {
        $normalizedName = self::normalizeString($name);
        $normalizedDistrict = self::normalizeString($district);
        $normalizedMunicipality = self::normalizeString($municipality);
        $normalizedStreet = self::normalizeString($street);
        $normalizedBlock = $block ? self::normalizeString($block) : null;

        return self::where(function ($query) use ($normalizedName) {
                $query->whereRaw('LOWER(TRIM(name_nepali)) = ?', [$normalizedName])
                      ->orWhereRaw('LOWER(TRIM(name_english)) = ?', [$normalizedName]);
            })
            ->whereRaw('LOWER(TRIM(district)) = ?', [$normalizedDistrict])
            ->whereRaw('LOWER(TRIM(municipality)) = ?', [$normalizedMunicipality])
            ->whereRaw('LOWER(TRIM(ward)) = ?', [trim($ward)])
            ->whereRaw('LOWER(TRIM(street)) = ?', [$normalizedStreet])
            ->when(!is_null($normalizedBlock), function ($q) use ($normalizedBlock) {
                $q->whereRaw('LOWER(TRIM(block_name)) = ?', [$normalizedBlock]);
            }, function ($q) {
                // यदि block NULL वा खाली छ भने, दुवै अवस्था मिलाउने
                $q->whereNull('block_name')->orWhere('block_name', '');
            })
            ->exists();
    }

    /**
     * Get the owner (user) of this hostel.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the registrations associated with this hostel.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Scope to show only approved and visible hostels.
     */
    public function scopeApproved($query)
    {
        return $query->where('approved', true)->where('visible', true);
    }

    /**
     * Scope for featured hostels.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Convenience accessor for hostel name.
     * (पहिले नेपाली नाम, नभए अङ्ग्रेजी)
     */
    public function getNameAttribute()
    {
        return $this->name_nepali ?? $this->name_english ?? 'N/A';
    }
}