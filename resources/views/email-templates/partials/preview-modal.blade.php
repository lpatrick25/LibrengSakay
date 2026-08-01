{{-- Preview Email Template Modal --}}
<div class="modal fade" id="previewTemplateModal" tabindex="-1" aria-labelledby="previewTemplateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow rounded-4">
            {{-- Header --}}
            <div class="modal-header border-0 pb-0 app-modal-header">
                <div>
                    <h5 class="modal-title fw-bold text-white" id="previewTemplateModalLabel">
                        <i class="bi bi-envelope-open text-primary me-2"></i>
                        Email Preview
                    </h5>
                    <p class="text-muted small mb-0">
                        Preview how this email will appear to recipients.
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                {{-- Loading --}}
                <div id="preview-skeleton" class="d-none">
                    <div class="card border rounded-4">
                        <div class="card-body">
                            <div class="skeleton skeleton-text mb-3" style="width:45%;height:18px;"></div>
                            <div class="skeleton skeleton-text mb-2" style="width:70%;height:14px;"></div>
                            <div class="skeleton skeleton-text mb-4" style="width:30%;height:14px;"></div>
                            <div class="skeleton rounded-3" style="height:420px;"></div>
                        </div>
                    </div>
                </div>
                {{-- Preview --}}
                <div id="preview-content" class="d-none">
                    {{-- Email Information --}}
                    <div class="card border-0 bg-light rounded-4 mb-4">
                        <div class="card-body py-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <small class="text-muted d-block">
                                        Subject
                                    </small>
                                    <div class="fw-semibold" id="preview-subject">
                                        —
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">
                                        Preview Recipient
                                    </small>
                                    <div class="fw-semibold">
                                        Juan Dela Cruz
                                        &lt;juan@example.com&gt;
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Email Canvas --}}
                    <div class="card border shadow-sm rounded-4 overflow-hidden">
                        {{-- Simulated Mail Header --}}
                        <div class="border-bottom bg-light px-4 py-3">
                            <div class="fw-semibold">
                                {{ config('app.name', 'Libreng Sakay Online Registration') }}
                            </div>
                            <small class="text-muted">
                                no-reply@example.com
                            </small>
                        </div>
                        {{-- Email Body --}}
                        <div id="preview-body" class="bg-white p-4"
                            style="min-height:450px; line-height:1.7; font-size:.95rem;">
                        </div>
                        {{-- Footer --}}
                        <div class="border-top bg-light text-center small text-muted py-3">
                            This preview uses sample applicant information.
                            Actual emails will display real applicant data.
                        </div>
                    </div>
                </div>
            </div>
            {{-- Footer --}}
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
