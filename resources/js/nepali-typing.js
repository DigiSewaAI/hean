/**
 * Nepali Typing Modal – Production Module v8 (FINAL)
 *
 * Features:
 * – One reusable modal, dynamic target via data-target
 * – Lazy loading: Sanscript loaded only when modal opens
 * – Case‑insensitive phrase preprocessing (longest match first)
 * – Unicode Private Use Area (U+E000–) placeholders (expected to remain unchanged by Sanscript)
 * – Post‑processing correction map (only true corrections)
 * – Accessibility: ESC, focus trap, ARIA, restore focus
 * – Mobile‑first, Tailwind CSS only
 */

(function() {
    'use strict';

    // ─── DOM refs ──────────────────────────────────────────────────
    const modal = document.getElementById('nepali-typing-modal');
    const input = document.getElementById('nepali-typing-input');
    const preview = document.getElementById('nepali-typing-preview');
    const insertBtn = modal?.querySelector('.nepali-insert-btn');
    const clearBtn = modal?.querySelector('.nepali-clear-btn');
    const cancelBtn = modal?.querySelector('.nepali-cancel-btn');

    // ─── Safety check ────────────────────────────────────────────
    if (!modal || !input || !preview) {
        console.warn('Nepali Typing Modal elements not found.');
        return;
    }

    // ─── State ────────────────────────────────────────────────────
    let activeTargetId = null;
    let previousFocused = null;
    let sanscriptModule = null;
    let isOpen = false;

    // ─── Phrase Preprocessing Map (GENERIC – only 5 entries) ────
    // Order: longest match first
    const PHRASE_PREPROCESS_MAP = [
        { pattern: 'boys hostel', nepali: 'ब्वाइज होस्टेल' },
        { pattern: 'girls hostel', nepali: 'गर्ल्स होस्टेल' },
        { pattern: 'hostel', nepali: 'होस्टेल' },
        { pattern: 'boys', nepali: 'ब्वाइज' },
        { pattern: 'girls', nepali: 'गर्ल्स' },
    ];

    // ─── Post‑Processing Correction Map (only true corrections) ──
    const CUSTOM_TRANSLITERATION_MAP = {
        'होस्तेल': 'होस्टेल',
        'होस्तेल्': 'होस्टेल',
        'होस्टेल्': 'होस्टेल',
        'बोइज़': 'ब्वाइज',
        'बोइज': 'ब्वाइज',
        'गर्ल्ज़': 'गर्ल्स',
        'गर्ल्ज': 'गर्ल्स',
        'नेपाल्गन्ज': 'नेपालगञ्ज',
        'काठमान्डु': 'काठमाडौं',
        'एशोसिएशन': 'एसोसिएसन',
        'एसोशिएसन': 'एसोसिएसन',
        'सङ्घ': 'संघ',
    };

    // ─── Normalization helper ─────────────────────────────────────
    function normalizeNepaliText(text) {
        let output = text;
        for (const [wrong, correct] of Object.entries(CUSTOM_TRANSLITERATION_MAP)) {
            output = output.replaceAll(wrong, correct);
        }
        return output;
    }

    // ─── Unified conversion pipeline ─────────────────────────────
    function convertText(rawText) {
        if (!rawText.trim()) return '';

        // 1. Preprocess: replace generic phrases with PUA placeholders
        const { processed, placeholders } = preprocessPhrases(rawText);

        // 2. Transliterate the remaining text.
        // PUA placeholders are expected to remain unchanged by Sanscript.
        let transliterated;
        try {
            const Sanscript = sanscriptModule;
            transliterated = Sanscript.t(processed, 'itrans', 'devanagari');
        } catch (e) {
            console.warn('Transliteration error:', e);
            transliterated = processed;
        }

        // 3. Restore placeholders to their Nepali equivalents
        let result = transliterated;
        for (const [ph, nepali] of Object.entries(placeholders)) {
            result = result.replaceAll(ph, nepali);
        }

        // 4. Post‑process with correction map
        return normalizeNepaliText(result);
    }

    // ─── Phrase preprocessing with PUA placeholders ──────────────
    function preprocessPhrases(text) {
        // Sort by pattern length descending (longest match first)
        const sorted = [...PHRASE_PREPROCESS_MAP].sort((a, b) => b.pattern.length - a.pattern.length);

        let processed = text;
        const placeholderMap = {};
        let counter = 0;

        for (const item of sorted) {
            // Escape regex specials
            const escaped = item.pattern.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            // Case‑insensitive, with word boundaries to avoid partial matches
            const regex = new RegExp('\\b' + escaped + '\\b', 'gi');

            // Use Unicode Private Use Area (PUA) code points.
            // These code points are reserved for application‑specific use and are
            // expected to remain unchanged by Sanscript during transliteration.
            const placeholder = String.fromCodePoint(0xE000 + counter);
            counter++;

            processed = processed.replace(regex, placeholder);
            placeholderMap[placeholder] = item.nepali;
        }

        return { processed, placeholders: placeholderMap };
    }

    // ─── Lazy load Sanscript ──────────────────────────────────────
    async function loadSanscript() {
        if (sanscriptModule) return sanscriptModule;
        try {
            const module = await import('@indic-transliteration/sanscript');
            sanscriptModule = module.default || module;
            return sanscriptModule;
        } catch (error) {
            console.error('Failed to load Nepali transliteration library:', error);
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg z-[9999]';
            toast.textContent = '⚠️ Nepali typing सेवा लोड गर्न असफल। पृष्ठ रिफ्रेस गर्नुहोस्।';
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 5000);
            throw error;
        }
    }

    // ─── Update preview ───────────────────────────────────────────
    function updatePreview() {
        const raw = input.value;
        if (!raw.trim()) {
            preview.innerHTML = '<span class="text-gray-400 text-sm">यहाँ नेपाली पाठ देखिनेछ</span>';
            return;
        }
        try {
            const nepali = convertText(raw);
            preview.textContent = nepali;
        } catch (e) {
            preview.textContent = raw;
        }
    }

    // ─── Open modal ───────────────────────────────────────────────
    async function openModal(targetId, triggerEl) {
        if (!modal || !input || !preview) return;

        try {
            await loadSanscript();
        } catch {
            return;
        }

        activeTargetId = targetId;
        previousFocused = document.activeElement;

        const title = triggerEl.dataset.title || '🇳🇵 नेपाली टाइपिङ';
        const placeholder = triggerEl.dataset.placeholder || 'जस्तै: Suryodaya Boys Hostel';
        const titleEl = document.getElementById('nepali-typing-title');
        if (titleEl) titleEl.textContent = title;
        input.placeholder = placeholder;

        input.value = '';
        preview.innerHTML = '<span class="text-gray-400 text-sm">यहाँ नेपाली पाठ देखिनेछ</span>';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        isOpen = true;

        requestAnimationFrame(() => input.focus());
        document.body.style.overflow = 'hidden';
    }

    // ─── Close modal ──────────────────────────────────────────────
    function closeModal() {
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        isOpen = false;
        document.body.style.overflow = '';

        if (previousFocused && previousFocused.focus) {
            previousFocused.focus();
        }
        activeTargetId = null;
    }

    // ─── Insert text ──────────────────────────────────────────────
    function insertText() {
        if (!activeTargetId) return;
        const targetInput = document.getElementById(activeTargetId);
        if (!targetInput) {
            console.warn('Target input not found:', activeTargetId);
            closeModal();
            return;
        }

        const raw = input.value;
        if (!raw.trim()) {
            closeModal();
            return;
        }

        let finalText;
        try {
            finalText = convertText(raw);
        } catch (e) {
            finalText = raw;
        }

        targetInput.value = finalText;
        targetInput.dispatchEvent(new Event('input', { bubbles: true }));
        targetInput.dispatchEvent(new Event('change', { bubbles: true }));

        closeModal();
    }

    // ─── Event Delegation for triggers ──────────────────────────
    document.addEventListener('click', async (e) => {
        const trigger = e.target.closest('.nepali-typing-trigger');
        if (!trigger) return;

        e.preventDefault();
        const targetId = trigger.dataset.target;
        if (!targetId) {
            console.warn('Missing data-target on trigger');
            return;
        }

        if (isOpen) {
            closeModal();
            await new Promise(resolve => setTimeout(resolve, 50));
        }

        openModal(targetId, trigger);
    });

    // ─── Modal internal events ──────────────────────────────────
    input?.addEventListener('input', updatePreview);

    insertBtn?.addEventListener('click', insertText);

    clearBtn?.addEventListener('click', () => {
        input.value = '';
        updatePreview();
        input.focus();
    });

    cancelBtn?.addEventListener('click', closeModal);

    // ─── Keyboard shortcuts ──────────────────────────────────────
    document.addEventListener('keydown', (e) => {
        if (!isOpen) return;

        if (e.key === 'Escape') {
            e.preventDefault();
            closeModal();
        }

        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            insertText();
        }
    });

    // ─── Click outside modal ────────────────────────────────────
    modal?.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // ─── Focus trap ──────────────────────────────────────────────
    modal?.addEventListener('keydown', (e) => {
        if (e.key !== 'Tab') return;
        const focusable = modal.querySelectorAll(
            'button, input, [tabindex]:not([tabindex="-1"])'
        );
        if (!focusable.length) return;

        const first = focusable[0];
        const last = focusable[focusable.length - 1];

        if (e.shiftKey && document.activeElement === first) {
            e.preventDefault();
            last.focus();
        } else if (!e.shiftKey && document.activeElement === last) {
            e.preventDefault();
            first.focus();
        }
    });

    console.log('✅ Nepali Typing Modal initialized');
})();