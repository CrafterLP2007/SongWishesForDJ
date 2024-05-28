<div>
    @if($rateLimitTime)
        <div class="lg:w-3/4 mx-auto">
            <div class="w-full p-4">
                <div role="alert" class="alert alert-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span wire:poll.1s="setRateLimit">{!! __('pages/home.rate_limit', ['time' => $rateLimitTime]) !!}</span>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-12 flex justify-center items-center">
        <i class="icon-disc-3 disc-animation xl:text-9xl lg:text-5xl text-3xl text-center"></i>
    </div>
    <div class="flex justify-center items-center">
        <h1 class="linear-wipe h-24 text-center xl:text-7xl lg:text-5xl text-3xl font-bold"> {{ config('app.name') }}</h1>
    </div>
    <x-form class="md:flex justify-center block items-center lg:mt-12 mt-0 w-full" wire:submit="search">
        <label class="input input-bordered flex items-center md:w-1/2 w-full">
            <input wire:model="searchTerm" type="text" class="grow" placeholder="{!! __('pages/home.search.input_placeholder') !!}"/>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70">
                <path fill-rule="evenodd"
                      d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                      clip-rule="evenodd"/>
            </svg>
        </label>
        <x-button type="submit" class="btn btn-primary ml-0 w-full md:w-auto md:mt-0 mt-2" spinner="search">
            <i class="icon-search"></i>
            {{ __('pages/home.search.search_button_label') }}
        </x-button>
    </x-form>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-12 mb-4">
        @foreach($songs as $song)
            <div x-data="{ playing: false }" class="card bg-base-100 shadow-xl card-bordered border-neutral">
                <div class="card-body">
                    <h2 class="card-title">{{ $song['name'] }}</h2>
                    <div class="divider"></div>
                    <img src="{{ $song['album']['images'][0]['url'] }}" alt="Albumcover">
                    <div class="divider"></div>
                    <audio id="audio-{{ $song['id'] }}" controls="controls" class="w-full audioplayer">
                        <source src="{{ $song['preview_url'] }}" type="audio/mpeg">
                    </audio>
                    <h2 class="font-semibold mt-2">{!! __('pages/home.cards.artist') !!}</h2>
                    <div class="ml-2 mb-4">
                        @foreach($song['artists'] as $artist)
                            <p class=""><b class="text-lg">-</b> {{ $artist['name'] }}</p>
                        @endforeach
                    </div>
                </div>
                <button wire:click="addSong('{{ $song['uri']}}')" class="btn btn-primary mt-4 mb-4 mx-4">
                    <i class="icon-plus"></i>
                    {!! __('pages/home.cards.add_button_label') !!}
                </button>
            </div>
        @endforeach
    </div>
</div>

<script>
    window.addEventListener('livewire:update', () => {
        const audios = document.querySelectorAll('audio[controls]');
        audios.forEach(audio => {
            audio.addEventListener('ended', () => {
                audio.volume = 0;
            });
        });
    });
</script>

