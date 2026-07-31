/**
 * Authentication – Login form (AJAX)
 */
(function ($) {
    'use strict';

    const CSRF = $('meta[name="csrf-token"]').attr('content');

    $(function () {
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': CSRF } });

        bindPasswordToggle();
        bindLoginForm();
    });

    function bindPasswordToggle() {
        $(document).on('click', '.toggle-password', function () {
            const $input = $($(this).data('target'));
            const isPassword = $input.attr('type') === 'password';
            $input.attr('type', isPassword ? 'text' : 'password');
            $(this).find('i').toggleClass('bi-eye bi-eye-slash');
            $(this).attr('aria-label', isPassword ? 'Hide password' : 'Show password');
        });
    }

    function bindLoginForm() {
        $('#login-form').on('submit', function (e) {
            e.preventDefault();
            clearErrors();
            setLoading(true);

            $.ajax({
                url: window.LoginRoutes.login,
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        // Brief success feedback then redirect
                        Swal.fire({
                            icon: 'success',
                            title: 'Welcome',
                            text: res.message || 'Login successful.',
                            timer: 1200,
                            showConfirmButton: false,
                            customClass: { popup: 'rounded-4' }
                        }).then(function () {
                            window.location.href = res.redirect || '/admin/applicants';
                        });
                    } else {
                        setLoading(false);
                        showAuthError(res.message || 'Invalid email or password.');
                    }
                },
                error: function (xhr) {
                    setLoading(false);

                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        displayFieldErrors(xhr.responseJSON.errors);
                    } else if (xhr.status === 401 && xhr.responseJSON?.message) {
                        showAuthError(xhr.responseJSON.message);
                    } else {
                        showAuthError(xhr.responseJSON?.message || 'An unexpected error occurred. Please try again.');
                    }
                }
            });
        });
    }

    function setLoading(loading) {
        const $btn = $('#btn-login');
        $btn.prop('disabled', loading);
        $btn.find('.btn-text').toggleClass('d-none', loading);
        $btn.find('.btn-spinner').toggleClass('d-none', !loading);
    }

    function clearErrors() {
        $('#login-form .is-invalid').removeClass('is-invalid');
        $('#login-form [data-error]').text('').hide();
        $('#auth-error').addClass('d-none');
    }

    function displayFieldErrors(errors) {
        $.each(errors, function (field, messages) {
            const $input = $('[name="' + field + '"]');
            const $feedback = $('[data-error="' + field + '"]');
            // Highlight the input-group if present
            $input.addClass('is-invalid');
            $input.closest('.input-group').find('.form-control, .input-group-text, .btn').addClass('is-invalid');
            $feedback.text(messages[0]).show();
        });
    }

    function showAuthError(message) {
        $('#auth-error-text').text(message);
        $('#auth-error').removeClass('d-none');
    }

})(jQuery);
