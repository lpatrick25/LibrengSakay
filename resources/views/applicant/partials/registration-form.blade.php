{{-- ========================================================= --}}
{{-- Registration Header --}}
{{-- ========================================================= --}}

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 fade-in">

    <div class="d-flex align-items-center gap-3">

        <button type="button" id="btn-back" class="btn btn-outline-warning rounded-circle">

            <i class="bi bi-arrow-left"></i>

        </button>

        <div>

            <span class="badge bg-warning text-dark rounded-pill px-3 py-2 mb-2">

                Step 2 of 2

            </span>

            <h2 class="fw-bold mb-1">

                Libreng Sakay Application

            </h2>

            <p class="text-muted mb-0">

                Complete the required information below.

            </p>

        </div>

    </div>

    <div>

        <span class="badge bg-success px-3 py-2 rounded-pill">

            <i class="bi bi-check-circle-fill me-2"></i>

            <span id="selected-category-label"></span>

        </span>

    </div>

</div>

<form id="registration-form" enctype="multipart/form-data" novalidate>

    @csrf

    <input type="hidden" name="applicant_type" id="form_applicant_type">

    {{-- ========================================================= --}}
    {{-- Applicant Information --}}
    {{-- ========================================================= --}}

    <div class="card border-0 shadow-lg rounded-4 mb-4">

        <div class="card-header bg-warning-subtle border-0 py-3">

            <h5 class="mb-0">

                <i class="bi bi-person-vcard-fill text-warning me-2"></i>

                Applicant Information

            </h5>

        </div>

        <div class="card-body p-4">

            <div class="row g-4">

                {{-- Last Name --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Last Name
                        <span class="text-danger">*</span>

                    </label>

                    <input type="text" class="form-control form-control-lg" name="last_name" id="last_name">

                    <div class="invalid-feedback" data-error="last_name"></div>

                </div>

                {{-- First Name --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        First Name
                        <span class="text-danger">*</span>

                    </label>

                    <input type="text" class="form-control form-control-lg" name="first_name" id="first_name">

                    <div class="invalid-feedback" data-error="first_name"></div>

                </div>

                {{-- Middle --}}
                <div class="col-md-6">

                    <label class="form-label">

                        Middle Name

                    </label>

                    <input type="text" class="form-control form-control-lg" name="middle_name">

                </div>

                {{-- Suffix --}}
                <div class="col-md-6">

                    <label class="form-label">

                        Suffix

                    </label>

                    <select class="form-select form-select-lg" name="suffix">

                        <option value="">None</option>
                        <option>Jr.</option>
                        <option>Sr.</option>
                        <option>II</option>
                        <option>III</option>
                        <option>IV</option>

                    </select>

                </div>

                {{-- Contact --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Contact Number

                        <span class="text-danger">*</span>

                    </label>

                    <input class="form-control form-control-lg" name="contact_number">

                    <div class="invalid-feedback" data-error="contact_number"></div>

                </div>

                {{-- Email --}}
                <div class="col-md-6">

                    <label class="form-label">

                        Email Address

                        <span class="text-danger">*</span>

                    </label>

                    <input type="email" class="form-control form-control-lg" name="email">

                    <div class="invalid-feedback" data-error="email"></div>

                </div>

            </div>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- Examination Details --}}
    {{-- ========================================================= --}}

    <div class="card border-0 shadow-lg rounded-4 mb-4">

        <div class="card-header bg-warning-subtle border-0 py-3">

            <h5 class="mb-0">

                <i class="bi bi-bus-front-fill text-warning me-2"></i>

                Examination Details

            </h5>

        </div>

        <div class="card-body p-4">

            <label class="form-label fw-semibold">

                Place of Examination

                <span class="text-danger">*</span>

            </label>

            <input class="form-control form-control-lg" id="place_of_examination" name="place_of_examination">

            <div class="invalid-feedback" data-error="place_of_examination"></div>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- Identification --}}
    {{-- ========================================================= --}}

    <div class="card border-0 shadow-lg rounded-4 mb-4">

        <div class="card-header bg-warning-subtle border-0 py-3">

            <h5 class="mb-0">

                <i class="bi bi-person-badge-fill text-warning me-2"></i>

                Identity Verification

            </h5>

        </div>

        <div class="card-body p-4">

            <div id="id-instructions" class="alert alert-warning border-start border-4 border-warning">

            </div>

            <label class="form-label fw-semibold">

                Upload Identification

            </label>

            <input class="form-control form-control-lg" type="file" id="identification" name="identification"
                accept=".jpg,.jpeg,.png,.pdf">

            <div class="form-text">

                Accepted:
                JPG,
                JPEG,
                PNG,
                PDF

                • Maximum

                <span id="max-upload-label">

                    5

                </span>

                MB

            </div>

            <div class="invalid-feedback" data-error="identification"></div>

            <div id="file-preview" class="d-none mt-4 border rounded-4 p-3 bg-light">

                <div class="d-flex gap-3 align-items-center">

                    <div id="preview-thumb"></div>

                    <div class="flex-grow-1">

                        <div id="preview-name" class="fw-semibold"></div>

                        <div id="preview-size" class="small text-muted"></div>

                    </div>

                    <button type="button" id="btn-remove-file" class="btn btn-outline-danger rounded-pill">

                        Remove

                    </button>

                </div>

            </div>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- Privacy --}}
    {{-- ========================================================= --}}

    <div class="card border-0 shadow-lg rounded-4 mb-4">

        <div class="card-header bg-warning-subtle border-0 py-3">

            <h5 class="mb-0">

                <i class="bi bi-shield-lock-fill text-warning me-2"></i>

                Data Privacy Consent

            </h5>

        </div>

        <div class="card-body">

            <div class="form-check">

                <input class="form-check-input" type="checkbox" id="consent" name="consent">

                <label class="form-check-label" for="consent">

                    I have read and understood the

                    <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">

                        Data Privacy Notice

                    </a>

                    and voluntarily consent to the collection,
                    processing and storage of my personal information.

                </label>

                <div class="invalid-feedback d-block" data-error="consent"></div>

            </div>

        </div>

    </div>

    {{-- Submit --}}
    <div class="text-end mb-5">

        <button id="btn-submit" class="btn btn-warning btn-lg rounded-pill px-5 shadow" disabled>

            <span class="btn-text">

                <i class="bi bi-send-check-fill me-2"></i>

                Submit Application

            </span>

            <span class="btn-spinner d-none">

                <span class="spinner-border spinner-border-sm me-2"></span>

                Processing...

            </span>

        </button>

    </div>

