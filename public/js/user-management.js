/**
 * User Management Module
 * Bootstrap Table (server-side) + AJAX CRUD + filters + statistics
 */
(function ($) {
    'use strict';

    const CSRF = $('meta[name="csrf-token"]').attr('content');
    let currentEditId = null;
    let currentViewId = null;

    $(function () {
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': CSRF } });

        loadUserStatistics();
        bindFilters();
        bindHeaderActions();
        bindCreateForm();
        bindEditForm();
        bindPasswordToggle();
        bindChangePasswordCheckbox();
    });

    // ------------------------------------------------------------------
    // Statistics
    // ------------------------------------------------------------------
    function loadUserStatistics() {
        $('#user-stats-skeleton').removeClass('d-none');
        $('#user-stats-cards').addClass('d-none');

        $.getJSON(window.UserRoutes.statistics)
            .done(function (res) {
                if (!res.success) return;
                $.each(res.data, function (key, value) {
                    $('[data-user-stat="' + key + '"]').text(Number(value).toLocaleString());
                });
                $('#user-stats-skeleton').addClass('d-none');
                $('#user-stats-cards').removeClass('d-none').addClass('fade-in');
            })
            .fail(function () {
                $('#user-stats-skeleton').addClass('d-none');
                $('#user-stats-cards').removeClass('d-none');
            });
    }

    // ------------------------------------------------------------------
    // Bootstrap Table helpers (global for data attributes)
    // ------------------------------------------------------------------
    window.userQueryParams = function (params) {
        params.email_status = $('#filter-email-status').val() || '';
        params.date_filter  = $('#filter-date').val() || '';
        params.date_from    = $('#filter-date-from').val() || '';
        params.date_to      = $('#filter-date-to').val() || '';
        return params;
    };

    window.userResponseHandler = function (res) { return res; };

    window.userLoadingTemplate = function () {
        return '<div class="py-5 text-center text-muted"><div class="spinner-border text-primary mb-2" role="status"></div><div class="small">Loading users…</div></div>';
    };

    window.userNameFormatter = function (value) {
        return '<span class="fw-medium">' + escapeHtml(value) + '</span>';
    };

    window.emailStatusFormatter = function (value) {
        if (value) {
            return '<span class="badge text-bg-success rounded-pill"><i class="bi bi-check-circle-fill me-1"></i>Verified</span>';
        }
        return '<span class="badge text-bg-warning rounded-pill"><i class="bi bi-exclamation-circle me-1"></i>Not Verified</span>';
    };

    window.userActionsFormatter = function (value, row) {
        return [
            '<div class="btn-group btn-group-sm" role="group">',
            '<button type="button" class="btn btn-outline-primary btn-user-action" data-action="view" data-id="' + row.id + '" title="View"><i class="bi bi-eye"></i></button>',
            '<button type="button" class="btn btn-outline-secondary btn-user-action" data-action="edit" data-id="' + row.id + '" title="Edit"><i class="bi bi-pencil"></i></button>',
            '<button type="button" class="btn btn-outline-danger btn-user-action" data-action="delete" data-id="' + row.id + '" title="Delete"><i class="bi bi-trash"></i></button>',
            '</div>'
        ].join('');
    };

    $(document).on('click', '.btn-user-action', function () {
        const action = $(this).data('action');
        const id = $(this).data('id');
        if (action === 'view') openViewModal(id);
        else if (action === 'edit') openEditModal(id);
        else if (action === 'delete') confirmDelete(id);
    });

    // ------------------------------------------------------------------
    // Filters
    // ------------------------------------------------------------------
    function bindFilters() {
        $('#filter-email-status, #filter-date, #filter-date-from, #filter-date-to').on('change', debounce(function () {
            const isCustom = $('#filter-date').val() === 'custom';
            $('#custom-date-from-wrap, #custom-date-to-wrap').toggleClass('d-none', !isCustom);
            refreshUsersTable();
        }, 300));

        $('#btn-reset-filters').on('click', function () {
            $('#filter-email-status, #filter-date').val('');
            $('#filter-date-from, #filter-date-to').val('');
            $('#custom-date-from-wrap, #custom-date-to-wrap').addClass('d-none');
            refreshUsersTable();
        });
    }

    function refreshUsersTable() {
        $('#users-table').bootstrapTable('refresh', { pageNumber: 1 });
    }

    // ------------------------------------------------------------------
    // Header actions
    // ------------------------------------------------------------------
    function bindHeaderActions() {
        $('#btn-add-user').on('click', function () {
            clearFormErrors('#create-user-form');
            $('#create-user-form')[0].reset();
            $('#createUserModal').modal('show');
        });

        $('#btn-refresh-all').on('click', function () {
            loadUserStatistics();
            refreshUsersTable();
        });

        $('#btn-export-csv').on('click', function (e) {
            e.preventDefault();
            try { $('#users-table').bootstrapTable('exportTable', { type: 'csv' }); } catch (err) {}
        });
        $('#btn-export-excel').on('click', function (e) {
            e.preventDefault();
            try { $('#users-table').bootstrapTable('exportTable', { type: 'excel' }); } catch (err) {}
        });
        $('#btn-export-pdf').on('click', function (e) {
            e.preventDefault();
            try { $('#users-table').bootstrapTable('exportTable', { type: 'pdf' }); } catch (err) {}
        });
        $('#btn-print-table').on('click', function () {
            try { $('#users-table').bootstrapTable('print'); } catch (err) { window.print(); }
        });
    }

    // ------------------------------------------------------------------
    // Create User
    // ------------------------------------------------------------------
    function bindCreateForm() {
        $('#create-user-form').on('submit', function (e) {
            e.preventDefault();
            clearFormErrors('#create-user-form');
            setButtonLoading('#btn-create-submit', true);

            $.ajax({
                url: window.UserRoutes.store,
                method: 'POST',
                data: $(this).serialize(),
                success: function (res) {
                    $('#createUserModal').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Created', text: res.message, customClass: { popup: 'rounded-4' } });
                    refreshUsersTable();
                    loadUserStatistics();
                },
                error: function (xhr) {
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        displayFormErrors('#create-user-form', xhr.responseJSON.errors);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message || 'Could not create user.', customClass: { popup: 'rounded-4' } });
                    }
                },
                complete: function () {
                    setButtonLoading('#btn-create-submit', false);
                }
            });
        });
    }

    // ------------------------------------------------------------------
    // Edit User
    // ------------------------------------------------------------------
    function openEditModal(id) {
        currentEditId = id;
        clearFormErrors('#edit-user-form');
        $('#edit-change-password').prop('checked', false);
        $('#edit-password-fields').addClass('d-none');
        $('#edit-password, #edit-password-confirmation').val('');
        $('#edit-modal-skeleton').removeClass('d-none');
        $('#edit-modal-content').addClass('d-none');
        $('#editUserModal').modal('show');

        $.getJSON(window.UserRoutes.show + '/' + id)
            .done(function (res) {
                if (!res.success) return;
                $('#edit-user-id').val(res.data.id);
                $('#edit-name').val(res.data.name);
                $('#edit-email').val(res.data.email);
                $('#edit-modal-skeleton').addClass('d-none');
                $('#edit-modal-content').removeClass('d-none');
            })
            .fail(function () {
                $('#editUserModal').modal('hide');
                Swal.fire({ icon: 'error', title: 'Error', text: 'Could not load user.', customClass: { popup: 'rounded-4' } });
            });
    }

    function bindEditForm() {
        $('#edit-user-form').on('submit', function (e) {
            e.preventDefault();
            clearFormErrors('#edit-user-form');
            setButtonLoading('#btn-edit-submit', true);

            const id = $('#edit-user-id').val();
            const data = $(this).serialize();

            $.ajax({
                url: window.UserRoutes.update + '/' + id,
                method: 'POST',
                data: data + '&_method=PUT',
                success: function (res) {
                    $('#editUserModal').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Updated', text: res.message, customClass: { popup: 'rounded-4' } });
                    refreshUsersTable();
                    loadUserStatistics();
                },
                error: function (xhr) {
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        displayFormErrors('#edit-user-form', xhr.responseJSON.errors);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message || 'Could not update user.', customClass: { popup: 'rounded-4' } });
                    }
                },
                complete: function () {
                    setButtonLoading('#btn-edit-submit', false);
                }
            });
        });
    }

    function bindChangePasswordCheckbox() {
        $('#edit-change-password').on('change', function () {
            $('#edit-password-fields').toggleClass('d-none', !this.checked);
            if (!this.checked) {
                $('#edit-password, #edit-password-confirmation').val('');
                clearFormErrors('#edit-user-form');
            }
        });
    }

    // ------------------------------------------------------------------
    // View User
    // ------------------------------------------------------------------
    function openViewModal(id) {
        currentViewId = id;
        $('#view-user-skeleton').removeClass('d-none');
        $('#view-user-content').addClass('d-none');
        $('#viewUserModal').modal('show');

        $.getJSON(window.UserRoutes.show + '/' + id)
            .done(function (res) {
                if (!res.success) return;
                const d = res.data;
                $('#vu-id').text(d.id);
                $('#vu-name').text(d.name);
                $('#vu-email').text(d.email);
                $('#vu-created').text(d.created_at || '—');
                $('#vu-updated').text(d.updated_at || '—');
                $('#vu-email-status').html(
                    d.email_verified
                        ? '<span class="badge text-bg-success rounded-pill"><i class="bi bi-check-circle-fill me-1"></i>Verified</span>'
                        : '<span class="badge text-bg-warning rounded-pill"><i class="bi bi-exclamation-circle me-1"></i>Not Verified</span>'
                );
                $('#view-user-skeleton').addClass('d-none');
                $('#view-user-content').removeClass('d-none').addClass('fade-in');
            })
            .fail(function () {
                $('#viewUserModal').modal('hide');
                Swal.fire({ icon: 'error', title: 'Error', text: 'Could not load user.', customClass: { popup: 'rounded-4' } });
            });
    }

    $('#vu-btn-edit').on('click', function () {
        $('#viewUserModal').modal('hide');
        if (currentViewId) openEditModal(currentViewId);
    });

    // ------------------------------------------------------------------
    // Delete
    // ------------------------------------------------------------------
    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete User?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            customClass: { popup: 'rounded-4' }
        }).then(function (result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: window.UserRoutes.destroy + '/' + id,
                method: 'DELETE',
                success: function (res) {
                    Swal.fire({ icon: 'success', title: 'Deleted', text: res.message, customClass: { popup: 'rounded-4' } });
                    refreshUsersTable();
                    loadUserStatistics();
                },
                error: function (xhr) {
                    Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message || 'Delete failed.', customClass: { popup: 'rounded-4' } });
                }
            });
        });
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    function bindPasswordToggle() {
        $(document).on('click', '.toggle-password', function () {
            const $input = $($(this).data('target'));
            const type = $input.attr('type') === 'password' ? 'text' : 'password';
            $input.attr('type', type);
            $(this).find('i').toggleClass('bi-eye bi-eye-slash');
        });
    }

    function setButtonLoading(selector, loading) {
        const $btn = $(selector);
        $btn.prop('disabled', loading);
        $btn.find('.btn-text').toggleClass('d-none', loading);
        $btn.find('.btn-spinner').toggleClass('d-none', !loading);
    }

    function clearFormErrors(formSelector) {
        $(formSelector).find('.is-invalid').removeClass('is-invalid');
        $(formSelector).find('[data-error]').text('').hide();
    }

    function displayFormErrors(formSelector, errors) {
        $.each(errors, function (field, messages) {
            const $input = $(formSelector).find('[name="' + field + '"]');
            const $feedback = $(formSelector).find('[data-error="' + field + '"]');
            $input.addClass('is-invalid');
            $feedback.text(messages[0]).show();
        });
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function debounce(fn, wait) {
        let t;
        return function () {
            const ctx = this, args = arguments;
            clearTimeout(t);
            t = setTimeout(function () { fn.apply(ctx, args); }, wait);
        };
    }

})(jQuery);
