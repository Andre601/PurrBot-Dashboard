<?php
/*
 * FLOW
 * - Include server_select.php which will make a request with $_POST['server']
 * - That request: Validate $_POST['server] and set $_COOKIE['server']
 *   - Open dashboard and validate $_COOKIE['server'] on every action
 */

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

$token = getToken();
$discord = getDiscord();

// TEMP
$user = $provider->getResourceOwner($token);

//echo '<h2>Owner details:</h2>';
//printf('Hello %s#%s!<br/><br/>', $user->getUsername(), $user->getDiscriminator());
//var_export($user->toArray());
// END TEMP

function resetServer() {
    // Delete server cookie, it's invalid..
    setcookie('server', '', time() - 3600);
    // Refresh
    header('Location: ' . createPath('discord.php'));
    exit();
}

if (isset($_GET['reset'])) {
    resetServer();
}

// Check this when including server_select.php & server_dashboard.php
$SERVER_INCLUDES = true;

// Validate $_GET['server']
$valid = false;

if (isset($_GET['server'])) {
    if ($valid = validateId($id = $_GET['server'])) {
        setcookie('server', $id);
    }
}


require_once 'inc/header.php';
?>
    <div class="container">
<?php
// Include server_select.php or server_dashboard.php depending what stage of the flow we're at

if (!$valid && !isset($_COOKIE['server'])) {
    /* >>> SELECT SERVER */
    include('server_select.php');
} else {
    // Check if server is valid if needed
    if (!$valid) {
        $valid = validateId($id = $_COOKIE['server']);
    }

    if (!$valid) {
        resetServer();
    } else {
        if (botHasGuild($id)) {
            /* >>> DASHBOARD */
            include('server_dashboard.php');
            $footerBottom = "<script src=\"dashboard.js\"></script>";
        } else {
            include('server_not_found.php');
        }
    }
}

?>
    </div>
<?php require_once 'inc/footer.php'; ?>