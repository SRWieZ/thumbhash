# Thumbhash PHP
[![Tests](https://github.com/SRWieZ/thumbhash/actions/workflows/test.yml/badge.svg)](https://github.com/SRWieZ/thumbhash/actions/workflows/tests.yml)
[![Latest Stable Version](https://poser.pugx.org/srwiez/thumbhash/v/stable)](https://packagist.org/packages/srwiez/thumbhash)

Thumbhash PHP is a PHP library for generating unique, human-readable identifiers from image files. It is inspired by [Evan Wallace's Thumbhash algorithm](https://github.com/evanw/thumbhash) and provides a PHP implementation of the algorithm.

Thumbhash is a very compact representation of a placeholder for an image. Store it inline with your data and show it while the real image is loading for a smoother loading experience. It's similar to [BlurHash](https://github.com/woltapp/blurhash) but with some advantages

[Read more and test it here !](https://evanw.github.io/thumbhash/)

## Installation

You can install Thumbhash PHP using Composer:

```bash
composer require srwiez/thumbhash
```

⚠️ I highly recommend to have Imagick extension installed on your computer. GD extension has only 7 bits of alpha channel resolution, and 127 is transparent, 0 opaque. While the library will still work, you may have different image between platforms. [See on stackoverflow](https://stackoverflow.com/questions/41079110/is-it-possible-to-retrieve-the-alpha-value-of-a-pixel-of-a-png-file-in-the-0-255)

## Usage

To generate a thumbhash for an image file, you can use the Thumbhash\Thumbhash class:

Example to show a thumbhash image from a local file

```php
use Thumbhash\Thumbhash;

$content = file_get_contents($url);

list($width, $height, $pixels) = extract_size_and_pixels_with_imagick($content);

$hash = Thumbhash::RGBAToHash($width, $height, $pixels);
$key = Thumbhash::convertHashToString($hash); // You can store this in your database as a string
$url = Thumbhash::toDataURL($hash);

echo '<img src="' . $url . '" />';
```

## Credits

Thumbhash PHP was created by Eser DENIZ. 

It is inspired by the javascript version of [Evan Wallace's Thumbhash algorithm](https://github.com/evanw/thumbhash).

## License

Thumbhash PHP is licensed under the MIT License. See LICENSE for more information.