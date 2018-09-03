<?php
// Composer
require_once 'vendor/autoload.php';

use RestCord\DiscordClient;
use Wohali\OAuth2\Client\Provider\Discord;

// Config
require_once 'config.php';

// Session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$provider = new Discord([
    'clientId'     => config('discord_application.clientId'),
    'clientSecret' => config('discord_application.clientSecret'),
    'redirectUri'  => createPath('discord.php'),
]);

/**
 * Store the token in the user's cookies
 * @param $token \League\OAuth2\Client\Token\AccessToken
 */
function storeToken($token) {
    try {
        setcookie('discord_token', encrypt(json_encode($token->jsonSerialize())));
    } catch (\Defuse\Crypto\Exception\EnvironmentIsBrokenException $e) {
        error_log('Could not encrypt token: ' . $e);
        die('Could not properly encrypt token');
    }
}

/**
 * Delete the token from the user's cookies
 */
function deleteToken() {
    setcookie('discord_token', '', time() - 3600);
}

/**
 * Gets the token from the user's cookies
 * Will redirect to discord.php get a new one as needed
 * @return \League\OAuth2\Client\Token\AccessToken
 */
function getToken() {
    global $token, $provider;
    if (!isset($_COOKIE['discord_token'])) {
        // Token cookie is not set, let's make them authenticate with Discord
        header('Location: ' . createPath('discord.php'));
        exit();
    }

    if (isset($token) && $token != null) {
        return $token;
    }

    // Decrypt the token json
    try {
        $json = json_decode(decrypt($_COOKIE['discord_token']), true);
    } catch (Exception $e) {
        // Invalid token (could not decrypt)
        // So we'll unset the token and make them authenticate with Discord again
        deleteToken();
        header('Location: ' . createPath('discord.php'));
        exit();
    }

    // Turn the JSON serialized token back to an AccessToken
    $token = new \League\OAuth2\Client\Token\AccessToken($json);

    // Refresh the token if needed
    if ($token->hasExpired()) {
        $newToken = $provider->getAccessToken('refresh_token', [
            'refresh_token' => $token->getRefreshToken()
        ]);
        storeToken($newToken);
        $token = $newToken;
    }
    return $token;
}

function getDiscord() {
    return new DiscordClient(['token' => getToken()->getToken(), 'tokenType' => 'OAuth']);
}

function getBotDiscord() {
    static $botDiscord;
    if (!isset($botDiscord) || !$botDiscord) {
        $botDiscord = new DiscordClient(['token' => config('discord_application.bot_token')]);
    }
    return $botDiscord;
}

// https://discordapp.com/developers/docs/topics/permissions#permissions-bitwise-permission-flags
define('MANAGE_GUILD', 0x00000020);

function validateId($id){
    global $discord, $guild;
    if (is_numeric($id)) {
        $id = (int) $id;
        if (!isset($discord)) {
            $discord = getDiscord();
        }
        $guilds = $discord->user->getCurrentUserGuilds([]);
        foreach ($guilds as $aGuild) {
            if ($aGuild->id == $id) {
                $guild = $aGuild;
                break;
            }
        }

        if (isset($guild)) {
            // Check for MANAGE GUILD permissions
            if (($guild->permissions & MANAGE_GUILD) != 0) {
                return true;
            }
        }
    }
    return false;
}

function botHasGuild($guildId) {
    $botDiscord = getBotDiscord();
    try {
        $guild = $botDiscord->guild->getGuild(['guild.id' => (int) $guildId]);
    } catch (Exception $e) {
        return false;
    }
    return $guild != null;
}

function getTextChannelsIdMapped($guildId) {
    $botDiscord = getBotDiscord();
    // Get
    $guildChannels = @$botDiscord->guild->getGuildChannels(['guild.id' => (int)$guildId]);
    // Filter so it's only text and categories
    $guildChannels = array_filter($guildChannels, function ($channel) {
        // https://discordapp.com/developers/docs/resources/channel#channel-object-channel-types
        return $channel->type == 0 || $channel->type == 4;
    });
    // Map to ids
    $mapped = array();
    foreach ($guildChannels as $channel) {
        $mapped[$channel->id] = $channel;
    }
    return $mapped;
}

function getTextChannelsCategorized($guildId) {
    global $mapped;
    $mapped = getTextChannelsIdMapped($guildId);
    // Map to parent ids
    $mapped2 = array();
    foreach ($mapped as $channel) {
        if ($channel->type == 0) {
            $parentId = @$channel->parent_id;
            if (array_key_exists($parentId, $mapped2)) {
                $mapped2[$parentId][] = $channel;
            } else {
                $mapped2[$parentId] = array();
                $mapped2[$parentId][] = $channel;
            }
        }
    }
    // Now sort categories
    uksort($mapped2, function($a, $b) {
        global $mapped;
        return $mapped[$a]->position - $mapped[$b]->position;
    });
    return $mapped2;
}