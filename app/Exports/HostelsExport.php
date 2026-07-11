<?php

namespace App\Exports;

use App\Models\Hostel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HostelsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Hostel::query();

        // Apply filters (same as index)
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name_nepali', 'LIKE', "%{$search}%")
                  ->orWhere('name_english', 'LIKE', "%{$search}%")
                  ->orWhere('district', 'LIKE', "%{$search}%")
                  ->orWhere('operator_name', 'LIKE', "%{$search}%")
                  ->orWhere('contact', 'LIKE', "%{$search}%")
                  ->orWhere('registration_number', 'LIKE', "%{$search}%")
                  ->orWhere('local_registration_number', 'LIKE', "%{$search}%");
            });
        }

        if (!empty($this->filters['status'])) {
            if ($this->filters['status'] == 'approved') {
                $query->where('approved', true);
            } elseif ($this->filters['status'] == 'pending') {
                $query->where('approved', false);
            }
        }

        if (isset($this->filters['featured']) && $this->filters['featured'] !== '') {
            $query->where('featured', $this->filters['featured'] == '1');
        }

        if (isset($this->filters['visible']) && $this->filters['visible'] !== '') {
            $query->where('visible', $this->filters['visible'] == '1');
        }

        if (!empty($this->filters['type'])) {
            $query->where('type', $this->filters['type']);
        }

        if (!empty($this->filters['district'])) {
            $query->where('district', $this->filters['district']);
        }

        if (!empty($this->filters['local_reg_number'])) {
            $query->where('local_registration_number', 'LIKE', "%{$this->filters['local_reg_number']}%");
        }

        if (!empty($this->filters['capacity_min'])) {
            $query->where('capacity', '>=', $this->filters['capacity_min']);
        }
        if (!empty($this->filters['capacity_max'])) {
            $query->where('capacity', '<=', $this->filters['capacity_max']);
        }

        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }
        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'S.N.',
            'दर्ता नम्बर',
            'स्थानीय दर्ता नम्बर',
            'नाम (नेपाली)',
            'नाम (अंग्रेजी)',
            'प्रकार',
            'जिल्ला',
            'नगरपालिका',
            'वडा',
            'सडक',
            'संचालक',
            'सम्पर्क',
            'ईमेल',
            'क्षमता (बेड)',
            'कोठा',
            'स्थापना वर्ष',
            'स्वीकृत',
            'फिचर्ड',
            'दृश्य',
        ];
    }

    public function map($hostel): array
    {
        static $sn = 0;
        $sn++;

        return [
            $sn,
            $hostel->registration_number ?? 'N/A',
            $hostel->local_registration_number ?? 'N/A',
            $hostel->name_nepali ?? 'N/A',
            $hostel->name_english ?? 'N/A',
            ucfirst($hostel->type ?? 'N/A'),
            $hostel->district ?? 'N/A',
            $hostel->municipality ?? 'N/A',
            $hostel->ward ?? 'N/A',
            $hostel->street ?? 'N/A',
            $hostel->operator_name ?? 'N/A',
            $hostel->contact ?? 'N/A',
            $hostel->email ?? 'N/A',
            $hostel->capacity ?? 0,
            $hostel->rooms ?? 0,
            $hostel->established_year ?? 'N/A',
            $hostel->approved ? 'हो' : 'होइन',
            $hostel->featured ? 'हो' : 'होइन',
            $hostel->visible ? 'हो' : 'होइन',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}