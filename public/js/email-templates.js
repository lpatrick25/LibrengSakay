/**
 * Email Template Management
 * Cards list, CKEditor edit, preview, test send, toggle active
 */
(function ($) {
    'use strict';

    const CSRF = $('meta[name="csrf-token"]').attr('content');
    let editorInstance = null;
    let currentTemplateId = null;
    let placeholders = {};

    $(function () {
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': CSRF } });
        loadTemplates();
        bindRefresh();
        bindEditForm();
        bindTestForm();
        bindPreviewFromEdit();
        bindTestFromEdit();
    });

    // ------------------------------------------------------------------
    // Load cards
    // ------------------------------------------------------------------
    function loadTemplates() {
        $('#templates-skeleton').removeClass('d-none');
        $('#templates-cards').addClass('d-none').empty();

        $.getJSON(window.EmailTemplateRoutes.data)
            .done(function (res) {
                if (!res.success) return;
                placeholders = res.placeholders || {};
                renderCards(res.data || []);
                $('#templates-skeleton').addClass('d-none');
                $('#templates-cards').removeClass('d-none').addClass('fade-in');
            })
            .fail(function () {
                $('#templates-skeleton').addClass('d-none');
                $('#templates-cards').removeClass('d-none').html(
                    '<div class="col-12"><div class="alert alert-danger rounded-3">Failed to load templates.</div></div>'
                );
            });
    }

    function renderCards(templates) {
        const $wrap = $('#templates-cards').empty();
        if (!templates.length) {
            $wrap.html('<div class="col-12 text-muted text-center py-5">No templates found. Run the seeder.</div>');
            return;
        }

        templates.forEach(function (t) {
            const activeBadge = t.is_active
                ? '<span class="badge text-bg-success rounded-pill"><i class="bi bi-check-circle me-1"></i>Active</span>'
                : '<span class="badge text-bg-secondary rounded-pill"><i class="bi bi-pause-circle me-1"></i>Inactive</span>';

            const icon = t.slug === 'applicant_approved' ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger';

            const card = `
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 template-card">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="template-icon rounded-3 d-flex align-items-center justify-content-center flex-shrink-0">
                                <i class="bi ${icon} fs-4"></i>
                            </div>
                            <div class="min-w-0 flex-grow-1">
                                <h2 class="h5 fw-semibold mb-1 text-truncate">${escapeHtml(t.name)}</h2>
                                <div class="small text-muted text-truncate">${escapeHtml(t.subject)}</div>
                            </div>
                            ${activeBadge}
                        </div>
                        <div class="small text-muted mb-3 mt-auto">
                            <i class="bi bi-clock-history me-1"></i>
                            Updated ${escapeHtml(t.updated_at || '—')}
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 btn-preview" data-id="${t.id}">
                                <i class="bi bi-eye me-1"></i> Preview
                            </button>
                            <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 btn-edit" data-id="${t.id}">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3 btn-toggle" data-id="${t.id}" data-active="${t.is_active ? 1 : 0}">
                                <i class="bi bi-toggle-${t.is_active ? 'on' : 'off'} me-1"></i>
                                ${t.is_active ? 'Disable' : 'Enable'}
                            </button>
                        </div>
                    </div>
                </div>
            </div>`;
            $wrap.append(card);
        });
    }

    function bindRefresh() {
        $('#btn-refresh-templates').on('click', loadTemplates);
    }

    // Card actions (delegated)
    $(document).on('click', '.btn-edit', function () {
        openEditModal($(this).data('id'));
    });

    $(document).on('click', '.btn-preview', function () {
        openPreview($(this).data('id'));
    });

    $(document).on('click', '.btn-toggle', function () {
        const id = $(this).data('id');
        const $btn = $(this);
        $btn.prop('disabled', true);

        $.ajax({
            url: window.EmailTemplateRoutes.toggle + '/' + id + '/toggle',
            method: 'POST',
            success: function (res) {
                Swal.fire({ icon: 'success', title: res.is_active ? 'Activated' : 'Deactivated', text: res.message, timer: 1500, showConfirmButton: false, customClass: { popup: 'rounded-4' } });
                loadTemplates();
            },
            error: function (xhr) {
                Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message || 'Toggle failed.', customClass: { popup: 'rounded-4' } });
            },
            complete: function () {
                $btn.prop('disabled', false);
            }
        });
    });

    // ------------------------------------------------------------------
    // Edit modal + CKEditor
    // ------------------------------------------------------------------
    function openEditModal(id) {
        currentTemplateId = id;
        clearFormErrors('#edit-template-form');
        $('#edit-template-skeleton').removeClass('d-none');
        $('#edit-template-content').addClass('d-none');
        $('#editTemplateModal').modal('show');

        destroyEditor();

        $.getJSON(window.EmailTemplateRoutes.show + '/' + id)
            .done(function (res) {
                if (!res.success) return;
                const d = res.data;
                placeholders = res.placeholders || placeholders;

                $('#edit-name').val(d.name);
                $('#edit-slug').val(d.slug);
                $('#edit-subject').val(d.subject);
                $('#edit-is-active').prop('checked', !!d.is_active);

                renderPlaceholdersList();

                initEditor(d.body || '').then(function () {
                    $('#edit-template-skeleton').addClass('d-none');
                    $('#edit-template-content').removeClass('d-none');
                });
            })
            .fail(function () {
                $('#editTemplateModal').modal('hide');
                Swal.fire({ icon: 'error', title: 'Error', text: 'Could not load template.', customClass: { popup: 'rounded-4' } });
            });
    }

    function initEditor(html) {
        return ClassicEditor
            .create(document.querySelector('#editor-container'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'underline', '|',
                    'fontColor', 'fontBackgroundColor', '|',
                    'bulletedList', 'numberedList', '|',
                    'alignment', '|',
                    'link', 'insertTable', '|',
                    'undo', 'redo'
                ],
            })
            .then(function (editor) {
                editorInstance = editor;
                editor.setData(html || '');
                return editor;
            })
            .catch(function (err) {
                console.error(err);
                // Fallback: show textarea
                $('#editor-container').html('<textarea class="form-control rounded-3" id="edit-body-fallback" rows="12"></textarea>');
                $('#edit-body-fallback').val(html || '');
            });
    }

    function destroyEditor() {
        if (editorInstance) {
            editorInstance.destroy().catch(function () {});
            editorInstance = null;
        }
        $('#editor-container').empty();
    }

    function getBodyContent() {
        if (editorInstance) {
            return editorInstance.getData();
        }
        return $('#edit-body-fallback').val() || '';
    }

    function renderPlaceholdersList() {
        const $list = $('#placeholders-list').empty();
        $.each(placeholders, function (key, desc) {
            const token = '{{ ' + key + ' }}';
            $list.append(`
                <div class="d-flex align-items-start gap-2 placeholder-item">
                    <code class="small flex-grow-1 text-break">${escapeHtml(token)}</code>
                    <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2 btn-copy-ph" data-token="${escapeHtml(token)}" title="${escapeHtml(desc)}">
                        <i class="bi bi-clipboard"></i>
                    </button>
                </div>
                <div class="small text-muted mb-1" style="margin-top:-4px;">${escapeHtml(desc)}</div>
            `);
        });
    }

    $(document).on('click', '.btn-copy-ph', function () {
        const token = $(this).data('token');
        navigator.clipboard.writeText(token).then(function () {
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Copied: ' + token, showConfirmButton: false, timer: 1500 });
        }).catch(function () {
            // Fallback
            const $tmp = $('<input>').val(token).appendTo('body').select();
            document.execCommand('copy');
            $tmp.remove();
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Copied', showConfirmButton: false, timer: 1200 });
        });
    });

    function bindEditForm() {
        $('#edit-template-form').on('submit', function (e) {
            e.preventDefault();
            clearFormErrors('#edit-template-form');
            setBtnLoading('#btn-save-template', true);

            const payload = {
                subject: $('#edit-subject').val(),
                body: getBodyContent(),
                is_active: $('#edit-is-active').is(':checked') ? 1 : 0,
            };

            $.ajax({
                url: window.EmailTemplateRoutes.update + '/' + currentTemplateId,
                method: 'POST',
                data: Object.assign(payload, { _method: 'PUT' }),
                success: function (res) {
                    $('#editTemplateModal').modal('hide');
                    destroyEditor();
                    Swal.fire({ icon: 'success', title: 'Saved', text: res.message, customClass: { popup: 'rounded-4' } });
                    loadTemplates();
                },
                error: function (xhr) {
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        displayFormErrors('#edit-template-form', xhr.responseJSON.errors);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message || 'Save failed.', customClass: { popup: 'rounded-4' } });
                    }
                },
                complete: function () {
                    setBtnLoading('#btn-save-template', false);
                }
            });
        });

        // Destroy editor when modal closes
        $('#editTemplateModal').on('hidden.bs.modal', function () {
            destroyEditor();
        });
    }

    // ------------------------------------------------------------------
    // Preview
    // ------------------------------------------------------------------
    function openPreview(id, subject, body) {
        $('#preview-skeleton').removeClass('d-none');
        $('#preview-content').addClass('d-none');
        $('#previewTemplateModal').modal('show');

        const data = {};
        if (subject !== undefined) data.subject = subject;
        if (body !== undefined) data.body = body;

        $.ajax({
            url: window.EmailTemplateRoutes.preview + '/' + id + '/preview',
            method: 'POST',
            data: data,
            success: function (res) {
                if (!res.success) return;
                $('#preview-subject').text(res.data.subject);
                $('#preview-body').html(res.data.body);
                $('#preview-skeleton').addClass('d-none');
                $('#preview-content').removeClass('d-none').addClass('fade-in');
            },
            error: function () {
                $('#previewTemplateModal').modal('hide');
                Swal.fire({ icon: 'error', title: 'Error', text: 'Could not generate preview.', customClass: { popup: 'rounded-4' } });
            }
        });
    }

    function bindPreviewFromEdit() {
        $('#btn-preview-from-edit').on('click', function () {
            if (!currentTemplateId) return;
            openPreview(currentTemplateId, $('#edit-subject').val(), getBodyContent());
        });
    }

    // ------------------------------------------------------------------
    // Test email
    // ------------------------------------------------------------------
    function bindTestFromEdit() {
        $('#btn-test-from-edit').on('click', function () {
            if (!currentTemplateId) return;
            $('#test-template-id').val(currentTemplateId);
            $('#test-email').val('');
            clearFormErrors('#test-email-form');
            $('#testEmailModal').modal('show');
        });
    }

    function bindTestForm() {
        $('#test-email-form').on('submit', function (e) {
            e.preventDefault();
            clearFormErrors('#test-email-form');
            setBtnLoading('#btn-send-test', true);

            const id = $('#test-template-id').val();
            const payload = {
                email: $('#test-email').val(),
            };

            // If editing, send current subject/body
            if (String(id) === String(currentTemplateId) && $('#editTemplateModal').hasClass('show')) {
                payload.subject = $('#edit-subject').val();
                payload.body = getBodyContent();
            }

            $.ajax({
                url: window.EmailTemplateRoutes.test + '/' + id + '/test',
                method: 'POST',
                data: payload,
                success: function (res) {
                    $('#testEmailModal').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Sent', text: res.message, customClass: { popup: 'rounded-4' } });
                },
                error: function (xhr) {
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        displayFormErrors('#test-email-form', xhr.responseJSON.errors);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message || 'Failed to send test email.', customClass: { popup: 'rounded-4' } });
                    }
                },
                complete: function () {
                    setBtnLoading('#btn-send-test', false);
                }
            });
        });
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    function setBtnLoading(sel, loading) {
        const $btn = $(sel);
        $btn.prop('disabled', loading);
        $btn.find('.btn-text').toggleClass('d-none', loading);
        $btn.find('.btn-spinner').toggleClass('d-none', !loading);
    }

    function clearFormErrors(form) {
        $(form).find('.is-invalid').removeClass('is-invalid');
        $(form).find('[data-error]').text('').hide();
    }

    function displayFormErrors(form, errors) {
        $.each(errors, function (field, messages) {
            const $input = $(form).find('[name="' + field + '"]');
            const $fb = $(form).find('[data-error="' + field + '"]');
            $input.addClass('is-invalid');
            $fb.text(messages[0]).show();
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

})(jQuery);
