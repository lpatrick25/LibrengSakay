{{-- =======================================================================
    Skeleton Loader
    Matches the actual Applicant Registration landing page
======================================================================= --}}

{{-- Hero Banner --}}
<div class="card hero-card border-0 shadow-lg rounded-4 mb-4 overflow-hidden">
    <div class="card-body p-4 p-lg-5">

        <div class="text-center">

            <div class="skeleton skeleton-circle mx-auto mb-4" style="width:90px;height:90px;"></div>

            <div class="skeleton skeleton-text mx-auto mb-3" style="width:340px;max-width:80%;height:34px;"></div>

            <div class="skeleton skeleton-text mx-auto mb-2" style="width:600px;max-width:95%;height:16px;"></div>

            <div class="skeleton skeleton-text mx-auto" style="width:420px;max-width:75%;height:16px;"></div>

        </div>

    </div>
</div>

{{-- Category Cards --}}
<div class="row g-4 mb-4">

    @for ($i = 0; $i < 3; $i++)
        <div class="col-lg-4">

            <div class="card border-0 rounded-4 shadow-sm overflow-hidden h-100">

                <div class="card-body p-4 text-center">

                    <div class="skeleton skeleton-circle mx-auto mb-4" style="width:72px;height:72px;"></div>

                    <div class="skeleton skeleton-text mx-auto mb-3" style="width:70%;height:22px;"></div>

                    <div class="skeleton skeleton-text mx-auto mb-2" style="width:100%;height:12px;"></div>

                    <div class="skeleton skeleton-text mx-auto mb-2" style="width:90%;height:12px;"></div>

                    <div class="skeleton skeleton-text mx-auto" style="width:75%;height:12px;"></div>

                    <div class="mt-4">

                        <div class="skeleton rounded-pill mx-auto" style="width:110px;height:32px;"></div>

                    </div>

                </div>

            </div>

        </div>
    @endfor

</div>

{{-- Continue Button --}}
<div class="text-center mb-4">

    <div class="skeleton rounded-pill mx-auto" style="width:220px;height:54px;"></div>

</div>

{{-- Information Card --}}
<div class="card border-0 rounded-4 shadow-sm overflow-hidden">

    <div class="card-body p-4">

        <div class="skeleton skeleton-text mb-3" style="width:220px;height:24px;"></div>

        @for ($i = 0; $i < 4; $i++)
            <div class="skeleton skeleton-text mb-2" style="width:100%;height:14px;"></div>
        @endfor

    </div>

</div>
