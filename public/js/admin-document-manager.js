// admin-document-manager.js
document.addEventListener('DOMContentLoaded', function() {
    // Generic document preview modal
    const previewModal = document.getElementById('docPreviewModal');
    if (previewModal) {
        previewModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const fileUrl = button.getAttribute('data-file-url');
            const fileType = button.getAttribute('data-file-type');
            const fileName = button.getAttribute('data-file-name');
            
            const modalTitle = previewModal.querySelector('.modal-title');
            const modalBody = previewModal.querySelector('.modal-body');
            
            if (modalTitle) modalTitle.textContent = fileName || 'Document Preview';
            
            // Clear previous content
            modalBody.innerHTML = '';
            
            if (fileType === 'image') {
                const img = document.createElement('img');
                img.src = fileUrl;
                img.style.maxWidth = '100%';
                img.style.maxHeight = '70vh';
                img.style.borderRadius = '4px';
                modalBody.appendChild(img);
            } else if (fileType === 'pdf') {
                const iframe = document.createElement('iframe');
                iframe.src = fileUrl;
                iframe.style.width = '100%';
                iframe.style.height = '70vh';
                iframe.style.border = 'none';
                modalBody.appendChild(iframe);
            } else {
                modalBody.innerHTML = '<p class="text-muted">Preview not available for this file type.</p>';
            }
        });
    }
    
    // Gallery modal
    const galleryModal = document.getElementById('photoGalleryModal');
    if (galleryModal) {
        galleryModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const photos = JSON.parse(button.getAttribute('data-photos'));
            const carouselInner = galleryModal.querySelector('.carousel-inner');
            const carouselIndicators = galleryModal.querySelector('.carousel-indicators');
            
            // Clear previous
            carouselInner.innerHTML = '';
            carouselIndicators.innerHTML = '';
            
            if (photos.length === 0) {
                carouselInner.innerHTML = '<div class="carousel-item active"><p class="text-muted">No photos available.</p></div>';
                return;
            }
            
            photos.forEach((photo, index) => {
                // Indicator
                const indicator = document.createElement('button');
                indicator.type = 'button';
                indicator.dataset.bsTarget = '#photoGalleryCarousel';
                indicator.dataset.bsSlideTo = index;
                if (index === 0) indicator.classList.add('active');
                carouselIndicators.appendChild(indicator);
                
                // Slide
                const item = document.createElement('div');
                item.classList.add('carousel-item');
                if (index === 0) item.classList.add('active');
                
                const img = document.createElement('img');
                img.src = photo;
                img.style.width = '100%';
                img.style.maxHeight = '70vh';
                img.style.objectFit = 'contain';
                item.appendChild(img);
                carouselInner.appendChild(item);
            });
        });
    }
});