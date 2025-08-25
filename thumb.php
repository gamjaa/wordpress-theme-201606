<?php
require_once('../../../wp-load.php');
require('./vendor/autoload.php');

use GDText\Box;
use GDText\Color;

if (empty($_GET["post_id"])) {
    http_response_code(404);
    return;
}

$post = get_post((int)$_GET["post_id"]);
if (empty($post)) {
    http_response_code(404);
    return;
}

// Trim title to prevent potential DoS attack from long strings.
$post->post_title = mb_strimwidth($post->post_title, 0, 100, "...");

$options = get_option( 'gamjaa_post_options' );

if (has_post_thumbnail($post)) {
    $thumb_url = get_the_post_thumbnail_url($post, 'medium_large');
    $img = imagecreatefromstring(file_get_contents($thumb_url));
} else if ($options['auto_thumb_background_image']) {
    $img = imagecreatefromstring(file_get_contents($options['auto_thumb_background_image']));
} else {
    $img = imagecreatetruecolor(560, 315);

    function hexColorAllocate($im,$hex){
        $hex = ltrim($hex,'#');
        $a = hexdec(substr($hex,0,2));
        $b = hexdec(substr($hex,2,2));
        $c = hexdec(substr($hex,4,2));
        return imagecolorallocate($im, $a, $b, $c); 
    }    
    $backgroundColor = hexColorAllocate($img, $options['auto_thumb_background_color'] ?: '#CCA94C');
    imagefill($img, 0, 0, $backgroundColor);
}

$box = new Box($img);
$box->setFontFace('./BMDOHYEON.ttf');
$box->setFontColor(new Color(51, 51, 51));

$imgx = imagesx($img);
$imgy = imagesy($img);
$textwidth = $imgx < $imgy * 2 ? $imgx : $imgy * 2;
$box->setFontSize($textwidth / mb_strlen($post->post_title));

$box->setLineHeight(1.5);
$box->setBox(0, 0, $imgx, $imgy);
$box->setTextAlign('center', 'center');

$box->setStrokeColor(new Color(255, 255, 255)); // Set stroke color
$box->setStrokeSize(2); // Stroke size in pixels

$box->draw($post->post_title);

header('Content-Type: image/png');
imagepng($img);
imagedestroy($img);
return;
?>