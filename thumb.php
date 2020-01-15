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

if (has_post_thumbnail($post)) {
    $thumb_url = get_the_post_thumbnail_url($post, 'medium_large');
    $img = imagecreatefromstring(file_get_contents($thumb_url));
} else {
    $img = imagecreatetruecolor(560, 315);
    $backgroundColor = imagecolorallocate($img, 204, 169, 76);
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