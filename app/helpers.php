<?php

use App\Services\Spotify\SpotifyService;

if (!function_exists("spotify")) {
    function spotify(): SpotifyService
    {
        return new SpotifyService();
    }
}
