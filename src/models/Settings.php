<?php
/**
 * Craft oEmbed plugin for Craft CMS 3.x
 *
 * @link      https://anti.as
 * @copyright Copyright (c) 2021 Lasse Mejlvang Tvedt
 */

namespace anti\oembed\models;

use craft\base\Model;
use craft\helpers\ConfigHelper;

/**
 * Settings Model
 *
 * @author    Lasse Mejlvang Tvedt
 * @package   craft-oembed
 * @since     1.0.0
 */
class Settings extends Model
{
  /**
   * @var array Additional providers.
   */
  public $providers = [];

  /**
   * @var array Default providers.
   */
  public $defaultProviders = [
    'codepen' => [
      'label' => 'Codepen',
      'endpoint' => 'http://codepen.io/api/oembed',
      'patterns' => [
        '|^https?://codepen\\.io/.*$|i',
      ],
    ],
    'facebook' => [
      'label' => 'Facebook',
      'endpoint' => 'https://graph.facebook.com/v11.0/oembed_post',
      'tokenKey' => 'access_token',
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
      'endpoint' => 'https://graph.facebook.com/v11.0/oembed_video.json',
      'tokenKey' => 'access_token',
      'patterns' => [
        '|^https?://www\\.facebook\\.com/.*/videos/.*$|i',
        '|^https?://www\\.facebook\\.com/video\\.php$|i',
      ],
    ],
    'giphy' => [
      'label' => 'Giphy',
      'endpoint' => 'https://giphy.com/services/oembed',
      'patterns' => [
        '|^https?://giphy\\.com/gifs/.*$|i',
        '|^https?://gph\\.is/.*$|i',
        '|^https?://media\\.giphy\\.com/media/.*/giphy\\.gif$|i',
      ],
    ],
    'instagram' => [
      'label' => 'Instagram',
      'endpoint' => 'https://graph.facebook.com/v11.0/instagram_oembed',
      'tokenKey' => 'access_token',
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
      'endpoint' => 'https://issuu.com/oembed',
      'patterns' => [
        '|^https?://issuu\\.com/.*/docs/.*$|i',
      ],
    ],
    'kickstarter' => [
      'label' => 'Kickstarter',
      'endpoint' => 'http://www.kickstarter.com/services/oembed',
      'patterns' => [
        '|^https?://www\\.kickstarter\\.com/projects/.*$|i',
      ],
    ],
    // 'nasjonalbiblioteket' => [
    //   'label' => 'Nasjonalbiblioteket',
    //   'endpoint' => 'https://api.nb.no/catalog/v1/oembed',
    //   'patterns' => [
    //     '|^https?://www\\.nb\\.no/items/.*$|i',
    //   ],
    // ],
    'reddit' => [
      'label' => 'Reddit',
      'endpoint' => 'https://www.reddit.com/oembed',
      'patterns' => [
        '|^https?://reddit\\.com/r/.*/comments/.*/.*$|i',
        '|^https?://www\\.reddit\\.com/r/.*/comments/.*/.*$|i',
      ],
    ],
    'slideshare' => [
      'label' => 'Slideshare',
      'endpoint' => 'http://www.slideshare.net/api/oembed/2',
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
      'endpoint' => 'https://soundcloud.com/oembed',
      'patterns' => [
        '|^https?://soundcloud\\.com/.*$|i',
      ],
    ],
    'spotify' => [
      'label' => 'Spotify',
      'endpoint' => 'https://embed.spotify.com/oembed/',
      'patterns' => [
        '|^https?://.*\\.spotify\\.com/.*$|i',
        '|^https?://spotify\\:.*$|i',
      ],
    ],
    'ted' => [
      'label' => 'TED',
      'endpoint' => 'https://www.ted.com/services/v1/oembed.json',
      'patterns' => [
        '|^https?://ted\\.com/talks/.*$|i',
        '|^https?://www\\.ted\\.com/talks/.*$|i',
      ],
    ],
    'nytimes' => [
      'label' => 'NY Times',
      'endpoint' => 'https://www.nytimes.com/svc/oembed/json/',
      'patterns' => [
        '|^https?://www\\.nytimes\\.com/svc/oembed$|i',
        '|^https?://nytimes\\.com/.*$|i',
        '|^https?://.*\\.nytimes\\.com/.*$|i',
      ],
    ],
    'tiktok' => [
      'label' => 'TikTok',
      'endpoint' => 'https://www.tiktok.com/oembed',
      'patterns' => [
        '|^https?://www\\.tiktok\\.com/.*/video/.*$|i',
        '|^https?://.*\\.tiktok\\.com/.*$|i',
      ],
    ],
    // 'twitch' => [
    //   'label' => 'Twitch',
    //   'endpoint' => 'https://api.twitch.tv/v5/oembed',
    //   'patterns' => [
    //     '|^https?://clips\\.twitch\\.tv/.*$|i',
    //     '|^https?://www\\.twitch\\.tv/.*$|i',
    //     '|^https?://twitch\\.tv/.*$|i',
    //   ],
    // ],
    'twitter' => [
      'label' => 'Twitter',
      'endpoint' => 'https://publish.twitter.com/oembed',
      'patterns' => [
        '|^https?://twitter\\.com/.*/status/.*$|i',
        '|^https?://.*\\.twitter\\.com/.*/status/.*$|i',
      ],
    ],
    'vimeo' => [
      'label' => 'Vimeo',
      'endpoint' => 'https://vimeo.com/api/oembed.json',
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
      'endpoint' => 'https://www.youtube.com/oembed',
      'patterns' => [
        '|^https?://.*\\.youtube\\.com/watch.*$|i',
        '|^https?://.*\\.youtube\\.com/v/.*$|i',
        '|^https?://youtu\\.be/.*$|i',
        '|^https?://.*\\.youtube\\.com/playlist\\?.*$|i',
      ],
    ],
    'jsbin' => [
      'label' => 'JS Bin',
      'endpoint' => 'http://jsbin.com/oembed',
      'patterns' => [
        '|^https?://jsbin\\.com/.*|i',
      ],
    ],
    'imgur' => [
      'label' => 'Imgur',
      'endpoint' => 'https://api.imgur.com/oembed',
      'patterns' => [
        '|^https?://imgur\\.com/.*$|i',
        '|^https?://i\\.imgur\\.com/.*$|i',
      ]
    ]
  ];

  /**
   * @var array Additional providers.
   */
  public $tokens = [];

  public function getProviders(): array
  {
    return array_merge($this->defaultProviders, $this->providers);
  }

  public function getToken(string $provider): string|null
  {
    return $this->tokens[$provider] ?? null;
  }
}
