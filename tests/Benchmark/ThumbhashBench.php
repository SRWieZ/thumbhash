<?php

namespace Tests\Benchmark;

use Thumbhash\Thumbhash;

use function Thumbhash\extract_size_and_pixels_with_imagick;

/**
 * @BeforeMethods("setUp")
 * @ParamProviders("images")
 * @Revs(10)
 * @Iterations(5)
 * @Warmup(1)
 * @OutputTimeUnit("milliseconds", precision=2)
 */
class ThumbhashBench
{
    private $width;

    private $height;

    private $pixels;

    private $hash;

    public function images(): \Generator
    {
        foreach (glob(__DIR__ . '/../../assets/*.{jpg,png}', GLOB_BRACE) as $file) {
            yield basename($file) => ['file' => $file];
        }
    }

    public function setUp(array $params): void
    {
        $content = file_get_contents($params['file']);
        list($this->width, $this->height, $this->pixels) = extract_size_and_pixels_with_imagick($content);
        $this->hash = Thumbhash::RGBAToHash($this->width, $this->height, $this->pixels);
    }

    public function benchEncode(): void
    {
        Thumbhash::RGBAToHash($this->width, $this->height, $this->pixels);
    }

    public function benchDecode(): void
    {
        Thumbhash::hashToRGBA($this->hash);
    }

    public function benchDataUrl(): void
    {
        Thumbhash::toDataURL($this->hash);
    }
}
