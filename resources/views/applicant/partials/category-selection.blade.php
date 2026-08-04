{{-- ========================================================= --}}
{{-- Welcome Card --}}
{{-- ========================================================= --}}
<div class="card border-0 rounded-4 shadow-lg fade-in overflow-hidden">
    <div class="card-body p-4 p-lg-5 text-center">
        <div class="category-icon mx-auto mb-4">
            <i class="bi bi-bus-front-fill"></i>
        </div>
        <span class="badge rounded-pill bg-warning text-dark px-3 py-2 mb-3">
            Municipality of Abuyog • CSC Pen-and-Paper Test
        </span>
        <h1 class="display-6 fw-bold mb-3">
            Libreng Sakay Online Registration
        </h1>
        <p class="lead text-muted mb-3">
            Welcome to the official registration portal for applicants
            who wish to avail of the
            <strong>Libreng Sakay Online Registration</strong>
            of the Municipality of Abuyog.
        </p>
        <div class="alert alert-warning border-0 mb-0">
            <i class="bi bi-info-circle-fill me-2"></i>
            Please select the category that best describes you.
            Your selection determines the identification requirements
            for your application.
        </div>
    </div>
</div>

{{-- ========================================================= --}}
{{-- STEP INDICATOR --}}
{{-- ========================================================= --}}
<div class="text-center my-4">
    <span class="badge rounded-pill bg-dark px-4 py-2">
        Step 1 of 2
    </span>
</div>

<div class="position-relative">

    @unless (config('app.registration_open'))
        <div class="registration-overlay">
            <div class="registration-overlay-card">
                <div class="registration-overlay-icon">
                    <i class="bi bi-lock-fill"></i>
                </div>

                <h3 class="fw-bold mb-3">
                    Registration is Currently Closed
                </h3>

                <p class="text-muted mb-4">
                    Online registration for the
                    <strong>Libreng Sakay Program</strong>
                    is currently closed.

                    <br><br>

                    <strong>Registration will officially reopen tomorrow.</strong>
                    We invite you to visit this portal again to submit your application.


                </p>

                <div class="alert alert-warning border-0 mb-0">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Thank you for your patience and understanding.
                </div>
            </div>
        </div>
    @endunless

    {{-- ========================================================= --}}
    {{-- CATEGORY --}}
    {{-- ========================================================= --}}
    <div class="row g-4 mb-5 {{ config('app.registration_open') ? '' : 'opacity-50' }}" id="category-cards">

        {{-- Abuyognon --}}
        <div class="col-lg-6">
            <div class="card category-card h-100" data-value="abuyognon" tabindex="0">
                <div class="bg-warning bg-opacity-10 py-4 text-center">
                    <div class="category-icon">
                        <i class="bi bi-house-heart-fill"></i>
                    </div>
                </div>
                <div class="card-body text-center p-4">
                    <h4 class="fw-bold">
                        Abuyognon
                    </h4>
                    <p class="text-muted">
                        Residents of the Municipality of Abuyog who are
                        applying for the Libreng Sakay Online Registration.
                    </p>
                    <small class="text-muted">
                        Click to select
                    </small>
                    <div class="selected-indicator d-none mt-3">
                        <span class="badge bg-success rounded-pill px-3 py-2">
                            <i class="bi bi-check-circle-fill me-1"></i>
                            Selected
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ACC Student --}}
        <div class="col-lg-6">
            <div class="card category-card h-100" data-value="acc_student" tabindex="0">
                <div class="bg-warning bg-opacity-10 py-4 text-center">
                    <div class="category-icon">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                </div>
                <div class="card-body text-center p-4">
                    <h4 class="fw-bold">
                        ACC Student
                    </h4>
                    <p class="text-muted">
                        Non-residents currently enrolled at
                        Abuyog Community College.
                    </p>
                    <small class="text-muted">
                        Click to select
                    </small>
                    <div class="selected-indicator d-none mt-3">
                        <span class="badge bg-success rounded-pill px-3 py-2">
                            <i class="bi bi-check-circle-fill me-1"></i>
                            Selected
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<input type="hidden" id="applicant_type" name="applicant_type">

{{-- ========================================================= --}}
{{-- CONTINUE --}}
{{-- ========================================================= --}}
<div class="text-center">
    <button id="btn-continue" class="btn btn-primary btn-lg rounded-pill px-5 shadow" @disabled(!config('app.registration_open'))>
        Continue Registration
        <i class="bi bi-arrow-right-circle-fill ms-2"></i>
    </button>
    <p class="small text-muted mt-3 mb-0">
        Your selected category determines the required identification
        document in the next step.
    </p>
</div>
