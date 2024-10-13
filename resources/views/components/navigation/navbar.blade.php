<div class="sticky top-0 z-50">
    <div class="navbar bg-base-300 border-b border-neutral sticky top-0 z-50 backdrop-filter backdrop-blur-xl bg-opacity-30">
        <div class="navbar-start">
            <img src="{{ asset('img/Logo.svg') }}" class="w-12 h-12" alt="Logo">
            <a href="{{ route('home') }}" class="sm:visible invisible btn btn-ghost text-xl">{{ config('app.name') }}</a>
        </div>
        <div class="navbar-end">
            <div class="flex items-center gap-1 mr-2">
                <i class="icon-disc-3"></i>
                @php
                    $trackCount = cache()->remember('playlist_track_count', now()->addMinutes(5), function () {
                        return spotify()->getAmountOfTracksInPlaylist();
                    });
                @endphp

                <p class="lg:block hidden">{!! __('pages/navbar.playlist_track_count', ['count' => $trackCount]) !!}</p>
                <p class="lg:hidden block font-bold">{{ $trackCount }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Content -->
<div class="content transition-all duration-200 ease-in-out pt-7 px-2 md:px-5 pb-4">

    {{ $content }}

</div>
