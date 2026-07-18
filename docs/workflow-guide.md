# HEAN System – Complete User & Admin Guide

---

## 📚 **नेपाली संस्करण (Nepali Version)**

---

### १. प्रणालीको परिचय (System Overview)

यो **Hostel Entrepreneurs Association Nepal (HEAN)** को **Hostel Registration & Management System** हो।

यस प्रणालीको मुख्य उद्देश्यहरू:
- होस्टल दर्ता
- इनभ्वाइस (Invoice) सिर्जना
- भुक्तानी (Payment) संकलन
- रसिद (Receipt) सिर्जना
- दर्ता सक्रिय (Activation)

**मुख्य कार्यप्रवाह (Workflow):**
```
दर्ता → स्वीकृति → इनभ्वाइस → भुक्तानी → रसिद → सक्रिय
```

---

### २. प्रयोगकर्ताको भूमिका (User Roles)

| भूमिका | जिम्मेवारी |
|--------|------------|
| **प्रशासक (Admin)** | दर्ता स्वीकृत, इनभ्वाइस सिर्जना, भुक्तानी व्यवस्थापन, भुक्तानी प्रमाणित, सबै होस्टल व्यवस्थापन |
| **स्वामी (Owner)** | आफ्नो दर्ता, भुक्तानी, इनभ्वाइस, रसिद हेर्ने |
| **निरीक्षक (Inspector)** | होस्टल निरीक्षण गर्ने |

---

### ३. पूर्ण कार्यप्रवाह (Complete Workflow - Step-by-Step)

#### चरण १: दर्ता (Registration)
- **कसले:** प्रशासक वा सार्वजनिक प्रयोगकर्ता
- **के गर्ने:** होस्टल दर्ता फारम भर्ने
- **स्थिति:** `पेन्डिङ (Pending)`
- **अर्को कार्य:** प्रशासक स्वीकृति

#### चरण २: प्रशासक स्वीकृति (Admin Approval)
- **कसले:** प्रशासक
- **के गर्ने:** दर्ता समीक्षा र स्वीकृत
- **स्थिति:** `स्वीकृत (Approved)`
- **अर्को कार्य:** इनभ्वाइस सिर्जना

#### चरण ३: इनभ्वाइस सिर्जना (Generate Invoice)
- **कसले:** प्रशासक
- **के गर्ने:** दर्ता शुल्कको इनभ्वाइस सिर्जना
- **स्थिति:** `भुक्तानी पर्खाइ (Awaiting Payment)`
- **अर्को कार्य:** भुक्तानी थप्नुहोस्

#### चरण ४: भुक्तानी थप्नुहोस् (Add Payment)
- **कसले:** प्रशासक
- **के गर्ने:** इनभ्वाइस विरुद्ध भुक्तानी रेकर्ड गर्ने
- **भुक्तानी स्थिति:** `पेन्डिङ (Pending)`
- **अर्को कार्य:** भुक्तानी प्रमाणित

#### चरण ५: भुक्तानी प्रमाणित (Verify Payment)
- **कसले:** प्रशासक
- **के गर्ने:** भुक्तानी सहि छ भनेर पुष्टि गर्ने
- **भुक्तानी स्थिति:** `प्रमाणित (Verified)`
- **इनभ्वाइस स्थिति:** `भुक्तानी भयो (Paid)`
- **स्वत: (Auto):** रसिद सिर्जना
- **दर्ता स्थिति:** `सक्रिय (Active)`
- **अर्को कार्य:** कुनै छैन (पूर्ण)

---

### ४. प्रशासक प्यानल गाइड (Admin Panel Guide)

#### ४.१ ड्यासबोर्ड (Dashboard)
**स्थान:** `/admin`  
**देखाउँछ:**
- जम्मा होस्टेल
- पेन्डिङ दर्ताहरू
- निरीक्षण पेन्डिङ
- सदस्यहरूको संख्या
- मासिक दर्ता चार्ट

#### ४.२ दर्ताहरू (Registrations)
**स्थान:** `/admin/registrations`

##### सबै दर्ताहरू हेर्ने
- सबै दर्ताहरूको सूची
- देखाउँछ: क्र.सं., होस्टल नाम, जिल्ला, स्थिति, कार्यहरू
- "विवरण हेर्नुहोस्" क्लिक गरेर पूरा दर्ता हेर्न सकिन्छ

##### दर्ता स्थितिहरू
| स्थिति | अर्थ | अर्को कार्य |
|--------|------|-------------|
| `पेन्डिङ (Pending)` | प्रशासक स्वीकृति पर्खाइमा | "स्वीकृत" वा "अस्वीकृत" क्लिक गर्नुहोस् |
| `स्वीकृत (Approved)` | प्रशासकले स्वीकृत गर्यो, इनभ्वाइस छैन | इनभ्वाइस सिर्जना गर्नुहोस् |
| `भुक्तानी पर्खाइ (Awaiting Payment)` | इनभ्वाइस सिर्जना भयो, भुक्तानी भएको छैन | भुक्तानी थप्नुहोस् |
| `सक्रिय (Active)` | पूर्ण भुक्तानी र सक्रिय | नवीकरण (भविष्यमा) |
| `म्याद सकिएको (Expired)` | म्याद समाप्त | नवीकरण (भविष्यमा) |
| `अस्वीकृत (Rejected)` | दर्ता अस्वीकृत | कुनै छैन |
| `डुप्लिकेट (Duplicate)` | डुप्लिकेट दर्ता | कुनै छैन |

