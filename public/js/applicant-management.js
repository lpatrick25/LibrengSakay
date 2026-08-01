/**
 * Applicant Management Dashboard
 * Bootstrap Table (server-side) + statistics + filters + AJAX actions
 */
(function ($) {
    "use strict";

    const CSRF = $('meta[name="csrf-token"]').attr("content");
    let currentViewId = null;
    let $table = null;

    // ------------------------------------------------------------------
    // Init
    // ------------------------------------------------------------------
    $(function () {
        $.ajaxSetup({ headers: { "X-CSRF-TOKEN": CSRF } });

        loadStatistics();
        initTable();
        bindFilters();
        bindHeaderActions();
        bindModalActions();
        bindRejectForm();
    });

    // ------------------------------------------------------------------
    // Statistics
    // ------------------------------------------------------------------
    function loadStatistics() {
        $("#stats-skeleton").removeClass("d-none");
        $("#stats-cards").addClass("d-none");

        $.getJSON(window.ApplicantRoutes.statistics)
            .done(function (res) {
                if (!res.success) return;

                $.each(res.data, function (key, value) {
                    $('[data-stat-value="' + key + '"]').text(
                        Number(value).toLocaleString(),
                    );
                });

                $("#stats-skeleton").addClass("d-none");
                $("#stats-cards").removeClass("d-none").addClass("fade-in");
            })
            .fail(function () {
                $("#stats-skeleton").addClass("d-none");
                $("#stats-cards").removeClass("d-none");
            });
    }

    // ------------------------------------------------------------------
    // Bootstrap Table
    // ------------------------------------------------------------------
    function initTable() {
        $table = $("#applicants-table");
        // Table is auto-initialized via data attributes.
        // We just keep a reference and bind events if needed.
    }

    /**
     * queryParams – merge filters into Bootstrap Table request.
     * Called automatically by bootstrap-table.
     */
    window.queryParams = function (params) {
        params.applicant_type = $("#filter-type").val() || "";
        params.verification_status = $("#filter-status").val() || "";
        params.id_status = $("#filter-id-status").val() || "";
        params.place_of_examination = $("#filter-place").val() || "";
        params.date_filter = $("#filter-date").val() || "";
        params.date_from = $("#filter-date-from").val() || "";
        params.date_to = $("#filter-date-to").val() || "";
        return params;
    };

    window.responseHandler = function (res) {
        return res;
    };

    window.loadingTemplate = function () {
        return '<div class="py-5 text-center text-muted"><div class="spinner-border text-primary mb-2" role="status"></div><div class="small">Loading applicants…</div></div>';
    };

    // Formatters
    window.nameFormatter = function (value, row) {
        return '<span class="fw-medium">' + escapeHtml(value) + "</span>";
    };

    window.categoryFormatter = function (value, row) {
        return (
            '<span class="badge text-bg-' +
            row.applicant_type_badge +
            ' rounded-pill">' +
            escapeHtml(row.applicant_type_label) +
            "</span>"
        );
    };

    window.statusFormatter = function (value, row) {
        const icons = {
            pending: "hourglass-split",
            verified: "check-circle-fill",
            rejected: "x-circle-fill",
        };
        const icon = icons[value] || "circle";
        return (
            '<span class="badge text-bg-' +
            row.verification_badge +
            ' rounded-pill">' +
            '<i class="bi bi-' +
            icon +
            ' me-1"></i>' +
            escapeHtml(row.verification_label) +
            "</span>"
        );
    };

    window.idStatusFormatter = function (value, row) {
        const icons = {
            uploaded: "cloud-check-fill",
            missing: "cloud-slash-fill",
            needs_review: "exclamation-triangle-fill",
        };
        const icon = icons[value] || "circle";
        return (
            '<span class="badge text-bg-' +
            row.id_status_badge +
            ' rounded-pill">' +
            '<i class="bi bi-' +
            icon +
            ' me-1"></i>' +
            escapeHtml(row.id_status_label) +
            "</span>"
        );
    };

    window.actionsFormatter = function (value, row) {
        return [
            '<div class="btn-group btn-group-sm" role="group">',
            '<button type="button" class="btn btn-outline-primary btn-action" data-action="view" data-id="' +
                row.id +
                '" title="View">',
            '<i class="bi bi-eye"></i></button>',
            '<button type="button" class="btn btn-outline-success btn-action" data-action="verify" data-id="' +
                row.id +
                '" title="Verify"' +
                (row.verification_status === "verified" ? " disabled" : "") +
                ">",
            '<i class="bi bi-check-lg"></i></button>',
            '<button type="button" class="btn btn-outline-danger btn-action" data-action="reject" data-id="' +
                row.id +
                '" title="Reject"' +
                (row.verification_status === "rejected" ? " disabled" : "") +
                ">",
            '<i class="bi bi-x-lg"></i></button>',
            '<button type="button" class="btn btn-outline-secondary btn-action" data-action="download" data-id="' +
                row.id +
                '" title="Download ID">',
            '<i class="bi bi-download"></i></button>',
            '<button type="button" class="btn btn-outline-danger btn-action" data-action="delete" data-id="' +
                row.id +
                '" title="Delete">',
            '<i class="bi bi-trash"></i></button>',
            "</div>",
        ].join("");
    };

    // Delegate action clicks
    $(document).on("click", ".btn-action", function () {
        const action = $(this).data("action");
        const id = $(this).data("id");

        switch (action) {
            case "view":
                openViewModal(id);
                break;
            case "verify":
                confirmVerify(id);
                break;
            case "reject":
                openRejectModal(id);
                break;
            case "download":
                window.open(
                    window.ApplicantRoutes.downloadId +
                        "/" +
                        id +
                        "/download-id",
                    "_blank",
                );
                break;
            case "delete":
                confirmDelete(id);
                break;
        }
    });

    // ------------------------------------------------------------------
    // Filters
    // ------------------------------------------------------------------
    function bindFilters() {
        const $filters = $(
            "#filter-type, #filter-status, #filter-id-status, #filter-date, #filter-place, #filter-date-from, #filter-date-to",
        );

        $filters.on(
            "change keyup",
            debounce(function () {
                // Toggle custom date inputs
                const isCustom = $("#filter-date").val() === "custom";
                $("#custom-date-from-wrap, #custom-date-to-wrap").toggleClass(
                    "d-none",
                    !isCustom,
                );

                refreshTable();
            }, 350),
        );

        $("#btn-reset-filters").on("click", function () {
            $(
                "#filter-type, #filter-status, #filter-id-status, #filter-date",
            ).val("");
            $("#filter-place, #filter-date-from, #filter-date-to").val("");
            $("#custom-date-from-wrap, #custom-date-to-wrap").addClass(
                "d-none",
            );
            refreshTable();
        });
    }

    function refreshTable() {
        $("#applicants-table").bootstrapTable("refresh", { pageNumber: 1 });
    }

    // ------------------------------------------------------------------
    // Header actions
    // ------------------------------------------------------------------
    function bindHeaderActions() {
        $("#btn-refresh-all").on("click", function () {
            loadStatistics();
            refreshTable();
        });

        // Export / Print – trigger Bootstrap Table toolbar buttons
        $("#btn-export-csv").on("click", function (e) {
            e.preventDefault();
            $('.fixed-table-toolbar .export button[data-type="csv"]').trigger(
                "click",
            );
            // Fallback: use built-in export if available
            try {
                $("#applicants-table").bootstrapTable("exportTable", {
                    type: "csv",
                });
            } catch (err) {}
        });

        $("#btn-export-excel").on("click", function (e) {
            e.preventDefault();
            try {
                $("#applicants-table").bootstrapTable("exportTable", {
                    type: "excel",
                });
            } catch (err) {}
        });

        $("#btn-export-pdf").on("click", function (e) {
            e.preventDefault();
            try {
                $("#applicants-table").bootstrapTable("exportTable", {
                    type: "pdf",
                });
            } catch (err) {}
        });

        $("#btn-print-table").on("click", function () {
            try {
                $("#applicants-table").bootstrapTable("print");
            } catch (err) {
                window.print();
            }
        });
    }

    // ------------------------------------------------------------------
    // View Modal
    // ------------------------------------------------------------------
    function openViewModal(id) {
        currentViewId = id;
        const $modal = $("#viewApplicantModal");
        const $skel = $("#view-modal-skeleton");
        const $cont = $("#view-modal-content");

        $skel.removeClass("d-none");
        $cont.addClass("d-none");
        $modal.modal("show");

        $.getJSON(window.ApplicantRoutes.show + "/" + id)
            .done(function (res) {
                if (!res.success) {
                    Swal.fire(
                        "Error",
                        "Could not load applicant details.",
                        "error",
                    );
                    $modal.modal("hide");
                    return;
                }
                populateViewModal(res.data);
                $skel.addClass("d-none");
                $cont.removeClass("d-none").addClass("fade-in");
            })
            .fail(function () {
                Swal.fire(
                    "Error",
                    "Could not load applicant details.",
                    "error",
                );
                $modal.modal("hide");
            });
    }

    // function populateViewModal(d) {
    //     $('#vm-full-name').text(d.full_name);
    //     $('#vm-category').html('<span class="badge text-bg-' + d.applicant_type_badge + ' rounded-pill">' + escapeHtml(d.applicant_type_label) + '</span>');
    //     $('#vm-place').text(d.place_of_examination || '—');
    //     $('#vm-contact').text(d.contact_number || '—');
    //     $('#vm-email').text(d.email || '—');
    //     $('#vm-submitted').text(d.created_at || '—');

    //     // ID preview
    //     const $preview = $('#vm-id-preview').empty();
    //     const $dl = $('#vm-download-id').addClass('d-none');

    //     if (d.identification_url) {
    //         if (d.is_image) {
    //             $preview.html('<img src="' + d.identification_url + '" class="img-fluid rounded-3 border" style="max-height:240px;" alt="ID">');
    //         } else if (d.is_pdf) {
    //             $preview.html(
    //                 '<div class="border rounded-3 p-4 text-center bg-light">' +
    //                 '<i class="bi bi-file-earmark-pdf-fill text-danger" style="font-size:3rem;"></i>' +
    //                 '<p class="mb-0 mt-2 small text-muted">PDF Document</p></div>'
    //             );
    //         }
    //         $dl.attr('href', window.ApplicantRoutes.downloadId + '/' + d.id + '/download-id').removeClass('d-none');
    //     } else {
    //         $preview.html('<p class="text-muted small mb-0">No identification uploaded.</p>');
    //     }

    //     $('#vm-id-status').html('<span class="badge text-bg-' + d.id_status_badge + ' rounded-pill">' + escapeHtml(d.id_status_label) + '</span>');

    //     // Verification
    //     $('#vm-status').html('<span class="badge text-bg-' + d.verification_badge + ' rounded-pill">' + escapeHtml(d.verification_label) + '</span>');
    //     $('#vm-verified-by').text(d.verified_by || '—');
    //     $('#vm-verified-at').text(d.verified_at || '—');
    //     $('#vm-remarks').text(d.remarks || 'No remarks.');

    //     // Toggle action buttons
    //     $('#vm-btn-verify').prop('disabled', d.verification_status === 'verified');
    //     $('#vm-btn-reject').prop('disabled', d.verification_status === 'rejected');
    // }
    function populateViewModal(d) {
        $("#vm-full-name").text(d.full_name);

        $("#vm-category").html(
            '<span class="badge text-bg-' +
                d.applicant_type_badge +
                ' rounded-pill">' +
                escapeHtml(d.applicant_type_label) +
                "</span>",
        );

        $("#vm-place").text(d.place_of_examination || "—");
        $("#vm-contact").text(d.contact_number || "—");
        $("#vm-email").text(d.email || "—");
        $("#vm-submitted").text(d.created_at || "—");

        /*
    |--------------------------------------------------------------------------
    | Identification Preview (Spatie Media Library)
    |--------------------------------------------------------------------------
    */

        const $preview = $("#vm-id-preview").empty();
        const $download = $("#vm-download-id").addClass("d-none");

        if (d.identification && d.identification.exists) {
            if (d.identification.is_image) {
                $preview.html(`
                <img
                    src="${d.identification.url}"
                    class="img-fluid rounded-3 border shadow-sm"
                    style="max-height:260px;"
                    alt="Identification">
            `);
            } else if (d.identification.is_pdf) {
                $preview.html(`
                <div class="border rounded-3 p-5 text-center bg-light">
                    <i class="bi bi-file-earmark-pdf-fill text-danger display-4"></i>
                    <h6 class="mt-3 mb-1">PDF Document</h6>
                    <small class="text-muted">${escapeHtml(d.identification.file_name)}</small>
                </div>
            `);
            } else {
                $preview.html(`
                <div class="border rounded-3 p-5 text-center bg-light">
                    <i class="bi bi-file-earmark-fill display-4 text-secondary"></i>
                    <h6 class="mt-3 mb-1">${escapeHtml(d.identification.file_name)}</h6>
                    <small class="text-muted">${escapeHtml(d.identification.human_size)}</small>
                </div>
            `);
            }

            $download
                .attr(
                    "href",
                    window.ApplicantRoutes.downloadId +
                        "/" +
                        d.id +
                        "/download-id",
                )
                .removeClass("d-none");
        } else {
            $preview.html(`
            <div class="text-center py-5 text-muted">
                <i class="bi bi-image fs-1 d-block mb-2"></i>
                <p class="mb-0">No identification uploaded.</p>
            </div>
        `);
        }

        /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

        $("#vm-id-status").html(
            '<span class="badge text-bg-' +
                d.id_status_badge +
                ' rounded-pill">' +
                escapeHtml(d.id_status_label) +
                "</span>",
        );

        $("#vm-status").html(
            '<span class="badge text-bg-' +
                d.verification_badge +
                ' rounded-pill">' +
                escapeHtml(d.verification_label) +
                "</span>",
        );

        $("#vm-verified-by").text(d.verified_by || "—");
        $("#vm-verified-at").text(d.verified_at || "—");
        $("#vm-remarks").text(d.remarks || "No remarks.");

        /*
    |--------------------------------------------------------------------------
    | Action Buttons
    |--------------------------------------------------------------------------
    */

        $("#vm-btn-verify").prop(
            "disabled",
            d.verification_status === "verified",
        );

        $("#vm-btn-reject").prop(
            "disabled",
            d.verification_status === "rejected",
        );
    }

    function bindModalActions() {
        $("#vm-btn-verify").on("click", function () {
            if (currentViewId) {
                $("#viewApplicantModal").modal("hide");
                confirmVerify(currentViewId);
            }
        });

        $("#vm-btn-reject").on("click", function () {
            if (currentViewId) {
                $("#viewApplicantModal").modal("hide");
                openRejectModal(currentViewId);
            }
        });
    }

    // ------------------------------------------------------------------
    // Verify
    // ------------------------------------------------------------------
    function confirmVerify(id) {
        Swal.fire({
            title: "Verify Applicant?",
            text: "This will mark the application as verified.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            confirmButtonText: "Yes, verify",
            cancelButtonText: "Cancel",
            customClass: { popup: "rounded-4" },
        }).then(function (result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: window.ApplicantRoutes.verify + "/" + id + "/verify",
                method: "POST",
                data: { verified_by: "Administrator" },
                success: function (res) {
                    Swal.fire({
                        icon: "success",
                        title: "Verified",
                        text: res.message,
                        customClass: { popup: "rounded-4" },
                    });
                    refreshTable();
                    loadStatistics();
                },
                error: function (xhr) {
                    const msg =
                        xhr.responseJSON?.message || "Verification failed.";
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: msg,
                        customClass: { popup: "rounded-4" },
                    });
                },
            });
        });
    }

    // ------------------------------------------------------------------
    // Reject
    // ------------------------------------------------------------------
    function openRejectModal(id) {
        // Fetch name for display
        $.getJSON(window.ApplicantRoutes.show + "/" + id)
            .done(function (res) {
                $("#reject-applicant-id").val(id);
                $("#reject-applicant-name").text(
                    res.data?.full_name || "#" + id,
                );
                $("#reject-remarks").val("").removeClass("is-invalid");
                $("#rejectApplicantModal").modal("show");
            })
            .fail(function () {
                $("#reject-applicant-id").val(id);
                $("#reject-applicant-name").text("#" + id);
                $("#reject-remarks").val("");
                $("#rejectApplicantModal").modal("show");
            });
    }

    function bindRejectForm() {
        $("#reject-form").on("submit", function (e) {
            e.preventDefault();
            const id = $("#reject-applicant-id").val();
            const remarks = $("#reject-remarks").val().trim();

            if (!remarks) {
                $("#reject-remarks").addClass("is-invalid");
                return;
            }

            const $btn = $("#btn-confirm-reject");
            $btn.prop("disabled", true);
            $btn.find(".btn-text").addClass("d-none");
            $btn.find(".btn-spinner").removeClass("d-none");

            $.ajax({
                url: window.ApplicantRoutes.reject + "/" + id + "/reject",
                method: "POST",
                data: { remarks: remarks, verified_by: "Administrator" },
                success: function (res) {
                    $("#rejectApplicantModal").modal("hide");
                    Swal.fire({
                        icon: "success",
                        title: "Rejected",
                        text: res.message,
                        customClass: { popup: "rounded-4" },
                    });
                    refreshTable();
                    loadStatistics();
                },
                error: function (xhr) {
                    const msg =
                        xhr.responseJSON?.message || "Rejection failed.";
                    if (
                        xhr.status === 422 &&
                        xhr.responseJSON?.errors?.remarks
                    ) {
                        $("#reject-remarks").addClass("is-invalid");
                    }
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: msg,
                        customClass: { popup: "rounded-4" },
                    });
                },
                complete: function () {
                    $btn.prop("disabled", false);
                    $btn.find(".btn-text").removeClass("d-none");
                    $btn.find(".btn-spinner").addClass("d-none");
                },
            });
        });
    }

    // ------------------------------------------------------------------
    // Delete
    // ------------------------------------------------------------------
    function confirmDelete(id) {
        Swal.fire({
            title: "Delete Applicant?",
            text: "This action cannot be undone. The uploaded ID will also be removed.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            confirmButtonText: "Yes, delete",
            cancelButtonText: "Cancel",
            customClass: { popup: "rounded-4" },
        }).then(function (result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: window.ApplicantRoutes.destroy + "/" + id,
                method: "DELETE",
                success: function (res) {
                    Swal.fire({
                        icon: "success",
                        title: "Deleted",
                        text: res.message,
                        customClass: { popup: "rounded-4" },
                    });
                    refreshTable();
                    loadStatistics();
                },
                error: function (xhr) {
                    const msg = xhr.responseJSON?.message || "Delete failed.";
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: msg,
                        customClass: { popup: "rounded-4" },
                    });
                },
            });
        });
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    function escapeHtml(str) {
        if (!str) return "";
        return String(str)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;");
    }

    function debounce(fn, wait) {
        let t;
        return function () {
            const ctx = this,
                args = arguments;
            clearTimeout(t);
            t = setTimeout(function () {
                fn.apply(ctx, args);
            }, wait);
        };
    }
})(jQuery);
