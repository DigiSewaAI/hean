<!-- Document Preview Modal -->
<div class="modal fade" id="docPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.document_preview') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('messages.close') }}"></button>
            </div>
            <div class="modal-body" style="text-align:center; min-height:300px;">
                <!-- Content will be injected by JavaScript -->
            </div>
        </div>
    </div>
</div>

<script>
    // ✅ सरल र पक्का – Modal को लागि Event Listener
    document.addEventListener('DOMContentLoaded', function() {
        var modalElement = document.getElementById('docPreviewModal');

        modalElement.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var fileUrl = button.getAttribute('data-file-url');
            var fileType = button.getAttribute('data-file-type');
            var fileName = button.getAttribute('data-file-name') || 'Document';

            var body = modalElement.querySelector('.modal-body');

            // Clear previous content
            body.innerHTML = '';

            if (fileType === 'image') {
                // ✅ सिधै इमेज देखाउने
                body.innerHTML = '<img src="' + fileUrl + '" style="max-width:100%; max-height:70vh; border-radius:8px;" alt="' + fileName + '">';
            } else if (fileType === 'pdf') {
                body.innerHTML = '<embed src="' + fileUrl + '" style="width:100%; height:70vh;" type="application/pdf">';
            } else {
                // Fallback – download link
                body.innerHTML = '<a href="' + fileUrl + '" target="_blank" class="btn btn-primary">View/Download File</a>';
            }
        });

        // Modal बन्द हुँदा content खाली गर्ने
        modalElement.addEventListener('hidden.bs.modal', function() {
            var body = modalElement.querySelector('.modal-body');
            body.innerHTML = '';
        });
    });
</script>