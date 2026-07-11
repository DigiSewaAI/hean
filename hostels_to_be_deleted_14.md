ID: 527 | Name: सूर्योदय ब्वाइज होस्टेल | HEAN: REG-DEMO-001 | Source: admin | Created: 2026-07-03 01:33:41
ID: 528 | Name: हिमालय गर्ल्स होस्टेल | HEAN: REG-DEMO-002 | Source: admin | Created: 2026-07-03 01:33:41
ID: 529 | Name: अन्नपूर्ण को-एड होस्टेल | HEAN: REG-DEMO-003 | Source: admin | Created: 2026-07-03 01:33:41
ID: 530 | Name: पशुपति ब्वाइज होस्टेल | HEAN: REG-DEMO-004 | Source: admin | Created: 2026-07-03 01:33:41
ID: 531 | Name: सगरमाथा गर्ल्स होस्टेल | HEAN: REG-DEMO-005 | Source: admin | Created: 2026-07-03 01:33:41
ID: 532 | Name: मनकामना ब्वाइज होस्टेल | HEAN: REG-2026-00532 | Source: admin | Created: 2026-07-03 04:13:35
ID: 533 | Name: ब्लु शीप गर्ल्स होस्टेल | HEAN: REG-2026-00533 | Source: admin | Created: 2026-07-03 06:27:28
ID: 534 | Name: Test Public Hostel | HEAN: REG-2026-00534 | Source: public | Created: 2026-07-03 08:16:58  TEST/DUMMY
ID: 535 | Name: तनहुँ ब्वाइज होस्टेल | HEAN: REG-2026-00535 | Source: public | Created: 2026-07-03 08:59:49
ID: 536 | Name: विरेन्द्र ब्वाइज होस्टेल | HEAN: REG-2026-00536 | Source: admin | Created: 2026-07-04 05:42:37  TEST/DUMMY
ID: 537 | Name: गण्डकी गर्ल्स होस्टेल | HEAN: REG-2026-00537 | Source: public | Created: 2026-07-04 05:51:33  TEST/DUMMY
ID: 538 | Name: नागार्जुन ब्वाइज होस्टेल | HEAN: HEAN-2026-000645 | Source: admin | Created: 2026-07-05 08:08:33
ID: 539 | Name: कामना महिला हस्टेल | HEAN: HEAN-2026-000646 | Source: public | Created: 2026-07-05 09:30:36
ID: 540 | Name: धौलागिरि को-एड होस्टेल | HEAN: HEAN-2026-000647 | Source: admin | Created: 2026-07-08 08:11:39
ID: 541 | Name: मच्छिन्द्र ब्वाइज होस्टेल | HEAN: HEAN-2026-000648 | Source: public | Created: 2026-07-08 08:58:42
--------------------------------------------------------------------------------
Total Registrations: 15

>
> // ====================================================

> // 2. MANUAL HOSTELS (NOT CREATED VIA IMPORT TODAY)

> //    Filter: created_at < '2026-07-10' (Import भएक मत भनद पहल)

> // ====================================================

> $hostels = App\Models\Hostel::where('created_at', '<', '2026-07-10')->get();

