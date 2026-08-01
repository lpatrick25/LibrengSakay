{{-- ================= View Applicant Modal ================= --}}
<div class="modal fade" id="viewApplicantModal" tabindex="-1" aria-labelledby="viewApplicantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            {{-- Header --}}
            <div class="modal-header border-0 app-modal-header">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-white text-warning shadow-sm d-flex align-items-center justify-content-center me-3"
                        style="width:58px;height:58px;">
                        <i class="bi bi-person-vcard fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">
                            Applicant Details
                        </h4>
                        <div class="small opacity-75">
                            Municipality of Abuyog • LIBRENG SAKAY ni Mayor Lemy
                        </div>
                    </div>
                </div>
                <button class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body p-4">
                {{-- Skeleton --}}
                <div id="view-modal-skeleton" class="d-none">
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="skeleton rounded-4" style="height:320px"></div>
                        </div>
                        <div class="col-lg-4">
                            <div class="skeleton rounded-4 mb-3" style="height:150px"></div>
                            <div class="skeleton rounded-4" style="height:150px"></div>
                        </div>
                    </div>
                </div>
                {{-- Content --}}
                <div id="view-modal-content" class="d-none">
                    <div class="row g-4">
                        {{-- LEFT COLUMN --}}
                        <div class="col-lg-7">
                            <div class="app-section-card">
                                <h6 class="section-title">
                                    <i class="bi bi-person-fill-check me-2"></i>
                                    Applicant Information
                                </h6>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <small class="text-muted">Full Name</small>
                                        <div class="fw-bold fs-5" id="vm-full-name">—</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">Applicant Category</small>
                                        <div id="vm-category">—</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">Contact Number</small>
                                        <div class="fw-semibold" id="vm-contact">—</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">Email Address</small>
                                        <div class="fw-semibold" id="vm-email">—</div>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">Place of Examination</small>
                                        <div class="fw-semibold" id="vm-place">—</div>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">Date Submitted</small>
                                        <div class="fw-semibold" id="vm-submitted">—</div>
                                    </div>
                                </div>
                            </div>
                            <div class="app-section-card mt-4">
                                <h6 class="section-title">
                                    <i class="bi bi-chat-left-text-fill me-2"></i>
                                    Verification Remarks
                                </h6>
                                <div id="vm-remarks" class="border rounded-4 bg-light p-3">
                                    —
                                </div>
                            </div>
                        </div>
                        {{-- RIGHT COLUMN --}}
                        <div class="col-lg-5">
                            <div class="app-section-card">
                                <h6 class="section-title">
                                    <i class="bi bi-card-image me-2"></i>
                                    Uploaded Identification
                                </h6>
                                <div id="vm-id-preview" class="text-center mb-3">
                                </div>
                                <div class="d-grid gap-2">
                                    <span id="vm-id-status"></span>
                                    <a href="#" id="vm-download-id" target="_blank"
                                        class="btn btn-warning rounded-pill d-none">
                                        <i class="bi bi-download me-2"></i>
                                        Download Identification
                                    </a>
                                </div>
                            </div>
                            <div class="app-section-card mt-4">
                                <h6 class="section-title">
                                    <i class="bi bi-patch-check-fill me-2"></i>
                                    Verification Status
                                </h6>
                                <div class="mb-3">
                                    <small class="text-muted">
                                        Current Status
                                    </small>
                                    <div id="vm-status"></div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">
                                        Verified By
                                    </small>
                                    <div class="fw-semibold" id="vm-verified-by">
                                        —
                                    </div>
                                </div>
                                <div>
                                    <small class="text-muted">
                                        Verified At
                                    </small>
                                    <div class="fw-semibold" id="vm-verified-at">
                                        —
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    Close
                </button>
                <button id="vm-btn-reject" class="btn btn-outline-danger rounded-pill px-4">
                    <i class="bi bi-x-circle me-2"></i>
                    Reject
                </button>
                <button id="vm-btn-verify" class="btn btn-warning rounded-pill px-4">
                    <i class="bi bi-patch-check-fill me-2"></i>
                    Verify Applicant
                </button>
            </div>
        </div>
    </div>
</div>
