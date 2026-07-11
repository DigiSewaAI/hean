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
    protected $description = 'Import hostels from CSV file (new format)';

    public function handle()
    {
        $file = $this->argument('file');
        if (!file_exists($file)) {
            $this->error("File not found: $file");
            return 1;
        }

        $this->info("📂 Reading file: $file");

        // Preeti to Unicode mapping (full)
        $compoundMap = [
            'xf]:6]n' => 'होस्टेल', 'un{\;' => 'गर्ल्स', 'AjfOh' => 'ब्वाइज',
            'xf]d' => 'होस्टल', 'uN;{' => 'गर्ल्स', 'JjfO{h' => 'ब्वाइज',
            'xf]:6n' => 'होस्टेल', 'xfd|f]' => 'हाम्रो', 'un{\\' => 'गर्ल्स',
            'Ans' => 'ब्लक', ';L' => 'सी', 'l/l4l;l4' => 'रिद्धि सिद्धि',
            'P; P;' => 'एस एस', 'Onfld' => 'इलामली', 'df]If' => 'मच',
            'Go gj b\'uf{' => 'न्यू नवदुर्गा', '/fh' => 'राज', 'l;G8«]nf' => 'सिन्ड्रेला',
            'n8 a\'4' => 'लर्ड बुद्ध', '/f]on /fKtL' => 'रोयल राप्ती',
            ';kf b]p/fnL' => 'सुपा देउराली', 'Go :ju{åf/L' => 'न्यू स्वर्गध्वारी',
        ];
        $singleSearch = ['k','K','I','M',';','c','C','j','J','t','T','d','D','n','f','F','g','G','h','v','V','b','B','m','y','r','l','e','s','S','u','U','z','Z','x','a','A','i','I','u','U','E','O','w','W','q','Q','p','P','R','Y','L',']','\\','0','1','2','3','4','5','6','7','8','9'];
        $singleReplace = ['क','ख','ग','घ','ङ','च','छ','ज','झ','ट','ठ','ड','ढ','ण','त','थ','द','ध','न','प','फ','ब','भ','म','य','र','ल','व','श','ष','स','ह','क्ष','त्र','ज्ञ','अ','आ','इ','ई','उ','ऊ','ऐ','औ','ौ','ो','ृ','ॄ','ि','ी','ु','ू','े','ै','्','०','१','२','३','४','५','६','७','८','९'];

        function preetiToUnicode($text, $compoundMap, $singleSearch, $singleReplace) {
            if (empty($text)) return $text;
            foreach ($compoundMap as $preeti => $unicode) {
                $text = str_replace($preeti, $unicode, $text);
            }
            return str_replace($singleSearch, $singleReplace, $text);
        }

        // Read CSV
        $content = file_get_contents($file);
        $content = mb_convert_encoding($content, 'UTF-8', 'auto');
        $lines = explode("\n", $content);
        if (count($lines) < 2) {
            $this->error("CSV is empty or invalid.");
            return 1;
        }

        $header = str_getcsv($lines[0]);
        $this->line("Headers: " . implode(', ', $header));

        $imported = 0;
        $errors = [];
        $rowNumber = 0;

        DB::beginTransaction();
        try {
            for ($i = 1; $i < count($lines); $i++) {
                $line = trim($lines[$i]);
                if (empty($line)) continue;
                $row = str_getcsv($line);
                $rowNumber++;
                if (count($row) < 11) {
                    $errors[] = "Row $rowNumber: Insufficient columns, skipped.";
                    continue;
                }

                // Extract fields
                $oldReg = trim($row[0] ?? '');
                $englishName = trim($row[1] ?? '');
                $nepaliPreeti = trim($row[2] ?? '');
                $location = trim($row[3] ?? '');
                $ownerName = trim($row[4] ?? '');
                $contact = trim($row[5] ?? '');
                $pan = trim($row[6] ?? '');
                $ward = trim($row[7] ?? '');
                $capacity = (int) ($row[10] ?? 0);

                // Validate required fields
                if (empty($englishName) && empty($nepaliPreeti)) {
                    $errors[] = "Row $rowNumber: No hostel name, skipped.";
                    continue;
                }

                // Convert Nepali name
                $nepaliName = $nepaliPreeti ? preetiToUnicode($nepaliPreeti, $compoundMap, $singleSearch, $singleReplace) : $englishName;

                // Default district, municipality
                $district = 'Kathmandu';
                $municipality = 'Kathmandu Metropolitan City';

                // Detect type
                $type = 'co-ed';
                $nameLower = strtolower($englishName . ' ' . $nepaliName);
                if (strpos($nameLower, 'girls') !== false || strpos($nameLower, 'girl') !== false) {
                    $type = 'girls';
                } elseif (strpos($nameLower, 'boys') !== false || strpos($nameLower, 'boy') !== false) {
                    $type = 'boys';
                }

                // Check duplicate by contact or old reg number
                $existing = Registration::where('contact', $contact)
                    ->orWhere('old_registration_number', $oldReg)
                    ->first();
                if ($existing) {
                    $errors[] = "Row $rowNumber: Duplicate (Contact/Old Reg#), skipped.";
                    continue;
                }

                // Create Registration (without registration_number)
                $registration = Registration::create([
                    'hostel_name' => $nepaliName,
                    'hostel_name_english' => $englishName,
                    'operator_name' => $ownerName ?: 'Unknown',
                    'contact' => $contact ?: 'N/A',
                    'pan' => $pan ?: null,
                    'ward' => $ward ?: '0',
                    'capacity' => $capacity,
                    'hostel_type' => $type,
                    'street' => $location ?: null,
                    'district' => $district,
                    'municipality' => $municipality,
                    'old_registration_number' => $oldReg ?: null,
                    'status' => 'active',
                    'source' => 'import',
                    'submitted_at' => now(),
                    'approved_at' => now(),
                    'valid_from' => now(),
                    'valid_until' => now()->addYear(),
                ]);

                // Create Hostel (auto-generates registration_number)
                $hostel = Hostel::create([
                    'name_nepali' => $nepaliName,
                    'name_english' => $englishName,
                    'operator_name' => $ownerName ?: 'Unknown',
                    'contact' => $contact ?: 'N/A',
                    'ward' => $ward ?: '0',
                    'capacity' => $capacity,
                    'type' => $type,
                    'street' => $location ?: null,
                    'district' => $district,
                    'municipality' => $municipality,
                    'old_registration_number' => $oldReg ?: null,
                    'approved' => true,
                    'visible' => true,
                    'featured' => false,
                    'owner_id' => null,
                ]);

                // Refresh to get generated registration_number
                $hostel->refresh();
                $registration->hostel_id = $hostel->id;
                if (empty($registration->registration_number)) {
                    $registration->registration_number = $hostel->registration_number;
                }
                $registration->save();

                // Create invoice, payment, receipt (dummy)
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
            if (!empty($errors)) {
                $this->warn("\n⚠️ Errors encountered:");
                foreach ($errors as $e) {
                    $this->warn($e);
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