= Illuminate\Database\Eloquent\Collection {#9131
    all: [
      App\Models\Hostel {#9145
        id: 635,
        registration_number: "HEAN-2026-000635",
        old_registration_number: null,
        local_registration_number: null,
        owner_id: null,
        name_nepali: "सूर्योदय ब्वाइज होस्टेल",
        name_english: "Suryoday Boys Hostel",
        block_name: null,
        type: "boys",
        capacity: 45,
        rooms: 15,
        established_year: 2020,
        operator_name: "Ram Prasad Sharma",
        district: "Kathmandu",
        province: "Bagmati",
        municipality: "Kathmandu Metropolitan City",
        ward: "4",
        street: "Gaushala Road",
        landmark: "Near Gaushala Bus Stop",
        contact: "9841234567",
        email: "info@suryodayboys.com",
        pan: "601234567",
        website: null,
        description: "Demo hostel for client presentation.",
        approved: 1,
        featured: 1,
        visible: 1,
        image: null,
        created_at: "2026-07-03 01:33:41",
        updated_at: "2026-07-03 01:33:41",
      },
      App\Models\Hostel {#9146
        id: 636,
        registration_number: "HEAN-2026-000636",
        old_registration_number: null,
        local_registration_number: null,
        owner_id: null,
        name_nepali: "हिमालय गर्ल्स होस्टेल",
        name_english: "Himalaya Girls Hostel",
        block_name: null,
        type: "girls",
        capacity: 50,
        rooms: 17,
        established_year: 2020,
        operator_name: "Sita Devi Pandey",
        district: "Lalitpur",
        province: "Bagmati",
        municipality: "Lalitpur Metropolitan City",
        ward: "8",
        street: "Kupondole Height",
        landmark: "Near Kupondole Chowk",
        contact: "9851122334",
        email: "info@himalayagirls.com",
        pan: "601234568",
        website: null,
        description: "Demo hostel for client presentation.",
        approved: 1,
        featured: 0,
        visible: 1,
        image: null,
        created_at: "2026-07-03 01:33:41",
        updated_at: "2026-07-03 01:33:41",
      },
      App\Models\Hostel {#9143
        id: 637,
        registration_number: "HEAN-2026-000637",
        old_registration_number: null,
        local_registration_number: null,
        owner_id: null,
        name_nepali: "अन्नपूर्ण को-एड होस्टेल",
        name_english: "Annapurna Co-Ed Hostel",
        block_name: null,
        type: "co-ed",
        capacity: 60,
        rooms: 20,
        established_year: 2020,
        operator_name: "Krishna Prasad Dhakal",
        district: "Bhaktapur",
        province: "Bagmati",
        municipality: "Bhaktapur Municipality",
        ward: "6",
        street: "Kamal Binayak Road",
        landmark: "Near Changu Narayan Temple",
        contact: "9845566778",
        email: "info@annapurnacoed.com",
        pan: "601234569",
        website: null,
        description: "Demo hostel for client presentation.",
        approved: 1,
        featured: 1,
        visible: 1,
        image: null,
        created_at: "2026-07-03 01:33:41",
        updated_at: "2026-07-03 01:33:41",
      },
      App\Models\Hostel {#9142
        id: 638,
        registration_number: "HEAN-2026-000638",
        old_registration_number: null,
        local_registration_number: null,
        owner_id: null,
        name_nepali: "पशुपति ब्वाइज होस्टेल",
        name_english: "Pashupati Boys Hostel",
        block_name: null,
        type: "boys",
        capacity: 35,
        rooms: 12,
        established_year: 2020,
        operator_name: "Hari Sharma",
        district: "Kathmandu",
        province: "Bagmati",
        municipality: "Kathmandu Metropolitan City",
        ward: "2",
        street: "Gaushala Road",
        landmark: "Near Pashupatinath Temple",
        contact: "9849876543",
        email: "info@pashupatiboys.com",
        pan: "601234570",
        website: null,
        description: "Demo hostel for client presentation.",
        approved: 1,
        featured: 1,
        visible: 1,
        image: null,
        created_at: "2026-07-03 01:33:41",
        updated_at: "2026-07-03 03:47:36",
      },
      App\Models\Hostel {#9141
        id: 639,
        registration_number: "HEAN-2026-000639",
        old_registration_number: null,
        local_registration_number: null,
        owner_id: null,
        name_nepali: "सगरमाथा गर्ल्स होस्टेल",
        name_english: "Sagarmatha Girls Hostel",
        block_name: null,
        type: "girls",
        capacity: 40,
        rooms: 13,
        established_year: 2020,
        operator_name: "Gita Adhikari",
        district: "Lalitpur",
        province: "Bagmati",
        municipality: "Lalitpur Metropolitan City",
        ward: "10",
        street: "Pulchowk Road",
        landmark: "Near Pulchowk Campus",
        contact: "9851234567",
        email: "info@sagarmathagirls.com",
        pan: "601234571",
        website: null,
        description: "Demo hostel for client presentation.",
        approved: 1,
        featured: 1,
        visible: 1,
        image: null,
        created_at: "2026-07-03 01:33:41",
        updated_at: "2026-07-05 09:39:30",
      },
      App\Models\Hostel {#9140
        id: 640,
        registration_number: "HEAN-2026-000640",
        old_registration_number: null,
        local_registration_number: null,
        owner_id: null,
        name_nepali: "मनकामना ब्वाइज होस्टेल",
        name_english: "Manakamana Boys Hostel",
        block_name: null,
        type: "boys",
        capacity: 30,
        rooms: 15,
        established_year: 2020,
        operator_name: "Ram Prasad Luitel",
        district: "Kathmandu",
        province: "Bagmati",
        municipality: "Kathmandu Metropolitan City",
        ward: "11",
        street: "Old Baneshor",
        landmark: "Near Nabil Bank",
        contact: "9841234564",
        email: "ram@example.com",
        pan: "987654321",
        website: "https://manakamanahostel.com",
        description: "मनकामना ब्वाइज होस्टेल काभ्रेको पनौतीमा अवस्थित छ। यहाँ ३० बेड र १५ कोठा छन्। सबै कोठा फर्निचरसहित, २४ घण्टा पानी र विद्युत् सुविधा उपलब्ध छ।",
        approved: 1,
        featured: 1,
        visible: 1,
        image: "hostels/K9XVI4IqCDoGgPywWNYdcGXP2f2Oen9VJYX6DG6i.jpg",
        created_at: "2026-07-03 06:56:55",
        updated_at: "2026-07-05 09:39:30",
      },
      App\Models\Hostel {#9139
        id: 641,
        registration_number: "HEAN-2026-000641",
        old_registration_number: null,
        local_registration_number: null,
        owner_id: null,
        name_nepali: "ब्लु शीप गर्ल्स होस्टेल",
        name_english: "Blue Sheep Girls Hostel",
        block_name: null,
        type: "girls",
        capacity: 40,
        rooms: 20,
        established_year: 2021,
        operator_name: "Sarita Khadka",
        district: "Kaski",
        province: "Gandaki",
        municipality: "Pokhara Metropolitan City",
        ward: "15",
        street: "Lakeside, 6",
        landmark: "Opposite of Fewa Lake",
        contact: "9841234500",
        email: "sarita@bluesheep.com",
        pan: "987654321",
        website: "https://bluesheepgirlshostel.com",
        description: "पोखराको लेकसाइडमा अवस्थित यो होस्टेल ४० बेड र २० कोठासहितको सुविधा सम्पन्न छ। सबै कोठामा अट्याच बाथरूम, २४ घण्टा पानी, विद्युत् र वाइफाइ सुविधा उपलब्ध छ। होस्टेलमा पुस्तकालय, जिम र क्यान्टिन पनि छ।",
        approved: 1,
        featured: 1,
        visible: 1,
        image: "hostels/3v6OO2QB57Qfho2h7swMQXHWxxVYw8y8UwLlygIx.jpg",
        created_at: "2026-07-03 06:56:55",
        updated_at: "2026-07-03 07:16:47",
      },
      App\Models\Hostel {#9138
        id: 642,
        registration_number: "HEAN-2026-000642",
        old_registration_number: null,
        local_registration_number: null,
        owner_id: null,
        name_nepali: "तनहुँ ब्वाइज होस्टेल",
        name_english: "Tanahun Boys Hostel",
        block_name: null,
        type: "boys",
        capacity: 45,
        rooms: 18,
        established_year: 2019,
        operator_name: "Ram Prasad Adhikari",
        district: "Bhaktapur",
        province: "Bagmati",
        municipality: "Changunarayan Municipality",
        ward: "7",
        street: "Changu Narayan Road, Kamal Binayak",
        landmark: "Buspark Najik",
        contact: "9851234567",
        email: "tanahunboys@gmail.com",
        pan: "9876543210",
        website: null,
        description: "तनहुँको ब्यास नगरपालिकामा अवस्थित, छात्रवासको लागि उपयुक्त वातावरण। सुरक्षित र सुविधाजनक।",
        approved: 1,
        featured: 0,
        visible: 1,
        image: "hostels/6a47843207dd6_vjBfI8PDDomSTLRYJrhiqOM7O1WzMoA7YHRBH1mG.jpg",
        created_at: "2026-07-03 09:38:27",
        updated_at: "2026-07-03 09:43:14",
      },
      App\Models\Hostel {#9137
        id: 643,
        registration_number: "HEAN-2026-000643",
        old_registration_number: null,
        local_registration_number: null,
        owner_id: null,
        name_nepali: "विरेन्द्र ब्वाइज होस्टेल",
        name_english: "Birendra Boys Hostel",
        block_name: null,
        type: "boys",
        capacity: 55,
        rooms: 25,
        established_year: 2018,
        operator_name: "Ram Prasad Koirala",
        district: "Kailali",
        province: "Sudurpashchim",
        municipality: "Dhangadhi Sub-Metropolitan City",
        ward: "4",
        street: "Attariya Road",
        landmark: "Opposite of Dhangadhi Stadium",
        contact: "9841234444",
        email: "test.owner.birendra@example.com",
        pan: "9876543210",
        website: "https://birendrahostel.com",
        description: "Modern boys hostel with high-speed WiFi, backup generator, hot water, and a large common room. Located in a quiet area near the main campus.",
        approved: 1,
        featured: 0,
        visible: 1,
        image: "hostels/6a489d9ebe005_YnU41Gteq8qJo1VyCqKt0FI4mNHS6ZDWAWZo5r5Z.jpg",
        created_at: "2026-07-04 05:43:58",
        updated_at: "2026-07-04 05:43:58",
      },
      App\Models\Hostel {#9136
        id: 644,
        registration_number: "HEAN-2026-000644",
        old_registration_number: null,
        local_registration_number: null,
        owner_id: null,
        name_nepali: "गण्डकी गर्ल्स होस्टेल",
        name_english: "Gandaki Girls Hostel",
        block_name: "Block A",
        type: "girls",
        capacity: 48,
        rooms: 20,
        established_year: 2002,
        operator_name: "Gita Sharma",
        district: "Kaski",
        province: "Gandaki",
        municipality: "Pokhara Metropolitan City",
        ward: "15",
        street: "Lakeside Road",
        landmark: "Near Phewa Lake",
        contact: "9861234500",
        email: "test.gandaki.girls@example.com",
        pan: "789456123",
        website: "https://gandakigirlshostel.com",
        description: "Safe girls hostel with Wi-Fi, hot water, study room",
        approved: 1,
        featured: 0,
        visible: 1,
        image: "hostels/6a489fb042465_pfKnoBMo9V4x3HgSlUxnjXA4ubO6WVDcnsjMhqja.jpg",
        created_at: "2026-07-04 05:52:48",
        updated_at: "2026-07-04 05:52:48",
      },
      App\Models\Hostel {#9135
        id: 645,
        registration_number: "HEAN-2026-000645",
        old_registration_number: null,
        local_registration_number: null,
        owner_id: null,
        name_nepali: "नागार्जुन ब्वाइज होस्टेल",
        name_english: "Nagarjun Boys Hostel",
        block_name: null,
        type: "boys",
        capacity: 50,
        rooms: 19,
        established_year: 2019,
        operator_name: "Hari Prasad Upadhyay",
        district: "Bhaktapur",
        province: "Bagmati",
        municipality: "Changunarayan Municipality",
        ward: "4",
        street: "Changu Narayan Road, Kamal Binayak",
        landmark: null,
        contact: "9851122334",
        email: "contact@nagarjunhostel.com",
        pan: null,
        website: null,
        description: "Peaceful environment, Free Wi-Fi, 24/7 security, Backup power, Healthy meals mess.",
        approved: 1,
        featured: 0,
        visible: 1,
        image: "hostels/6a4a117ca28d1_g057MY4bqD7LR3ZsdQW7ClBCGPjMkIZxKIaCwvj3.jpg",
        created_at: "2026-07-05 08:10:36",
        updated_at: "2026-07-05 08:10:36",
      },
      App\Models\Hostel {#9134
        id: 646,
        registration_number: "HEAN-2026-000646",
        old_registration_number: null,
        local_registration_number: null,
        owner_id: null,
        name_nepali: "कामना महिला हस्टेल",
        name_english: "Kamana Girls Hostel",
        block_name: null,
        type: "girls",
        capacity: 25,
        rooms: 10,
        established_year: 2023,
        operator_name: "Kamana Upreti",
        district: "Kathmandu",
        province: "Bagmati",
        municipality: "Kathmandu Metropolitan City",
        ward: "31",
        street: "Thulo Kharibot-New Baneshor",
        landmark: "Deurali Club",
        contact: "9842657345",
        email: "kamanaupreti11@gmail.com",
        pan: null,
        website: null,
        description: "Kamana Girls Hostel is a safe, well-managed, and fully secured accommodation exclusively for female students and working professionals. Established in 2023, we offer 10 spacious rooms with a total capacity of 25 beds. Our hostel provides a peaceful environment perfect for studying and personal growth, combined with modern amenities and round-the-clock security. We are dedicated to making every resident feel at home with our hygienic food, reliable Wi-Fi, and supportive staff.",
        approved: 1,
        featured: 1,
        visible: 1,
        image: "hostels/6a4a24ce08975_fbe6oD4Dz0rN6Bk61BECv3rOv4x0GtKjQBtUMuA1.jpg",
        created_at: "2026-07-05 09:33:02",
        updated_at: "2026-07-05 09:39:30",
      },
      App\Models\Hostel {#9133
        id: 647,
        registration_number: "HEAN-2026-000647",
        old_registration_number: null,
        local_registration_number: "KMC-W31-2082-00125",
        owner_id: null,
        name_nepali: "धौलागिरि को-एड होस्टेल",
        name_english: "Dhaulagiri Co-Ed Hostel",
        block_name: null,
        type: "co-ed",
        capacity: 65,
        rooms: 22,
        established_year: 2019,
        operator_name: "Ram Krishna Adhikari",
        district: "Kathmandu",
        province: "Bagmati",
        municipality: "Kathmandu Metropolitan City",
        ward: "30",
        street: "Kamalpokhari, 30, City-Center",
        landmark: "Near city center",
        contact: "9841234588",
        email: "ram.adhikari@gmail.com",
        pan: null,
        website: "https://dhaulagirihostel.com.np",
        description: <<<EOS
          We offer comfortable accommodation with 24/7 security, \r
          Wi-Fi, hot water, and laundry service. \r
          Located in a peaceful environment near City Center.
          EOS,
        approved: 1,
        featured: 0,
        visible: 1,
        image: "hostels/6a4e06564a0f2_xtZ765VHfHPAyb8eDLmMBg9sOkjcmCwfYhFEx2y8.jpg",
        created_at: "2026-07-08 08:12:06",
        updated_at: "2026-07-08 08:12:06",
      },
      App\Models\Hostel {#9132
        id: 648,
        registration_number: "HEAN-2026-000648",
        old_registration_number: null,
        local_registration_number: null,
        owner_id: null,
        name_nepali: "मच्छिन्द्र ब्वाइज होस्टेल",
        name_english: "Machhindra Boys Hostel",
        block_name: null,
        type: "boys",
        capacity: 40,
        rooms: 16,
        established_year: 2020,
        operator_name: "Shiva Prasad Sharma",
        district: "Kathmandu",
        province: "Bagmati",
        municipality: "Kathmandu Metropolitan City",
        ward: "23",
        street: "Machhindra Marga",
        landmark: "Near Machhindra Temple",
        contact: "9849876543",
        email: "info@machhindrahostel.com",
        pan: null,
        website: null,
        description: null,
        approved: 1,
        featured: 0,
        visible: 1,
        image: "hostels/6a4e11a4f3e05_KjzQxyMSaFATA8QI3gi59CybQqIyBdsQnoP7t055.jpg",
        created_at: "2026-07-08 09:00:21",
        updated_at: "2026-07-08 09:00:21",
      },
    ],
  }

