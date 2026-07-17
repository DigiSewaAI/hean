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
            <div class="modal-footer">
                <!-- Close button removed – use X button or click outside -->
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('docPreviewModal');
    if (modal) {
        modal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var fileUrl = button.getAttribute('data-file-url');
            var fileType = button.getAttribute('data-file-type');
            var fileName = button.getAttribute('data-file-name');
            var body = modal.querySelector('.modal-body');

            if (fileType === 'image') {
                body.innerHTML = '<img src="' + fileUrl + '" style="max-width:100%; max-height:70vh; border-radius:8px;" alt="' + fileName + '">';
            } else if (fileType === 'pdf') {
                body.innerHTML = '<embed src="' + fileUrl + '" style="width:100%; height:70vh;" type="application/pdf">';
            } else {
                body.innerHTML = '<a href="' + fileUrl + '" target="_blank" class="btn btn-primary">Download File</a>';
            }
        });

        // Clear content on hide to prevent flickering
        modal.addEventListener('hidden.bs.modal', function() {
            var body = modal.querySelector('.modal-body');
            body.innerHTML = '';
        });
    }
});
</script>
@endpush