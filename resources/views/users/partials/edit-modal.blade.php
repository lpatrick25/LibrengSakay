<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            {{-- Header --}}
            <div class="modal-header applicant-section border-0 text-white py-4">

                <div class="d-flex align-items-center">
                    <div class="hero-icon me-3">
                        <i class="bi bi-pencil-square fs-3"></i>
                    </div>

                    <div>
                        <h4 class="modal-title fw-bold mb-1" id="editUserModalLabel">
                            Edit User
                        </h4>

                        <small class="opacity-75">
                            Update account information and security settings
                        </small>
                    </div>
                </div>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                </button>

            </div>

            <form id="edit-user-form" novalidate>

                <input type="hidden" id="edit-user-id" name="id">

                <div class="modal-body p-4 p-lg-5">

                    {{-- Skeleton --}}
                    <div id="edit-modal-skeleton" class="d-none">

                        <div class="card border-0 bg-light rounded-4">

                            <div class="card-body">

                                <div class="skeleton skeleton-text mb-4" style="width:35%;height:18px;"></div>

                                <div class="skeleton rounded-3 mb-3" style="height:58px;"></div>

                                <div class="skeleton rounded-3 mb-3" style="height:58px;"></div>

                                <div class="skeleton rounded-3" style="height:120px;"></div>

                            </div>

                        </div>

                    </div>

                    {{-- Content --}}
                    <div id="edit-modal-content">

                        {{-- User Information --}}
                        <div class="card border-0 bg-light rounded-4 mb-4">

                            <div class="card-body">

                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-person-vcard text-warning fs-5 me-2"></i>
                                    <h6 class="fw-bold mb-0">
                                        User Information
                                    </h6>
                                </div>

                                <div class="row g-4">

                                    {{-- Name --}}
                                    <div class="col-12">

                                        <label for="edit-name" class="form-label fw-semibold">

                                            Full Name
                                            <span class="text-danger">*</span>

                                        </label>

                                        <div class="input-group input-group-lg">

                                            <span class="input-group-text bg-white">
                                                <i class="bi bi-person"></i>
                                            </span>

                                            <input type="text" class="form-control" id="edit-name" name="name"
                                                autocomplete="name">

                                        </div>

                                        <div class="invalid-feedback d-block" data-error="name"></div>

                                    </div>

                                    {{-- Email --}}
                                    <div class="col-12">

                                        <label for="edit-email" class="form-label fw-semibold">

                                            Email Address
                                            <span class="text-danger">*</span>

                                        </label>

                                        <div class="input-group input-group-lg">

                                            <span class="input-group-text bg-white">
                                                <i class="bi bi-envelope"></i>
                                            </span>

                                            <input type="email" class="form-control" id="edit-email" name="email"
                                                autocomplete="email">

                                        </div>

                                        <div class="invalid-feedback d-block" data-error="email"></div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- Password Card --}}
                        <div class="card border-0 bg-light rounded-4">

                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center">

                                    <div>

                                        <h6 class="fw-bold mb-1">
                                            <i class="bi bi-shield-lock text-warning me-2"></i>
                                            Password Settings
                                        </h6>

                                        <small class="text-muted">
                                            Leave disabled to keep the current password.
                                        </small>

                                    </div>

                                    <div class="form-check form-switch">

                                        <input class="form-check-input" type="checkbox" id="edit-change-password"
                                            name="change_password" value="1">

                                        <label class="form-check-label fw-semibold" for="edit-change-password">

                                            Change Password

                                        </label>

                                    </div>

                                </div>

                                <hr>

                                <div id="edit-password-fields" class="d-none">

                                    <div class="row g-4">

                                        {{-- Password --}}
                                        <div class="col-md-6">

                                            <label class="form-label fw-semibold">

                                                New Password
                                                <span class="text-danger">*</span>

                                            </label>

                                            <div class="input-group input-group-lg">

                                                <span class="input-group-text bg-white">
                                                    <i class="bi bi-lock"></i>
                                                </span>

                                                <input type="password" class="form-control" id="edit-password"
                                                    name="password" autocomplete="new-password">

                                                <button type="button" class="btn btn-outline-secondary toggle-password"
                                                    data-target="#edit-password">

                                                    <i class="bi bi-eye"></i>

                                                </button>

                                            </div>

                                            <div class="invalid-feedback d-block" data-error="password"></div>

                                        </div>

                                        {{-- Confirmation --}}
                                        <div class="col-md-6">

                                            <label class="form-label fw-semibold">

                                                Confirm Password
                                                <span class="text-danger">*</span>

                                            </label>

                                            <div class="input-group input-group-lg">

                                                <span class="input-group-text bg-white">
                                                    <i class="bi bi-shield-check"></i>
                                                </span>

                                                <input type="password" class="form-control"
                                                    id="edit-password-confirmation" name="password_confirmation"
                                                    autocomplete="new-password">

                                            </div>

                                            <div class="invalid-feedback d-block" data-error="password_confirmation">
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer bg-light border-0 py-3">

                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">

                        <i class="bi bi-x-circle me-2"></i>
                        Cancel

                    </button>

                    <button type="submit" id="btn-edit-submit"
                        class="btn btn-warning rounded-pill px-5 fw-semibold shadow-sm">

                        <span class="btn-text">

                            <i class="bi bi-check-circle-fill me-2"></i>

                            Save Changes

                        </span>

                        <span class="btn-spinner d-none">

                            <span class="spinner-border spinner-border-sm me-2"></span>

                            Saving...

                        </span>

                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
