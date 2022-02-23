<?php
namespace NSWDPC\Elemental\Models\Image;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextareaField;

/**
 * ElementalSVG adds an image with some config
 */
class ElementalSVG extends BaseElement
{
    private static $icon = "font-icon-image";

    private static $table_name = "ElementalSVG";

    private static $title = "SVG";
    private static $description = "Display an SVG";

    private static $singular_name = "SVG";
    private static $plural_name = "SVGs";

    public function getType()
    {
        return _t(__CLASS__ . ".BlockType", "SVG");
    }

    private static $db = [
        "Width" => "Varchar",
        "Height" => "Varchar",
        'Caption' => 'Text',
    ];

    private static $has_one = [
        "SVG" => File::class,
    ];

    private static $summary_fields = [
        "Title" => "Title",
    ];

    private static $owns = ["SVG"];

    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->addFieldsToTab("Root.Main", [
                DropdownField::create(
                    "Width",
                    _t(__CLASS__ . ".WIDTH", "Width"),
                    [
                        "container" => _t(__CLASS__ . ".CONTAINER_WIDTH", "Content width"),
                        "full" => _t(__CLASS__ . ".BROWSER_WIDTH", "Browser width")
                    ]
                ),
                DropdownField::create(
                    "Height",
                    _t(__CLASS__ . ".HEIGHT", "Height"),
                    [
                        "small" => _t(__CLASS__ . ".HEIGHT_SMALL", "Small"),
                        "medium" => _t(__CLASS__ . ".HEIGHT_MEDIUM", "Medium"),
                        "large" => _t(__CLASS__ . ".HEIGHT_LARGE", "Large"),
                        "original" => _t(__CLASS__ . ".HEIGHT_ORIGINAL", "Original")
                    ]
                ),
                UploadField::create(
                    "SVG",
                    _t(__CLASS__ . ".SLIDE_SVG", "SVG")
                )
                ->setIsMultiUpload(false),
                TextareaField::create(
                    'Caption',
                    'Caption'
                )
            ]);
        });
        return parent::getCMSFields();
    }
}
