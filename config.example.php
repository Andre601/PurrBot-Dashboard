<?php
/*
   Purr Dashboard Configuration

   *** Please copy config.example.php to config.php and then edit it! ***
*/
$config = array(
    // The url of this website **with leading slash**
    'base_url' => 'http://localhost/neko-bot-dashboard/',
    'github_url' => 'https://github.com',
    // Encryption key (for discord tokens)
    // Contents of the file must be generated via `./vendor/bin/generate-defuse-key`
    // e.g `./vendor/bin/generate-defuse-key > secret-key.txt`
    // **MAKE SURE THE FILE IS NOT ACCESSIBLE TO THE PUBLIC**
    'encryption_key_path' => 'secret-key.txt',
    // RethinkDB Connection Details
    'rethinkdb' => array(
        'connection' => array(
            'host' => 'localhost',
            'port' => 28015
        ),
        'structure' => array(
            'db' => 'main',
            'table' => 'guilds'
        )
    ),
    // Discord Application (https://discordapp.com/developers/applications/)
    'discord_application' => array(
        'clientId' => '',
        'clientSecret' => '',
        'bot_token' => ''
    ),
    // The settings for the welcome images
    'imageSelect' => array(
        'directory' => 'welcome-images',
        'images' => array(
		    'color_black.png' => 'color_black',
		    'color_blue.png' => 'color_blue',
		    'color_green.png' => 'color_green',
		    'color_red.png' => 'color_red',
		    'color_white.png' => 'color_white',
		    'gradient.png' => 'gradient',
		    'gradient_blue.png' => 'gradient_blue',
		    'gradient_dark_red.png' => 'gradient_dark_red',
		    'gradient_green.png' => 'gradient_green',
		    'gradient_orange.png' => 'gradient_orange',
		    'gradient_red.png' => 'gradient_red',
		    'neko_cat.png' => 'neko_cat',
		    'neko_hug.png' => 'neko_hug',
		    'neko_smiling.png' => 'neko_smiling',
		    'purr.png' => 'purr',
		    'wood.png' => 'wood',
		    'wood_bright.png' => 'wood_bright',
		    'wood_dark.png' => 'wood_dark',
		    'wood_grey.png' => 'wood_grey',
		    'random.png' => 'random'
        )
    )
);

// DO NOT EDIT BELOW THIS LINE
require_once 'config_helper.php';