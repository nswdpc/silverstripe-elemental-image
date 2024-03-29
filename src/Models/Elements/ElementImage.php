<?php
namespace NSWDPC\Elemental\Models\Image;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextareaField;

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

    const WIDTH_FULL = 'full';
    const WIDTH_CONTAINER = 'container';

    const HEIGHT_SMALL = 'small';
    const HEIGHT_MEDIUM = 'medium';
    const HEIGHT_LARGE = 'large';
    const HEIGHT_ORIGINAL = 'original';

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
                        self::WIDTH_CONTAINER => _t(__CLASS__ . ".CONTAINER_WIDTH", "Content width"),
                        self::WIDTH_FULL => _t(__CLASS__ . ".BROWSER_WIDTH", "Browser width")
                    ]
                ),
                DropdownField::create(
                    "Height",
                    _t(__CLASS__ . ".HEIGHT", "Height"),
                    [
                        self::HEIGHT_SMALL => _t(__CLASS__ . ".HEIGHT_SMALL", "Small"),
                        self::HEIGHT_MEDIUM => _t(__CLASS__ . ".HEIGHT_MEDIUM", "Medium"),
                        self::HEIGHT_LARGE => _t(__CLASS__ . ".HEIGHT_LARGE", "Large"),
                        self::HEIGHT_ORIGINAL => _t(__CLASS__ . ".HEIGHT_ORIGINAL", "Original")
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
                    _t(__CLASS__ . ".CAPTION", "Caption")
                )
            ]);
        });
        return parent::getCMSFields();
    }
}
