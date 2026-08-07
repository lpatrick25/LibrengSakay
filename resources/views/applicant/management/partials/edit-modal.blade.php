{{-- Edit Applicant Details Modal --}}
<div class="modal fade" id="editApplicantModal" tabindex="-1" aria-labelledby="editApplicantModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow rounded-4">

            {{-- Header --}}
            <div class="modal-header border-0 pb-0 app-modal-header">
                <h5 class="modal-title fw-bold" id="editApplicantModalLabel">
                    <i class="bi bi-pencil-square text-primary me-2"></i>
                    Edit Applicant Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Form now only wraps body + footer so scrollable works correctly --}}
            <form id="edit-applicant-form" enctype="multipart/form-data" novalidate>
                <div class="modal-body pt-2">
                    {{-- Skeleton --}}
                    <div id="edit-applicant-skeleton" class="d-none">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="skeleton skeleton-text mb-2" style="width:40%;height:12px;"></div>
                                <div class="skeleton skeleton-text mb-3" style="width:100%;height:38px;"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="skeleton skeleton-text mb-2" style="width:40%;height:12px;"></div>
                                <div class="skeleton skeleton-text mb-3" style="width:100%;height:38px;"></div>
                            </div>
                            <div class="col-12">
                                <div class="skeleton skeleton-text mb-2" style="width:30%;height:12px;"></div>
                                <div class="skeleton skeleton-text" style="width:100%;height:38px;"></div>
                            </div>
                        </div>
                    </div>

                    <div id="edit-applicant-content" class="d-none">
                        <input type="hidden" id="edit-applicant-id" name="id" value="">

                        <div class="row g-3">
                            {{-- Category --}}
                            <div class="col-12">
                                <label for="edit-applicant-type" class="form-label fw-medium">
                                    Applicant Category <span class="text-danger">*</span>
                                </label>
                                <select class="form-select rounded-3" id="edit-applicant-type" name="applicant_type">
                                    <option value="abuyognon">Abuyognon</option>
                                    <option value="acc_student">Non-Abuyognon (ACC Student)</option>
                                    <option value="non_abuyognon">Non-Abuyognon</option>
                                </select>
                                <div class="invalid-feedback" data-error="applicant_type"></div>
                            </div>

                            {{-- Last Name --}}
                            <div class="col-md-6">
                                <label for="edit-last-name" class="form-label fw-medium">
                                    Last Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control rounded-3" id="edit-last-name"
                                    name="last_name" autocomplete="family-name">
                                <div class="invalid-feedback" data-error="last_name"></div>
                            </div>

                            {{-- First Name --}}
                            <div class="col-md-6">
                                <label for="edit-first-name" class="form-label fw-medium">
                                    First Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control rounded-3" id="edit-first-name"
                                    name="first_name" autocomplete="given-name">
                                <div class="invalid-feedback" data-error="first_name"></div>
                            </div>

                            {{-- Middle Name --}}
                            <div class="col-md-6">
                                <label for="edit-middle-name" class="form-label fw-medium">Middle Name</label>
                                <input type="text" class="form-control rounded-3" id="edit-middle-name"
                                    name="middle_name" autocomplete="additional-name">
                                <div class="invalid-feedback" data-error="middle_name"></div>
                            </div>

                            {{-- Suffix --}}
                            <div class="col-md-6">
                                <label for="edit-suffix" class="form-label fw-medium">Suffix</label>
                                <select class="form-select rounded-3" id="edit-suffix" name="suffix">
                                    <option value="">— None —</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="V">V</option>
                                </select>
                                <div class="invalid-feedback" data-error="suffix"></div>
                            </div>

                            {{-- Birthdate --}}
                            <div class="col-md-6">
                                <label for="edit-birthdate" class="form-label fw-medium">
                                    Birthdate <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control rounded-3" id="edit-birthdate"
                                    name="date_of_birth">
                                <div class="invalid-feedback" data-error="date_of_birth"></div>
                            </div>

                            {{-- Place of Examination --}}
                            <div class="col-12">
                                <label for="edit-place" class="form-label fw-medium">
                                    Place of Examination <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control rounded-3" id="edit-place"
                                    name="place_of_examination">
                                <div class="invalid-feedback" data-error="place_of_examination"></div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label for="edit-email" class="form-label fw-medium">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control rounded-3" id="edit-email" name="email"
                                    autocomplete="email">
                                <div class="invalid-feedback" data-error="email"></div>
                            </div>

                            {{-- Contact --}}
                            <div class="col-md-6">
                                <label for="edit-contact" class="form-label fw-medium">
                                    Contact Number <span class="text-danger">*</span>
                                </label>
                                <input type="tel" class="form-control rounded-3" id="edit-contact"
                                    name="contact_number" autocomplete="tel">
                                <div class="invalid-feedback" data-error="contact_number"></div>
                            </div>

                            {{-- ID Status --}}
                            <div class="col-md-6">
                                <label for="edit-id-status" class="form-label fw-medium">ID Status</label>
                                <select class="form-select rounded-3" id="edit-id-status" name="id_status">
                                    <option value="uploaded">Uploaded</option>
                                    <option value="missing">Missing</option>
                                    <option value="needs_review">Needs Review</option>
                                </select>
                                <div class="invalid-feedback" data-error="id_status"></div>
                            </div>

                            {{-- Replace ID --}}
                            <div class="col-md-6">
                                <label for="edit-identification" class="form-label fw-medium">
                                    Replace Identification
                                    <span class="text-muted fw-normal">(Optional)</span>
                                </label>
                                <input type="file" class="form-control rounded-3" id="edit-identification"
                                    name="identification"
                                    accept=".jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf">
                                <div class="form-text">JPG, JPEG, PNG, or PDF. Leave empty to keep current file.</div>
                                <div class="invalid-feedback" data-error="identification"></div>
                            </div>

                            {{-- Remarks --}}
                            <div class="col-12">
                                <label for="edit-remarks" class="form-label fw-medium">Remarks</label>
                                <textarea class="form-control rounded-3" id="edit-remarks" name="remarks" rows="3"
                                    placeholder="Optional notes…" maxlength="1000"></textarea>
                                <div class="invalid-feedback" data-error="remarks"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="btn-save-applicant" class="btn btn-primary rounded-pill px-4">
                        <span class="btn-text"><i class="bi bi-check-lg me-1"></i> Save Changes</span>
                        <span class="btn-spinner d-none">
                            <span class="spinner-border spinner-border-sm me-1"></span> Saving…
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
