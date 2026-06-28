<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    /**
     * Display a listing of generated certificates.
     */
    public function index()
    {
        $certificates = Certificate::with('registration.owner', 'registration.hostel')
            ->latest()
            ->paginate(15);

        return view('admin.certificate.index', compact('certificates'));
    }

    /**
     * Generate a certificate for a given registration.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
        ]);

        $registration = Registration::with('owner', 'hostel')
            ->findOrFail($request->registration_id);

        // Check if certificate already exists for this registration
        if ($registration->certificates()->exists()) {
            return back()->with('error', 'Certificate already generated for this registration.');
        }

        // Generate a unique certificate number
        $certificateNumber = 'HEAN-' . date('Y') . '-' . str_pad(
            Certificate::count() + 1,
            5,
            '0',
            STR_PAD_LEFT
        );

        // Prepare data for PDF
        $data = [
            'registration' => $registration,
            'certificate_number' => $certificateNumber,
            'issued_date' => now()->format('F d, Y'),
            'owner_name' => $registration->owner->name ?? 'N/A',
            'hostel_name' => $registration->hostel->name ?? 'N/A',
            'address' => $registration->hostel
                ? ($registration->hostel->district . ', ' . $registration->hostel->municipality)
                : 'N/A',
        ];

        // Generate PDF
        $pdf = Pdf::loadView('pdf.certificate', $data);
        $pdfPath = 'certificates/cert_' . uniqid() . '.pdf';
        Storage::disk('public')->put($pdfPath, $pdf->output());

        // Save certificate record
        $certificate = Certificate::create([
            'registration_id' => $registration->id,
            'certificate_number' => $certificateNumber,
            'issued_date' => now(),
            'pdf_path' => $pdfPath,
        ]);

        return redirect()->route('admin.certificate.index')
            ->with('success', 'Certificate generated successfully!');
    }

    /**
     * Download the certificate PDF.
     */
    public function download($id)
    {
        $certificate = Certificate::findOrFail($id);

        // Check if file exists
        if (!Storage::disk('public')->exists($certificate->pdf_path)) {
            abort(404, 'Certificate file not found.');
        }

        return response()->download(
            storage_path('app/public/' . $certificate->pdf_path),
            'certificate_' . $certificate->certificate_number . '.pdf'
        );
    }

    /**
     * Preview a certificate (for admin preview before generating).
     * Optional helper method.
     */
    public function preview(Request $request)
    {
        $registration = Registration::with('owner', 'hostel')
            ->findOrFail($request->registration_id);

        $data = [
            'registration' => $registration,
            'certificate_number' => 'HEAN-' . date('Y') . '-XXXXX',
            'issued_date' => now()->format('F d, Y'),
            'owner_name' => $registration->owner->name ?? 'N/A',
            'hostel_name' => $registration->hostel->name ?? 'N/A',
            'address' => $registration->hostel
                ? ($registration->hostel->district . ', ' . $registration->hostel->municipality)
                : 'N/A',
        ];

        return view('pdf.certificate', $data);
    }
}