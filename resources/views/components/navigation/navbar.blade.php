<div class="sticky top-0 z-50">
    <div class="navbar bg-base-300">
        <div class="navbar-start">
            <img src="{{ asset('img/Logo.svg') }}" class="w-12 h-12" alt="Logo">
            <a class="sm:visible invisible btn btn-ghost text-xl">{{ config('app.name') }}</a>
        </div>
        <div class="sm:navbar-end navbar-center md:mr-12 mr-0">
            <div class="flex items-center space-x-1">
                <i class="icon-disc-3"></i>
                <p>{!! __('pages/navbar.playlist_track_count', ['count' => spotify()->getAmountOfTracksInPlaylist()]) !!}</p>
            </div>
        </div>
    </div>
</div>

<!-- Content -->
<div class="content transition-all duration-200 ease-in-out pt-7 px-2 md:px-5 pb-4">

    {{ $content }}

</div>
