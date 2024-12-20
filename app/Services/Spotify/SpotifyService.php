<?php

namespace App\Services\Spotify;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\SpotifyWebAPIAuthException;
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
        $this->playlistId = config('swf.playlists.id');

        $this->session = new Session(
            config('swf.spotify.client_id'),
            config('swf.spotify.client_secret'),
            config('swf.callback.redirect_uri')
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
        $api = new SpotifyWebAPI();
        $api->setAccessToken($this->getAccessToken());

        return json_decode(json_encode($api->search($searchTerm, ['track'], ['limit' => 12])->tracks->items), true);
    }

    /**
     * Get the access token for Spotify API.
     *
     * @return string
     */
    private function getAccessToken(): string
    {
        $accessToken = Cache::get('swf.spotify.access_token');
        $refreshToken = Cache::get('swf.spotify.refresh_token');

        if (!$accessToken || $this->isTokenExpired($accessToken)) {

            $this->session->refreshAccessToken($refreshToken);

            $accessToken = $this->session->getAccessToken();

            Cache::put('swf.spotify.access_token', $accessToken, 3600);
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
        } catch (SpotifyWebAPIException) {
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
        $api->setAccessToken($this->getAccessToken());

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
        $api = new SpotifyWebAPI();
        $api->setAccessToken($this->getAccessToken());

        $offset = 0;
        $limit = 100;

        do {
            $tracks = $api->getPlaylistTracks($this->playlistId, [
                'offset' => $offset,
                'limit' => $limit,
                'fields' => 'items(track(uri))'
            ]);

            foreach ($tracks->items as $item) {
                if ($item->track->uri === $trackUri) {
                    return true;
                }
            }

            $offset += $limit;
        } while (count($tracks->items) === $limit);

        return false;
    }

    /**
     * Check if the maximum number of tracks in the Spotify playlist is exceeded.
     *
     * @return bool
     */
    public function getIsMaxTracksExceeded(): bool
    {
        return $this->getAmountOfTracksInPlaylist() >= config('swf.playlists.max_tracks');
    }

    /**
     * Generate the authentication link for Spotify.
     *
     * @return string
     */
    public function generateAuthLink(): string
    {
        $scopes = [
            'playlist-modify-public',
            'playlist-modify-private',
            'playlist-read-private',
            'playlist-read-collaborative',
        ];

        if (config('swf.show_active_track')) {
            $scopes[] = 'user-read-playback-state';
        }

        return $this->session->getAuthorizeUrl([
            'scope' => $scopes,
        ]);
    }

    /**
     * Get the number of tracks in the Spotify playlist.
     *
     * @return int
     */
    public function getAmountOfTracksInPlaylist(): int
    {
        $api = new SpotifyWebAPI();
        $api->setAccessToken($this->getAccessToken());

        $total = $api->getPlaylistTracks($this->playlistId, [
            'fields' => 'total'
        ]);

        return $total->total;
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

        Cache::put('swf.spotify.access_token', $accessToken, 3600);
        Cache::put('swf.spotify.refresh_token', $refreshToken, 3600);

        return redirect()->to(route('home'));
    }

    /**
     * Refresh the access token.
     *
     * @return void
     */
    public function refreshToken(): void
    {
        $accessToken = Cache::get('swf.spotify.access_token');
        $refreshToken = Cache::get('swf.spotify.refresh_token');

        if (!$accessToken || $this->isTokenExpired($accessToken)) {
            $this->session->refreshAccessToken($refreshToken);
            $accessToken = $this->session->getAccessToken();
            $refreshToken = $this->session->getRefreshToken();

            Cache::put('swf.spotify.access_token', $accessToken, 3600);
            Cache::put('swf.spotify.refresh_token', $refreshToken, 3600);
        }
    }

    /**
     * Check if the user is connected to Spotify.
     *
     * @return bool
     */
    public function isConnected(): bool
    {
        try {
            $api = new SpotifyWebAPI();
            $api->setAccessToken($this->getAccessToken());
            $api->me();
        } catch (SpotifyWebAPIAuthException) {
            return false;
        }

        return true;
    }

    /**
     * Get the current track from Spotify.
     *
     * @return array
     */
    public function getCurrentTrack(): array
    {
        $api = new SpotifyWebAPI();
        $api->setAccessToken($this->getAccessToken());

        $devices = $api->getMyDevices()->devices;
        $activeDeviceType = null;

        foreach ($devices as $device) {
            if ($device->is_active) {
                $activeDeviceType = $device->type;
                break;
            }
        }

        $currentTrack = json_decode(json_encode($api->getMyCurrentTrack()), true);
        $currentTrack['active_device_type'] = $activeDeviceType;

        return $currentTrack;
    }
}
