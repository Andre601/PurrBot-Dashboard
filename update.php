<?php
// Config
require_once 'config.php';

// Session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Discord ($provider)
require_once 'discord_token.php';

// RethinkDB
require_once 'rethinkdb_connection.php';

$id = $_COOKIE['server'];
if (!isset($id) || !validateId($id)) {
    exit();
}

function error($msg) {
    http_response_code(400);
    exit($msg);
}

// Check that nothing is empty/not set (welcome-channel can be empty)
$keys = ['prefix', 'welcome-color', 'welcome-image'];
foreach ($keys as $key) {
    if (!isset($_POST[$key]) || empty($_POST[$key])) {
        error('The ' . $key . ' is needed');
    }
}

// Set variables from POST data
$prefix = $_POST['prefix'];
$welcome_channel = $_POST['welcome-channel'];
$welcome_color = $_POST['welcome-color'];
$welcome_image = $_POST['welcome-image'];

// Default to none for welcome channel
if (!$welcome_channel) {
    $welcome_channel = 'none';
}

// Validate options

// rgb:$$$,$$$,$$$ or hex:#$$$$$$ or hex:#$$$
if (!preg_match('/(rgb:\d{1,3},\d{1,3},\d{1,3}|hex:(#)?[0-9a-fA-F]{3,6})/m', $welcome_color)) {
    error('Invalid welcome color. It must be in a format similar to <code>rgb:20,100,30</code> or <code>hex:#ffffff</code>.');
}

// Validate Image
$images = config('imageSelect.images');
$valid = false;
// Using $realImage in case the 'case' doesn't match (lol)
$realImage = null;
foreach ($images as $image) {
    if (strcasecmp($image, $welcome_image) == 0) {
        $realImage = $image;
        $valid = true;
        break;
    }
}

if (!$valid) {
    error('That image does not exist');
}

try {
    updateServerData([
        'id' => $id,
        'prefix' => $prefix,
        'welcome_channel' => $welcome_channel,
        'welcome_color' => $welcome_color,
        'welcome_image' => $realImage
    ]);
    echo 'Successfully updated server settings!';
} catch (Exception $e) {
    error_log('Failed to update server data for ' . $id . ' because ' . $e);
    error('A server error has occurred when updating server settings!');
}