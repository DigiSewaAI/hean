<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Hostel;
use App\Models\Registration;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Receipt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportHostels extends Command
{
    protected $signature = 'import:hostels {file}';
    protected $description = 'Import hostels from CSV file (UTF-8 support)';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File not found: $file");
            return 1;
        }

        $this->info("📂 Reading file: $file");

        // ✅ Read file as UTF-8
        $content = file_get_contents($file);
        $content = mb_convert_encoding($content, 'UTF-8', 'auto');
        $lines = explode("\n", $content);

        if (count($lines) < 2) {
            $this->error("File is empty or invalid.");
            return 1;
        }

        // Get headers
        $header = str_getcsv($lines[0]);
        $this->line("Headers: " . implode(', ', $header));

        $imported = 0;
        $errors = [];
        $rowNumber = 1;

        DB::beginTransaction();

        try {
            for ($i = 1; $i < count($lines); $i++) {
                $line = trim($lines[$i]);
                if (empty($line)) continue;

                $row = str_getcsv($line);
                $rowNumber++;

                // ================================================
                // 1. EXTRACT DATA WITH DEFAULTS
                // ================================================
                $oldRegNumber = trim($row[0] ?? '');
                $hostelNameEnglish = trim($row[1] ?? '');
                $hostelNameNepali = trim($row[2] ?? '');
                $address = trim($row[3] ?? '');
                $ownerName = trim($row[4] ?? '');
                $contact = trim($row[5] ?? '');
                $pan = trim($row[6] ?? '');
                $ward = trim($row[7] ?? '');
                $capacity = (int) ($row[13] ?? 0);
                $remarks = trim($row[14] ?? '');

                // ✅ Convert to UTF-8 if needed
                if (!mb_check_encoding($hostelNameNepali, 'UTF-8')) {
                    $hostelNameNepali = mb_convert_encoding($hostelNameNepali, 'UTF-8', 'auto');
                }
                if (!mb_check_encoding($hostelNameEnglish, 'UTF-8')) {
                    $hostelNameEnglish = mb_convert_encoding($hostelNameEnglish, 'UTF-8', 'auto');
                }
                if (!mb_check_encoding($ownerName, 'UTF-8')) {
                    $ownerName = mb_convert_encoding($ownerName, 'UTF-8', 'auto');
                }
                if (!mb_check_encoding($address, 'UTF-8')) {
                    $address = mb_convert_encoding($address, 'UTF-8', 'auto');
                }

                // Fallbacks
                if (empty($hostelNameNepali) && !empty($hostelNameEnglish)) {
                    $hostelNameNepali = $hostelNameEnglish;
                } elseif (empty($hostelNameNepali) && empty($hostelNameEnglish)) {
                    $hostelNameNepali = 'Unknown Hostel';
                    $hostelNameEnglish = 'Unknown Hostel';
                }

                if (empty($ownerName)) $ownerName = 'Unknown';
                if (empty($contact)) $contact = 'N/A';
                if (empty($ward)) $ward = '0';
                if (empty($oldRegNumber)) $oldRegNumber = 'N/A';
                if ($capacity <= 0) $capacity = 0;

                // Detect type
                $type = 'co-ed';
                $nameLower = strtolower($hostelNameNepali . ' ' . $hostelNameEnglish);
                if (strpos($nameLower, 'girls') !== false || strpos($nameLower, 'girl') !== false) {
                    $type = 'girls';
                } elseif (strpos($nameLower, 'boys') !== false || strpos($nameLower, 'boy') !== false) {
                    $type = 'boys';
                }

                // Default district & municipality
                $district = 'Kathmandu';
                $municipality = 'Kathmandu Metropolitan City';

                if (empty($hostelNameNepali) && empty($hostelNameEnglish)) {
                    $errors[] = "Row $rowNumber: Hostel name empty. Skipped.";
                    continue;
                }

                // Check duplicate
                $existing = Registration::where('contact', $contact)
                    ->orWhere('old_registration_number', $oldRegNumber)
                    ->first();

                if ($existing) {
                    $errors[] = "Row $rowNumber: Duplicate (Contact/Old Reg#). Skipped.";
                    continue;
                }

                // ================================================
                // 2. CREATE REGISTRATION & HOSTEL
                // ================================================
                $registration = Registration::create([
                    'hostel_name' => $hostelNameNepali,
                    'hostel_name_english' => $hostelNameEnglish,
                    'operator_name' => $ownerName,
                    'contact' => $contact,
                    'pan' => $pan ?: null,
                    'ward' => $ward,
                    'capacity' => $capacity,
                    'hostel_type' => $type,
                    'street' => $address ?: null,
                    'district' => $district,
                    'municipality' => $municipality,
                    'description' => $remarks ?: null,
                    'old_registration_number' => $oldRegNumber,
                    'status' => 'active',
                    'source' => 'import',
                    'submitted_at' => now(),
                    'approved_at' => now(),
                    'valid_from' => now(),
                    'valid_until' => now()->addYear(),
                ]);

                $hostel = Hostel::create([
                    'name_nepali' => $hostelNameNepali,
                    'name_english' => $hostelNameEnglish,
                    'operator_name' => $ownerName,
                    'contact' => $contact,
                    'ward' => $ward,
                    'capacity' => $capacity,
                    'type' => $type,
                    'street' => $address ?: null,
                    'district' => $district,
                    'municipality' => $municipality,
                    'old_registration_number' => $oldRegNumber,
                    'description' => $remarks ?: null,
                    'approved' => true,
                    'visible' => true,
                    'featured' => false,
                    'owner_id' => null,
                ]);

                $hostel->refresh();
                $registration->hostel_id = $hostel->id;
                if (empty($registration->registration_number)) {
                    $registration->registration_number = $hostel->registration_number;
                }
                $registration->save();

                // Dummy invoice/payment/receipt
                $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad(Invoice::max('id') + 1, 6, '0', STR_PAD_LEFT);
                $invoice = Invoice::create([
                    'registration_id' => $registration->id,
                    'invoice_number' => $invoiceNumber,
                    'amount' => 0,
                    'issued_date' => now(),
                    'due_date' => now(),
                    'status' => 'paid',
                    'invoice_type' => 'membership_fee',
                    'pdf_path' => null,
                ]);

                $payment = Payment::create([
                    'registration_id' => $registration->id,
                    'invoice_id' => $invoice->id,
                    'method' => 'cash',
                    'amount' => 0,
                    'payment_date' => now(),
                    'status' => 'verified',
                    'verified_at' => now(),
                    'verified_by' => 1,
                    'remarks' => 'Imported from CSV',
                ]);

                $receiptNumber = 'RCP-' . date('Y') . '-' . str_pad(Receipt::max('id') + 1, 6, '0', STR_PAD_LEFT);
                Receipt::create([
                    'payment_id' => $payment->id,
                    'receipt_number' => $receiptNumber,
                    'amount' => 0,
                    'issued_date' => now(),
                    'pdf_path' => null,
                    'remarks' => 'Imported from CSV',
                ]);

                $imported++;
                if ($imported % 50 == 0) {
                    $this->line("✅ Imported $imported hostels...");
                }
            }

            DB::commit();

            $this->info("\n🎉 Successfully imported $imported hostels.");
            if (count($errors) > 0) {
                $this->warn("\n⚠️ Errors encountered:");
                foreach ($errors as $err) {
                    $this->warn($err);
                }
            }
            return 0;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('❌ Import failed: ' . $e->getMessage());
            Log::error('Import failed: ' . $e->getMessage());
            return 1;
        }
    }
}