##### दर्ता विवरण पृष्ठ (`/admin/registrations/{id}`)

**सेक्सनहरू:**

१. **हेडर:** दर्ता आईडी, मिति, स्थिति, स्रोत
२. **होस्टल जानकारी:** नाम, प्रकार, जिल्ला
३. **कार्यप्रवाह स्थिति:** दृश्य प्रगति (दर्ता → इनभ्वाइस → भुक्तानी → रसिद → सक्रिय)
४. **वित्तीय सारांश:** इनभ्वाइस संख्या, जम्मा इनभ्वाइस, जम्मा भुक्तानी, बाँकी, पछिल्लो रसिद
५. **अर्को कार्य:** प्रशासकले अब के गर्नुपर्ने (लिङ्क सहित)
६. **इनभ्वाइसहरू:** स्थिति, रकम, हेर्ने/डाउनलोड बटन सहितको सूची
७. **भुक्तानीहरू:** स्थिति, रकम, हेर्ने बटन सहितको सूची
८. **रसिदहरू:** हेर्ने/डाउनलोड बटन सहितको सूची
९. **कागजातहरू:** अपलोड गरिएका कागजातहरू डाउनलोड लिङ्क सहित
१०. **निरीक्षणहरू:** तालिका/सम्पन्न निरीक्षणहरू
११. **डुप्लिकेट समीक्षा:** डुप्लिकेट वा नभएको चिन्ह लगाउने
१२. **कार्यहरू:** वित्त, निरीक्षण, व्यवस्थापन समूह

#### ४.३ इनभ्वाइसहरू (`/admin/invoices`)

**सूची पृष्ठ:**
- सबै इनभ्वाइसहरूको सूची
- फिल्टर: खोजी, स्थिति, मिति दायरा
- कार्यहरू: हेर्ने, PDF डाउनलोड

**इनभ्वाइस विवरण (`/admin/invoices/{id}`):**
- इनभ्वाइस नम्बर, रकम, जारी मिति, म्याद मिति
- स्थिति ब्याज (पेन्डिङ/आंशिक/भुक्तानी भयो/म्याद नाघेको)
- दर्ता जानकारी लिङ्क सहित
- भुक्तानी सारांश (जम्मा भुक्तानी, बाँकी)
- भुक्तानी इतिहास स्थिति सहित
- कार्यहरू: PDF डाउनलोड, भुक्तानी थप्नुहोस्, दर्तामा जानुहोस्

#### ४.४ भुक्तानीहरू (`/admin/payments`)

**सूची पृष्ठ:**
- सबै भुक्तानीहरूको सूची
- तथ्यांक: जम्मा भुक्तानी, पेन्डिङ भुक्तानी, प्रमाणित भुक्तानी
- फिल्टर: खोजी, स्थिति
- कार्यहरू: हेर्ने, सम्पादन (पेन्डिङ भएमा), हटाउने (पेन्डिङ भएमा)
- **नोट:** "भुक्तानी थप्नुहोस्" बटन हटाइएको छ (भुक्तानी मात्र इनभ्वाइस कन्टेक्स्टबाट)

**भुक्तानी विवरण (`/admin/payments/{id}`):**
- भुक्तानी आईडी, दर्ता, इनभ्वाइस, रकम, विधि
- स्थिति ब्याज
- प्रमाणित/रिफन्ड मिति प्रयोगकर्ता जानकारी सहित
- कार्यहरू: प्रमाणित, अस्वीकार, रिफन्ड (स्थिति अनुसार)
- रसिद लिङ्कहरू (सिर्जना भएमा)

#### ४.५ रसिदहरू (`/admin/receipts`)

**सूची पृष्ठ:**
- सबै रसिदहरूको सूची
- फिल्टर: खोजी, दर्ता
- कार्यहरू: हेर्ने, PDF डाउनलोड

**रसिद विवरण (`/admin/receipts/{id}`):**
- रसिद नम्बर, रकम, जारी मिति
- भुक्तानी विधि, टिप्पणी
- दर्ता र इनभ्वाइस लिङ्कहरू
- PDF पूर्वावलोकन
- PDF डाउनलोड बटन

#### ४.६ होस्टेलहरू (`/admin/hostels`)

- सबै होस्टेलको सूची
- फिल्टर: खोजी, स्थिति, विशेष, दृश्यता, प्रकार
- बल्क कार्यहरू
- कार्यहरू: स्वीकृत, विशेष, लुकाउने, सम्पादन, हटाउने

#### ४.७ निरीक्षणहरू (`/admin/inspections`)

- सबै निरीक्षणको सूची
- स्थिति: तालिका, सम्पन्न, रद्द
- कार्यहरू: विवरण हेर्नुहोस्

#### ४.८ रिपोर्टहरू (`/admin/reports`)

