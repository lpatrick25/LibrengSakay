<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Received</title>
</head>

<body
    style="margin:0;padding:0;background:#f4f6f9;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#212529;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9;padding:32px 16px;">
        <tr>
            <td align="center">

                <table role="presentation" cellpadding="0" cellspacing="0"
                    style="
                        width:100%;
                        max-width:650px;
                        background:#ffffff;
                        border:1px solid #e9ecef;
                        border-radius:14px;
                        overflow:hidden;">

                    {{-- Header --}}
                    <tr>
                        <td
                            style="
                                background:#0d6efd;
                                color:#ffffff;
                                padding:30px;
                                text-align:center;">

                            <h1
                                style="
                                    margin:0;
                                    font-size:24px;
                                    font-weight:700;">
                                {{ config('app.name') }}
                            </h1>

                            <p
                                style="
                                    margin:8px 0 0;
                                    opacity:.9;
                                    font-size:14px;">
                                Applicant Registration System
                            </p>

                        </td>
                    </tr>

                    {{-- Title --}}
                    <tr>
                        <td style="padding:35px 35px 20px;">

                            <h2
                                style="
                                    margin:0;
                                    color:#198754;
                                    font-size:28px;
                                    font-weight:700;">
                                Application Successfully Received
                            </h2>

                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td
                            style="
                                padding:0 35px 35px;
                                font-size:15px;
                                line-height:1.8;
                                color:#495057;">

                            <p>
                                Dear <strong>{{ $applicant->full_name }}</strong>,
                            </p>

                            <p>
                                Thank you for submitting your online application to
                                <strong>{{ config('app.name') }}</strong>.
                            </p>

                            <p>
                                We have successfully received your application. It is now waiting for verification and
                                review by our administrators.
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="
                                    margin:30px 0;
                                    background:#f8f9fa;
                                    border:1px solid #dee2e6;
                                    border-radius:10px;">

                                <tr>
                                    <td style="padding:18px 22px;">

                                        <h3
                                            style="
                                                margin-top:0;
                                                margin-bottom:18px;
                                                color:#0d6efd;">
                                            Application Details
                                        </h3>

                                        <table width="100%" cellpadding="6">

                                            <tr>
                                                <td width="180">
                                                    <strong>Reference Number</strong>
                                                </td>
                                                <td>
                                                    #{{ str_pad($applicant->id, 6, '0', STR_PAD_LEFT) }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong>Applicant</strong>
                                                </td>
                                                <td>
                                                    {{ $applicant->full_name }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong>Category</strong>
                                                </td>
                                                <td>
                                                    {{ $applicant->applicant_type_label }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong>Place of Examination</strong>
                                                </td>
                                                <td>
                                                    {{ $applicant->place_of_examination }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong>Status</strong>
                                                </td>
                                                <td>
                                                    <span
                                                        style="
                                                            display:inline-block;
                                                            background:#fff3cd;
                                                            color:#856404;
                                                            padding:5px 12px;
                                                            border-radius:50px;
                                                            font-size:13px;
                                                            font-weight:600;">
                                                        Pending Verification
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong>Date Submitted</strong>
                                                </td>
                                                <td>
                                                    {{ $applicant->created_at->format('F d, Y h:i A') }}
                                                </td>
                                            </tr>

                                        </table>

                                    </td>
                                </tr>

                            </table>

                            <div
                                style="
                                    background:#e7f1ff;
                                    border-left:5px solid #0d6efd;
                                    padding:20px;
                                    border-radius:8px;
                                    margin-bottom:30px;">

                                <strong>What happens next?</strong>

                                <ul style="margin-top:12px;margin-bottom:0;">

                                    <li>Your submitted information will be reviewed by our personnel.</li>

                                    <li>If your application is approved, you will receive another email containing your
                                        official QR Code.</li>

                                    <li>The QR Code will serve as proof of your verified registration.</li>

                                    <li>If additional information is required, our office may contact you.</li>

                                </ul>

                            </div>

                            <div
                                style="
                                    background:#fff8e1;
                                    border:1px solid #ffe69c;
                                    padding:20px;
                                    border-radius:8px;
                                    margin-bottom:30px;">

                                <strong>Important Reminders</strong>

                                <ul style="margin-top:12px;margin-bottom:0;">

                                    <li>Keep your Reference Number for future inquiries.</li>

                                    <li>Please do not submit duplicate applications.</li>

                                    <li>Monitor your email regularly for updates.</li>

                                    <li>Bring the QR Code once your application has been approved.</li>

                                </ul>

                            </div>

                            <p>
                                Thank you for your interest in
                                <strong>{{ config('app.name') }}</strong>.
                            </p>

                            <p>
                                Respectfully,
                            </p>

                            <p>
                                <strong>{{ config('app.name') }}</strong>
                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td
                            style="
                                background:#f8f9fa;
                                border-top:1px solid #e9ecef;
                                padding:24px;
                                text-align:center;
                                color:#6c757d;
                                font-size:13px;">

                            This is an automated email generated by the system.<br>
                            Please do not reply directly to this message.

                            <br><br>

                            © {{ now()->year }} {{ config('app.name') }}.
                            All Rights Reserved.

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
