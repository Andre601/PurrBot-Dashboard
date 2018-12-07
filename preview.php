<?php
// Composer
require_once 'vendor/autoload.php';
// Config
require_once 'config.php';
// Discord
require_once 'discord_token.php';

$fileName = null;
if (isset($_GET['image'])) {
    foreach (config('imageSelect.images') as $imageFileName => $imageAlias) {
        if (strcasecmp($_GET['image'], $imageAlias) == 0) {
            $fileName = $imageFileName;
            break;
        }
    }
} else {
    http_response_code(400);
    exit('Please provide image name');
}

// https://css-tricks.com/snippets/php/convert-hex-to-rgb/
function hex2rgb( $colour ) {
    if ( $colour[0] == '#' ) {
        $colour = substr( $colour, 1 );
    }
    if ( strlen( $colour ) == 6 ) {
        list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
    } elseif ( strlen( $colour ) == 3 ) {
        list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
    } else {
        return false;
    }
    $r = hexdec( $r );
    $g = hexdec( $g );
    $b = hexdec( $b );
    return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

$color = null;
color: {
    if (isset($_GET['color'])) {
        $colorInput = $_GET['color'];
        // rgb:$$$,$$$,$$$ or hex:#$$$$$$ or hex:#$$$
        if (!preg_match('/(rgb:\d{1,3},\d{1,3},\d{1,3}|hex:(#)?[0-9a-fA-F]{3,6})/m', $colorInput)) {
            http_response_code(400);
            exit('Invalid welcome color. It must be in a format similar to <code>rgb:20,100,30</code> or <code>hex:#ffffff</code>.' . $colorInput);
        }
        try {
            if (strpos($colorInput, 'rgb:') === 0) {
                $colorInput = substr($colorInput, strlen('rgb:'));
                $rgb = explode(',', $colorInput);
                $r = (int)$rgb[0];
                $g = (int)$rgb[1];
                $b = (int)$rgb[2];

                $palette = new \Imagine\Image\Palette\RGB();
                $color = $palette->color([$r, $g, $b]);
            } else if (strpos($colorInput, 'hex:#') === 0) {
                $colorInput = substr($colorInput, strlen('hex:#'));
                $rgb = hex2rgb($colorInput);
                $r = $rgb['red'];
                $g = $rgb['green'];
                $b = $rgb['blue'];

                $palette = new \Imagine\Image\Palette\RGB();
                $color = $palette->color([$r, $g, $b]);
            } else if (strpos($colorInput, 'hex:') === 0) {
                $colorInput = substr($colorInput, strlen('hex:'));
                $rgb = hex2rgb($colorInput);
                $r = $rgb['red'];
                $g = $rgb['green'];
                $b = $rgb['blue'];

                $palette = new \Imagine\Image\Palette\RGB();
                $color = $palette->color([$r, $g, $b]);
            }
        } catch (Exception $e) {
        }
    }
}

if ($fileName == null) {
    http_response_code(400);
    exit('Image with name ' . $_GET['image'] . ' not found');
}

// IMAGE
$imagine = new \Imagine\Gd\Imagine();
$image = $imagine->create(new \Imagine\Image\Box(1000, 300));
//

$base = config('imageSelect.directory') . '/';
$fullPath = $base . $fileName;
$textOverlayPath = $base . config('imageSelect.text_overlay_image');

// Open Template
try {
    $templateOverlay = $imagine->open($fullPath);
} catch (Exception $e) {
    error_log('Failed to open images because: ' . $e);
    http_response_code(500);
    exit('Failed to open images' . $e);
}

// Text Overlay
if ($color) {
    $font = new \Imagine\Gd\Font(__DIR__ . '/arial.ttf', 48, $color);
    $templateOverlay->draw()->text('Welcome', $font, new \Imagine\Image\Point(318, 48));

    $discord = getDiscord();
    $discordUser = $discord->user->getCurrentUser([]);
    $user = $discordUser->username . '#' . $discordUser->discriminator;
    $templateOverlay->draw()->text($user, $font, new \Imagine\Image\Point(318, 140));
    $templateOverlay->draw()->text('You are user #100', $font, new \Imagine\Image\Point(320, 200));
} else {
    $font = new \Imagine\Gd\Font(__DIR__ . '/arial.ttf', 48, (new \Imagine\Image\Palette\RGB())->color([0,0,0]));
    $templateOverlay->draw()->text('Invalid color', $font, new \Imagine\Image\Point(318, 48));
}

// User Image
@$tmpfname = tempnam("/tmp", "DiscordProfile-" . $discordUser->id);
$img = file_get_contents('http://cdn.discordapp.com/avatars/' . $discordUser->id . '/' . $discordUser->avatar . '.png');
file_put_contents($tmpfname, $img);
$userImage = $imagine->open($tmpfname);
$userImage->resize(new \Imagine\Image\Box(300, 300));

// Paste Overlays
$origin = new \Imagine\Image\Point(0, 0);
$image->paste($userImage, $origin);
$image->paste($templateOverlay, $origin);

// Cleanup
unlink($tmpfname);
// Show Image
$image->show('png');
exit();