- दर्ता, भुक्तानी, रसिदका लागि रिपोर्ट सिर्जना

#### ४.९ सेटिङहरू (`/admin/settings`)

- प्रणाली सेटिङ कन्फिगरेसन

#### ४.१० प्रमाणपत्र (`/admin/certificate`)

- प्रमाणपत्र सिर्जना र व्यवस्थापन

#### ४.११ CMS (`/admin/cms`)

- होमपेज सामग्री सम्पादन

#### ४.१२ आयात (`/admin/import`)

- Excel/CSV बाट डाटा आयात

---

### ५. स्वामी प्यानल गाइड (Owner Panel Guide)

#### ५.१ ड्यासबोर्ड
- आफ्नो दर्ताको सिंहावलोकन

#### ५.२ मेरा आवेदनहरू (`/owner/registrations`)
- आफ्नो दर्ता हेर्ने
- स्थिति ट्र्याक गर्ने

#### ५.३ मेरा कागजातहरू (`/owner/documents`)
- कागजात अपलोड र व्यवस्थापन

#### ५.४ मेरा भुक्तानीहरू (`/owner/payments`)
- भुक्तानी इतिहास हेर्ने

#### ५.५ मेरा इनभ्वाइसहरू (`/owner/invoices`)
- इनभ्वाइस हेर्ने
- PDF डाउनलोड

#### ५.६ मेरा प्रमाणपत्रहरू (`/owner/certificates`)
- प्रमाणपत्र हेर्ने
- डाउनलोड

#### ५.७ सदस्यता नवीकरण (`/owner/renew`)
- सदस्यता नवीकरण (भविष्यको सुविधा)

---

### ६. दर्ता प्रक्रिया (Registration Process - Detailed)

#### ६.१ सार्वजनिक दर्ता
**URL:** `/register-hostel`  
**फिल्डहरू:**
- होस्टल नाम (नेपाली र अंग्रेजी)
- प्रकार (केटा/केटी/सह-शिक्षा)
- क्षमता, कोठाहरू
- स्थापना वर्ष
- सम्पर्क, इमेल, वेबसाइट
- ठेगाना (प्रदेश, जिल्ला, नगरपालिका, वार्ड, सडक, स्थलचिह्न)
- स्वामी/व्यवस्थापक जानकारी
- PAN नम्बर
- कागजातहरू (दर्ता प्रमाणपत्र, नागरिकता, PAN प्रमाणपत्र, साइनबोर्ड, अन्य)

**पेशी पछि:**
- `पेन्डिङ` स्थितिमा दर्ता सिर्जना
- दर्ता आईडी सहित सफलता पृष्ठ

#### ६.२ प्रशासक दर्ता
**URL:** `/admin/registrations/create`  
- सार्वजनिक दर्ता जस्तै फिल्डहरू
- स्रोत "Admin" को रूपमा चिन्ह लगाइन्छ

#### ६.३ प्रशासक स्वीकृति
**स्थान:** दर्ता विवरण पृष्ठ  
**बटन:** "स्वीकृत" वा "अस्वीकृत"  
**पछि:** स्थिति `स्वीकृत` हुन्छ

---

### ७. इनभ्वाइस प्रक्रिया (Invoice Process - Detailed)

#### ७.१ इनभ्वाइस सिर्जना
**स्थान:** दर्ता विवरण पृष्ठ  
**शर्त:** दर्ता स्थिति = `स्वीकृत` र कुनै पेन्डिङ इनभ्वाइस छैन  
**बटन:** "इनभ्वाइस सिर्जना गर्नुहोस्"

**फारम फिल्डहरू:**
- इनभ्वाइस प्रकार (नयाँ दर्ता, नवीकरण, सदस्यता शुल्क, निरीक्षण शुल्क, प्रमाणपत्र शुल्क, जरिवाना, अन्य)
- रकम (NPR)
- म्याद मिति (वैकल्पिक)

**सिर्जना पछि:**
- `पेन्डिङ` स्थितिमा इनभ्वाइस सिर्जना
- दर्ता स्थिति `भुक्तानी पर्खाइ` हुन्छ
- PDF सिर्जना र भण्डारण

#### ७.२ इनभ्वाइस हेर्ने
**स्थान:** दर्ता विवरण वा इनभ्वाइस सूची  
**बटन:** "इनभ्वाइस हेर्नुहोस्"  
**देखाउँछ:** इनभ्वाइस विवरण, दर्ता जानकारी, भुक्तानी इतिहास, बाँकी रकम

#### ७.३ इनभ्वाइस PDF डाउनलोड
**स्थान:** इनभ्वाइस विवरण पृष्ठ  
**बटन:** "PDF डाउनलोड"

---

### ८. भुक्तानी प्रक्रिया (Payment Process - Detailed)

#### ८.१ भुक्तानी थप्नुहोस्
**स्थान:**
- दर्ता विवरण → "भुक्तानी थप्नुहोस्" बटन
- इनभ्वाइस विवरण → "भुक्तानी थप्नुहोस्" बटन

**महत्वपूर्ण:** इनभ्वाइस र दर्ता **स्वत: पूर्व-चयन** हुन्छ – प्रशासकले म्यानुअल रूपमा चयन गर्नु पर्दैन।

