<?php
// Composer
require_once 'vendor/autoload.php';
// Config
require_once 'config.php';
// Discord
require_once 'discord_token.php';

deleteToken();
header('Location: ' . createPath(''));