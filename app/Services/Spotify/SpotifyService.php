<?php

namespace App\Services\Spotify;

use Aerni\Spotify\Exceptions\SpotifyApiException;
use Aerni\Spotify\Exceptions\ValidatorException;
use Aerni\Spotify\Facades\SpotifyFacade;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\SpotifyWebAPIException;

class SpotifyService
{
    public string $playlistId;
    private Session $session;

    /**
     * SpotifyService constructor.
     */
    public function __construct()
    {
        $this->playlistId = config('spotify.playlists.id');

        $this->session = new Session(
            config('spotify.auth.client_id'),
            config('spotify.auth.client_secret'),
            config('spotify.callback.redirect_uri')
        );
    }

    /**
     * Search for tracks on Spotify.
     *
     * @param string $searchTerm
     * @return array
     * @throws Exception
     */
    public function searchTracks(string $searchTerm): array
    {
        try {
            return SpotifyFacade::searchTracks($searchTerm)->limit(12)->get()['tracks']['items'];
        } catch (SpotifyApiException | ValidatorException $e) {
            throw new Exception($e);
        }
    }

    /**
     * Get the access token for Spotify API.
     *
     * @return string
     */
    public function getAccessToken(): string
    {
        $accessToken = Cache::get('spotify.auth.access_token');
        $refreshToken = Cache::get('spotify.auth.refresh_token');

        if (!$accessToken || $this->isTokenExpired($accessToken)) {
            $this->session->refreshAccessToken($refreshToken);

            $accessToken = $this->session->getAccessToken();

            Cache::put('spotify.auth.access_token', $accessToken, 3600);
        }

        return $accessToken;
    }

    /**
     * Check if the access token is expired.
     *
     * @param string $accessToken
     * @return bool
     */
    private function isTokenExpired(string $accessToken): bool
    {
        $api = new SpotifyWebAPI();
        try {
            $api->setAccessToken($accessToken);
            $api->me();

            return false;
        } catch (SpotifyWebAPIException $e) {
            return true;
        }
    }

    /**
     * Add a track to the Spotify playlist.
     *
     * @param string $trackUri
     */
    public function addTrackToPlaylist(string $trackUri): void
    {
        $api = new SpotifyWebAPI();

        $accessToken = $this->getAccessToken();

        $api->setAccessToken($accessToken);

        if ($this->isAlreadyInPlaylist($trackUri)) {
            return;
        }

        $api->addPlaylistTracks($this->playlistId, [$trackUri]);
    }

    /**
     * Check if a track is already in the Spotify playlist.
     *
     * @param string $trackUri
     * @return bool
     */
    private function isAlreadyInPlaylist(string $trackUri): bool
    {
        foreach (SpotifyFacade::playlist($this->playlistId)->fields('tracks')->get() as $playlist) {
            foreach ($playlist['items'] as $item) {
                if ($item['track']['uri'] === $trackUri) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Check if the maximum number of tracks in the Spotify playlist is exceeded.
     *
     * @return bool
     */
    public function getIsMaxTracksExceeded(): bool
    {
        return $this->getAmountOfTracksInPlaylist() >= config('spotify.playlists.max_tracks');
    }

    /**
     * Generate the authentication link for Spotify.
     *
     * @return string
     */
    public function generateAuthLink(): string
    {
        return $this->session->getAuthorizeUrl([
            'scope' => [
                'playlist-modify-public',
                'playlist-modify-private',
                'playlist-read-private',
                'playlist-read-collaborative',
            ],
        ]);
    }

    /**
     * Get the number of tracks in the Spotify playlist.
     *
     * @return int
     */
    public function getAmountOfTracksInPlaylist(): int
    {
        $size = 0;

        foreach (SpotifyFacade::playlist($this->playlistId)->fields('tracks')->get() as $playlist) {
            foreach ($playlist['items'] as $item) {
                unset($item);
                $size++;
            }
        }

        return $size;
    }

    /**
     * Handle the Spotify callback.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function handleSpotifyCallback(Request $request): RedirectResponse
    {
        $this->session->requestAccessToken($request->get('code'));

        $accessToken = $this->session->getAccessToken();
        $refreshToken = $this->session->getRefreshToken();

        Cache::put('spotify.auth.access_token', $accessToken, 3600);
        Cache::put('spotify.auth.refresh_token', $refreshToken, 3600);

        return redirect()->to(route('home'));
    }
}