**भुक्तानी फारम फिल्डहरू:**
- भुक्तानी विधि (बैंक, eSewa, Khalti, नगद)
- रकम (NPR)
- कारोबार आईडी (वैकल्पिक)
- भुक्तानी मिति
- बैंकको नाम (वैकल्पिक)
- बैंक खाता (वैकल्पिक)
- टिप्पणी (वैकल्पिक)

**भ्यालिडेसन:**
- इनभ्वाइस `पेन्डिङ` वा `आंशिक` वा `म्याद नाघेको` हुनुपर्छ
- दर्ता इनभ्वाइसको दर्तासँग मिल्नुपर्छ
- रकम ० भन्दा बढी हुनुपर्छ

#### ८.२ भुक्तानी हेर्ने
**स्थान:** भुक्तानी सूची वा भुक्तानी विवरण  
**देखाउँछ:** सबै भुक्तानी विवरण, स्थिति, रसिद लिङ्कहरू

#### ८.३ भुक्तानी प्रमाणित (CRITICAL STEP)
**स्थान:** भुक्तानी विवरण पृष्ठ  
**शर्त:** भुक्तानी स्थिति = `पेन्डिङ`  
**बटन:** "प्रमाणित"

**प्रमाणित पछि के हुन्छ:**
१. भुक्तानी स्थिति `प्रमाणित` हुन्छ
२. **रसिद स्वत: सिर्जना** (कुनै म्यानुअल कार्य आवश्यक छैन)
३. इनभ्वाइस स्थिति अपडेट:
   - पूर्ण भुक्तानी भएमा → `भुक्तानी भयो`
   - आंशिक भुक्तानी भएमा → `आंशिक`
४. **दर्ता स्थिति `सक्रिय` हुन्छ** (यदि इनभ्वाइस पूर्ण भुक्तानी भएमा)
५. दर्ता म्याद मिति सेट: `valid_from` = आज, `valid_until` = आज + १ वर्ष

#### ८.४ भुक्तानी अस्वीकार
**स्थान:** भुक्तानी विवरण पृष्ठ  
**शर्त:** भुक्तानी स्थिति = `पेन्डिङ`  
**बटन:** "अस्वीकार"  
**पछि:** भुक्तानी स्थिति = `अस्वीकृत`

#### ८.५ भुक्तानी रिफन्ड
**स्थान:** भुक्तानी विवरण पृष्ठ  
**शर्त:** भुक्तानी स्थिति = `प्रमाणित`  
**बटन:** "रिफन्ड"  
**फिल्डहरू:** रिफन्ड कारण  
**पछि:** भुक्तानी स्थिति = `रिफन्ड गरियो`

---

### ९. रसिद प्रक्रिया (Receipt Process - Detailed)

#### ९.१ रसिद स्वत: सिर्जना (IMPORTANT)
**कहिले:** भुक्तानी प्रमाणित हुँदा  
**कसरी:** Event/Listener प्रणाली  
**कुनै म्यानुअल कार्य आवश्यक छैन।**

#### ९.२ रसिद हेर्ने
**स्थान:**
- दर्ता विवरण → रसिद सेक्सन
- रसिद सूची
- भुक्तानी विवरण

**देखाउँछ:** रसिद नम्बर, रकम, जारी मिति, दर्ता जानकारी, इनभ्वाइस जानकारी

#### ९.३ रसिद PDF डाउनलोड
**स्थान:** रसिद विवरण पृष्ठ वा दर्ता विवरण  
**बटन:** "डाउनलोड"

---

### १०. दर्ता सक्रिय (Registration Activation)

#### १०.१ दर्ता कहिले सक्रिय हुन्छ?
| शर्त | परिणाम |
|------|---------|
| दर्ता पेश | `पेन्डिङ` |
| प्रशासकले स्वीकृत | `स्वीकृत` |
| इनभ्वाइस सिर्जना | `भुक्तानी पर्खाइ` |
| भुक्तानी थपियो | (भुक्तानी: `पेन्डिङ`) |
| **भुक्तानी प्रमाणित** | **दर्ता `सक्रिय` हुन्छ** |
| दर्ता म्याद सकियो | `म्याद सकिएको` |

#### १०.२ सक्रिय विवरण
- `status` = `active`
- `valid_from` = आज
- `valid_until` = आज + १ वर्ष

---

### ११. वित्तीय सारांश (Financial Summary)

#### ११.१ दर्ता विवरण पृष्ठमा
| सेक्सन | देखाउँछ |
|--------|----------|
| **इनभ्वाइसहरू** | इनभ्वाइसको संख्या |
| **जम्मा इनभ्वाइस** | सबै इनभ्वाइस रकमको योग |
| **जम्मा भुक्तानी** | प्रमाणित भुक्तानीको योग |
| **बाँकी** | जम्मा इनभ्वाइस - जम्मा भुक्तानी |
| **पछिल्लो रसिद** | सबैभन्दा नयाँ रसिद नम्बर (लिङ्क सहित) |

#### ११.२ अर्को कार्य
प्रणालीले स्वत: सुझाव दिन्छ प्रशासकलाई अब के गर्ने:

