# Craft oEmbed plugin for Craft CMS 3.x

A plugin that fetches and caches data from oEmbed APIs

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:
	Since this is a private package hosted on github you need to tell composer where to find this package. Add the following code to your `composer.json` (also note how craft-fetch path is also added):
	```
  "repositories": [
    {
      "type": "path",
      "url": "git@github.com:anewtypeofinterference/craft-oembed.git"
    },
    {
      "type": "vcs",
      "url": "git@github.com:anewtypeofinterference/craft-fetch.git"
    }
  ]
	```
	Note, repositories might already exisit in your project, then you just have to add the object to the exisitng property.

	Then you run `composer require anti/craft-oembed` as usual. You might get asked to authenticate yourself, if so, follow instructions from composer.

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Craft Fetch.


## Configuring Craft oEmbed


## Using Craft oEmbed
Craft oEmbed comes with a field you can create which validates and display oEmbeds in the admin panel. In the front end the field outputs the url, so you have to run it through the service to fetch the oembed data:
```
{% set oembedData = craft.oembed.get(entry.yourOembed/URLfield) %}
```
The data outputted is following the [oembed spec (see response parameters section)](https://oembed.com/)
You can also add consuomer ptions request data when fetching the data:
```
{% set oembedData = craft.oembed.get(entry.yourOembed, {
  maxwidth: 1920
}) %}
