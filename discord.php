<?php
// Composer
require_once 'vendor/autoload.php';
// Config
require_once 'config.php';

// Session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Discord ($provider)
require_once 'discord_token.php';

// This part of the code is based off of https://github.com/wohali/oauth2-discord-new 's README.MD

if (isset($_COOKIE['discord_token'])) {
    // They already have a token, lets check if it can be decrypted
    try {
        decrypt($_COOKIE['discord_token']);
        header('Location: ' . createPath('server.php'));
    } catch (Exception $e) {
        // Invalid, delete it and reauthenticate
        deleteToken();
        header('Location: ' . createPath('discord.php'));
    }
    exit();
}

if (!isset($_GET['code'])) {
    // == STEP 1 ==
    // We need to redirect them to Discord Authentication
    $authUrl = $provider->getAuthorizationUrl([
        'scope' => ['identify', 'guilds']
    ]);
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    ?>
    <div style="font-weight: bold;">Invalid State Error</div>, please <a href="<?=createPath('discord.php')?>">try again</a>.
    <?php
} else {
    // == STEP 2 ==

    // Get token
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Set cookie to encrypted token
    storeToken($token);

    // Redirect to server selection
    header('Location: ' . createPath('server.php'));
}