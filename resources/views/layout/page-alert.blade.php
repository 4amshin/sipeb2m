<!--Notifikasi Singkat-->
@if (session('success'))
    <div class="bs-toast toast toast-placement-ex m-3 fade bg-success top-0 end-0 show" role="alert"
        aria-live="assertive" aria-atomic="true" data-delay="2000">
        <div class="toast-header">
            <i class="bx bx-bell me-2"></i>
            <div class="me-auto fw-semibold">Notifikasi</div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"> {{ session('success') }}</div>
    </div>
@elseif (session('info'))
    <div class="bs-toast toast toast-placement-ex m-3 fade bg-info top-0 end-0 show" role="alert"
        aria-live="assertive" aria-atomic="true" data-delay="2000">
        <div class="toast-header">
            <i class="bx bx-bell me-2"></i>
            <div class="me-auto fw-semibold">Notifikasi</div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"> {{ session('info') }}</div>
    </div>
@elseif (session('error'))
    <div class="bs-toast toast toast-placement-ex m-3 fade bg-danger top-0 end-0 show" role="alert"
        aria-live="assertive" aria-atomic="true" data-delay="2000">
        <div class="toast-header">
            <i class="bx bx-bell me-2"></i>
            <div class="me-auto fw-semibold">Notifikasi</div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"> {{ session('error') }}</div>
    </div>
@endif
