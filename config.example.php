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
            'welcome_layer.png' => 'purr',
            'welcome_layer2.png' => 'gradient',
            'welcome_layer3.png' => 'landscape',
            'welcome_layer_red.png' => 'red',
            'welcome_layer_green.png' => 'green',
            'welcome_layer_blue.png' => 'blue',
            'welcome_layer_purr2.png' => 'neko1',
            'welcome_layer_purr3.png' => 'neko2',
            'welcome_layer8.png' => 'gradient_blue',
            'welcome_layer9.png' => 'gradient_orange',
            'welcome_layer10.png' => 'gradient_green',
            'welcome_layer11.png' => 'gradient_red1',
            'welcome_layer12.png' => 'gradient_red2',
            'welcome_layer13.png' => 'wood1',
            'welcome_layer14.png' => 'wood2',
            'welcome_layer15.png' => 'wood3',
            'welcome_layer16.png' => 'dots_blue',
            'welcome_layer17.png' => 'dots_green',
            'welcome_layer18.png' => 'dots_orange',
            'welcome_layer19.png' => 'dots_pink',
            'welcome_layer20.png' => 'dots_red'
        )
    )
);

// DO NOT EDIT BELOW THIS LINE
require_once 'config_helper.php';