>
> echo "\n MANUALLY REGISTERED HOSTELS (NOT IMPORTED):\n";


 MANUALLY REGISTERED HOSTELS (NOT IMPORTED):

> echo str_repeat('=', 80) . "\n";

================================================================================

>
> if ($hostels->isEmpty()) {
.     echo " No manually registered hostels found.\n";
. } else {
.     foreach ($hostels as $h) {
.         $isTest = false;
.         $name = strtolower($h->name_nepali . ' ' . ($h->name_english ?? ''));
.         $email = strtolower($h->email ?? '');
.         $desc = strtolower($h->description ?? '');
.         if (strpos($name, 'test') !== false || strpos($name, 'dummy') !== false ||
.             strpos($email, 'test') !== false || strpos($email, 'dummy') !== false ||
.             strpos($desc, 'test') !== false || strpos($desc, 'dummy') !== false ||
.             $h->capacity == 0 || $h->contact == 'N/A') {
.             $isTest = true;
.         }
.         echo "ID: {$h->id} | Name: {$h->name_nepali} | HEAN: {$h->registration_number} | Created: {$h->created_at}";
.         if ($isTest) echo "  TEST/DUMMY";
.         echo "\n";
.     }
.     echo str_repeat('-', 80) . "\n";
.     echo "Total Hostels: " . $hostels->count() . "\n";
. }

