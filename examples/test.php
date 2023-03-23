<?php

use Thumbhash\Thumbhash;
use function Thumbhash\extract_size_and_pixels_with_gd;
use function Thumbhash\extract_size_and_pixels_with_imagick;

require_once __DIR__ . '/../vendor/autoload.php';

$test_images = [
    '../assets/sunrise.jpg',
    '../assets/sunset.jpg',
    '../assets/field.jpg',
    '../assets/fall.jpg',
    '../assets/street.jpg',
    '../assets/mountain.jpg',
    '../assets/coast.jpg',
    '../assets/firefox.png',
    '../assets/opera.png',
];

echo '<h1 style="text-align: center">Thumbhash examples</h1>
    <table style="background-color: lightgray; text-align: center;width:80%; margin:auto;">';

foreach ($test_images as $test_image) {
    $url = $test_image;
    $path = __DIR__ . '/' . $url;
    $content = file_get_contents($path);

    list($width, $height, $pixels) = extract_size_and_pixels_with_imagick($content);
    $hash = Thumbhash::encode($width, $height, $pixels);

    $thumbBase64 = rtrim(base64_encode(implode(array_map("chr", $hash))), '=');
    $data_url = Thumbhash::toDataURL($hash);
    ?>
    <tr>
        <td>
            <img style="width: 200px; height: auto; border: 1px solid black;" width="<?= $width; ?>" height="<?= $height; ?>" src="<?= $url; ?>" alt="">
            <br><?= $width; ?> x <?= $height; ?>
        </td>
        <td>
            <img style="width: 200px; height: auto; border: 1px solid black;" width="<?= $width; ?>" height="<?= $height; ?>" src="<?= $data_url; ?>" alt="">
            <br>
            <br>
            <?= $thumbBase64; ?>
        </td>
    </tr>


    <?php

}
echo '</table>';