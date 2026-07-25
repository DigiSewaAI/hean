{{-- ONE REUSABLE MODAL – NO hardcoded target --}}
<div id="nepali-typing-modal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm"
     role="dialog"
     aria-modal="true"
     aria-labelledby="nepali-typing-title">

    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 p-6 relative">

        {{-- Header --}}
        <h3 id="nepali-typing-title" class="text-lg font-bold text-gray-800 mb-1">
            🇳🇵 नेपाली टाइपिङ
        </h3>
        <p class="text-sm text-gray-500 mb-4">
            अङ्ग्रेजीमा टाइप गर्नुहोस्, नेपाली युनिकोडमा रूपान्तरण हुन्छ।
        </p>

        {{-- Input field – dynamic placeholder via JS --}}
        <input type="text"
               id="nepali-typing-input"
               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
               placeholder="जस्तै: suryodaya boys hostel"
               autofocus
               autocomplete="off"
               autocorrect="off"
               autocapitalize="off"
               spellcheck="false">

        {{-- Live preview – Unicode output --}}
        <div class="mt-4">
            <label class="text-sm font-medium text-gray-600 block mb-1">🔍 लाइभ प्रिव्यू</label>
            <div id="nepali-typing-preview"
                 class="min-h-[48px] p-3 bg-gray-50 border border-gray-200 rounded-xl text-lg text-gray-800 break-words">
                <span class="text-gray-400 text-sm">यहाँ नेपाली पाठ देखिनेछ</span>
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-5 flex flex-wrap gap-2 justify-end">
            <button type="button"
                    class="nepali-clear-btn px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                खाली गर्नुहोस्
            </button>
            <button type="button"
                    class="nepali-cancel-btn px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                रद्द गर्नुहोस्
            </button>
            <button type="button"
                    class="nepali-insert-btn px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-sm">
                📥 घुसाउनुहोस्
            </button>
        </div>
    </div>
</div>