| स्थिति | अर्को कार्य |
|--------|-------------|
| `पेन्डिङ` | यो दर्ता स्वीकृत गर्नुहोस् |
| `स्वीकृत` | इनभ्वाइस सिर्जना गर्नुहोस् |
| `भुक्तानी पर्खाइ` | इनभ्वाइस INV-XXXXX को लागि भुक्तानी थप्नुहोस् |
| `सक्रिय` | दर्ता सक्रिय छ। म्याद YYYY-MM-DD सम्म |
| `म्याद सकिएको` | दर्ता नवीकरण गर्नुहोस् (भविष्य) |

---

### १२. समस्या समाधान (Troubleshooting)

#### १२.१ दर्तामा भुक्तानी नदेखिने
- भुक्तानी सहि इनभ्वाइसमा लिङ्क भएको छ कि जाँच गर्नुहोस्
- भुक्तानी स्थिति `प्रमाणित` छ कि जाँच गर्नुहोस्
- इनभ्वाइस स्थिति `भुक्तानी भयो` छ कि जाँच गर्नुहोस्

#### १२.२ रसिद सिर्जना नभएको
- भुक्तानी `प्रमाणित` छ कि जाँच गर्नुहोस्
- लग हेर्नुहोस्: `storage/logs/laravel.log`
- Queue जाँच गर्नुहोस्: `.env` मा `QUEUE_CONNECTION=sync`
- Listeners `EventServiceProvider` मा दर्ता भएको छ कि

#### १२.३ दर्ता सक्रिय नभएको
- इनभ्वाइस `भुक्तानी भयो` हुनुपर्छ
- भुक्तानी `प्रमाणित` हुनुपर्छ
- `valid_from` र `valid_until` सेट भएको छ कि जाँच गर्नुहोस्
- Manual fix (Tinker):
  ```php
  $registration = Registration::find(ID);
  $registration->activate();
  ```

#### १२.४ "भुक्तानी थप्नुहोस्" बटन हराएको
- इनभ्वाइस पूर्ण भुक्तानी भएको छैन भने मात्र देखिन्छ
- इनभ्वाइस स्थिति जाँच गर्नुहोस्: `पेन्डिङ`, `आंशिक`, `म्याद नाघेको`
- इनभ्वाइस स्थिति `भुक्तानी भयो` भएमा बटन लुक्छ

#### १२.५ इनभ्वाइस डाउनलोड काम नगरेको
- PDF अवस्थित छ कि: `storage/app/public/invoices/`
- Tinker मार्फत PDF पुन: सिर्जना (developers लाई सोध्नुहोस्)

---

### १३. बारम्बार सोधिने प्रश्नहरू (FAQ)

#### Q1: के एउटा होस्टल दुई पटक दर्ता गर्न सकिन्छ?
**A:** होइन। प्रणालीले सक्रिय दर्ताहरू विरुद्ध डुप्लिकेट PAN, इमेल, र सम्पर्क नम्बर जाँच गर्छ।

#### Q2: के इनभ्वाइस बिना भुक्तानी थप्न सकिन्छ?
**A:** होइन। सबै भुक्तानी इनभ्वाइसमा लिङ्क हुनुपर्छ।

#### Q3: के प्रमाणित भुक्तानी सम्पादन गर्न सकिन्छ?
**A:** होइन। प्रमाणित भुक्तानी लक हुन्छ। केवल रिफन्डको अनुमति छ।

#### Q4: यदि आंशिक भुक्तानी भयो भने के हुन्छ?
**A:** इनभ्वाइस स्थिति `आंशिक` हुन्छ। दर्ता `भुक्तानी पर्खाइ` मा रहन्छ पूर्ण भुक्तानी नभएसम्म।

#### Q5: के एउटा दर्ताको लागि धेरै इनभ्वाइस सिर्जना गर्न सकिन्छ?
**A:** हो, तर एक पटकमा एउटा मात्र `पेन्डिङ` इनभ्वाइस। इनभ्वाइस भुक्तानी भएपछि नयाँ इनभ्वाइस सिर्जना गर्न सकिन्छ (जस्तै: नवीकरण, जरिवाना)।

#### Q6: "म्याद नाघेको" इनभ्वाइसको अर्थ के हो?
**A:** म्याद मिति बितिसकेको छ तर इनभ्वाइस पूर्ण भुक्तानी भएको छैन। भुक्तानी अझै थप्न र प्रमाणित गर्न सकिन्छ।

#### Q7: दर्ता सक्रिय छ कि छैन कसरी थाहा पाउने?
**A:** स्थितिले `सक्रिय` ब्याज देखाउँछ। `valid_until` मितिले म्याद देखाउँछ।

#### Q8: सदस्यता कसरी नवीकरण गर्ने?
**A:** (भविष्यको सुविधा) – जब दर्ता `म्याद सकिएको` हुन्छ, नवीकरण बटन देखिन्छ। नयाँ इनभ्वाइस सिर्जना हुन्छ, र भुक्तानी पछि `valid_until` विस्तार हुन्छ।

---

## 📌 **प्रयोगकर्ताहरूको लागि महत्वपूर्ण नोटहरू:**

