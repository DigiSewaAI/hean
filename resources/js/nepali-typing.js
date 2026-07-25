/**
 * Nepali Typing Modal – Production Module (v2)
 * Features: one modal, dynamic target, lazy loading, accessibility, graceful error,
 *           custom normalization map for HEAN-specific corrections.
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

    // ─── State ────────────────────────────────────────────────────
    let activeTargetId = null;          // ID of the input field we are typing for
    let activeTrigger = null;           // The button that opened the modal
    let previousFocused = null;         // Element to restore focus after close
    let sanscriptModule = null;         // Lazy-loaded module cache
    let isOpen = false;
    let isComposing = false;            // For IME handling

    // ─── HEAN Custom Transliteration Map (Global Constant) ──────
    const CUSTOM_TRANSLITERATION_MAP = {
        // Common corrections for HEAN
        'होस्तेल': 'होस्टेल',
        'होस्तेल्': 'होस्टेल',
        'होस्टेल्': 'होस्टेल',

        'बोइज़': 'ब्वाइज',
        'बोइज': 'ब्वाइज',

        'गर्ल्ज़': 'गर्ल्स',
        'गर्ल्ज': 'गर्ल्स',

        // Future / additional words (can be extended easily)
        'नेपाल्गन्ज': 'नेपालगञ्ज',
        'काठमान्डु': 'काठमाडौं',
        'पोखरा': 'पोखरा', // already correct, but kept for consistency
        'चितवन': 'चितवन',
        'विराटनगर': 'विराटनगर',
        'धनगढी': 'धनगढी',
        'भैरहवा': 'भैरहवा',
        'सर्लाही': 'सर्लाही',

        // Common English loanwords
        'म्यानेजमेन्ट': 'म्यानेजमेन्ट', // already correct
        'इन्टरप्रेनर': 'इन्टरप्रेनर',
        'एसोसिएसन': 'एसोसिएसन',
        'एशोसिएशन': 'एसोसिएसन',
        'एसोशिएसन': 'एसोसिएसन',

        // Student related
        'विद्यार्थी': 'विद्यार्थी',
        'आवास': 'आवास',
        'समिति': 'समिति',
        'व्यवस्थापन': 'व्यवस्थापन',
        'संघ': 'संघ',
        'सङ्घ': 'संघ',
    };

    // ─── Normalize function (uses global constant) ──────────────
    function normalizeNepaliText(text) {
        let output = text;
        for (const [wrong, correct] of Object.entries(CUSTOM_TRANSLITERATION_MAP)) {
            // Use replaceAll to fix all occurrences
            output = output.replaceAll(wrong, correct);
        }
        return output;
    }

    // ─── Lazy load Sanscript ──────────────────────────────────────
    async function loadSanscript() {
        if (sanscriptModule) return sanscriptModule;
        try {
            const module = await import('@indic-transliteration/sanscript');
            // The package exports default object with .t method
            sanscriptModule = module.default || module;
            return sanscriptModule;
        } catch (error) {
            console.error('Failed to load Nepali transliteration library:', error);
            // Show user-friendly message (non-blocking)
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg z-[9999]';
            toast.textContent = '⚠️ Nepali typing सेवा लोड गर्न असफल। पृष्ठ रिफ्रेस गर्नुहोस्।';
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 5000);
            throw error;
        }
    }

    // ─── Transliterate ────────────────────────────────────────────
    function transliterate(text) {
        if (!text.trim()) return '';
        try {
            const Sanscript = sanscriptModule;
            const result = Sanscript.t(text, 'itrans', 'devanagari');
            return normalizeNepaliText(result);
        } catch (e) {
            console.warn('Transliteration error:', e);
            return text; // fallback
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
            const nepali = transliterate(raw);
            preview.textContent = nepali;
        } catch (e) {
            preview.textContent = raw;
        }
    }

    // ─── Open modal ───────────────────────────────────────────────
    async function openModal(targetId, triggerEl) {
        if (!modal || !input || !preview) return;

        // Lazy load Sanscript if not already
        try {
            await loadSanscript();
        } catch {
            // Error already handled in loadSanscript
            return;
        }

        activeTargetId = targetId;
        activeTrigger = triggerEl;
        previousFocused = document.activeElement;

        // Update modal title & placeholder from data attributes (if any)
        const title = triggerEl.dataset.title || '🇳🇵 नेपाली टाइपिङ';
        const placeholder = triggerEl.dataset.placeholder || 'जस्तै: suryodaya boys hostel';
        const titleEl = document.getElementById('nepali-typing-title');
        if (titleEl) titleEl.textContent = title;
        input.placeholder = placeholder;

        // Clear previous content
        input.value = '';
        preview.innerHTML = '<span class="text-gray-400 text-sm">यहाँ नेपाली पाठ देखिनेछ</span>';

        // Show modal (flex)
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        isOpen = true;

        // Focus input after a tiny delay (for animation)
        requestAnimationFrame(() => input.focus());

        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }

    // ─── Close modal ──────────────────────────────────────────────
    function closeModal() {
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        isOpen = false;
        document.body.style.overflow = '';

        // Restore focus
        if (previousFocused && previousFocused.focus) {
            previousFocused.focus();
        }
        activeTargetId = null;
        activeTrigger = null;
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

        // Transliterate the final text using the same logic
        let finalText;
        try {
            const Sanscript = sanscriptModule;
            finalText = normalizeNepaliText(
                Sanscript.t(raw, 'itrans', 'devanagari')
            );
        } catch (e) {
            finalText = raw;
        }

        // Set value and trigger change/input events so any validation/listeners fire
        targetInput.value = finalText;
        targetInput.dispatchEvent(new Event('input', { bubbles: true }));
        targetInput.dispatchEvent(new Event('change', { bubbles: true }));

        // Close modal
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

        // If modal is already open for another field, close it first
        if (isOpen) {
            closeModal();
            // Small delay to let it close before reopening
            await new Promise(resolve => setTimeout(resolve, 50));
        }

        openModal(targetId, trigger);
    });

    // ─── Modal internal events ──────────────────────────────────

    // Input events: use 'input' for all typing, paste, etc.
    input?.addEventListener('input', updatePreview);

    // Composition events for IME (e.g., Japanese/Korean, but also for mobile)
    input?.addEventListener('compositionstart', () => {
        isComposing = true;
    });
    input?.addEventListener('compositionend', () => {
        isComposing = false;
        updatePreview(); // update after IME commit
    });

    // Insert button
    insertBtn?.addEventListener('click', insertText);

    // Clear button
    clearBtn?.addEventListener('click', () => {
        input.value = '';
        updatePreview();
        input.focus();
    });

    // Cancel button
    cancelBtn?.addEventListener('click', closeModal);

    // ─── Keyboard shortcuts (when modal is open) ──────────────
    document.addEventListener('keydown', (e) => {
        if (!isOpen) return;

        if (e.key === 'Escape') {
            e.preventDefault();
            closeModal();
        }

        // Ctrl+Enter or Cmd+Enter to insert
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            insertText();
        }
    });

    // ─── Click outside modal content to close ──────────────────
    modal?.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // ─── Focus trap (Tab within modal) ─────────────────────────
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

    // ─── Cleanup on page unload (optional) ─────────────────────
    // Nothing persistent to clean; event listeners are on document/modal.

    console.log('✅ Nepali Typing Modal initialized (lazy-load ready)');
})();