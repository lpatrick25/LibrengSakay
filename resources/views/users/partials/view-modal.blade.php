<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            {{-- Header --}}
            <div class="modal-header applicant-section text-white border-0 py-4 app-modal-header">

                <div class="d-flex align-items-center">

                    <div class="hero-icon me-3">
                        <i class="bi bi-person-vcard-fill fs-3"></i>
                    </div>

                    <div>

                        <h4 class="modal-title fw-bold mb-1 text-white" id="viewUserModalLabel">

                            User Details

                        </h4>

                        <small class="opacity-75 text-white">
                            Human Resource Management Office
                        </small>

                    </div>

                </div>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body p-4 p-lg-5">

                {{-- Skeleton --}}
                <div id="view-user-skeleton" class="d-none">

                    <div class="card border-0 bg-light rounded-4">

                        <div class="card-body">

                            <div class="skeleton skeleton-circle mb-4" style="width:72px;height:72px;"></div>

                            <div class="skeleton skeleton-text mb-3" style="width:45%;height:22px;"></div>

                            <div class="skeleton rounded-3 mb-3" style="height:60px;"></div>

                            <div class="skeleton rounded-3 mb-3" style="height:60px;"></div>

                            <div class="skeleton rounded-3" style="height:130px;"></div>

                        </div>

                    </div>

                </div>

                {{-- Content --}}
                <div id="view-user-content" class="d-none">

                    {{-- Profile --}}
                    <div class="text-center mb-4">

                        <div class="hero-icon mx-auto mb-3">

                            <i class="bi bi-person-fill fs-2"></i>

                        </div>

                        <h3 class="fw-bold mb-1" id="vu-name">

                            —

                        </h3>

                        <span id="vu-email-status">
                            —
                        </span>

                    </div>

                    {{-- Account Information --}}
                    <div class="card border-0 bg-light rounded-4 mb-4">

                        <div class="card-body">

                            <div class="d-flex align-items-center mb-3">

                                <i class="bi bi-person-vcard text-warning me-2 fs-5"></i>

                                <h6 class="fw-bold mb-0">

                                    Account Information

                                </h6>

                            </div>

                            <div class="row g-4">

                                <div class="col-md-6">

                                    <small class="text-muted text-uppercase d-block mb-1">
                                        User ID
                                    </small>

                                    <div class="fw-semibold fs-5" id="vu-id">
                                        —
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <small class="text-muted text-uppercase d-block mb-1">
                                        Email Address
                                    </small>

                                    <div class="fw-semibold" id="vu-email">
                                        —
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Activity --}}
                    <div class="card border-0 bg-light rounded-4">

                        <div class="card-body">

                            <div class="d-flex align-items-center mb-3">

                                <i class="bi bi-clock-history text-warning me-2 fs-5"></i>

                                <h6 class="fw-bold mb-0">

                                    Activity Information

                                </h6>

                            </div>

                            <div class="row g-4">

                                <div class="col-md-6">

                                    <div class="border rounded-4 p-3 bg-white h-100">

                                        <small class="text-muted text-uppercase">
                                            Created At
                                        </small>

                                        <div class="fw-semibold mt-2" id="vu-created">
                                            —
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="border rounded-4 p-3 bg-white h-100">

                                        <small class="text-muted text-uppercase">
                                            Last Updated
                                        </small>

                                        <div class="fw-semibold mt-2" id="vu-updated">
                                            —
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="modal-footer bg-light border-0 py-3">

                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">

                    <i class="bi bi-x-circle me-2"></i>

                    Close

                </button>

                <button type="button" id="vu-btn-edit" class="btn btn-warning rounded-pill px-5 fw-semibold shadow-sm">

                    <i class="bi bi-pencil-square me-2"></i>

                    Edit User

                </button>

            </div>

        </div>

    </div>

</div>
