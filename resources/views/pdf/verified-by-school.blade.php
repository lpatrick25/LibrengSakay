<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        @page {
            size: A4 portrait;
            margin: 10mm 18mm;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 11pt;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .page-break {
            page-break-after: always;
        }

        /* HEADER */

        .header-table td {
            border: none;
            vertical-align: middle;
        }

        .logo {
            width: 70px;
        }

        .logo-left {
            width: 80px;
        }

        .logo-right {
            width: 80px;
            text-align: right;
        }

        .header-center {
            text-align: center;
            line-height: 1.25;
        }

        .municipality {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .divider {
            border-bottom: 2px solid #000;
            margin-top: 8px;
            margin-bottom: 15px;
        }

        .office {
            font-size: 15pt;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .title {
            text-align: center;
            font-size: 15pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .school {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .generated {
            text-align: right;
            margin-bottom: 15px;
            font-size: 10pt;
        }

        /* TABLE */

        .report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #000;
            padding: 3px;
            font-size: 10pt;
        }

        .report-table th {
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 15px;
            font-weight: bold;
        }
    </style>

</head>

<body>

    @foreach ($schools as $school => $applicants)
        <table class="header-table">
            <tr>
                <td class="logo-left">
                    <img src="{{ public_path('images/abuyog-logo.png') }}" class="logo">
                </td>

                <td class="header-center">
                    <div>Republic of the Philippines</div>

                    <div class="municipality">
                        MUNICIPALITY OF ABUYOG
                    </div>

                    <div>
                        Province of Leyte
                    </div>
                </td>

                <td class="logo-right">
                    <img src="{{ public_path('images/right.png') }}" class="logo">
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="office">
            Human Resource Management Office
        </div>

        <div class="title">
            {{-- VERIFIED APPLICANTS REPORT --}}
        </div>

        <div class="school">
            {{ $school }}
        </div>

        <div class="generated">
            {{-- Generated: {{ $generatedAt->format('F d, Y h:i A') }} --}}
        </div>

        <table class="report-table">

            <thead>
                <tr>
                    <th width="6%">#</th>
                    <th width="35%">Applicant Name</th>
                    <th width="24%">Email</th>
                    <th width="15%">Contact No.</th>
                    <th width="20%">Birthday</th>
                </tr>
            </thead>

            <tbody>

                @forelse($applicants as $index => $applicant)
                    <tr>

                        <td class="text-center">
                            {{ $index + 1 }}
                        </td>

                        <td>
                            {{ strtoupper($applicant->last_name) }},
                            {{ strtoupper($applicant->first_name) }}
                            {{ $applicant->middle_name ? strtoupper(substr($applicant->middle_name, 0, 1)) . '.' : '' }}
                            {{ strtoupper($applicant->suffix) }}
                        </td>

                        <td>
                            {{ $applicant->email }}
                        </td>

                        <td class="text-center">
                            {{ $applicant->contact_number }}
                        </td>

                        <td class="text-center">
                            {{ $applicant->date_of_birth }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center">
                            No verified applicants.
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

        <div class="footer">
            Total Verified Applicants: {{ $applicants->count() }}
        </div>

        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

</body>

</html>
