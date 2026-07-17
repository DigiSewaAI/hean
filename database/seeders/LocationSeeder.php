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

        // ===== 4. INSERT PROVINCES (७ वटा) =====
        DB::table('provinces')->insert([
            ['id' => 1, 'name' => 'Province 1', 'name_ne' => 'प्रदेश १'],
            ['id' => 2, 'name' => 'Madhesh Province', 'name_ne' => 'मधेश प्रदेश'],
            ['id' => 3, 'name' => 'Bagmati Province', 'name_ne' => 'बागमती प्रदेश'],
            ['id' => 4, 'name' => 'Gandaki Province', 'name_ne' => 'गण्डकी प्रदेश'],
            ['id' => 5, 'name' => 'Lumbini Province', 'name_ne' => 'लुम्बिनी प्रदेश'],
            ['id' => 6, 'name' => 'Karnali Province', 'name_ne' => 'कर्णाली प्रदेश'],
            ['id' => 7, 'name' => 'Sudurpashchim Province', 'name_ne' => 'सुदूरपश्चिम प्रदेश'],
        ]);

        // ===== 5. INSERT DISTRICTS (सबै ७७ जिल्ला) =====
        DB::table('districts')->insert([
            // Province 1 (id=1) - 14 districts
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
            // Province 2 (id=2) - 8 districts
            ['id' => 15, 'province_id' => 2, 'name' => 'Bara', 'name_ne' => 'बारा'],
            ['id' => 16, 'province_id' => 2, 'name' => 'Dhanusha', 'name_ne' => 'धनुषा'],
            ['id' => 17, 'province_id' => 2, 'name' => 'Mahottari', 'name_ne' => 'महोत्तरी'],
            ['id' => 18, 'province_id' => 2, 'name' => 'Parsa', 'name_ne' => 'पर्सा'],
            ['id' => 19, 'province_id' => 2, 'name' => 'Rautahat', 'name_ne' => 'रौतहट'],
            ['id' => 20, 'province_id' => 2, 'name' => 'Saptari', 'name_ne' => 'सप्तरी'],
            ['id' => 21, 'province_id' => 2, 'name' => 'Sarlahi', 'name_ne' => 'सर्लाही'],
            ['id' => 22, 'province_id' => 2, 'name' => 'Siraha', 'name_ne' => 'सिरहा'],
            // Province 3 - Bagmati (id=3) - 13 districts
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
            // Province 4 - Gandaki (id=4) - 11 districts
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
            // Province 5 - Lumbini (id=5) - 12 districts
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
            // Province 6 - Karnali (id=6) - 10 districts
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
            // Province 7 - Sudurpashchim (id=7) - 9 districts
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

        // ===== 6. INSERT MUNICIPALITIES (२००+ मुख्य नगरपालिका/गाउँपालिका) =====
        DB::table('municipalities')->insert([
            // ===== PROVINCE 1 (प्रदेश १) =====
            // Bhojpur (1)
            ['district_id' => 1, 'name' => 'Bhojpur Municipality', 'name_ne' => 'भोजपुर नगरपालिका'],
            ['district_id' => 1, 'name' => 'Shadanand Municipality', 'name_ne' => 'षडानन्द नगरपालिका'],
            // Dhankuta (2)
            ['district_id' => 2, 'name' => 'Dhankuta Municipality', 'name_ne' => 'धनकुटा नगरपालिका'],
            ['district_id' => 2, 'name' => 'Pakhribas Municipality', 'name_ne' => 'पाख्रिबास नगरपालिका'],
            // Ilam (3)
            ['district_id' => 3, 'name' => 'Ilam Municipality', 'name_ne' => 'इलाम नगरपालिका'],
            ['district_id' => 3, 'name' => 'Suryodaya Municipality', 'name_ne' => 'सूर्योदय नगरपालिका'],
            ['district_id' => 3, 'name' => 'Deumai Municipality', 'name_ne' => 'देउमाई नगरपालिका'],
            ['district_id' => 3, 'name' => 'Mai Municipality', 'name_ne' => 'माई नगरपालिका'],
            // Jhapa (4)
            ['district_id' => 4, 'name' => 'Mechinagar Municipality', 'name_ne' => 'मेचीनगर नगरपालिका'],
            ['district_id' => 4, 'name' => 'Birtamod Municipality', 'name_ne' => 'विर्तामोड नगरपालिका'],
            ['district_id' => 4, 'name' => 'Damak Municipality', 'name_ne' => 'दमक नगरपालिका'],
            ['district_id' => 4, 'name' => 'Bhadrapur Municipality', 'name_ne' => 'भद्रपुर नगरपालिका'],
            ['district_id' => 4, 'name' => 'Arjundhara Municipality', 'name_ne' => 'अर्जुनधारा नगरपालिका'],
            ['district_id' => 4, 'name' => 'Shivasatakshi Municipality', 'name_ne' => 'शिवसताक्षी नगरपालिका'],
            ['district_id' => 4, 'name' => 'Gauradaha Municipality', 'name_ne' => 'गौरादह नगरपालिका'],
            ['district_id' => 4, 'name' => 'Kankai Municipality', 'name_ne' => 'कन्काई नगरपालिका'],
            // Khotang (5)
            ['district_id' => 5, 'name' => 'Diktel Rupakot Majhuwagadhi Municipality', 'name_ne' => 'दिक्तेल रुपाकोट मझुवागढी नगरपालिका'],
            ['district_id' => 5, 'name' => 'Halesi Tuwachung Municipality', 'name_ne' => 'हलेसी तुवाचुङ नगरपालिका'],
            // Morang (6)
            ['district_id' => 6, 'name' => 'Biratnagar Metropolitan City', 'name_ne' => 'विराटनगर महानगरपालिका'],
            ['district_id' => 6, 'name' => 'Sundar Haraicha Municipality', 'name_ne' => 'सुन्दर हरैंचा नगरपालिका'],
            ['district_id' => 6, 'name' => 'Belbari Municipality', 'name_ne' => 'बेलवारी नगरपालिका'],
            ['district_id' => 6, 'name' => 'Pathari Sanishchare Municipality', 'name_ne' => 'पथरी शनिश्चरे नगरपालिका'],
            ['district_id' => 6, 'name' => 'Ratuwamai Municipality', 'name_ne' => 'रतुवामाई नगरपालिका'],
            ['district_id' => 6, 'name' => 'Uralabari Municipality', 'name_ne' => 'उर्लाबारी नगरपालिका'],
            ['district_id' => 6, 'name' => 'Rangeli Municipality', 'name_ne' => 'रंगेली नगरपालिका'],
            ['district_id' => 6, 'name' => 'Sunawarshi Municipality', 'name_ne' => 'सुनवर्षी नगरपालिका'],
            // Okhaldhunga (7)
            ['district_id' => 7, 'name' => 'Siddhicharan Municipality', 'name_ne' => 'सिद्धिचरण नगरपालिका'],
            // Panchthar (8)
            ['district_id' => 8, 'name' => 'Phidim Municipality', 'name_ne' => 'फिदिम नगरपालिका'],
            // Sankhuwasabha (9)
            ['district_id' => 9, 'name' => 'Khandbari Municipality', 'name_ne' => 'खाँदबारी नगरपालिका'],
            ['district_id' => 9, 'name' => 'Chainpur Municipality', 'name_ne' => 'चैनपुर नगरपालिका'],
            // Solukhumbu (10)
            ['district_id' => 10, 'name' => 'Solududhkunda Municipality', 'name_ne' => 'सोलुदुधकुण्ड नगरपालिका'],
            // Sunsari (11)
            ['district_id' => 11, 'name' => 'Dharan Sub-Metropolitan City', 'name_ne' => 'धरान उप-महानगरपालिका'],
            ['district_id' => 11, 'name' => 'Itahari Sub-Metropolitan City', 'name_ne' => 'ईटहरी उप-महानगरपालिका'],
            ['district_id' => 11, 'name' => 'Barahachhetra Municipality', 'name_ne' => 'बराहक्षेत्र नगरपालिका'],
            ['district_id' => 11, 'name' => 'Inaruwa Municipality', 'name_ne' => 'ईनरुवा नगरपालिका'],
            ['district_id' => 11, 'name' => 'Duhabi Municipality', 'name_ne' => 'दुहबी नगरपालिका'],
            ['district_id' => 11, 'name' => 'Ramdhuni Municipality', 'name_ne' => 'रामधुनी नगरपालिका'],
            // Taplejung (12)
            ['district_id' => 12, 'name' => 'Taplejung Municipality', 'name_ne' => 'ताप्लेजुङ नगरपालिका'],
            // Tehrathum (13)
            ['district_id' => 13, 'name' => 'Myanglung Municipality', 'name_ne' => 'म्याङ्लुङ नगरपालिका'],
            ['district_id' => 13, 'name' => 'Laligurans Municipality', 'name_ne' => 'लालीगुराँस नगरपालिका'],
            // Udayapur (14)
            ['district_id' => 14, 'name' => 'Triyuga Municipality', 'name_ne' => 'त्रियुगा नगरपालिका'],
            ['district_id' => 14, 'name' => 'Katari Municipality', 'name_ne' => 'कटारी नगरपालिका'],
            ['district_id' => 14, 'name' => 'Belaka Municipality', 'name_ne' => 'बेलका नगरपालिका'],
            ['district_id' => 14, 'name' => 'Chaudandigadhi Municipality', 'name_ne' => 'चौदण्डीगढी नगरपालिका'],

            // ===== PROVINCE 2 (मधेश प्रदेश) =====
            // Bara (15)
            ['district_id' => 15, 'name' => 'Kalaiya Sub-Metropolitan City', 'name_ne' => 'कलैया उप-महानगरपालिका'],
            ['district_id' => 15, 'name' => 'Jitpursimara Sub-Metropolitan City', 'name_ne' => 'जितपुरसिमरा उप-महानगरपालिका'],
            ['district_id' => 15, 'name' => 'Kolhabi Municipality', 'name_ne' => 'कोल्हबी नगरपालिका'],
            ['district_id' => 15, 'name' => 'Nijgadh Municipality', 'name_ne' => 'निजगढ नगरपालिका'],
            ['district_id' => 15, 'name' => 'Mahagadhimai Municipality', 'name_ne' => 'महागढीमाई नगरपालिका'],
            ['district_id' => 15, 'name' => 'Simraungadh Municipality', 'name_ne' => 'सिम्रौनगढ नगरपालिका'],
            ['district_id' => 15, 'name' => 'Pacharauta Municipality', 'name_ne' => 'पचरौता नगरपालिका'],
            // Dhanusha (16)
            ['district_id' => 16, 'name' => 'Janakpur Sub-Metropolitan City', 'name_ne' => 'जनकपुर उप-महानगरपालिका'],
            ['district_id' => 16, 'name' => 'Dhanushadham Municipality', 'name_ne' => 'धनुषाधाम नगरपालिका'],
            ['district_id' => 16, 'name' => 'Mithila Municipality', 'name_ne' => 'मिथिला नगरपालिका'],
            ['district_id' => 16, 'name' => 'Sabaila Municipality', 'name_ne' => 'सबैला नगरपालिका'],
            ['district_id' => 16, 'name' => 'Hansapur Municipality', 'name_ne' => 'हंसपुर नगरपालिका'],
            ['district_id' => 16, 'name' => 'Kamala Municipality', 'name_ne' => 'कमला नगरपालिका'],
            ['district_id' => 16, 'name' => 'Ganeshman Charnath Municipality', 'name_ne' => 'गणेशमान चारनाथ नगरपालिका'],
            // Mahottari (17)
            ['district_id' => 17, 'name' => 'Bardibas Municipality', 'name_ne' => 'बर्दिबास नगरपालिका'],
            ['district_id' => 17, 'name' => 'Gaushala Municipality', 'name_ne' => 'गौशाला नगरपालिका'],
            ['district_id' => 17, 'name' => 'Matihani Municipality', 'name_ne' => 'मटिहानी नगरपालिका'],
            ['district_id' => 17, 'name' => 'Jaleshwor Municipality', 'name_ne' => 'जलेश्वर नगरपालिका'],
            ['district_id' => 17, 'name' => 'Loharpatti Municipality', 'name_ne' => 'लोहरपट्टी नगरपालिका'],
            // Parsa (18)
            ['district_id' => 18, 'name' => 'Birganj Metropolitan City', 'name_ne' => 'वीरगंज महानगरपालिका'],
            ['district_id' => 18, 'name' => 'Bahudarmai Municipality', 'name_ne' => 'बहुदरमाई नगरपालिका'],
            ['district_id' => 18, 'name' => 'Parsagadhi Municipality', 'name_ne' => 'पर्सागढी नगरपालिका'],
            ['district_id' => 18, 'name' => 'Pokhariya Municipality', 'name_ne' => 'पोखरिया नगरपालिका'],
            // Rautahat (19)
            ['district_id' => 19, 'name' => 'Gaur Municipality', 'name_ne' => 'गौर नगरपालिका'],
            ['district_id' => 19, 'name' => 'Chandrapur Municipality', 'name_ne' => 'चन्द्रपुर नगरपालिका'],
            ['district_id' => 19, 'name' => 'Baudhimai Municipality', 'name_ne' => 'बौधिमाई नगरपालिका'],
            ['district_id' => 19, 'name' => 'Brindaban Municipality', 'name_ne' => 'वृन्दावन नगरपालिका'],
            ['district_id' => 19, 'name' => 'Devahi Gonahi Municipality', 'name_ne' => 'देवाही गोनाही नगरपालिका'],
            ['district_id' => 19, 'name' => 'Garuda Municipality', 'name_ne' => 'गरुडा नगरपालिका'],
            ['district_id' => 19, 'name' => 'Rajdevi Municipality', 'name_ne' => 'राजदेवी नगरपालिका'],
            // Saptari (20)
            ['district_id' => 20, 'name' => 'Rajbiraj Municipality', 'name_ne' => 'राजविराज नगरपालिका'],
            ['district_id' => 20, 'name' => 'Saptakoshi Municipality', 'name_ne' => 'सप्तकोशी नगरपालिका'],
            ['district_id' => 20, 'name' => 'Shambhunath Municipality', 'name_ne' => 'शम्भुनाथ नगरपालिका'],
            ['district_id' => 20, 'name' => 'Bodebarsain Municipality', 'name_ne' => 'बोदेबर्साईन नगरपालिका'],
            ['district_id' => 20, 'name' => 'Khadak Municipality', 'name_ne' => 'खडक नगरपालिका'],
            ['district_id' => 20, 'name' => 'Kanchanrup Municipality', 'name_ne' => 'कञ्चनरूप नगरपालिका'],
            ['district_id' => 20, 'name' => 'Surunga Municipality', 'name_ne' => 'सुरुङ्गा नगरपालिका'],
            // Sarlahi (21)
            ['district_id' => 21, 'name' => 'Malangawa Municipality', 'name_ne' => 'मलङ्गवा नगरपालिका'],
            ['district_id' => 21, 'name' => 'Lalbandi Municipality', 'name_ne' => 'लालबन्दी नगरपालिका'],
            ['district_id' => 21, 'name' => 'Ishworpur Municipality', 'name_ne' => 'ईश्वरपुर नगरपालिका'],
            ['district_id' => 21, 'name' => 'Haripur Municipality', 'name_ne' => 'हरिपुर नगरपालिका'],
            ['district_id' => 21, 'name' => 'Barhathwa Municipality', 'name_ne' => 'बरहथवा नगरपालिका'],
            // Siraha (22)
            ['district_id' => 22, 'name' => 'Siraha Municipality', 'name_ne' => 'सिरहा नगरपालिका'],
            ['district_id' => 22, 'name' => 'Lahan Municipality', 'name_ne' => 'लहान नगरपालिका'],
            ['district_id' => 22, 'name' => 'Dhangadhimai Municipality', 'name_ne' => 'धनगढीमाई नगरपालिका'],
            ['district_id' => 22, 'name' => 'Golbazar Municipality', 'name_ne' => 'गोलबजार नगरपालिका'],
            ['district_id' => 22, 'name' => 'Mirchaiya Municipality', 'name_ne' => 'मिर्चैया नगरपालिका'],
            ['district_id' => 22, 'name' => 'Sukhipur Municipality', 'name_ne' => 'सुखीपुर नगरपालिका'],

            // ===== PROVINCE 3 (बागमती प्रदेश) =====
            // Bhaktapur (23)
            ['district_id' => 23, 'name' => 'Bhaktapur Municipality', 'name_ne' => 'भक्तपुर नगरपालिका'],
            ['district_id' => 23, 'name' => 'Madhyapur Thimi Municipality', 'name_ne' => 'मध्यपुर थिमि नगरपालिका'],
            ['district_id' => 23, 'name' => 'Changunarayan Municipality', 'name_ne' => 'चाँगुनारायण नगरपालिका'],
            ['district_id' => 23, 'name' => 'Suryabinayak Municipality', 'name_ne' => 'सूर्यविनायक नगरपालिका'],
            // Chitwan (24)
            ['district_id' => 24, 'name' => 'Bharatpur Metropolitan City', 'name_ne' => 'भरतपुर महानगरपालिका'],
            ['district_id' => 24, 'name' => 'Ratnanagar Municipality', 'name_ne' => 'रत्ननगर नगरपालिका'],
            ['district_id' => 24, 'name' => 'Kalika Municipality', 'name_ne' => 'कालिका नगरपालिका'],
            ['district_id' => 24, 'name' => 'Khairhani Municipality', 'name_ne' => 'खैरहनी नगरपालिका'],
            ['district_id' => 24, 'name' => 'Madi Municipality', 'name_ne' => 'माडी नगरपालिका'],
            ['district_id' => 24, 'name' => 'Rapti Municipality', 'name_ne' => 'राप्ती नगरपालिका'],
            // Dhading (25)
            ['district_id' => 25, 'name' => 'Dhading Besi Municipality', 'name_ne' => 'धादिङ बेसी नगरपालिका'],
            ['district_id' => 25, 'name' => 'Nilkantha Municipality', 'name_ne' => 'नीलकण्ठ नगरपालिका'],
            // Dolakha (26)
            ['district_id' => 26, 'name' => 'Bhimeshwor Municipality', 'name_ne' => 'भीमेश्वर नगरपालिका'],
            ['district_id' => 26, 'name' => 'Jiri Municipality', 'name_ne' => 'जिरी नगरपालिका'],
            // Kathmandu (27)
            ['district_id' => 27, 'name' => 'Kathmandu Metropolitan City', 'name_ne' => 'काठमाडौं महानगरपालिका'],
            ['district_id' => 27, 'name' => 'Kirtipur Municipality', 'name_ne' => 'कीर्तिपुर नगरपालिका'],
            ['district_id' => 27, 'name' => 'Tokha Municipality', 'name_ne' => 'टोखा नगरपालिका'],
            ['district_id' => 27, 'name' => 'Tarakeshwor Municipality', 'name_ne' => 'तारकेश्वर नगरपालिका'],
            ['district_id' => 27, 'name' => 'Chandragiri Municipality', 'name_ne' => 'चन्द्रागिरी नगरपालिका'],
            ['district_id' => 27, 'name' => 'Nagarjun Municipality', 'name_ne' => 'नागार्जुन नगरपालिका'],
            ['district_id' => 27, 'name' => 'Budhanilkantha Municipality', 'name_ne' => 'बुढानीलकण्ठ नगरपालिका'],
            ['district_id' => 27, 'name' => 'Gokarneshwor Municipality', 'name_ne' => 'गोकर्णेश्वर नगरपालिका'],
            ['district_id' => 27, 'name' => 'Dakshinkali Municipality', 'name_ne' => 'दक्षिणकाली नगरपालिका'],
            ['district_id' => 27, 'name' => 'Shankharapur Municipality', 'name_ne' => 'शंखरापुर नगरपालिका'],
            // Kavrepalanchok (28)
            ['district_id' => 28, 'name' => 'Banepa Municipality', 'name_ne' => 'बनेपा नगरपालिका'],
            ['district_id' => 28, 'name' => 'Dhulikhel Municipality', 'name_ne' => 'धुलिखेल नगरपालिका'],
            ['district_id' => 28, 'name' => 'Panauti Municipality', 'name_ne' => 'पनौती नगरपालिका'],
            ['district_id' => 28, 'name' => 'Namobuddha Municipality', 'name_ne' => 'नमोबुद्ध नगरपालिका'],
            ['district_id' => 28, 'name' => 'Mandan Deupur Municipality', 'name_ne' => 'मण्डन देवपुर नगरपालिका'],
            // Lalitpur (29)
            ['district_id' => 29, 'name' => 'Lalitpur Metropolitan City', 'name_ne' => 'ललितपुर महानगरपालिका'],
            ['district_id' => 29, 'name' => 'Godawari Municipality', 'name_ne' => 'गोदावरी नगरपालिका'],
            ['district_id' => 29, 'name' => 'Mahalaxmi Municipality', 'name_ne' => 'महालक्ष्मी नगरपालिका'],
            ['district_id' => 29, 'name' => 'Bagmati Municipality', 'name_ne' => 'बागमती नगरपालिका'],
            ['district_id' => 29, 'name' => 'Konjyosom Rural Municipality', 'name_ne' => 'कोन्ज्योसोम गाउँपालिका'],
            // Makwanpur (30)
            ['district_id' => 30, 'name' => 'Hetauda Sub-Metropolitan City', 'name_ne' => 'हेटौंडा उप-महानगरपालिका'],
            ['district_id' => 30, 'name' => 'Thaha Municipality', 'name_ne' => 'थाहा नगरपालिका'],
            ['district_id' => 30, 'name' => 'Bhimphedi Rural Municipality', 'name_ne' => 'भिमफेदी गाउँपालिका'],
            ['district_id' => 30, 'name' => 'Manahari Rural Municipality', 'name_ne' => 'मनहरी गाउँपालिका'],
            // Nuwakot (31)
            ['district_id' => 31, 'name' => 'Bidur Municipality', 'name_ne' => 'बिदुर नगरपालिका'],
            ['district_id' => 31, 'name' => 'Belkotgadhi Municipality', 'name_ne' => 'बेलकोटगढी नगरपालिका'],
            // Ramechhap (32)
            ['district_id' => 32, 'name' => 'Manthali Municipality', 'name_ne' => 'मन्थली नगरपालिका'],
            ['district_id' => 32, 'name' => 'Ramechhap Municipality', 'name_ne' => 'रामेछाप नगरपालिका'],
            // Rasuwa (33)
            ['district_id' => 33, 'name' => 'Dhunche Municipality', 'name_ne' => 'धुन्चे नगरपालिका'],
            // Sindhuli (34)
            ['district_id' => 34, 'name' => 'Kamalamai Municipality', 'name_ne' => 'कमलामाई नगरपालिका'],
            ['district_id' => 34, 'name' => 'Dudhauli Municipality', 'name_ne' => 'दुधौली नगरपालिका'],
            // Sindhupalchok (35)
            ['district_id' => 35, 'name' => 'Chautara Sangachowkgadhi Municipality', 'name_ne' => 'चौतारा साँगाचोकगढी नगरपालिका'],
            ['district_id' => 35, 'name' => 'Melamchi Municipality', 'name_ne' => 'मेलम्ची नगरपालिका'],

            // ===== PROVINCE 4 (गण्डकी प्रदेश) =====
            // Baglung (36)
            ['district_id' => 36, 'name' => 'Baglung Municipality', 'name_ne' => 'बागलुङ नगरपालिका'],
            ['district_id' => 36, 'name' => 'Galkot Municipality', 'name_ne' => 'गल्कोट नगरपालिका'],
            // Gorkha (37)
            ['district_id' => 37, 'name' => 'Gorkha Municipality', 'name_ne' => 'गोरखा नगरपालिका'],
            ['district_id' => 37, 'name' => 'Palungtar Municipality', 'name_ne' => 'पालुङटार नगरपालिका'],
            // Kaski (38)
            ['district_id' => 38, 'name' => 'Pokhara Metropolitan City', 'name_ne' => 'पोखरा महानगरपालिका'],
            // Lamjung (39)
            ['district_id' => 39, 'name' => 'Besisahar Municipality', 'name_ne' => 'बेसीशहर नगरपालिका'],
            // Manang (40)
            ['district_id' => 40, 'name' => 'Chame Rural Municipality', 'name_ne' => 'चामे गाउँपालिका'],
            // Mustang (41)
            ['district_id' => 41, 'name' => 'Jomsom Municipality', 'name_ne' => 'जोमसोम नगरपालिका'],
            // Myagdi (42)
            ['district_id' => 42, 'name' => 'Beni Municipality', 'name_ne' => 'बेनी नगरपालिका'],
            // Nawalpur (43)
            ['district_id' => 43, 'name' => 'Kawasoti Municipality', 'name_ne' => 'कावासोती नगरपालिका'],
            ['district_id' => 43, 'name' => 'Gaindakot Municipality', 'name_ne' => 'गैँडाकोट नगरपालिका'],
            ['district_id' => 43, 'name' => 'Devachuli Municipality', 'name_ne' => 'देवचुली नगरपालिका'],
            // Parbat (44)
            ['district_id' => 44, 'name' => 'Kushma Municipality', 'name_ne' => 'कुश्मा नगरपालिका'],
            ['district_id' => 44, 'name' => 'Phalewas Municipality', 'name_ne' => 'फलेवास नगरपालिका'],
            // Syangja (45)
            ['district_id' => 45, 'name' => 'Putalibazar Municipality', 'name_ne' => 'पुतलीबजार नगरपालिका'],
            ['district_id' => 45, 'name' => 'Waling Municipality', 'name_ne' => 'वालिङ नगरपालिका'],
            ['district_id' => 45, 'name' => 'Galyang Municipality', 'name_ne' => 'गल्याङ नगरपालिका'],
            // Tanahu (46)
            ['district_id' => 46, 'name' => 'Damauli Municipality', 'name_ne' => 'दमौली नगरपालिका'],
            ['district_id' => 46, 'name' => 'Bandipur Municipality', 'name_ne' => 'बन्दीपुर नगरपालिका'],
            ['district_id' => 46, 'name' => 'Bhimad Municipality', 'name_ne' => 'भिमाद नगरपालिका'],
            ['district_id' => 46, 'name' => 'Shuklagandaki Municipality', 'name_ne' => 'शुक्लागण्डकी नगरपालिका'],

            // ===== PROVINCE 5 (लुम्बिनी प्रदेश) =====
            // Arghakhanchi (47)
            ['district_id' => 47, 'name' => 'Sandhikharka Municipality', 'name_ne' => 'सन्धिखर्क नगरपालिका'],
            // Banke (48)
            ['district_id' => 48, 'name' => 'Nepalgunj Sub-Metropolitan City', 'name_ne' => 'नेपालगञ्ज उप-महानगरपालिका'],
            ['district_id' => 48, 'name' => 'Kohalpur Municipality', 'name_ne' => 'कोहलपुर नगरपालिका'],
            // Bardiya (49)
            ['district_id' => 49, 'name' => 'Gulariya Municipality', 'name_ne' => 'गुलरिया नगरपालिका'],
            ['district_id' => 49, 'name' => 'Rajapur Municipality', 'name_ne' => 'राजापुर नगरपालिका'],
            ['district_id' => 49, 'name' => 'Madhuwan Municipality', 'name_ne' => 'मधुवन नगरपालिका'],
            // Dang (50)
            ['district_id' => 50, 'name' => 'Ghorahi Sub-Metropolitan City', 'name_ne' => 'घोराही उप-महानगरपालिका'],
            ['district_id' => 50, 'name' => 'Tulsipur Sub-Metropolitan City', 'name_ne' => 'तुल्सीपुर उप-महानगरपालिका'],
            ['district_id' => 50, 'name' => 'Lamahi Municipality', 'name_ne' => 'लमही नगरपालिका'],
            // Gulmi (51)
            ['district_id' => 51, 'name' => 'Tamghas Municipality', 'name_ne' => 'तम्घास नगरपालिका'],
            ['district_id' => 51, 'name' => 'Resunga Municipality', 'name_ne' => 'रेसुङ्गा नगरपालिका'],
            // Kapilvastu (52)
            ['district_id' => 52, 'name' => 'Kapilvastu Municipality', 'name_ne' => 'कपिलवस्तु नगरपालिका'],
            ['district_id' => 52, 'name' => 'Banganga Municipality', 'name_ne' => 'बाणगंगा नगरपालिका'],
            ['district_id' => 52, 'name' => 'Krishnanagar Municipality', 'name_ne' => 'कृष्णनगर नगरपालिका'],
            ['district_id' => 52, 'name' => 'Buddhabhumi Municipality', 'name_ne' => 'बुद्धभूमि नगरपालिका'],
            // Palpa (53)
            ['district_id' => 53, 'name' => 'Tansen Municipality', 'name_ne' => 'तानसेन नगरपालिका'],
            ['district_id' => 53, 'name' => 'Rampur Municipality', 'name_ne' => 'रामपुर नगरपालिका'],
            // Parasi (54)
            ['district_id' => 54, 'name' => 'Ramgram Municipality', 'name_ne' => 'रामग्राम नगरपालिका'],
            ['district_id' => 54, 'name' => 'Sunwal Municipality', 'name_ne' => 'सुनवल नगरपालिका'],
            // Pyuthan (55)
            ['district_id' => 55, 'name' => 'Pyuthan Municipality', 'name_ne' => 'प्युठान नगरपालिका'],
            ['district_id' => 55, 'name' => 'Swargadwari Municipality', 'name_ne' => 'स्वर्गद्वारी नगरपालिका'],
            // Rolpa (56)
            ['district_id' => 56, 'name' => 'Rolpa Municipality', 'name_ne' => 'रोल्पा नगरपालिका'],
            // Rukum East (57)
            ['district_id' => 57, 'name' => 'Rukumkot Rural Municipality', 'name_ne' => 'रुकुमकोट गाउँपालिका'],
            // Rupandehi (58)
            ['district_id' => 58, 'name' => 'Butwal Sub-Metropolitan City', 'name_ne' => 'बुटवल उप-महानगरपालिका'],
            ['district_id' => 58, 'name' => 'Siddharthanagar Municipality', 'name_ne' => 'सिद्धार्थनगर नगरपालिका'],
            ['district_id' => 58, 'name' => 'Lumbini Sanskritik Municipality', 'name_ne' => 'लुम्बिनी सांस्कृतिक नगरपालिका'],
            ['district_id' => 58, 'name' => 'Sainamaina Municipality', 'name_ne' => 'सैनामैना नगरपालिका'],
            ['district_id' => 58, 'name' => 'Devdaha Municipality', 'name_ne' => 'देवदह नगरपालिका'],
            ['district_id' => 58, 'name' => 'Tilottama Municipality', 'name_ne' => 'तिलोत्तमा नगरपालिका'],
            ['district_id' => 58, 'name' => 'Rohini Rural Municipality', 'name_ne' => 'रोहिणी गाउँपालिका'],

            // ===== PROVINCE 6 (कर्णाली प्रदेश) =====
            // Dailekh (59)
            ['district_id' => 59, 'name' => 'Narayan Municipality', 'name_ne' => 'नारायण नगरपालिका'],
            ['district_id' => 59, 'name' => 'Dullu Municipality', 'name_ne' => 'दुल्लु नगरपालिका'],
            // Dolpa (60)
            ['district_id' => 60, 'name' => 'Dolpa Municipality', 'name_ne' => 'डोल्पा नगरपालिका'],
            // Humla (61)
            ['district_id' => 61, 'name' => 'Simkot Rural Municipality', 'name_ne' => 'सिमकोट गाउँपालिका'],
            // Jajarkot (62)
            ['district_id' => 62, 'name' => 'Khalanga Rural Municipality', 'name_ne' => 'खलंगा गाउँपालिका'],
            // Jumla (63)
            ['district_id' => 63, 'name' => 'Chandannath Municipality', 'name_ne' => 'चन्दननाथ नगरपालिका'],
            // Kalikot (64)
            ['district_id' => 64, 'name' => 'Khandachakra Municipality', 'name_ne' => 'खाँडाचक्र नगरपालिका'],
            // Mugu (65)
            ['district_id' => 65, 'name' => 'Ghumta Rural Municipality', 'name_ne' => 'घुम्टा गाउँपालिका'],
            // Salyan (66)
            ['district_id' => 66, 'name' => 'Salyan Municipality', 'name_ne' => 'सल्यान नगरपालिका'],
            // Surkhet (67)
            ['district_id' => 67, 'name' => 'Birendranagar Municipality', 'name_ne' => 'वीरेन्द्रनगर नगरपालिका'],
            ['district_id' => 67, 'name' => 'Gurbhakot Municipality', 'name_ne' => 'गुर्भाकोट नगरपालिका'],
            // Western Rukum (68)
            ['district_id' => 68, 'name' => 'Musikot Municipality', 'name_ne' => 'मुसीकोट नगरपालिका'],
            ['district_id' => 68, 'name' => 'Chaurjahari Municipality', 'name_ne' => 'चौरजहारी नगरपालिका'],

            // ===== PROVINCE 7 (सुदूरपश्चिम प्रदेश) =====
            // Achham (69)
            ['district_id' => 69, 'name' => 'Mangalsen Municipality', 'name_ne' => 'मंगलसेन नगरपालिका'],
            ['district_id' => 69, 'name' => 'Kamalbazar Municipality', 'name_ne' => 'कमलबजार नगरपालिका'],
            // Baitadi (70)
            ['district_id' => 70, 'name' => 'Dasharathchand Municipality', 'name_ne' => 'दशरथचन्द नगरपालिका'],
            ['district_id' => 70, 'name' => 'Patan Municipality', 'name_ne' => 'पाटन नगरपालिका'],
            ['district_id' => 70, 'name' => 'Melauli Municipality', 'name_ne' => 'मेलौली नगरपालिका'],
            // Bajhang (71)
            ['district_id' => 71, 'name' => 'Jayaprithvi Municipality', 'name_ne' => 'जयपृथ्वी नगरपालिका'],
            ['district_id' => 71, 'name' => 'Bungal Municipality', 'name_ne' => 'बुङ्गल नगरपालिका'],
            // Bajura (72)
            ['district_id' => 72, 'name' => 'Badimalika Municipality', 'name_ne' => 'बडीमालिका नगरपालिका'],
            ['district_id' => 72, 'name' => 'Triveni Municipality', 'name_ne' => 'त्रिवेणी नगरपालिका'],
            // Dadeldhura (73)
            ['district_id' => 73, 'name' => 'Amargadhi Municipality', 'name_ne' => 'अमरगढी नगरपालिका'],
            ['district_id' => 73, 'name' => 'Parashuram Municipality', 'name_ne' => 'परशुराम नगरपालिका'],
            // Darchula (74)
            ['district_id' => 74, 'name' => 'Api Municipality', 'name_ne' => 'अपि नगरपालिका'],
            ['district_id' => 74, 'name' => 'Shailyashikhar Municipality', 'name_ne' => 'शैल्यशिखर नगरपालिका'],
            ['district_id' => 74, 'name' => 'Mahakali Municipality', 'name_ne' => 'महाकाली नगरपालिका'],
            // Doti (75)
            ['district_id' => 75, 'name' => 'Dipayal Silgadhi Municipality', 'name_ne' => 'दिपायल सिलगढी नगरपालिका'],
            // Kailali (76)
            ['district_id' => 76, 'name' => 'Dhangadhi Sub-Metropolitan City', 'name_ne' => 'धनगढी उप-महानगरपालिका'],
            ['district_id' => 76, 'name' => 'Tikapur Municipality', 'name_ne' => 'टीकापुर नगरपालिका'],
            ['district_id' => 76, 'name' => 'Ghoda Ghodi Municipality', 'name_ne' => 'घोडाघोडी नगरपालिका'],
            ['district_id' => 76, 'name' => 'Lamkichuha Municipality', 'name_ne' => 'लम्कीचुहा नगरपालिका'],
            ['district_id' => 76, 'name' => 'Bhajani Municipality', 'name_ne' => 'भजनी नगरपालिका'],
            ['district_id' => 76, 'name' => 'Gauriganga Municipality', 'name_ne' => 'गौरीगंगा नगरपालिका'],
            ['district_id' => 76, 'name' => 'Kailari Rural Municipality', 'name_ne' => 'कैलारी गाउँपालिका'],
            ['district_id' => 76, 'name' => 'Bardagoriya Rural Municipality', 'name_ne' => 'बर्दगोरिया गाउँपालिका'],
            // Kanchanpur (77)
            ['district_id' => 77, 'name' => 'Bhimdatta Municipality', 'name_ne' => 'भीमदत्त नगरपालिका'],
            ['district_id' => 77, 'name' => 'Punarbas Municipality', 'name_ne' => 'पुनर्वास नगरपालिका'],
            ['district_id' => 77, 'name' => 'Bedkot Municipality', 'name_ne' => 'बेडकोट नगरपालिका'],
            ['district_id' => 77, 'name' => 'Belauri Municipality', 'name_ne' => 'बेलौरी नगरपालिका'],
            ['district_id' => 77, 'name' => 'Krishnapur Municipality', 'name_ne' => 'कृष्णपुर नगरपालिका'],
            ['district_id' => 77, 'name' => 'Suklaphanta Municipality', 'name_ne' => 'शुक्लाफाँटा नगरपालिका'],
        ]);
    }
}