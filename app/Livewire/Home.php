<?php

namespace App\Livewire;

use App\Facades\SpotifyManager;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Exception;
use Filament\Notifications\Notification;
use Livewire\Component;

class Home extends Component
{
    use WithRateLimiting;

    public $searchTerm = "";
    public $songs = [];
    public $rateLimitTime;

    public function addSong($trackUri): void
    {
        if ($this->setRateLimit()) {
            return;
        }

        try {
            if (SpotifyManager::getIsMaxTracksExceeded()) {
                Notification::make()
                    ->danger()
                    ->title(__('messages.notifications.tracks_limit_reached.title'))
                    ->body(__('messages.notifications.tracks_limit_reached.body'))
                    ->send();

                $this->redirect(route('home'), true);
                return;
            }
            SpotifyManager::addTrackToPlaylist($trackUri);

            Notification::make()
                ->success()
                ->title(__('messages.notifications.track_added.title'))
                ->body(__('messages.notifications.track_added.body'))
                ->send();
        } catch (Exception) {
            Notification::make()
                ->danger()
                ->title(__('messages.notifications.cannot_add_track.title'))
                ->body(__('messages.notifications.cannot_add_track.body'))
                ->send();
        }

        $this->redirect(route('home'), true);
    }

    public function search(): void
    {
        if (empty($this->searchTerm)) {
            return;
        }

        if ($this->setRateLimit()) {
            return;
        }

        $this->songs = SpotifyManager::searchTracks($this->searchTerm);
    }

    public function setRateLimit(): bool
    {
        try {
            $this->rateLimit(20, "60");
        } catch (TooManyRequestsException $exception) {
            $this->rateLimitTime = $exception->secondsUntilAvailable;

            return true;
        }

        return false;
    }

    public function render()
    {
        return view('livewire.home');
    }
}
