<?php

namespace App\Facades;

use App\Services\Spotify\SpotifyCallbackService;
use App\Services\Spotify\SpotifyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array searchTracks(string $searchTerm)
 * @method static RedirectResponse addTrackToPlaylist(string $trackUri)
 * @method static int getAmountOfTracksInPlaylist()
 * @method static string generateAuthLink()
 * @method static bool isAlreadyInPlaylist(string $trackUri, int $offset = 0)
 * @method static bool getIsMaxTracksExceeded()
 */
class SpotifyManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SpotifyService::class;
    }
}
