<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    public function run()
    {
        // ===== 1. FOREIGN KEY CHECKS DISABLE =====
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // ===== 2. TRUNCATE TABLES =====
        DB::table('municipalities')->truncate();
        DB::table('districts')->truncate();
        DB::table('provinces')->truncate();

        // ===== 3. RE-ENABLE FOREIGN KEY CHECKS =====
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ===== 4. INSERT PROVINCES =====
        DB::table('provinces')->insert([
            ['id' => 1, 'name' => 'Province 1', 'name_ne' => 'प्रदेश १'],
            ['id' => 2, 'name' => 'Province 2', 'name_ne' => 'प्रदेश २'],
            ['id' => 3, 'name' => 'Bagmati', 'name_ne' => 'बागमती'],
            ['id' => 4, 'name' => 'Gandaki', 'name_ne' => 'गण्डकी'],
            ['id' => 5, 'name' => 'Lumbini', 'name_ne' => 'लुम्बिनी'],
            ['id' => 6, 'name' => 'Karnali', 'name_ne' => 'कर्णाली'],
            ['id' => 7, 'name' => 'Sudurpashchim', 'name_ne' => 'सुदूरपश्चिम'],
        ]);

        // ===== 5. INSERT DISTRICTS (with province_id) =====
        DB::table('districts')->insert([
            // Province 1 (id=1)
            ['id' => 1, 'province_id' => 1, 'name' => 'Bhojpur', 'name_ne' => 'भोजपुर'],
            ['id' => 2, 'province_id' => 1, 'name' => 'Dhankuta', 'name_ne' => 'धनकुटा'],
            ['id' => 3, 'province_id' => 1, 'name' => 'Ilam', 'name_ne' => 'इलाम'],
            ['id' => 4, 'province_id' => 1, 'name' => 'Jhapa', 'name_ne' => 'झापा'],
            ['id' => 5, 'province_id' => 1, 'name' => 'Khotang', 'name_ne' => 'खोटाङ'],
            ['id' => 6, 'province_id' => 1, 'name' => 'Morang', 'name_ne' => 'मोरङ'],
            ['id' => 7, 'province_id' => 1, 'name' => 'Okhaldhunga', 'name_ne' => 'ओखलढुङ्गा'],
            ['id' => 8, 'province_id' => 1, 'name' => 'Panchthar', 'name_ne' => 'पाँचथर'],
            ['id' => 9, 'province_id' => 1, 'name' => 'Sankhuwasabha', 'name_ne' => 'सङ्खुवासभा'],
            ['id' => 10, 'province_id' => 1, 'name' => 'Solukhumbu', 'name_ne' => 'सोलुखुम्बु'],
            ['id' => 11, 'province_id' => 1, 'name' => 'Sunsari', 'name_ne' => 'सुनसरी'],
            ['id' => 12, 'province_id' => 1, 'name' => 'Taplejung', 'name_ne' => 'ताप्लेजुङ'],
            ['id' => 13, 'province_id' => 1, 'name' => 'Tehrathum', 'name_ne' => 'तेह्रथुम'],
            ['id' => 14, 'province_id' => 1, 'name' => 'Udayapur', 'name_ne' => 'उदयपुर'],
            // Province 2 (id=2)
            ['id' => 15, 'province_id' => 2, 'name' => 'Bara', 'name_ne' => 'बारा'],
            ['id' => 16, 'province_id' => 2, 'name' => 'Dhanusha', 'name_ne' => 'धनुषा'],
            ['id' => 17, 'province_id' => 2, 'name' => 'Mahottari', 'name_ne' => 'महोत्तरी'],
            ['id' => 18, 'province_id' => 2, 'name' => 'Parsa', 'name_ne' => 'पर्सा'],
            ['id' => 19, 'province_id' => 2, 'name' => 'Rautahat', 'name_ne' => 'रौतहट'],
            ['id' => 20, 'province_id' => 2, 'name' => 'Saptari', 'name_ne' => 'सप्तरी'],
            ['id' => 21, 'province_id' => 2, 'name' => 'Sarlahi', 'name_ne' => 'सर्लाही'],
            ['id' => 22, 'province_id' => 2, 'name' => 'Siraha', 'name_ne' => 'सिरहा'],
            // Bagmati (id=3)
            ['id' => 23, 'province_id' => 3, 'name' => 'Bhaktapur', 'name_ne' => 'भक्तपुर'],
            ['id' => 24, 'province_id' => 3, 'name' => 'Chitwan', 'name_ne' => 'चितवन'],
            ['id' => 25, 'province_id' => 3, 'name' => 'Dhading', 'name_ne' => 'धादिङ'],
            ['id' => 26, 'province_id' => 3, 'name' => 'Dolakha', 'name_ne' => 'दोलखा'],
            ['id' => 27, 'province_id' => 3, 'name' => 'Kathmandu', 'name_ne' => 'काठमाडौं'],
            ['id' => 28, 'province_id' => 3, 'name' => 'Kavrepalanchok', 'name_ne' => 'काभ्रेपलान्चोक'],
            ['id' => 29, 'province_id' => 3, 'name' => 'Lalitpur', 'name_ne' => 'ललितपुर'],
            ['id' => 30, 'province_id' => 3, 'name' => 'Makwanpur', 'name_ne' => 'मकवानपुर'],
            ['id' => 31, 'province_id' => 3, 'name' => 'Nuwakot', 'name_ne' => 'नुवाकोट'],
            ['id' => 32, 'province_id' => 3, 'name' => 'Ramechhap', 'name_ne' => 'रामेछाप'],
            ['id' => 33, 'province_id' => 3, 'name' => 'Rasuwa', 'name_ne' => 'रसुवा'],
            ['id' => 34, 'province_id' => 3, 'name' => 'Sindhuli', 'name_ne' => 'सिन्धुली'],
            ['id' => 35, 'province_id' => 3, 'name' => 'Sindhupalchok', 'name_ne' => 'सिन्धुपाल्चोक'],
            // Gandaki (id=4)
            ['id' => 36, 'province_id' => 4, 'name' => 'Baglung', 'name_ne' => 'बागलुङ'],
            ['id' => 37, 'province_id' => 4, 'name' => 'Gorkha', 'name_ne' => 'गोरखा'],
            ['id' => 38, 'province_id' => 4, 'name' => 'Kaski', 'name_ne' => 'कास्की'],
            ['id' => 39, 'province_id' => 4, 'name' => 'Lamjung', 'name_ne' => 'लमजुङ'],
            ['id' => 40, 'province_id' => 4, 'name' => 'Manang', 'name_ne' => 'मनाङ'],
            ['id' => 41, 'province_id' => 4, 'name' => 'Mustang', 'name_ne' => 'मुस्ताङ'],
            ['id' => 42, 'province_id' => 4, 'name' => 'Myagdi', 'name_ne' => 'म्याग्दी'],
            ['id' => 43, 'province_id' => 4, 'name' => 'Nawalpur', 'name_ne' => 'नवलपुर'],
            ['id' => 44, 'province_id' => 4, 'name' => 'Parbat', 'name_ne' => 'पर्वत'],
            ['id' => 45, 'province_id' => 4, 'name' => 'Syangja', 'name_ne' => 'स्याङ्जा'],
            ['id' => 46, 'province_id' => 4, 'name' => 'Tanahu', 'name_ne' => 'तनहुँ'],
            // Lumbini (id=5)
            ['id' => 47, 'province_id' => 5, 'name' => 'Arghakhanchi', 'name_ne' => 'अर्घाखाँची'],
            ['id' => 48, 'province_id' => 5, 'name' => 'Banke', 'name_ne' => 'बाँके'],
            ['id' => 49, 'province_id' => 5, 'name' => 'Bardiya', 'name_ne' => 'बर्दिया'],
            ['id' => 50, 'province_id' => 5, 'name' => 'Dang', 'name_ne' => 'दाङ'],
            ['id' => 51, 'province_id' => 5, 'name' => 'Gulmi', 'name_ne' => 'गुल्मी'],
            ['id' => 52, 'province_id' => 5, 'name' => 'Kapilvastu', 'name_ne' => 'कपिलवस्तु'],
            ['id' => 53, 'province_id' => 5, 'name' => 'Palpa', 'name_ne' => 'पाल्पा'],
            ['id' => 54, 'province_id' => 5, 'name' => 'Parasi', 'name_ne' => 'परासी'],
            ['id' => 55, 'province_id' => 5, 'name' => 'Pyuthan', 'name_ne' => 'प्युठान'],
            ['id' => 56, 'province_id' => 5, 'name' => 'Rolpa', 'name_ne' => 'रोल्पा'],
            ['id' => 57, 'province_id' => 5, 'name' => 'Rukum East', 'name_ne' => 'रुकुम पूर्व'],
            ['id' => 58, 'province_id' => 5, 'name' => 'Rupandehi', 'name_ne' => 'रुपन्देही'],
            // Karnali (id=6)
            ['id' => 59, 'province_id' => 6, 'name' => 'Dailekh', 'name_ne' => 'दैलेख'],
            ['id' => 60, 'province_id' => 6, 'name' => 'Dolpa', 'name_ne' => 'डोल्पा'],
            ['id' => 61, 'province_id' => 6, 'name' => 'Humla', 'name_ne' => 'हुम्ला'],
            ['id' => 62, 'province_id' => 6, 'name' => 'Jajarkot', 'name_ne' => 'जाजरकोट'],
            ['id' => 63, 'province_id' => 6, 'name' => 'Jumla', 'name_ne' => 'जुम्ला'],
            ['id' => 64, 'province_id' => 6, 'name' => 'Kalikot', 'name_ne' => 'कालिकोट'],
            ['id' => 65, 'province_id' => 6, 'name' => 'Mugu', 'name_ne' => 'मुगु'],
            ['id' => 66, 'province_id' => 6, 'name' => 'Salyan', 'name_ne' => 'सल्यान'],
            ['id' => 67, 'province_id' => 6, 'name' => 'Surkhet', 'name_ne' => 'सुर्खेत'],
            ['id' => 68, 'province_id' => 6, 'name' => 'Western Rukum', 'name_ne' => 'रुकुम पश्चिम'],
            // Sudurpashchim (id=7)
            ['id' => 69, 'province_id' => 7, 'name' => 'Achham', 'name_ne' => 'अछाम'],
            ['id' => 70, 'province_id' => 7, 'name' => 'Baitadi', 'name_ne' => 'बैतडी'],
            ['id' => 71, 'province_id' => 7, 'name' => 'Bajhang', 'name_ne' => 'बझाङ'],
            ['id' => 72, 'province_id' => 7, 'name' => 'Bajura', 'name_ne' => 'बाजुरा'],
            ['id' => 73, 'province_id' => 7, 'name' => 'Dadeldhura', 'name_ne' => 'डडेलधुरा'],
            ['id' => 74, 'province_id' => 7, 'name' => 'Darchula', 'name_ne' => 'दार्चुला'],
            ['id' => 75, 'province_id' => 7, 'name' => 'Doti', 'name_ne' => 'डोटी'],
            ['id' => 76, 'province_id' => 7, 'name' => 'Kailali', 'name_ne' => 'कैलाली'],
            ['id' => 77, 'province_id' => 7, 'name' => 'Kanchanpur', 'name_ne' => 'कञ्चनपुर'],
        ]);

        // ===== 6. INSERT MUNICIPALITIES (सही district_id सहित) =====
        DB::table('municipalities')->insert([
            // Kathmandu (district_id: 27)
            ['district_id' => 27, 'name' => 'Kathmandu Metropolitan City', 'name_ne' => 'काठमाडौं महानगरपालिका'],
            ['district_id' => 27, 'name' => 'Kirtipur Municipality', 'name_ne' => 'कीर्तिपुर नगरपालिका'],
            ['district_id' => 27, 'name' => 'Tokha Municipality', 'name_ne' => 'टोखा नगरपालिका'],
            ['district_id' => 27, 'name' => 'Tarakeshwor Municipality', 'name_ne' => 'तारकेश्वर नगरपालिका'],
            ['district_id' => 27, 'name' => 'Chandragiri Municipality', 'name_ne' => 'चन्द्रागिरी नगरपालिका'],

            // Lalitpur (district_id: 29)
            ['district_id' => 29, 'name' => 'Lalitpur Metropolitan City', 'name_ne' => 'ललितपुर महानगरपालिका'],
            ['district_id' => 29, 'name' => 'Godawori Municipality', 'name_ne' => 'गोदावरी नगरपालिका'],
            ['district_id' => 29, 'name' => 'Mahalaxmi Municipality', 'name_ne' => 'महालक्ष्मी नगरपालिका'],

            // Bhaktapur (district_id: 23)
            ['district_id' => 23, 'name' => 'Bhaktapur Municipality', 'name_ne' => 'भक्तपुर नगरपालिका'],
            ['district_id' => 23, 'name' => 'Madhyapur Thimi Municipality', 'name_ne' => 'मध्यपुर थिमि नगरपालिका'],
            ['district_id' => 23, 'name' => 'Changunarayan Municipality', 'name_ne' => 'चाँगुनारायण नगरपालिका'],

            // Kaski (district_id: 38)
            ['district_id' => 38, 'name' => 'Pokhara Metropolitan City', 'name_ne' => 'पोखरा महानगरपालिका'],

            // Morang (district_id: 6)
            ['district_id' => 6, 'name' => 'Biratnagar Metropolitan City', 'name_ne' => 'विराटनगर महानगरपालिका'],

            // Sunsari (district_id: 11)
            ['district_id' => 11, 'name' => 'Dharan Sub-Metropolitan City', 'name_ne' => 'धरान उप-महानगरपालिका'],
            ['district_id' => 11, 'name' => 'Itahari Sub-Metropolitan City', 'name_ne' => 'ईटहरी उप-महानगरपालिका'],

            // Jhapa (district_id: 4)
            ['district_id' => 4, 'name' => 'Bhadrapur Municipality', 'name_ne' => 'भद्रपुर नगरपालिका'],
            ['district_id' => 4, 'name' => 'Mechinagar Municipality', 'name_ne' => 'मेचीनगर नगरपालिका'],

            // Chitwan (district_id: 24)
            ['district_id' => 24, 'name' => 'Bharatpur Metropolitan City', 'name_ne' => 'भरतपुर महानगरपालिका'],
            ['district_id' => 24, 'name' => 'Ratnanagar Municipality', 'name_ne' => 'रत्ननगर नगरपालिका'],

            // Rupandehi (district_id: 58)
            ['district_id' => 58, 'name' => 'Butwal Sub-Metropolitan City', 'name_ne' => 'बुटवल उप-महानगरपालिका'],
            ['district_id' => 58, 'name' => 'Siddharthanagar Municipality', 'name_ne' => 'सिद्धार्थनगर नगरपालिका'],

            // Dang (district_id: 50)
            ['district_id' => 50, 'name' => 'Ghorahi Sub-Metropolitan City', 'name_ne' => 'घोराही उप-महानगरपालिका'],
            ['district_id' => 50, 'name' => 'Tulsipur Sub-Metropolitan City', 'name_ne' => 'तुल्सीपुर उप-महानगरपालिका'],

            // Surkhet (district_id: 67)
            ['district_id' => 67, 'name' => 'Birendranagar Municipality', 'name_ne' => 'वीरेन्द्रनगर नगरपालिका'],

            // Kailali (district_id: 76)
            ['district_id' => 76, 'name' => 'Dhangadhi Sub-Metropolitan City', 'name_ne' => 'धनगढी उप-महानगरपालिका'],
            ['district_id' => 76, 'name' => 'Tikapur Municipality', 'name_ne' => 'टीकापुर नगरपालिका'],

            // Kanchanpur (district_id: 77)
            ['district_id' => 77, 'name' => 'Bhimdatta Municipality', 'name_ne' => 'भीमदत्त नगरपालिका'],
        ]);
    }
}