<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Hostel;
use App\Models\CommitteeMember;
use App\Models\Notice;
use App\Models\GalleryImage;
use App\Models\Setting;
use App\Models\Registration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // =============================================
        // 1. REAL USERS (तपाईंको अनुरोध अनुसार)
        // =============================================
        $users = [
            // Chairman
            [
                'name' => 'Kiran Sharma',
                'email' => 'kiransharma@gmail.com',
                'role' => 'admin',
            ],
            // Vice-chairman
            [
                'name' => 'Junu Dhakal',
                'email' => 'junudhakal@gmail.com',
                'role' => 'committee',
            ],
            // Admin
            [
                'name' => 'Suchana Shahi Thakuri',
                'email' => 'suchanashahi@gmail.com',
                'role' => 'admin',
            ],
            // Member
            [
                'name' => 'Niraj Dhakal',
                'email' => 'nirajdhakal@gmail.com',
                'role' => 'committee',
            ],
            // Admin (तपाईंले पहिले राख्नुभएको)
            [
                'name' => 'Parashar Regmi',
                'email' => 'parasharregmi@gmail.com',
                'role' => 'admin',
            ],
            // थप ५ जना नमुना प्रयोगकर्ता (viewer)
            [
                'name' => 'Sita Poudel',
                'email' => 'sitapoudel@gmail.com',
                'role' => 'viewer',
            ],
            [
                'name' => 'Ram Thapa',
                'email' => 'ramthapa@gmail.com',
                'role' => 'viewer',
            ],
            [
                'name' => 'Gita Adhikari',
                'email' => 'gitaadhikari@gmail.com',
                'role' => 'viewer',
            ],
            [
                'name' => 'Hari Shrestha',
                'email' => 'harishrestha@gmail.com',
                'role' => 'viewer',
            ],
            [
                'name' => 'Saraswati Neupane',
                'email' => 'saraswatineupane@gmail.com',
                'role' => 'viewer',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('Himalayan@1981'), // सबैको पासवर्ड एउटै
                'role' => $user['role'],
            ]);
        }

        // =============================================
        // 2. COMMITTEE MEMBERS (समिति सदस्यहरू - छुट्टै तालिका)
        // =============================================
        CommitteeMember::create([
            'name' => 'Kiran Sharma',
            'position' => 'Chairman',
            'image' => null,
            'facebook' => 'https://facebook.com/kiran',
            'linkedin' => 'https://linkedin.com/in/kiran',
            'is_published' => true,
            'order' => 1,
        ]);

        CommitteeMember::create([
            'name' => 'Junu Dhakal',
            'position' => 'Vice-Chairman',
            'image' => null,
            'facebook' => 'https://facebook.com/junu',
            'linkedin' => 'https://linkedin.com/in/junu',
            'is_published' => true,
            'order' => 2,
        ]);

        CommitteeMember::create([
            'name' => 'Suchana Shahi Thakuri',
            'position' => 'Admin Secretary',
            'image' => null,
            'facebook' => 'https://facebook.com/suchana',
            'linkedin' => 'https://linkedin.com/in/suchana',
            'is_published' => true,
            'order' => 3,
        ]);

        CommitteeMember::create([
            'name' => 'Niraj Dhakal',
            'position' => 'Member',
            'image' => null,
            'facebook' => 'https://facebook.com/niraj',
            'linkedin' => 'https://linkedin.com/in/niraj',
            'is_published' => true,
            'order' => 4,
        ]);

        // =============================================
        // 3. HOSTELS (Boys/Girls सहित)
        // =============================================
        Hostel::create([
            'name_nepali' => 'सूर्योदय ब्वाइज होस्टेल',
            'name_english' => 'Suryodaya Boys Hostel',
            'operator_name' => 'राम प्रसाद दाहाल',
            'district' => 'काठमाडौं',
            'municipality' => 'काठमाडौं महानगरपालिका',
            'ward' => '१२',
            'street' => 'चावहिल',
            'contact' => '9841234567',
            'description' => 'आधुनिक सुविधासहितको सुरक्षित ब्वाइज होस्टेल।',
            'approved' => true,
            'featured' => true,
            'visible' => true,
            'image' => null,
        ]);

        Hostel::create([
            'name_nepali' => 'सूर्योदय गर्ल्स होस्टेल',
            'name_english' => 'Suryodaya Girls Hostel',
            'operator_name' => 'लक्ष्मी शर्मा',
            'district' => 'काठमाडौं',
            'municipality' => 'काठमाडौं महानगरपालिका',
            'ward' => '१२',
            'street' => 'चावहिल',
            'contact' => '9841234568',
            'description' => 'सुरक्षित र आरामदायी गर्ल्स होस्टेल।',
            'approved' => true,
            'featured' => false,
            'visible' => true,
            'image' => null,
        ]);

        Hostel::create([
            'name_nepali' => 'हिमालयन ब्वाइज होस्टेल',
            'name_english' => 'Himalayan Boys Hostel',
            'operator_name' => 'हरि अधिकारी',
            'district' => 'ललितपुर',
            'municipality' => 'ललितपुर महानगरपालिका',
            'ward' => '५',
            'street' => 'कुपण्डोल',
            'contact' => '9812345678',
            'description' => 'विद्यार्थीहरूको लागि उत्कृष्ट ब्वाइज आवास।',
            'approved' => true,
            'featured' => false,
            'visible' => true,
            'image' => null,
        ]);

        Hostel::create([
            'name_nepali' => 'हिमालयन गर्ल्स होस्टेल',
            'name_english' => 'Himalayan Girls Hostel',
            'operator_name' => 'सुनिता पण्डित',
            'district' => 'ललितपुर',
            'municipality' => 'ललितपुर महानगरपालिका',
            'ward' => '३',
            'street' => 'पुल्चोक',
            'contact' => '9876543210',
            'description' => 'सुरक्षित र शान्त गर्ल्स होस्टेल।',
            'approved' => true,
            'featured' => false,
            'visible' => true,
            'image' => null,
        ]);

        Hostel::create([
            'name_nepali' => 'गोकर्ण ब्वाइज होस्टेल',
            'name_english' => 'Gokarna Boys Hostel',
            'operator_name' => 'गोविन्द न्यौपाने',
            'district' => 'भक्तपुर',
            'municipality' => 'भक्तपुर नगरपालिका',
            'ward' => '८',
            'street' => 'सल्लाघारी',
            'contact' => '9856789123',
            'description' => 'शान्त वातावरणमा अध्ययनमैत्री ब्वाइज होस्टेल।',
            'approved' => true,
            'featured' => false,
            'visible' => true,
            'image' => null,
        ]);

        // =============================================
        // 4. NOTICES (सूचनाहरू)
        // =============================================
        Notice::create([
            'title' => 'HEAN Hostel Summit 2025 – Registration Open',
            'content' => 'Join the largest gathering of hostel entrepreneurs in Nepal. The summit will feature workshops, networking sessions, and guest speakers from the hospitality industry.',
            'date' => '2025-06-15',
            'category' => 'Event',
            'image' => null,
            'is_featured' => true,
            'is_published' => true,
        ]);

        Notice::create([
            'title' => 'नयाँ सदस्यता अभियान सुरु',
            'content' => 'HEAN ले नयाँ सदस्यता अभियान सुरु गरेको छ। आगामी ३ महिनामा सबै होस्टेलहरूलाई सदस्य बनाउने लक्ष्य राखिएको छ।',
            'date' => '2025-05-20',
            'category' => 'News',
            'image' => null,
            'is_featured' => false,
            'is_published' => true,
        ]);

        Notice::create([
            'title' => 'स्वच्छता कार्यशाला सम्पन्न',
            'content' => 'HEAN को आयोजनामा होस्टल सञ्चालकहरूको लागि स्वच्छता र सुरक्षा कार्यशाला सम्पन्न भएको छ। ५० भन्दा बढी सञ्चालकले सहभागिता जनाएका थिए।',
            'date' => '2025-04-10',
            'category' => 'Workshop',
            'image' => null,
            'is_featured' => true,
            'is_published' => true,
        ]);

        // =============================================
        // 5. GALLERY IMAGES (ग्यालरी)
        // =============================================
        GalleryImage::create([
            'title' => 'HEAN Summit 2025 - Group Photo',
            'image' => 'gallery/summit-2025.jpg',
            'is_published' => true,
        ]);

        GalleryImage::create([
            'title' => 'Award Ceremony 2024',
            'image' => 'gallery/award-ceremony.jpg',
            'is_published' => true,
        ]);

        GalleryImage::create([
            'title' => 'Hostel Inspection Visit',
            'image' => 'gallery/inspection-visit.jpg',
            'is_published' => true,
        ]);

        // =============================================
        // 6. SETTINGS (सेटिङहरू)
        // =============================================
        Setting::create(['key' => 'site_name', 'value' => 'HEAN']);
        Setting::create(['key' => 'contact_address', 'value' => 'Kathmandu-10, Nepal']);
        Setting::create(['key' => 'contact_phone', 'value' => '01-5921615']);
        Setting::create(['key' => 'contact_email', 'value' => 'hostelsangh@gmail.com']);
        Setting::create(['key' => 'office_hours', 'value' => 'Sun – Fri: 9:00 AM – 5:00 PM']);

        // =============================================
        // 7. SAMPLE REGISTRATIONS (नमुना आवेदन)
        // =============================================
        Registration::create([
            'hostel_name' => 'पशुपति होस्टेल',
            'operator_name' => 'गोविन्द न्यौपाने',
            'district' => 'काठमाडौं',
            'municipality' => 'काठमाडौं महानगरपालिका',
            'ward' => '१५',
            'street' => 'गौशाला',
            'contact' => '9867890123',
            'documents' => null,
            'status' => 'pending',
            'inspector_id' => null,
        ]);

        Registration::create([
            'hostel_name' => 'सगरमाथा होस्टेल',
            'operator_name' => 'सुनिता पण्डित',
            'district' => 'ललितपुर',
            'municipality' => 'ललितपुर महानगरपालिका',
            'ward' => '३',
            'street' => 'पुल्चोक',
            'contact' => '9876543210',
            'documents' => null,
            'status' => 'inspection',
            'inspector_id' => null,
        ]);
    }
}