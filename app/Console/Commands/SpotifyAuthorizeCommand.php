<?php

namespace App\Console\Commands;

use App\Facades\SpotifyManager;
use Illuminate\Console\Command;

class SpotifyAuthorizeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swf:spotify:authorize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Authorize with the Spotify API.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Laravel\Prompts\info("
 .d88888b                      dP   oo .8888b
88.    '\"'                     88      88   \"
`Y88888b. 88d888b. .d8888b. d8888P dP 88aaa  dP    dP
      `8b 88'  `88 88'  `88   88   88 88     88    88
d8'   .8P 88.  .88 88.  .88   88   88 88     88.  .88
 Y88888P  88Y888P' `88888P'   dP   dP dP     `8888P88
          88                                      .88
          dP                                  d8888P
        ");

        if (config('spotify.auth.client_id') === "" || config('spotify.auth.client_secret') === "" || config('spotify.callback.redirect_uri') === "") {
            $this->error('Please set the SPOTIFY_CLIENT_ID, SPOTIFY_CLIENT_SECRET and SPOTIFY_REDIRECT_URI in your .env file');
            return;
        }

        $url = SpotifyManager::generateAuthLink();

        \Laravel\Prompts\info('Your authentication url: ' . $url);
    }
}