१. **सधैं भुक्तानी प्रमाणित गर्नुहोस्** – प्रमाणित भुक्तानीले मात्र रसिद सिर्जना र दर्ता सक्रिय गर्छ।
२. **रसिदहरू स्वत: सिर्जना हुन्छन्** – भुक्तानी प्रमाणित पछि कुनै म्यानुअल कार्य आवश्यक छैन।
३. **दर्ताहरू स्वत: सक्रिय हुन्छन्** – जब इनभ्वाइस पूर्ण भुक्तानी हुन्छ।
४. **दर्ता स्थिति जाँच गर्नुहोस्** – प्रगति ट्र्याक गर्न कार्यप्रवाह स्थिति ब्याजहरू प्रयोग गर्नुहोस्।
५. **अर्को कार्य पालना गर्नुहोस्** – प्रणालीले तपाईंलाई अब के गर्ने भनेर सही बताउँछ।

---

**दस्तावेज संस्करण:** १.०  
**अन्तिम अपडेट:** २०२६-०७-०२  
**तयार गरिएको:** HEAN प्रणाली प्रयोगकर्ता र प्रशासकहरूको लागि

---

---

## 📚 **English Version**

---

### 1. System Overview

This is the **Hostel Entrepreneurs Association Nepal (HEAN)** **Hostel Registration & Management System**.

The main objectives of this system are:
- Hostel registration
- Invoice creation
- Payment collection
- Receipt generation
- Registration activation

**Core Workflow:**
```
Registration → Approval → Invoice → Payment → Receipt → Active
```

---

### 2. User Roles

| Role | Responsibilities |
|------|------------------|
| **Admin** | Approve registrations, generate invoices, manage payments, verify payments, manage all hostels |
| **Owner** | View own registrations, payments, invoices, receipts |
| **Inspector** | Conduct hostel inspections |

---

### 3. Complete Workflow (Step-by-Step)

#### Step 1: Registration
- **Who:** Admin or Public User
- **What:** Submit hostel registration form
- **Status:** `Pending`
- **Next Action:** Admin approval

#### Step 2: Admin Approval
- **Who:** Admin
- **What:** Review and approve registration
- **Status:** `Approved`
- **Next Action:** Generate Invoice

#### Step 3: Generate Invoice
- **Who:** Admin
- **What:** Create invoice for registration fee
- **Status:** `Awaiting Payment`
- **Next Action:** Add Payment

#### Step 4: Add Payment
- **Who:** Admin
- **What:** Record payment against invoice
- **Payment Status:** `Pending`
- **Next Action:** Verify Payment

#### Step 5: Verify Payment
- **Who:** Admin
- **What:** Confirm payment is valid
- **Payment Status:** `Verified`
- **Invoice Status:** `Paid`
- **Auto-Generated:** Receipt
- **Registration Status:** `Active`
- **Next Action:** None (Complete)

---

### 4. Admin Panel Guide

#### 4.1 Dashboard
**Location:** `/admin`  
**Shows:**
- Total Hostels
- Pending Registrations
- Inspections Pending
- Members Count
- Monthly Registrations Chart

#### 4.2 Registrations (Applications)
**Location:** `/admin/registrations`

##### View All Registrations
- Lists all registrations
- Shows: ID, Hostel Name, District, Status, Actions
- Click "View Details" to see full registration

##### Registration Statuses
| Status | Meaning | Next Action |
|--------|---------|-------------|
| `Pending` | Awaiting admin approval | Click "Approve" or "Reject" |
| `Approved` | Admin approved, no invoice yet | Generate Invoice |
| `Awaiting Payment` | Invoice generated, not paid | Add Payment |
| `Active` | Fully paid and active | Renewal (future) |
| `Expired` | Validity expired | Renew (future) |
| `Rejected` | Registration rejected | None |
| `Duplicate` | Duplicate registration | None |

##### Registration Details Page (`/admin/registrations/{id}`)

**Sections:**

1. **Header:** Registration ID, Date, Status, Source
2. **Hostel Information:** Name, Type, District
3. **Workflow Status:** Visual progress (Registration → Invoice → Payment → Receipt → Active)
4. **Financial Summary:** Invoices count, Total Invoiced, Total Paid, Outstanding, Latest Receipt
5. **Next Action:** What admin should do next (with link)
6. **Invoices:** List with status, amount, View/Download buttons
7. **Payments:** List with status, amount, View button
8. **Receipts:** List with View/Download buttons
9. **Documents:** Uploaded documents with download links
10. **Inspections:** Scheduled/completed inspections
11. **Duplicate Reviews:** Mark as duplicate or not duplicate
12. **Actions:** Finance, Inspection, Management groups

#### 4.3 Invoices (`/admin/invoices`)

**Index Page:**
- Lists all invoices
- Filters: Search, Status, Date range
- Actions: View, Download PDF

**Invoice Details (`/admin/invoices/{id}`):**
- Invoice number, Amount, Issue Date, Due Date
- Status badge (Pending/Partial/Paid/Overdue)
- Registration information with link
- Payment summary (Total Paid, Outstanding)
- Payment history with status
- Actions: Download PDF, Add Payment, Go to Registration

