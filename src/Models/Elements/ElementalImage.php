<?php
namespace NSWDPC\Elemental\Models\Image;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\DropdownField;

/**
 * ElementImage adds an image with some config
 */
class ElementImage extends BaseElement
{
    private static $icon = "font-icon-image";

    private static $table_name = "ElementImage";

    private static $title = "Image";
    private static $description = "Display an image";

    private static $singular_name = "Image";
    private static $plural_name = "Images";

    private static $allowed_file_types = ["jpg", "jpeg", "gif", "png", "webp"];

    public function getType()
    {
        return _t(__CLASS__ . ".BlockType", "Image");
    }

    private static $db = [
        "Width" => "Varchar",
        "Height" => "Varchar",
        'Caption' => 'Text',
    ];

    private static $has_one = [
        "Image" => Image::class,
    ];

    private static $summary_fields = [
        "Image.CMSThumbnail" => "Image",
        "Title" => "Title",
    ];

    private static $owns = ["Image"];

    public function getAllowedFileTypes()
    {
        $types = $this->config()->get("allowed_file_types");
        if (empty($types)) {
            $types = ['jpg', 'jpeg', 'gif', 'png', 'webp'];
        }
        $types = array_unique($types);
        return $types;
    }

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
                    "Image",
                    _t(__CLASS__ . ".SLIDE_IMAGE", "Image")
                )
                ->setAllowedExtensions($this->getAllowedFileTypes())
                ->setIsMultiUpload(false)
                ->setDescription(
                    _t(
                        __CLASS__ . "ALLOWED_FILE_TYPES",
                        "Allowed file types: {types}",
                        [
                            'types' => implode(",", $this->getAllowedFileTypes())
                        ]
                    )
                ),
                TextareaField::create(
                    'Caption',
                    'Caption'
                )
            ]);
        });
        return parent::getCMSFields();
    }
}
