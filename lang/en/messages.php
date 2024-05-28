<?php

return [
    'notifications' => [
        'tracks_limit_reached' => [
            'title' => 'You have reached the maximum number of tracks',
            'body' => 'You have reached the maximum number of tracks that can be added to the playlist.'
        ],
        'track_added' => [
            'title' => 'Successfully added Track',
            'body' => 'The track has been successfully added to the playlist.'
        ],
        'cannot_add_track' => [
            'title' => 'Cannot add track',
            'body' => 'A problem at spotify occurred while adding the track to the playlist. Please try again later.'
        ]
    ]
];
