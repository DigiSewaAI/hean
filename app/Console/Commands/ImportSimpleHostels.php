<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Registration;
use App\Models\Hostel;
use Illuminate\Support\Facades\DB;

class ImportSimpleHostels extends Command
{
    protected $signature = 'import:simple-hostels {file} {--force : Skip duplicate check, import all}';
    protected $description = 'Import hostels from simple CSV (Name, Location, Owner, Contact)';

    public function handle()
    {
        $file = $this->argument('file');
        if (!file_exists($file)) {
            $this->error("File not found: $file");
            return 1;
        }

        $this->info("📂 Reading: $file");

        $lines = file($file);
        $header = str_getcsv(array_shift($lines));

        $imported = 0;
        $updated = 0;
        $errors = [];

        DB::beginTransaction();
        try {
            foreach ($lines as $line) {
                $row = str_getcsv(trim($line));
                if (count($row) < 4) continue;

                $name = trim($row[0]);
                $location = trim($row[1]);
                $owner = trim($row[2]);
                $contact = trim($row[3]);

                if (empty($name) || empty($contact)) {
                    $errors[] = "Skipped: Name or Contact empty";
                    continue;
                }

                // Detect type
                $type = 'co-ed';
                $nameLower = strtolower($name);
                if (strpos($nameLower, 'girls') !== false || strpos($nameLower, 'girl') !== false) {
                    $type = 'girls';
                } elseif (strpos($nameLower, 'boys') !== false || strpos($nameLower, 'boy') !== false) {
                    $type = 'boys';
                }

                // ✅ Duplicate check — SKIP नगर्ने, UPDATE गर्ने
                $existing = Registration::where('contact', $contact)->first();
                if ($existing && !$this->option('force')) {
                    $this->warn("⏭️ Duplicate: $name (Contact: $contact) — Use --force to override");
                    continue;
                }

                if ($existing && $this->option('force')) {
                    // Update existing
                    $existing->update([
                        'hostel_name' => $name,
                        'hostel_name_english' => $name,
                        'operator_name' => $owner ?: 'Unknown',
                        'contact' => $contact,
                        'location' => $location,
                        'updated_at' => now(),
                    ]);
                    $updated++;
                    $this->line("🔄 Updated: $name (Contact: $contact)");
                    continue;
                }

                // Create Registration
                $registration = Registration::create([
                    'hostel_name' => $name,
                    'hostel_name_english' => $name,
                    'operator_name' => $owner ?: 'Unknown',
                    'contact' => $contact,
                    'location' => $location,
                    'district' => 'Kathmandu',
                    'municipality' => 'Kathmandu Metropolitan City',
                    'ward' => '0',
                    'capacity' => 0,
                    'hostel_type' => $type,
                    'status' => 'active',
                    'source' => 'import',
                    'submitted_at' => now(),
                    'approved_at' => now(),
                    'valid_from' => now(),
                    'valid_until' => now()->addYear(),
                ]);

                // Create Hostel
                $hostel = Hostel::create([
                    'name_nepali' => $name,
                    'name_english' => $name,
                    'operator_name' => $owner ?: 'Unknown',
                    'contact' => $contact,
                    'street' => $location,
                    'district' => 'Kathmandu',
                    'municipality' => 'Kathmandu Metropolitan City',
                    'ward' => '0',
                    'capacity' => 0,
                    'type' => $type,
                    'approved' => true,
                    'visible' => true,
                    'featured' => false,
                    'owner_id' => null,
                ]);

                $registration->hostel_id = $hostel->id;
                if (empty($registration->registration_number)) {
                    $registration->registration_number = $hostel->registration_number;
                }
                $registration->save();

                $imported++;
                $this->line("✅ Imported: $name");
            }

            DB::commit();
            $this->info("\n✅ Successfully imported: $imported");
            $this->info("🔄 Updated: $updated");
            if (!empty($errors)) {
                $this->warn("⚠️ Errors: " . implode(', ', $errors));
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Import failed: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}