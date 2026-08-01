{{-- Create User Modal --}}
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            {{-- Honey Header --}}
            <div class="modal-header border-0 applicant-section text-white py-4 app-modal-header">
                <div class="d-flex align-items-center">
                    <div class="hero-icon me-3">
                        <i class="bi bi-person-plus-fill fs-3"></i>
                    </div>

                    <div>
                        <h4 class="modal-title fw-bold mb-1 text-white" id="createUserModalLabel">
                            Create New User
                        </h4>
                        <small class="opacity-75 text-white">
                            Municipality of Abuyog • Human Resource Management Office
                        </small>
                    </div>
                </div>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="create-user-form" novalidate>

                <div class="modal-body p-4 p-lg-5">

                    {{-- Information Card --}}
                    <div class="card border-0 bg-light rounded-4 mb-4">
                        <div class="card-body">

                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-person-vcard text-warning me-2 fs-5"></i>
                                <h6 class="fw-bold mb-0">
                                    Account Information
                                </h6>
                            </div>

                            <div class="row g-4">

                                {{-- Full Name --}}
                                <div class="col-12">
                                    <label for="create-name" class="form-label fw-semibold">
                                        Full Name
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-white">
                                            <i class="bi bi-person"></i>
                                        </span>

                                        <input type="text" class="form-control" id="create-name" name="name"
                                            placeholder="Juan Dela Cruz" autocomplete="name">

                                    </div>

                                    <div class="invalid-feedback d-block" data-error="name"></div>
                                </div>

                                {{-- Email --}}
                                <div class="col-12">
                                    <label for="create-email" class="form-label fw-semibold">
                                        Email Address
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-white">
                                            <i class="bi bi-envelope"></i>
                                        </span>

                                        <input type="email" class="form-control" id="create-email" name="email"
                                            placeholder="name@example.com" autocomplete="email">
                                    </div>

                                    <div class="invalid-feedback d-block" data-error="email"></div>
                                </div>

                                {{-- Password --}}
                                <div class="col-md-6">
                                    <label for="create-password" class="form-label fw-semibold">
                                        Password
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="input-group input-group-lg">

                                        <span class="input-group-text bg-white">
                                            <i class="bi bi-lock"></i>
                                        </span>

                                        <input type="password" class="form-control" id="create-password" name="password"
                                            placeholder="Minimum 8 characters" autocomplete="new-password">

                                        <button type="button" class="btn btn-outline-secondary toggle-password"
                                            data-target="#create-password">

                                            <i class="bi bi-eye"></i>

                                        </button>

                                    </div>

                                    <div class="invalid-feedback d-block" data-error="password"></div>
                                </div>

                                {{-- Confirm Password --}}
                                <div class="col-md-6">

                                    <label for="create-password-confirmation" class="form-label fw-semibold">
                                        Confirm Password
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="input-group input-group-lg">

                                        <span class="input-group-text bg-white">
                                            <i class="bi bi-shield-lock"></i>
                                        </span>

                                        <input type="password" class="form-control" id="create-password-confirmation"
                                            name="password_confirmation" placeholder="Re-enter password"
                                            autocomplete="new-password">

                                    </div>

                                    <div class="invalid-feedback d-block" data-error="password_confirmation"></div>

                                </div>

                            </div>

                        </div>
                    </div>

                    {{-- Reminder --}}
                    <div class="alert alert-warning border-0 rounded-4 mb-0">

                        <div class="d-flex">

                            <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>

                            <div>

                                <div class="fw-bold">
                                    Security Reminder
                                </div>

                                <small>
                                    The newly created user will use this password during
                                    their first login. Encourage them to change it
                                    immediately after signing in.
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer border-0 bg-light py-3">

                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">

                        <i class="bi bi-x-circle me-2"></i>
                        Cancel

                    </button>

                    <button type="submit" id="btn-create-submit"
                        class="btn btn-warning rounded-pill px-5 fw-semibold shadow-sm">

                        <span class="btn-text">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Create User
                        </span>

                        <span class="btn-spinner d-none">

                            <span class="spinner-border spinner-border-sm me-2"></span>

                            Creating...

                        </span>

                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
