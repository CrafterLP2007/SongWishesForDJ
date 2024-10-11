<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Spotify
    |--------------------------------------------------------------------------
    |
    | The Client ID and Client Secret of your Spotify App.
    | You need this information to authenticate with Spotify.
    */
    'spotify' => [
        'client_id' => env('SPOTIFY_CLIENT_ID'),
        'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Callback
    |--------------------------------------------------------------------------
    |
    | The redirect URI of your Spotify App.
    | This is where the user will be redirected after authenticating with Spotify.
    |
    */
    'callback' => [
        'redirect_uri' => env('SPOTIFY_REDIRECT_URI')
    ],

    /*
    |--------------------------------------------------------------------------
    | Playlists
    |--------------------------------------------------------------------------
    |
    | The ID of the playlist you want to use for Song Wishes.
    | The maximum number of tracks that can be added to the playlist.
    |
    */
    'playlists' => [
        'id' => env('SPOTIFY_PLAYLIST_ID'),
        'max_tracks' => env('SPOTIFY_PLAYLIST_MAX_TRACKS', 100),
    ],

    /*
    |--------------------------------------------------------------------------
    | Internal Authentication
    |--------------------------------------------------------------------------
    |
    | Here you can enable or disable the internal authentication and set the secret.
    | This can be helpful if you want to protect it from other users which should not have access to it.
    |
    */
    'auth' => [
        'enabled' => env('SWF_AUTHENTICATION_ENABLED', false),
        'secret' => env('SWF_AUTHENTICATION_SECRET'),
    ]
];
