{{-- ================= Reject Applicant Modal ================= --}}
<div class="modal fade" id="rejectApplicantModal" tabindex="-1" aria-labelledby="rejectApplicantModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">

            {{-- Header --}}
            <div class="modal-header reject-modal-header border-0">

                <div class="d-flex align-items-center">

                    <div class="reject-icon me-3">

                        <i class="bi bi-x-octagon-fill fs-2"></i>

                    </div>

                    <div>

                        <h4 class="fw-bold mb-1">
                            Reject Applicant
                        </h4>

                        <small class="opacity-75">
                            Municipality of Abuyog • LIBRENG SAKAY ni Mayor Lemy
                        </small>

                    </div>

                </div>

                <button class="btn-close btn-close-white" data-bs-dismiss="modal">
                </button>

            </div>

            <form id="reject-form">

                <div class="modal-body p-4">

                    {{-- Applicant Card --}}
                    <div class="card border-0 bg-danger-subtle rounded-4 mb-4">

                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center me-3"
                                    style="width:60px;height:60px;">

                                    <i class="bi bi-person-fill fs-3"></i>

                                </div>

                                <div>

                                    <small class="text-muted text-uppercase">
                                        Applicant
                                    </small>

                                    <h5 id="reject-applicant-name" class="fw-bold mb-1">
                                        —
                                    </h5>

                                    <div class="text-danger small">

                                        This action will mark the application as
                                        <strong>Rejected</strong>.

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Notice --}}
                    <div class="alert alert-warning rounded-4 border-0">

                        <div class="d-flex">

                            <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>

                            <div>

                                <strong>
                                    Review carefully before proceeding.
                                </strong>

                                <div class="small mt-1">

                                    Please provide a clear reason for rejection.
                                    This information may be used for future
                                    reference by the reviewing office.

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Remarks --}}
                    <div class="mt-4">

                        <label class="form-label fw-semibold">

                            Reason for Rejection
                            <span class="text-danger">*</span>

                        </label>

                        <textarea id="reject-remarks" name="remarks" rows="6" maxlength="1000" required class="form-control rounded-4"
                            placeholder="State the reason why this application is being rejected..."></textarea>

                        <div class="d-flex justify-content-between mt-2">

                            <div class="invalid-feedback d-block">
                                Remarks are required.
                            </div>

                            <small class="text-muted">

                                <span id="reject-counter">0</span>/1000

                            </small>

                        </div>

                    </div>

                    <input type="hidden" id="reject-applicant-id">

                </div>

                <div class="modal-footer border-0 bg-light">

                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit" id="btn-confirm-reject" class="btn btn-danger rounded-pill px-4">

                        <span class="btn-text">

                            <i class="bi bi-x-octagon-fill me-2"></i>

                            Reject Application

                        </span>

                        <span class="btn-spinner d-none">

                            <span class="spinner-border spinner-border-sm me-2"></span>

                            Processing...

                        </span>

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
