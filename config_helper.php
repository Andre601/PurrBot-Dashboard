<?php
// Composer
require_once 'vendor/autoload.php';

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

/**
 * @param string $key
 * @return mixed
 */
function config($key = '') {
    global $config;
    // Get the individual keys
    $keys = explode('.', $key);

    // Go through the keys
    $value = $config;
    foreach ($keys as $key) {
        $value = @$value[$key];
    }

    return $value;
}

function isConfigSet($key = '') {
    return config($key) != null;
}

function createPath($path) {
    return config('base_url') . $path;
}

function getCryptoKey() {
    static $fileModified, $key;
    $path = config('encryption_key_path');
    if ($key == null || $fileModified == null || $fileModified != filemtime($path)) {
        try {
            $key = Key::loadFromAsciiSafeString(file_get_contents($path));
        } catch (Exception $e) {
            error_log('Failed to get encryption key ' . $e);
            die('Failed to get encryption key');
        }
    }
    return $key;
}

/**
 * @param $data
 * @return string
 * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
 */
function encrypt($data) {
    return Crypto::encrypt($data, getCryptoKey());
}

/**
 * @param $cipheredData
 * @return string
 * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
 * @throws \Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException
 */
function decrypt($cipheredData) {
    return Crypto::decrypt($cipheredData, getCryptoKey());
}