ID: 635 | Name: सूर्योदय ब्वाइज होस्टेल | HEAN: HEAN-2026-000635 | Created: 2026-07-03 01:33:41
ID: 636 | Name: हिमालय गर्ल्स होस्टेल | HEAN: HEAN-2026-000636 | Created: 2026-07-03 01:33:41
ID: 637 | Name: अन्नपूर्ण को-एड होस्टेल | HEAN: HEAN-2026-000637 | Created: 2026-07-03 01:33:41
ID: 638 | Name: पशुपति ब्वाइज होस्टेल | HEAN: HEAN-2026-000638 | Created: 2026-07-03 01:33:41
ID: 639 | Name: सगरमाथा गर्ल्स होस्टेल | HEAN: HEAN-2026-000639 | Created: 2026-07-03 01:33:41
ID: 640 | Name: मनकामना ब्वाइज होस्टेल | HEAN: HEAN-2026-000640 | Created: 2026-07-03 06:56:55
ID: 641 | Name: ब्लु शीप गर्ल्स होस्टेल | HEAN: HEAN-2026-000641 | Created: 2026-07-03 06:56:55
ID: 642 | Name: तनहुँ ब्वाइज होस्टेल | HEAN: HEAN-2026-000642 | Created: 2026-07-03 09:38:27
ID: 643 | Name: विरेन्द्र ब्वाइज होस्टेल | HEAN: HEAN-2026-000643 | Created: 2026-07-04 05:43:58  TEST/DUMMY
ID: 644 | Name: गण्डकी गर्ल्स होस्टेल | HEAN: HEAN-2026-000644 | Created: 2026-07-04 05:52:48  TEST/DUMMY
ID: 645 | Name: नागार्जुन ब्वाइज होस्टेल | HEAN: HEAN-2026-000645 | Created: 2026-07-05 08:10:36
ID: 646 | Name: कामना महिला हस्टेल | HEAN: HEAN-2026-000646 | Created: 2026-07-05 09:33:02
ID: 647 | Name: धौलागिरि को-एड होस्टेल | HEAN: HEAN-2026-000647 | Created: 2026-07-08 08:12:06
ID: 648 | Name: मच्छिन्द्र ब्वाइज होस्टेल | HEAN: HEAN-2026-000648 | Created: 2026-07-08 09:00:21
--------------------------------------------------------------------------------
Total Hostels: 14

