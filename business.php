<?php
require 'vendor/autoload.php';
function applyWatermark($filePath, $watermark){
    $image = imagecreatefromstring((file_get_contents(($filePath . '.jpg'))));
    $color = imagecolorallocatealpha( $image,255,255,255,50);
    $font = __DIR__ . '/fonts/Arial.ttf';
    imagettftext($image,50,0,20,50,$color, $font, $watermark);
    imagejpeg($image, $filePath . '_watermarked.jpg');
    imagedestroy($image);
}
function createThumbnail($filePath){
    $image = imagecreatefromstring(file_get_contents(($filePath . '.jpg')));
    $thumb = imagescale($image,125,200);
    imagejpeg($thumb, $filePath . '_thumb.jpg');
    imagedestroy($image);
}
function getGalleryImages($dir){
    $files = array_diff(scandir($dir), ['.', '..']);
    return array_values(array_filter($files, function($file) {
        return strpos($file, '_thumb.jpg') !== false;
    }));
}
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
function get_db()
{
    $mongo = new MongoDB\Client(
    "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);
        $db = $mongo->wai;
        return $db;
}