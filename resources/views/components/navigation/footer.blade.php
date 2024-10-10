<footer class="footer footer-center bg-base-300 text-base-content p-4 mt-auto">
    <aside class="flex md:flex-row flex-col justify-between items-center w-full">
        <div>
            @if(spotify()->isConnected())
                <p>{{ __('pages/footer.status.text') }} <b class="text-green-400">{{ __('pages/footer.status.connected') }}</b></p>
            @else
                <p>{{ __('pages/footer.status.text') }} <b class="text-red-400">{{ __('pages/footer.status.disconnected') }}</b></p>
            @endif
        </div>
        <div class="text-center">
            <p>{!! __('pages/footer.text', ['year' => date('Y'), 'name' => config('app.name')]) !!}</p>
        </div>
        <div>
            <p>{!! __('pages/footer.ping', ['ping' => number_format((microtime(true) - LARAVEL_START) * 1000, 2)]) !!}</p>
        </div>
    </aside>
</footer>
