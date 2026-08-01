<div class="modal fade" id="testEmailModal" tabindex="-1" aria-labelledby="testEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0 app-modal-header">
                <h5 class="modal-title fw-bold text-white" id="testEmailModalLabel">
                    <i class="bi bi-send text-primary me-2"></i> Send Test Email
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="test-email-form">
                <div class="modal-body">
                    <p class="small text-muted mb-3">
                        The template will be rendered with sample applicant data and sent to the address below.
                    </p>
                    <div class="mb-0">
                        <label for="test-email" class="form-label fw-medium">
                            Recipient Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" class="form-control rounded-3" id="test-email" name="email"
                            placeholder="you@example.com" required>
                        <div class="invalid-feedback" data-error="email"></div>
                    </div>
                    <input type="hidden" id="test-template-id" value="">
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="btn-send-test" class="btn btn-primary rounded-pill px-4">
                        <span class="btn-text"><i class="bi bi-send me-1"></i> Send Test</span>
                        <span class="btn-spinner d-none">
                            <span class="spinner-border spinner-border-sm me-1"></span> Sending…
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
