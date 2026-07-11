// ============================================================
// DOCUMENT MANAGER - Registration Show Page
// ============================================================

document.addEventListener('DOMContentLoaded', function() {

    // Fix for aria-hidden error on all modals
    function setupModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        
        // Remove aria-hidden when modal is shown
        modal.addEventListener('shown.bs.modal', function() {
            this.removeAttribute('aria-hidden');
        });
    }
    
    // Apply fix to both modals
    setupModal('docPreviewModal');
    setupModal('photoGalleryModal');

    // ============================================================
    // 1. DOCUMENT PREVIEW (Direct click handler)
    // ============================================================
    const viewButtons = document.querySelectorAll('button[data-bs-target="#docPreviewModal"]');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const fileUrl = this.getAttribute('data-file-url');
            const fileType = this.getAttribute('data-file-type');
            const fileName = this.getAttribute('data-file-name');
            
            const modal = document.getElementById('docPreviewModal');
            if (!modal) return;
            
            const modalTitle = modal.querySelector('.modal-title');
            const modalBody = modal.querySelector('.modal-body');
            
            if (modalTitle) modalTitle.textContent = fileName || 'Document Preview';
            modalBody.innerHTML = '';
            
            if (fileType === 'image') {
                const img = document.createElement('img');
                img.src = fileUrl;
                img.style.maxWidth = '100%';
                img.style.maxHeight = '70vh';
                img.style.borderRadius = '4px';
                img.style.display = 'block';
                img.style.margin = '0 auto';
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
            
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                const modalInstance = bootstrap.Modal.getInstance(modal) || new bootstrap.Modal(modal);
                modalInstance.show();
            }
        });
    });

    // ============================================================
    // 2. PHOTO GALLERY (Direct click handler + Carousel init)
    // ============================================================
    const galleryButtons = document.querySelectorAll('button[data-bs-target="#photoGalleryModal"]');
    
    galleryButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const photosAttr = this.getAttribute('data-photos');
            let photos = [];
            try {
                photos = JSON.parse(photosAttr) || [];
            } catch (e) {
                photos = [];
            }
            
            const modal = document.getElementById('photoGalleryModal');
            if (!modal) return;
            
            const carouselInner = document.getElementById('galleryInner');
            const carouselIndicators = document.getElementById('galleryIndicators');
            const carouselElement = document.getElementById('photoGalleryCarousel');
            
            // Clear previous
            carouselInner.innerHTML = '';
            carouselIndicators.innerHTML = '';
            
            if (!photos || photos.length === 0) {
                carouselInner.innerHTML = `
                    <div class="carousel-item active">
                        <div style="display:flex; align-items:center; justify-content:center; min-height:300px; color:#94a3b8; flex-direction:column; gap:12px;">
                            <i class="fas fa-images" style="font-size:3rem; color:#cbd5e1;"></i>
                            <p>{{ __('messages.no_photos_available') }}</p>
                        </div>
                    </div>
                `;
            } else {
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
                    img.style.borderRadius = '4px';
                    img.style.display = 'block';
                    img.style.margin = '0 auto';
                    item.appendChild(img);
                    carouselInner.appendChild(item);
                });
            }
            
            // 🔥 Carousel re-initialize
            let carouselInstance = bootstrap.Carousel.getInstance(carouselElement);
            if (carouselInstance) {
                carouselInstance.dispose();
            }
            new bootstrap.Carousel(carouselElement, {
                interval: false,
                ride: false
            });
            
            // Modal show
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                const modalInstance = bootstrap.Modal.getInstance(modal) || new bootstrap.Modal(modal);
                modalInstance.show();
            }
        });
    });
});