#### 4.4 Payments (`/admin/payments`)

**Index Page:**
- Lists all payments
- Stats: Total Paid, Pending Payments, Verified Payments
- Filters: Search, Status
- Actions: View, Edit (if pending), Delete (if pending)
- **Note:** "Add Payment" button is removed (payments only from invoice context)

**Payment Details (`/admin/payments/{id}`):**
- Payment ID, Registration, Invoice, Amount, Method
- Status badge
- Verified/Refunded timestamps with user info
- Actions: Verify, Reject, Refund (based on status)
- Receipt links (if generated)

#### 4.5 Receipts (`/admin/receipts`)

**Index Page:**
- Lists all receipts
- Filters: Search, Registration
- Actions: View, Download PDF

**Receipt Details (`/admin/receipts/{id}`):**
- Receipt number, Amount, Issue Date
- Payment method, Remarks
- Registration and Invoice links
- PDF preview
- Download PDF button

#### 4.6 Hostels (`/admin/hostels`)

- List all hostels
- Filters: Search, Status, Featured, Visibility, Type
- Bulk actions
- Actions: Approve, Feature, Hide, Edit, Delete

#### 4.7 Inspections (`/admin/inspections`)

- List all inspections
- Status: Scheduled, Completed, Cancelled
- Actions: View Details

#### 4.8 Reports (`/admin/reports`)

- Generate reports for registrations, payments, receipts

#### 4.9 Settings (`/admin/settings`)

- System settings configuration

#### 4.10 Certificate (`/admin/certificate`)

- Generate and manage certificates

#### 4.11 CMS (`/admin/cms`)

- Edit homepage content

#### 4.12 Import (`/admin/import`)

- Import data from Excel/CSV

---

### 5. Owner Panel Guide

#### 5.1 Dashboard
- Overview of own registrations

#### 5.2 My Applications (`/owner/registrations`)
- View own registrations
- Track status

#### 5.3 My Documents (`/owner/documents`)
- Upload and manage documents

#### 5.4 My Payments (`/owner/payments`)
- View payment history

#### 5.5 My Invoices (`/owner/invoices`)
- View invoices
- Download PDF

#### 5.6 My Certificates (`/owner/certificates`)
- View certificates
- Download

#### 5.7 Renew Subscription (`/owner/renew`)
- Renew membership (future feature)

---

### 6. Registration Process (Detailed)

#### 6.1 Public Registration
**URL:** `/register-hostel`  
**Fields:**
- Hostel Name (Nepali & English)
- Type (Boys/Girls/Co-Ed)
- Capacity, Rooms
- Established Year
- Contact, Email, Website
- Address (Province, District, Municipality, Ward, Street, Landmark)
- Owner/Manager Information
- PAN Number
- Documents (Registration Certificate, Citizenship, PAN Certificate, Signboard, Other)

**After Submission:**
- Registration created with `Pending` status
- Success page with Registration ID

#### 6.2 Admin Registration
**URL:** `/admin/registrations/create`  
- Similar fields as public registration
- Source marked as "Admin"

#### 6.3 Admin Approval
**Location:** Registration Details page  
**Button:** "Approve" or "Reject"  
**After Approval:** Status becomes `Approved`

---

### 7. Invoice Process (Detailed)

#### 7.1 Generate Invoice
**Location:** Registration Details page  
**Condition:** Registration status = `Approved` and no pending invoice  
**Button:** "Generate Invoice"

**Form Fields:**
- Invoice Type (New Registration, Renewal, Membership Fee, Inspection Fee, Certificate Fee, Penalty, Other)
- Amount (NPR)
- Due Date (optional)

**After Generation:**
- Invoice created with `Pending` status
- Registration status becomes `Awaiting Payment`
- PDF generated and stored

#### 7.2 View Invoice
**Location:** Registration Details or Invoice Index  
**Button:** "View Invoice"  
**Shows:** Invoice details, Registration info, Payment history, Outstanding amount

#### 7.3 Download Invoice PDF
**Location:** Invoice Details page  
**Button:** "Download PDF"

---

### 8. Payment Process (Detailed)

#### 8.1 Add Payment
**Location:**
- Registration Details → "Add Payment" button
- Invoice Details → "Add Payment" button

**Important:** Invoice and Registration are **automatically pre-selected** – admin does NOT select them manually.

**Payment Form Fields:**
- Payment Method (Bank, eSewa, Khalti, Cash)
- Amount (NPR)
- Transaction ID (optional)
- Payment Date
- Bank Name (optional)
- Bank Account (optional)
- Remarks (optional)

**Validation:**
- Invoice must be `Pending` or `Partial` or `Overdue`
- Registration must match invoice's registration
- Amount must be greater than 0

#### 8.2 View Payment
**Location:** Payment Index or Payment Details  
**Shows:** All payment details, status, receipt links

#### 8.3 Verify Payment (CRITICAL STEP)
**Location:** Payment Details page  
**Condition:** Payment status = `Pending`  
**Button:** "Verify"

**What Happens After Verify:**
1. Payment status becomes `Verified`
2. **Receipt auto-generates** (no manual action needed)
3. Invoice status updates:
   - If fully paid → `Paid`
   - If partially paid → `Partial`
