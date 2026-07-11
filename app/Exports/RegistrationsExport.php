<?php

namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RegistrationsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Registration::with('hostel');

        // Apply filters (same as index)
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('hostel_name', 'LIKE', "%{$search}%")
                  ->orWhere('hostel_name_english', 'LIKE', "%{$search}%")
                  ->orWhere('operator_name', 'LIKE', "%{$search}%")
                  ->orWhere('contact', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('pan', 'LIKE', "%{$search}%")
                  ->orWhere('registration_number', 'LIKE', "%{$search}%")
                  ->orWhere('local_registration_number', 'LIKE', "%{$search}%");
            });
        }

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['source'])) {
            $query->where('source', $this->filters['source']);
        }

        if (!empty($this->filters['district'])) {
            $query->where('district', $this->filters['district']);
        }

        if (!empty($this->filters['date_from'])) {
            $query->whereDate('submitted_at', '>=', $this->filters['date_from']);
        }
        if (!empty($this->filters['date_to'])) {
            $query->whereDate('submitted_at', '<=', $this->filters['date_to']);
        }

        if (!empty($this->filters['local_reg_number'])) {
            $query->where('local_registration_number', 'LIKE', "%{$this->filters['local_reg_number']}%");
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'S.N.',
            'दर्ता नम्बर',
            'स्थानीय दर्ता नम्बर',
            'होस्टल नाम (नेपाली)',
            'होस्टल नाम (अंग्रेजी)',
            'प्रकार',
            'जिल्ला',
            'नगरपालिका',
            'वडा',
            'सडक',
            'संचालक',
            'सम्पर्क',
            'ईमेल',
            'PAN',
            'क्षमता (बेड)',
            'कोठा',
            'स्थापना वर्ष',
            'स्रोत',
            'स्थिति',
            'पेश गरिएको मिति',
            'स्वीकृत मिति',
        ];
    }

    public function map($registration): array
    {
        static $sn = 0;
        $sn++;

        return [
            $sn,
            $registration->registration_number ?? 'N/A',
            $registration->local_registration_number ?? 'N/A',
            $registration->hostel_name ?? 'N/A',
            $registration->hostel_name_english ?? 'N/A',
            ucfirst($registration->hostel_type ?? 'N/A'),
            $registration->district ?? 'N/A',
            $registration->municipality ?? 'N/A',
            $registration->ward ?? 'N/A',
            $registration->street ?? 'N/A',
            $registration->operator_name ?? 'N/A',
            $registration->contact ?? 'N/A',
            $registration->email ?? 'N/A',
            $registration->pan ?? 'N/A',
            $registration->capacity ?? 0,
            $registration->rooms ?? 0,
            $registration->established_year ?? 'N/A',
            ucfirst($registration->source ?? 'N/A'),
            ucfirst($registration->status ?? 'N/A'),
            $registration->submitted_at ? $registration->submitted_at->format('Y-m-d') : 'N/A',
            $registration->approved_at ? $registration->approved_at->format('Y-m-d') : 'N/A',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}