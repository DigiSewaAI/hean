<!-- Photo Gallery Modal -->
<div class="modal fade" id="photoGalleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.hostel_photos') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('messages.close') }}"></button>
            </div>
            <div class="modal-body" style="text-align:center;">
                <div id="photoGalleryCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators" id="galleryIndicators"></div>
                    <div class="carousel-inner" id="galleryInner"></div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#photoGalleryCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">{{ __('messages.previous') }}</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#photoGalleryCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">{{ __('messages.next') }}</span>
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.close') }}</button>
            </div>
        </div>
    </div>
</div>