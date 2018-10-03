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
            'welcome_purr.png' => 'purr',
            'welcome_gradient.png' => 'gradient',
            'welcome_landscape.png' => 'landscape',
            'welcome_red.png' => 'red',
            'welcome_green.png' => 'green',
            'welcome_blue.png' => 'blue',
            'welcome_neko_cat.png' => 'neko1',
            'welcome_neko.png' => 'neko2',
            'welcome_gradient_blue.png' => 'gradient_blue',
            'welcome_gradient_orange.png' => 'gradient_orange',
            'welcome_gradient_green.png' => 'gradient_green',
            'welcome_gradient_red.png' => 'gradient_red1',
            'welcome_gradient_dark_red.png' => 'gradient_red2',
            'welcome_wood_grey.png' => 'wood1',
            'welcome_wood_dark_grey.png' => 'wood2',
            'welcome_wodd.png' => 'wood3',
            'welcome_dots_blue.png' => 'dots_blue',
            'welcome_dots_green.png' => 'dots_green',
            'welcome_dots_orange.png' => 'dots_orange',
            'welcome_dots_pink.png' => 'dots_pink',
            'welcome_dots_red.png' => 'dots_red',
			'welcome_random.png' => 'random'
        )
    )
);

// DO NOT EDIT BELOW THIS LINE
require_once 'config_helper.php';