>
> echo "\n Combined Total (Unique Registrations + Hostels): " . ($registrations->count() + $hostels->count()) . "\n";


 Combined Total (Unique Registrations + Hostels): 29

IMPORTANT TO BE NOTICE: 

📋 Skip भएका 14 Hostels (List) whitel importing:
Row	Hostel Name (Nepali)	Old Reg	Contact
21	;fGeL un{; xf]:6]n	20	(खाली)
47	cg'>L un{; xf]:6]n	46	(खाली)
64	OGgf]e]l6a AjfOh xf]:6]n	63	(खाली)
88	xfd	f] AjfOh xf]:6]n	87	(खाली)
119	Soflk6n AjfOh xf]:6]n	118	(खाली)
129	dgsfdgf AjfOh xf]:6]n	128	(खाली)
134	Go' laGbfjfl;gL AjfOh xf]:6]n	133	(खाली)
152	g]S;f AjfOh xf]:6]n	151	(खाली)
153	sGof 5fqf jf;	152	(खाली)
157	s}nfz AjfOh xf]:6]n	156	(खाली)
181	;]G6«n un{; xf]:6]n	180	(खाली)
238	lk; hf]g un{; xf]:6]n	237	(खाली)
374	JofnL AjfOh xf]:6]n	373	(खाली)
585	(खाली नाम)	584	(खाली)
