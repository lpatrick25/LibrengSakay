/**
 * Applicant Registration – Frontend Logic
 * Handles category selection, dynamic ID instructions, file preview,
 * AJAX form submission, validation display, and skeleton loading.
 */
(function ($) {
    'use strict';

    // ------------------------------------------------------------------
    // Configuration
    // ------------------------------------------------------------------
    const CONFIG = {
        maxUploadKb: 5120, // default 5 MB – can be overridden via data attribute
        storeUrl: '/applicant/register',
        idInstructions: {
            abuyognon: `
                <strong>Please upload a valid government-issued ID showing your residential address within the Municipality of Abuyog.</strong>
                <br><br>
                Accepted IDs include:
                <ul class="mb-2 ps-3">
                    <li>Philippine National ID</li>
                    <li>Driver's License</li>
                    <li>Voter's ID</li>
                    <li>UMID</li>
                    <li>Passport</li>
                    <li>Other Government-issued IDs showing an Abuyog address</li>
                </ul>
                The uploaded ID must clearly show an address in Abuyog.
            `,
            acc_student: `
                <strong>Please upload your valid Abuyog Community College (ACC) School ID.</strong>
                <br><br>
                The School ID must:
                <ul class="mb-0 ps-3">
                    <li>Show the applicant's name</li>
                    <li>Clearly indicate Abuyog Community College</li>
                    <li>Be readable</li>
                    <li>Be valid/current or otherwise verifiable</li>
                </ul>
            `,
            non_abuyognon: `
                <strong>Please upload any valid government-issued ID for identity verification.</strong>
                <br><br>
                Accepted IDs include:
                <ul class="mb-0 ps-3">
                    <li>National ID</li>
                    <li>Driver's License</li>
                    <li>Passport</li>
                    <li>Voter's ID</li>
                    <li>UMID</li>
                    <li>PRC ID</li>
                    <li>Other Government-issued IDs</li>
                </ul>
            `
        },
        categoryLabels: {
            abuyognon: 'Abuyognon',
            acc_student: 'Non-Abuyognon (ACC Student)',
            non_abuyognon: 'Non-Abuyognon'
        }
    };

    // ------------------------------------------------------------------
    // State
    // ------------------------------------------------------------------
    let selectedType = null;
    let selectedFile = null;

    // ------------------------------------------------------------------
    // Initialization
    // ------------------------------------------------------------------
    $(function () {
        // Simulate initial page load skeleton (short delay for polish)
        setTimeout(showCategoryStep, 600);

        bindCategoryCards();
        bindContinueButton();
        bindBackButton();
        bindFileInput();
        bindConsentCheckbox();
        bindFormSubmit();

        // CSRF setup for all AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    // ------------------------------------------------------------------
    // Step Transitions
    // ------------------------------------------------------------------
    function showCategoryStep() {
        $('#page-skeleton').addClass('fade-out');
        setTimeout(function () {
            $('#page-skeleton').addClass('d-none').removeClass('fade-out');
            $('#step-category').removeClass('d-none').addClass('fade-in');
        }, 300);
    }

    function showFormStep() {
        $('#step-category').addClass('fade-out');
        setTimeout(function () {
            $('#step-category').addClass('d-none').removeClass('fade-out');
            $('#step-form').removeClass('d-none').addClass('fade-in');

            // Populate form with selected type
            $('#form_applicant_type').val(selectedType);
            $('#selected-category-label').text(CONFIG.categoryLabels[selectedType] || selectedType);
            $('#id-instructions').html(CONFIG.idInstructions[selectedType] || '');
            updateMaxUploadLabel();

            // Reset consent & submit state
            $('#consent').prop('checked', false);
            updateSubmitButtonState();

            // Scroll to top of form
            $('html, body').animate({ scrollTop: 0 }, 300);
        }, 300);
    }

    function goBackToCategories() {
        $('#step-form').addClass('fade-out');
        setTimeout(function () {
            $('#step-form').addClass('d-none').removeClass('fade-out');
            $('#step-category').removeClass('d-none').addClass('fade-in');
            clearValidationErrors();
        }, 300);
    }

    // ------------------------------------------------------------------
    // Category Selection
    // ------------------------------------------------------------------
    function bindCategoryCards() {
        const $cards = $('.category-card');

        $cards.on('click keypress', function (e) {
            if (e.type === 'keypress' && e.which !== 13 && e.which !== 32) {
                return;
            }
            e.preventDefault();

            const value = $(this).data('value');
            selectCategory(value);
        });
    }

    function selectCategory(value) {
        selectedType = value;
        $('#applicant_type').val(value);

        $('.category-card').each(function () {
            const $card = $(this);
            const isSelected = $card.data('value') === value;

            $card.toggleClass('selected', isSelected);
            $card.attr('aria-pressed', isSelected ? 'true' : 'false');
            $card.find('.selected-indicator').toggleClass('d-none', !isSelected);
        });

        $('#btn-continue').prop('disabled', false);
    }

    function bindContinueButton() {
        $('#btn-continue').on('click', function () {
            if (!selectedType) {
                return;
            }
            showFormStep();
        });
    }

    function bindBackButton() {
        $('#btn-back').on('click', function () {
            goBackToCategories();
        });
    }

    // ------------------------------------------------------------------
    // File Upload & Preview
    // ------------------------------------------------------------------
    function bindFileInput() {
        $('#identification').on('change', function () {
            const file = this.files[0];
            clearFieldError('identification');

            if (!file) {
                hideFilePreview();
                return;
            }

            // Client-side validation
            const allowed = ['image/jpeg', 'image/png', 'application/pdf'];
            const maxBytes = CONFIG.maxUploadKb * 1024;

            if (!allowed.includes(file.type) && !/\.(jpe?g|png|pdf)$/i.test(file.name)) {
                showFieldError('identification', 'The identification must be a file of type: JPG, JPEG, PNG, or PDF.');
                this.value = '';
                hideFilePreview();
                return;
            }

            if (file.size > maxBytes) {
                const maxMb = (CONFIG.maxUploadKb / 1024).toFixed(1);
                showFieldError('identification', `The identification file may not be greater than ${maxMb} MB.`);
                this.value = '';
                hideFilePreview();
                return;
            }

            selectedFile = file;
            showFilePreview(file);
        });

        $('#btn-remove-file').on('click', function () {
            $('#identification').val('');
            selectedFile = null;
            hideFilePreview();
            clearFieldError('identification');
        });
    }

    function showFilePreview(file) {
        const $preview = $('#file-preview');
        const $thumb = $('#preview-thumb');
        const isPdf = file.type === 'application/pdf' || /\.pdf$/i.test(file.name);

        $('#preview-name').text(file.name);
        $('#preview-size').text(formatFileSize(file.size));

        if (isPdf) {
            $thumb.html('<div class="pdf-icon"><i class="bi bi-file-earmark-pdf-fill"></i></div>');
        } else {
            const url = URL.createObjectURL(file);
            $thumb.html(`<img src="${url}" alt="Preview">`);
        }

        $preview.removeClass('d-none').addClass('fade-in');
    }

    function hideFilePreview() {
        $('#file-preview').addClass('d-none').removeClass('fade-in');
        $('#preview-thumb').empty();
        selectedFile = null;
    }

    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(2) + ' MB';
    }

    function updateMaxUploadLabel() {
        const mb = (CONFIG.maxUploadKb / 1024).toFixed(1);
        $('#max-upload-label').text(mb);
    }

    // ------------------------------------------------------------------
    // Consent & Submit Button State
    // ------------------------------------------------------------------
    function bindConsentCheckbox() {
        $('#consent').on('change', function () {
            clearFieldError('consent');
            updateSubmitButtonState();
        });
    }

    function updateSubmitButtonState() {
        const consented = $('#consent').is(':checked');
        $('#btn-submit').prop('disabled', !consented);
    }

    // ------------------------------------------------------------------
    // Form Submission (AJAX)
    // ------------------------------------------------------------------
    function bindFormSubmit() {
        $('#registration-form').on('submit', function (e) {
            e.preventDefault();

            if (!$('#consent').is(':checked')) {
                showFieldError('consent', 'You must accept the Data Privacy Notice before submitting.');
                return;
            }

            clearValidationErrors();
            setSubmitting(true);

            const formData = new FormData(this);

            $.ajax({
                url: CONFIG.storeUrl,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    setSubmitting(false);

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Application Submitted',
                            text: response.message || 'Application submitted successfully.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#0d6efd',
                            customClass: {
                                popup: 'rounded-4'
                            }
                        }).then(function () {
                            resetFormAndReturn();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Submission Failed',
                            text: response.message || 'Something went wrong. Please try again.',
                            confirmButtonColor: '#0d6efd',
                            customClass: { popup: 'rounded-4' }
                        });
                    }
                },
                error: function (xhr) {
                    setSubmitting(false);

                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        // Validation errors
                        displayValidationErrors(xhr.responseJSON.errors);

                        Swal.fire({
                            icon: 'warning',
                            title: 'Validation Error',
                            text: xhr.responseJSON.message || 'Please correct the errors below.',
                            confirmButtonColor: '#0d6efd',
                            customClass: { popup: 'rounded-4' }
                        });
                    } else {
                        const msg = (xhr.responseJSON && xhr.responseJSON.message)
                            ? xhr.responseJSON.message
                            : 'An unexpected error occurred. Please try again later.';

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: msg,
                            confirmButtonColor: '#0d6efd',
                            customClass: { popup: 'rounded-4' }
                        });
                    }
                }
            });
        });
    }

    function setSubmitting(isSubmitting) {
        const $btn = $('#btn-submit');
        $btn.prop('disabled', isSubmitting || !$('#consent').is(':checked'));

        if (isSubmitting) {
            $btn.find('.btn-text').addClass('d-none');
            $btn.find('.btn-spinner').removeClass('d-none');
        } else {
            $btn.find('.btn-text').removeClass('d-none');
            $btn.find('.btn-spinner').addClass('d-none');
        }
    }

    // ------------------------------------------------------------------
    // Validation Helpers
    // ------------------------------------------------------------------
    function displayValidationErrors(errors) {
        $.each(errors, function (field, messages) {
            showFieldError(field, messages[0]);
        });

        // Scroll to first error
        const $first = $('.is-invalid').first();
        if ($first.length) {
            $('html, body').animate({
                scrollTop: $first.offset().top - 100
            }, 300);
        }
    }

    function showFieldError(field, message) {
        const $input = $('[name="' + field + '"]');
        const $feedback = $('[data-error="' + field + '"]');

        $input.addClass('is-invalid');
        $feedback.text(message).show();
    }

    function clearFieldError(field) {
        const $input = $('[name="' + field + '"]');
        const $feedback = $('[data-error="' + field + '"]');

        $input.removeClass('is-invalid');
        $feedback.text('').hide();
    }

    function clearValidationErrors() {
        $('.is-invalid').removeClass('is-invalid');
        $('[data-error]').text('').hide();
    }

    // ------------------------------------------------------------------
    // Reset after successful submission
    // ------------------------------------------------------------------
    function resetFormAndReturn() {
        $('#registration-form')[0].reset();
        hideFilePreview();
        selectedFile = null;
        clearValidationErrors();

        // Keep selected category, go back to form clean state
        $('#consent').prop('checked', false);
        updateSubmitButtonState();

        // Optionally return to category selection for a fresh start
        selectedType = null;
        $('#applicant_type').val('');
        $('.category-card').removeClass('selected').attr('aria-pressed', 'false');
        $('.selected-indicator').addClass('d-none');
        $('#btn-continue').prop('disabled', true);

        goBackToCategories();
    }

})(jQuery);
