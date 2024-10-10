<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    |
    | The Client ID and Client Secret of your Spotify App.
    |
    */
    'auth' => [
        'client_id' => env('SPOTIFY_CLIENT_ID'),
        'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
    ],

    'callback' => [
        'redirect_uri' => env('SPOTIFY_REDIRECT_URI')
    ],

    'playlists' => [
        'id' => env('SPOTIFY_PLAYLIST_ID'),
        'max_tracks' => env('SPOTIFY_PLAYLIST_MAX_TRACKS', 100),
    ],
];