</form>

{{-- ========================================================= --}}
{{-- Data Privacy Notice Modal --}}
{{-- ========================================================= --}}
<div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content border-0 rounded-4 shadow-lg">

            {{-- Header --}}
            <div class="modal-header border-0 app-modal-header">
                <h4 class="modal-title fw-bold text-white" id="privacyModalLabel">
                    <i class="bi bi-shield-lock-fill text-white me-2"></i>
                    Data Privacy Notice
                </h4>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>

            </div>

            {{-- Body --}}
            <div class="modal-body px-4 py-4">

                <div class="text-center mb-4">

                    <i class="bi bi-person-lock display-5 text-warning"></i>

                    <h5 class="fw-bold mt-3">

                        Municipality of Abuyog

                    </h5>

                    <p class="text-muted mb-0">

                        Libreng Sakay Online Registration for the
                        Civil Service Commission (CSC)
                        Pen-and-Paper Test

                    </p>

                </div>

                <div class="alert alert-warning border-start border-4 border-warning">

                    <strong>Republic Act No. 10173</strong><br>

                    This registration system complies with the
                    <strong>Data Privacy Act of 2012</strong>.
                    The Municipality of Abuyog values your privacy and is committed
                    to protecting your personal information.

                </div>

                <h6 class="fw-bold mt-4">

                    <i class="bi bi-collection-fill text-warning me-2"></i>

                    Information We Collect

                </h6>

                <ul class="text-muted">

                    <li>Applicant's full name</li>

                    <li>Contact number</li>

                    <li>Email address (if provided)</li>

                    <li>Applicant category</li>

                    <li>Place of examination</li>

                    <li>Uploaded identification document</li>

                </ul>

                <hr>

                <h6 class="fw-bold">

                    <i class="bi bi-bullseye text-warning me-2"></i>

                    Purpose of Collection

                </h6>

                <p class="text-muted">

                    Your personal information is collected solely for the purpose
                    of processing your application for the
                    <strong>LIBRENG SAKAY ni Mayor Lemy</strong>
                    for eligible examinees taking the
                    Civil Service Commission Pen-and-Paper Test.

                </p>

                <ul class="text-muted">

                    <li>Verify your identity</li>

                    <li>Determine your eligibility</li>

                    <li>Validate residency or student status</li>

                    <li>Coordinate transportation arrangements</li>

                    <li>Communicate updates regarding your application</li>

                </ul>

                <hr>

                <h6 class="fw-bold">

                    <i class="bi bi-lock-fill text-warning me-2"></i>

                    Protection of Your Information

                </h6>

                <p class="text-muted">

                    Your information will be treated as confidential and will only
                    be accessed by authorized personnel of the
                    Municipality of Abuyog for legitimate government purposes.
                    Appropriate administrative, organizational, and technical
                    safeguards are implemented to protect your personal data
                    against unauthorized access, disclosure, alteration, or loss.

                </p>

                <hr>

                <h6 class="fw-bold">

                    <i class="bi bi-clock-history text-warning me-2"></i>

                    Data Retention

                </h6>

                <p class="text-muted">

                    Your personal information will be retained only for as long
                    as necessary to fulfill the purposes of the Libreng Sakay
                    Program and to comply with applicable laws, regulations,
                    auditing, and government record-keeping requirements.

                </p>

                <hr>

                <h6 class="fw-bold">

                    <i class="bi bi-person-check-fill text-warning me-2"></i>

                    Your Consent

                </h6>

                <p class="text-muted mb-0">

                    By submitting this application, you acknowledge that you
                    have read and understood this Data Privacy Notice and
                    voluntarily consent to the collection, processing, storage,
                    and use of your personal information in accordance with
                    Republic Act No. 10173 (Data Privacy Act of 2012).

                </p>

            </div>

            {{-- Footer --}}
            <div class="modal-footer bg-light border-0">

                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">

                    Close

                </button>

                <button type="button" class="btn btn-warning rounded-pill px-4" data-bs-dismiss="modal">

                    <i class="bi bi-check-circle-fill me-2"></i>

                    I Understand

                </button>

            </div>

        </div>

    </div>

</div>
