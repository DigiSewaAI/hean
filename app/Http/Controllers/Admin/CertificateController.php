<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Mpdf\Mpdf;
use Mpdf\MpdfException;


class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with('registration.owner', 'registration.hostel')
            ->latest()
            ->paginate(15);
        return view('admin.certificate.index', compact('certificates'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
        ]);

        $registration = Registration::with('owner', 'hostel')->findOrFail($request->registration_id);

        if ($registration->certificates()->exists()) {
            return back()->with('error', 'Certificate already generated.');
        }

        $certificateNumber = 'HEAN-' . date('Y') . '-' . str_pad(Certificate::count() + 1, 5, '0', STR_PAD_LEFT);

        $certificateData = [
            'registration_id' => $registration->id,
            'certificate_number' => $certificateNumber,
            'issued_date' => now(),
            'operator_name' => null,
            'address' => null,
            'contact' => null,
            'pan' => null,
            'pdf_path' => null,
        ];

        $certificate = Certificate::create($certificateData);
        $certificate->load('registration.owner', 'registration.hostel');

        try {
            $html = view('admin.certificates.certificate', [
                'certificate' => $certificate,
                'registration' => $certificate->registration,
            ])->render();

            $tempDir = storage_path('app/mpdf');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'default_font_size' => 12,
                'default_font' => 'dejavusans',
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'margin_left' => 10,
                'margin_right' => 10,
                'tempDir' => $tempDir,
            ]);

            // ===== WATERMARK IMAGE (Fixed) =====
            $logoPath = public_path('images/logo.png');
            if (file_exists($logoPath)) {
                // SetWatermarkImage(file, alpha, size, position)
                // alpha = 0.08 (8% transparency), 'F' = fit to page, 'P' = center
                $mpdf->SetWatermarkImage($logoPath, 0.08, 'F', 'P');
                $mpdf->showWatermarkImage = true;
            }

            $mpdf->WriteHTML($html);

            $pdfOutput = $mpdf->Output('', 'S');

            $pdfPath = 'certificates/cert_' . uniqid() . '.pdf';
            Storage::disk('public')->put($pdfPath, $pdfOutput);

            $certificate->update(['pdf_path' => $pdfPath]);

            return redirect()->route('admin.certificate.index')
                ->with('success', 'Certificate generated successfully!');

        } catch (MpdfException $e) {
            Log::error('Certificate PDF Generation Error: ' . $e->getMessage());
            $certificate->delete();
            return back()->with('error', 'Certificate generation failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Certificate Generation Error: ' . $e->getMessage());
            $certificate->delete();
            return back()->with('error', 'Certificate generation failed. Please try again.');
        }
    }

    public function show($id)
    {
        $certificate = Certificate::with('registration.owner', 'registration.hostel')->findOrFail($id);
        return view('admin.certificates.certificate', [
            'certificate' => $certificate,
            'registration' => $certificate->registration,
        ]);
    }

    public function download($id)
    {
        $certificate = Certificate::with('registration.owner', 'registration.hostel')->findOrFail($id);

        try {
            $html = view('admin.certificates.certificate', [
                'certificate' => $certificate,
                'registration' => $certificate->registration,
            ])->render();

            $tempDir = storage_path('app/mpdf');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'default_font_size' => 12,
                'default_font' => 'dejavusans',
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'margin_left' => 10,
                'margin_right' => 10,
                'tempDir' => $tempDir,
            ]);

            // ===== WATERMARK IMAGE (Fixed) =====
            $logoPath = public_path('images/logo.png');
            if (file_exists($logoPath)) {
                $mpdf->SetWatermarkImage($logoPath, 0.08, 'F', 'P');
                $mpdf->showWatermarkImage = true;
            }

            $mpdf->WriteHTML($html);

            $filename = 'certificate_' . ($certificate->certificate_number ?? $certificate->id) . '.pdf';

            // Clear any output buffers
            if (ob_get_length()) {
                ob_clean();
            }

            // Get PDF content
            $pdfContent = $mpdf->Output($filename, 'S');

            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Content-Length' => strlen($pdfContent),
            ]);

        } catch (MpdfException $e) {
            Log::error('Certificate Download Error: ' . $e->getMessage());
            return back()->with('error', 'PDF download failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Certificate Download Error: ' . $e->getMessage());
            return back()->with('error', 'PDF download failed. Please try again.');
        }
    }

    public function preview(Request $request)
    {
        $registration = Registration::with('owner', 'hostel')->findOrFail($request->registration_id);

        $certificate = new Certificate([
            'certificate_number' => 'HEAN-' . date('Y') . '-XXXXX',
            'issued_date' => now(),
            'operator_name' => null,
            'address' => null,
            'contact' => null,
            'pan' => null,
        ]);
        $certificate->setRelation('registration', $registration);

        return view('admin.certificates.certificate', [
            'certificate' => $certificate,
            'registration' => $registration,
        ]);
    }
}