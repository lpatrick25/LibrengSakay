{{-- ==========================================================================
    Dashboard Statistics
========================================================================== --}}
@php
    $cards = [
        [
            'key' => 'total',
            'label' => 'Total Applicants',
            'icon' => 'bi-people-fill',
            'color' => 'primary',
        ],
        [
            'key' => 'abuyognon',
            'label' => 'Abuyognon',
            'icon' => 'bi-house-heart-fill',
            'color' => 'warning',
        ],
        [
            'key' => 'acc_student',
            'label' => 'ACC Students',
            'icon' => 'bi-mortarboard-fill',
            'color' => 'success',
        ],
        [
            'key' => 'non_abuyognon',
            'label' => 'Non-Abuyognon',
            'icon' => 'bi-globe-asia-australia',
            'color' => 'secondary',
        ],
        [
            'key' => 'submitted_today',
            'label' => 'Submitted Today',
            'icon' => 'bi-calendar-check-fill',
            'color' => 'info',
        ],
        [
            'key' => 'pending',
            'label' => 'Pending Verification',
            'icon' => 'bi-hourglass-split',
            'color' => 'danger',
        ],
        [
            'key' => 'verified',
            'label' => 'Verified',
            'icon' => 'bi-patch-check-fill',
            'color' => 'success',
        ],
    ];
@endphp

@foreach ($cards as $card)
    <div class="col-6 col-lg-4 col-xl">

        <div class="card stat-card h-100">

            <div class="card-body d-flex flex-column">

                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-start mb-4">

                    <small class="text-muted text-uppercase fw-semibold pe-3">
                        {{ $card['label'] }}
                    </small>

                    <div class="stat-icon bg-{{ $card['color'] }}-subtle flex-shrink-0">
                        <i class="bi {{ $card['icon'] }}"></i>
                    </div>

                </div>

                {{-- Push number to bottom --}}
                <div class="mt-auto">

                    <h2 class="stat-number fw-bold mb-0" data-stat-value="{{ $card['key'] }}">

                        —

                    </h2>

                </div>

            </div>

        </div>

    </div>
@endforeach
