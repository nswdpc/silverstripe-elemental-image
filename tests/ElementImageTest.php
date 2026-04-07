<?php

declare(strict_types=1);

namespace NSWDPC\Elemental\Models\Image\Tests;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Config\Config;
use NSWDPC\Elemental\Models\Image\ElementImage;

class ElementImageTest extends SapphireTest
{
    protected $usesDatabase = true;

    public function testAllowedFileTypes(): void
    {
        $allowed = ["jpg", "jpeg"];
        Config::modify()->set(
            ElementImage::class,
            'allowed_file_types',
            $allowed
        );
        $element = ElementImage::create();
        $this->assertEquals($allowed, $element->getAllowedFileTypes());
    }

    public function testDimensions(): void
    {
        $width = ElementImage::WIDTH_CONTAINER;
        $height = ElementImage::HEIGHT_LARGE;
        $element = ElementImage::create([
            'Width' => $width,
            'Height' => $height
        ]);
        $this->assertEquals($width, $element->Width);
        $this->assertEquals($height, $element->Height);
    }

    public function testCaption(): void
    {
        $caption = 'Test caption';
        $element = ElementImage::create([
            'Caption' => $caption
        ]);
        $this->assertEquals($caption, $element->Caption);
    }

}
