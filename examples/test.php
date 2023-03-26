<?php

use Thumbhash\Thumbhash;

require_once __DIR__.'/../src/Thumbhash.php';

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

    $Th = new Thumbhash($path);

    $thumbBase64 = rtrim(base64_encode(implode(array_map("chr", $Th->getHash() ))), '=');
    $data_url = $Th->toDataURL($Th->getHash() );
    ?>
    <tr>
        <td>
            <img style="width: 200px; height: auto; border: 1px solid black;" width="<?= $Th->getWidth(); ?>" height="<?= $Th->getHeight(); ?>" src="<?= $url; ?>" alt="">
            <br><?= $Th->getWidth(); ?> x <?= $Th->getHeight(); ?>
        </td>
        <td>
            <img style="width: 200px; height: auto; border: 1px solid black;" width="<?= $Th->getWidth(); ?>" height="<?= $Th->getHeight(); ?>" src="<?= $data_url; ?>" alt="">
            <br>
            <br>
            <?= $thumbBase64; ?>
        </td>
    </tr>


    <?php

}
echo '</table>';