4. **Registration status becomes `Active`** (if invoice fully paid)
5. Registration validity dates set: `valid_from` = today, `valid_until` = today + 1 year

#### 8.4 Reject Payment
**Location:** Payment Details page  
**Condition:** Payment status = `Pending`  
**Button:** "Reject"  
**After:** Payment status = `Rejected`

#### 8.5 Refund Payment
**Location:** Payment Details page  
**Condition:** Payment status = `Verified`  
**Button:** "Refund"  
**Fields:** Refund Reason  
**After:** Payment status = `Refunded`

---

### 9. Receipt Process (Detailed)

#### 9.1 Receipt Auto-Generation (IMPORTANT)
**When:** When Payment is Verified  
**How:** Event/Listener system  
**No manual action required.**

#### 9.2 View Receipt
**Location:**
- Registration Details → Receipts section
- Receipt Index
- Payment Details

**Shows:** Receipt number, Amount, Issue Date, Registration info, Invoice info

#### 9.3 Download Receipt PDF
**Location:** Receipt Details page or Registration Details  
**Button:** "Download"

---

### 10. Registration Activation

#### 10.1 When Does Registration Become Active?

| Condition | Result |
|-----------|--------|
| Registration submitted | `Pending` |
| Admin approves | `Approved` |
| Invoice generated | `Awaiting Payment` |
| Payment added | (Payment: `Pending`) |
| **Payment verified** | **Registration becomes `Active`** |
| Registration expires | `Expired` |

#### 10.2 Activation Details
- `status` = `active`
- `valid_from` = today
- `valid_until` = today + 1 year

---

### 11. Financial Summary

#### 11.1 On Registration Details Page

| Section | Shows |
|---------|-------|
| **Invoices** | Number of invoices |
| **Total Invoiced** | Sum of all invoice amounts |
| **Total Paid** | Sum of verified payments |
| **Outstanding** | Total Invoiced - Total Paid |
| **Latest Receipt** | Most recent receipt number (with link) |

#### 11.2 Next Action
System automatically suggests what admin should do next:

| Status | Next Action |
|--------|-------------|
| `Pending` | Approve this registration |
| `Approved` | Generate an invoice |
| `Awaiting Payment` | Add payment for invoice INV-XXXXX |
| `Active` | Registration is active. Valid until YYYY-MM-DD |
| `Expired` | Renew registration (future) |

---

### 12. Troubleshooting

#### 12.1 Payment Not Showing on Registration
- Check if payment is linked to correct invoice
- Verify payment status is `Verified`
- Check if invoice status is `Paid`

#### 12.2 Receipt Not Generated
- Check payment is `Verified`
- Check logs: `storage/logs/laravel.log`
- Check queue: `QUEUE_CONNECTION=sync` in `.env`
- Listeners registered in `EventServiceProvider`

#### 12.3 Registration Not Active
- Invoice must be `Paid`
- Payment must be `Verified`
- Check `valid_from` and `valid_until` are set
- Manual fix (Tinker):
  ```php
  $registration = Registration::find(ID);
  $registration->activate();
  ```

#### 12.4 "Add Payment" Button Missing
- Only shows if invoice is not fully paid
- Check invoice status: `Pending`, `Partial`, `Overdue`
- If invoice status is `Paid`, button is hidden

#### 12.5 Invoice Download Not Working
- Check if PDF exists: `storage/app/public/invoices/`
- Regenerate PDF via Tinker (ask developer)

---

### 13. Frequently Asked Questions

#### Q1: Can a hostel be registered twice?
**A:** No. System checks for duplicate PAN, email, and contact number against active registrations.

#### Q2: Can I add payment without invoice?
**A:** No. All payments must be linked to an invoice.

#### Q3: Can I edit a verified payment?
**A:** No. Verified payments are locked. Only refund is allowed.

#### Q4: What happens if payment is partially paid?
**A:** Invoice status becomes `Partial`. Registration remains `Awaiting Payment` until fully paid.

#### Q5: Can I generate multiple invoices for one registration?
**A:** Yes, but only one `Pending` invoice at a time. After invoice is paid, new invoices can be generated (e.g., renewal, penalty).

#### Q6: What does "Overdue" invoice mean?
**A:** The due date has passed but invoice is not fully paid. Payment can still be added and verified.

#### Q7: How do I know if registration is active?
**A:** Status shows `Active` badge. `valid_until` date shows expiry.

#### Q8: How do I renew membership?
**A:** (Future feature) – When registration is `Expired`, Renewal button appears. A new invoice is generated, and after payment, `valid_until` extends.

---

## 📌 **Important Notes for Users:**

1. **Always verify payment** – Only verified payments generate receipts and activate registrations.
2. **Receipts are auto-generated** – No manual action needed after payment verification.
3. **Registrations activate automatically** – When invoice becomes fully paid.
4. **Check Registration Status** – Use the workflow status badges to track progress.
5. **Follow Next Action** – The system tells you exactly what to do next.

---

**Document Version:** 1.0  
**Last Updated:** 2026-07-02  
**Prepared for:** HEAN System Users & Admins

---
