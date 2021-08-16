<?php
return [
    'codepen' => [
        'label' => 'Codepen',
        'url' => 'http://codepen.io/api/oembed',
        'patterns' => [
            '|^https?://codepen\\.io/.*$|i',
        ],
    ],
    'facebook' => [
        'label' => 'Facebook',
        'url' => 'https://www.facebook.com/plugins/post/oembed.json',
        'patterns' => [
            '|^https?://www\\.facebook\\.com/.*/posts/.*$|i',
            '|^https?://www\\.facebook\\.com/photos/.*$|i',
            '|^https?://www\\.facebook\\.com/.*/photos/.*$|i',
            '|^https?://www\\.facebook\\.com/photo\\.php.*$|i',
            '|^https?://www\\.facebook\\.com/photo\\.php$|i',
            '|^https?://www\\.facebook\\.com/.*/activity/.*$|i',
            '|^https?://www\\.facebook\\.com/permalink\\.php$|i',
            '|^https?://www\\.facebook\\.com/media/set\\?set\\=.*$|i',
            '|^https?://www\\.facebook\\.com/questions/.*$|i',
            '|^https?://www\\.facebook\\.com/notes/.*/.*/.*$|i',
        ],
    ],
    'facebookVideo' => [
        'label' => 'Facebook Video',
        'url' => 'https://www.facebook.com/plugins/video/oembed.json',
        'patterns' => [
            '|^https?://www\\.facebook\\.com/.*/videos/.*$|i',
            '|^https?://www\\.facebook\\.com/video\\.php$|i',
        ],
    ],
    'giphy' => [
        'label' => 'Giphy',
        'url' => 'https://giphy.com/services/oembed',
        'patterns' => [
            '|^https?://giphy\\.com/gifs/.*$|i',
            '|^https?://gph\\.is/.*$|i',
            '|^https?://media\\.giphy\\.com/media/.*/giphy\\.gif$|i',
        ],
    ],
    'instagram' => [
      'label' => 'Instagram',
      'url' => 'https://api.instagram.com/oembed',
      'patterns' => [
        '|^https?://instagram\\.com/.*/p/.*,$|i',
        '|^https?://www\\.instagram\\.com/.*/p/.*,$|i',
        '|^https?://instagram\\.com/p/.*$|i',
        '|^https?://instagr\\.am/p/.*$|i',
        '|^https?://www\\.instagram\\.com/p/.*$|i',
        '|^https?://www\\.instagr\\.am/p/.*$|i',
        '|^https?://instagram\\.com/tv/.*$|i',
        '|^https?://instagr\\.am/tv/.*$|i',
        '|^https?://www\\.instagram\\.com/tv/.*$|i',
        '|^https?://www\\.instagr\\.am/tv/.*$|i',
      ],
    ],
    'issuu' => [
      'label' => 'Issuu',
      'url' => 'https://issuu.com/oembed',
      'patterns' => [
          '|^https?://issuu\\.com/.*/docs/.*$|i',
      ],
    ],
    'kickstarter' => [
        'label' => 'Kickstarter',
        'url' => 'http://www.kickstarter.com/services/oembed',
        'patterns' => [
            '|^https?://www\\.kickstarter\\.com/projects/.*$|i',
        ],
    ],
    'nasjonalbiblioteket' => [
        'label' => 'Nasjonalbiblioteket',
        'url' => 'https://api.nb.no/catalog/v1/oembed',
        'patterns' => [
            '|^https?://www\\.nb\\.no/items/.*$|i',
        ],
    ],
    'reddit' => [
        'label' => 'Reddit',
        'url' => 'https://www.reddit.com/oembed',
        'patterns' => [
            '|^https?://reddit\\.com/r/.*/comments/.*/.*$|i',
            '|^https?://www\\.reddit\\.com/r/.*/comments/.*/.*$|i',
        ],
    ],
    'slideshare' => [
        'label' => 'Slideshare',
        'url' => 'http://www.slideshare.net/api/oembed/2',
        'patterns' => [
            '|^https?://www\\.slideshare\\.net/.*/.*$|i',
            '|^https?://fr\\.slideshare\\.net/.*/.*$|i',
            '|^https?://de\\.slideshare\\.net/.*/.*$|i',
            '|^https?://es\\.slideshare\\.net/.*/.*$|i',
            '|^https?://pt\\.slideshare\\.net/.*/.*$|i',
        ],
    ],
    'soundcloud' => [
        'label' => 'Soundcloud',
        'url' => 'https://soundcloud.com/oembed',
        'patterns' => [
            '|^https?://soundcloud\\.com/.*$|i',
        ],
    ],
    'spotify' => [
        'label' => 'Spotify',
        'url' => 'https://embed.spotify.com/oembed/',
        'patterns' => [
            '|^https?://.*\\.spotify\\.com/.*$|i',
            '|^https?://spotify\\:.*$|i',
        ],
    ],
    'ted' => [
        'label' => 'TED',
        'url' => 'https://www.ted.com/services/v1/oembed.json',
        'patterns' => [
            '|^https?://ted\\.com/talks/.*$|i',
            '|^https?://www\\.ted\\.com/talks/.*$|i',
        ],
    ],
    'nytimes' => [
        'label' => 'NY Times',
        'url' => 'https://www.nytimes.com/svc/oembed/json/',
        'patterns' => [
            '|^https?://www\\.nytimes\\.com/svc/oembed$|i',
            '|^https?://nytimes\\.com/.*$|i',
            '|^https?://.*\\.nytimes\\.com/.*$|i',
        ],
    ],
    'tiktok' => [
        'label' => 'TikTok',
        'url' => 'https://www.tiktok.com/oembed',
        'patterns' => [
            '|^https?://www\\.tiktok\\.com/.*/video/.*$|i',
            '|^https?://.*\\.tiktok\\.com/.*$|i',
        ],
    ],
    'twitch' => [
        'label' => 'Twitch',
        'url' => 'https://api.twitch.tv/v5/oembed',
        'patterns' => [
            '|^https?://clips\\.twitch\\.tv/.*$|i',
            '|^https?://www\\.twitch\\.tv/.*$|i',
            '|^https?://twitch\\.tv/.*$|i',
        ],
    ],
    'twitter' => [
        'label' => 'Twitter',
        'url' => 'https://publish.twitter.com/oembed',
        'patterns' => [
            '|^https?://twitter\\.com/.*/status/.*$|i',
            '|^https?://.*\\.twitter\\.com/.*/status/.*$|i',
        ],
    ],
    'vimeo' => [
        'label' => 'Vimeo',
        'url' => 'https://vimeo.com/api/oembed.json',
        'patterns' => [
            '|^https?://vimeo\\.com/.*$|i',
            '|^https?://vimeo\\.com/album/.*/video/.*$|i',
            '|^https?://vimeo\\.com/channels/.*/.*$|i',
            '|^https?://vimeo\\.com/groups/.*/videos/.*$|i',
            '|^https?://vimeo\\.com/ondemand/.*/.*$|i',
            '|^https?://player\\.vimeo\\.com/video/.*$|i',
        ],
    ],
    'youtube' => [
        'label' => 'Youtube',
        'url' => 'https://www.youtube.com/oembed',
        'patterns' => [
            '|^https?://.*\\.youtube\\.com/watch.*$|i',
            '|^https?://.*\\.youtube\\.com/v/.*$|i',
            '|^https?://youtu\\.be/.*$|i',
            '|^https?://.*\\.youtube\\.com/playlist\\?.*$|i',
        ],
    ],
    'jsbin' => [
        'label' => 'JS Bin',
        'url' => 'http://jsbin.com/oembed',
        'patterns' => [
            '|^https?://output\\.jsbin\\.com/.*$|i',
        ],
    ],
    'imgur' => [
        'label' => 'Imgur',
        'url' => 'https://api.imgur.com/oembed',
        'patterns' => [
            '|^https?://imgur\\.com/.*$|i',
            '|^https?://i\\.imgur\\.com/.*$|i',
        ]
    ],
];
