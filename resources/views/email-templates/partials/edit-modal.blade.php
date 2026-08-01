{{-- Edit Email Template Modal --}}
<div class="modal fade" id="editTemplateModal" tabindex="-1" aria-labelledby="editTemplateModalLabel" aria-hidden="true"
    data-bs-backdrop="static">

    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" style="max-height: 92vh;">
        <div class="modal-content border-0 shadow rounded-4 d-flex flex-column" style="max-height: 92vh;">

            {{-- Header --}}
            <div class="modal-header border-0 pb-0 flex-shrink-0 app-modal-header">
                <div>
                    <h5 class="modal-title fw-bold text-white" id="editTemplateModalLabel">
                        <i class="bi bi-pencil-square text-primary me-2"></i>
                        Edit Email Template
                    </h5>
                    <p class="text-muted small mb-0">
                        Customize the email subject and message sent to applicants.
                    </p>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="edit-template-form" novalidate class="d-flex flex-column flex-grow-1 overflow-hidden">

                {{-- Body (this is the only scrollable part) --}}
                <div class="modal-body overflow-auto flex-grow-1">

                    {{-- Loading Skeleton --}}
                    <div id="edit-template-skeleton" class="d-none py-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div>
                                        <div class="skeleton skeleton-text mb-2" style="width:180px;height:22px;"></div>
                                        <div class="skeleton skeleton-text" style="width:120px;height:14px;"></div>
                                    </div>
                                    <div class="skeleton rounded-pill" style="width:70px;height:32px;"></div>
                                </div>
                                <div class="skeleton skeleton-text mb-2" style="width:90px;height:14px;"></div>
                                <div class="skeleton skeleton-text mb-4" style="width:100%;height:42px;"></div>
                                <div class="skeleton rounded-3" style="height:340px;"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div id="edit-template-content" class="d-none">
                        <div class="row g-4">

                            {{-- Editor --}}
                            <div class="col-lg-8">
                                <div class="card border shadow-sm rounded-4 h-100">
                                    <div class="card-body">

                                        {{-- Template Information --}}
                                        <div
                                            class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                                            <div>
                                                <div class="small text-muted text-uppercase mb-1">Template</div>
                                                <h5 class="fw-bold mb-1" id="edit-name">—</h5>
                                                <code id="edit-slug">—</code>
                                            </div>

                                            <div class="form-check form-switch mt-1">
                                                <input class="form-check-input" type="checkbox" id="edit-is-active"
                                                    name="is_active" value="1">
                                                <label class="form-check-label fw-medium" for="edit-is-active">
                                                    Active
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Subject --}}
                                        <div class="mb-4">
                                            <label for="edit-subject" class="form-label fw-semibold">
                                                <i class="bi bi-envelope me-1 text-primary"></i>
                                                Email Subject
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" class="form-control form-control-lg rounded-3"
                                                id="edit-subject" name="subject" maxlength="255"
                                                placeholder="Enter email subject">

                                            <div class="d-flex justify-content-between mt-1">
                                                <div class="invalid-feedback d-block" data-error="subject"></div>
                                                <small class="text-muted">
                                                    <span id="subject-count">0</span>/255
                                                </small>
                                            </div>
                                        </div>

                                        {{-- Body --}}
                                        <div>
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-file-earmark-text me-1 text-primary"></i>
                                                Email Body
                                                <span class="text-danger">*</span>
                                            </label>

                                            <textarea id="edit-body" name="body" class="d-none"></textarea>

                                            {{-- Constrain editor height so the modal never overflows --}}
                                            <div id="editor-container" class="border rounded-3 overflow-hidden"
                                                style="min-height: 280px; max-height: 420px;">
                                            </div>

                                            <div class="invalid-feedback d-block" data-error="body"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- Sidebar --}}
                            <div class="col-lg-4">
                                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top:1rem;">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2">
                                            <i class="bi bi-braces text-primary me-2"></i>
                                            Available Variables
                                        </h6>

                                        <p class="small text-muted mb-3">
                                            Use these placeholders in the subject or body.
                                            Click the copy button to insert them into your clipboard.
                                        </p>

                                        <div id="placeholders-list" class="d-flex flex-column gap-2">
                                            {{-- Filled by JavaScript --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- Footer (always visible) --}}
                <div class="modal-footer border-0 pt-0 flex-shrink-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <div class="ms-auto d-flex flex-wrap gap-2">
                        <button type="button" id="btn-preview-from-edit"
                            class="btn btn-outline-primary rounded-pill px-3">
                            <i class="bi bi-eye me-1"></i>
                            Preview
                        </button>

                        <button type="button" id="btn-test-from-edit"
                            class="btn btn-outline-info rounded-pill px-3">
                            <i class="bi bi-send me-1"></i>
                            Send Test
                        </button>

                        <button type="submit" id="btn-save-template" class="btn btn-primary rounded-pill px-4">
                            <span class="btn-text">
                                <i class="bi bi-check-lg me-1"></i>
                                Save Changes
                            </span>
                            <span class="btn-spinner d-none">
                                <span class="spinner-border spinner-border-sm me-1"></span>
                                Saving...
                            </span>
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
