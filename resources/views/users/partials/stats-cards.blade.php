@php
    $cards = [
        [
            'key' => 'total',
            'label' => 'Total Users',
            'icon' => 'bi-people-fill',
            'color' => 'warning',
        ],
        [
            'key' => 'verified',
            'label' => 'Verified Email',
            'icon' => 'bi-envelope-check-fill',
            'color' => 'success',
        ],
        [
            'key' => 'unverified',
            'label' => 'Unverified Email',
            'icon' => 'bi-envelope-exclamation-fill',
            'color' => 'danger',
        ],
        [
            'key' => 'today',
            'label' => 'New Users Today',
            'icon' => 'bi-person-plus-fill',
            'color' => 'info',
        ],
    ];
@endphp

<div class="row g-3">

    @foreach ($cards as $card)
        <div class="col-6 col-lg-3">

            <div class="card stat-card h-100 border-0 shadow-sm rounded-4 honey-stat-card"
                data-stat="{{ $card['key'] }}">

                <div class="card-body d-flex flex-column">

                    {{-- Icon --}}
                    <div class="d-flex justify-content-between align-items-start mb-3">

                        <div class="hex-icon bg-{{ $card['color'] }}-subtle text-{{ $card['color'] }}">
                            <i class="bi {{ $card['icon'] }}"></i>
                        </div>

                        <span class="badge rounded-pill bg-light text-muted">
                            {{ strtoupper($card['key']) }}
                        </span>

                    </div>

                    {{-- Label --}}
                    <div class="text-muted fw-semibold small text-uppercase flex-grow-1">
                        {{ $card['label'] }}
                    </div>

                    {{-- Value --}}
                    <div class="display-6 fw-bold mt-3" data-user-stat="{{ $card['key'] }}">
                        —
                    </div>

                </div>

            </div>

        </div>
    @endforeach

</div>
