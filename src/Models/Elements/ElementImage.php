<?php
namespace NSWDPC\Elemental\Models\Image;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextareaField;

/**
 * ElementImage adds an image with some config
 * @property ?string $Width
 * @property ?string $Height
 * @property ?string $Caption
 * @property int $ImageID
 * @method \SilverStripe\Assets\Image Image()
 */
class ElementImage extends BaseElement
{
    private static string $icon = "font-icon-image";

    private static string $table_name = "ElementImage";

    private static string $title = "Image";

    private static string $description = "Display an image";

    private static string $singular_name = "Image";

    private static string $plural_name = "Images";

    private static array $allowed_file_types = ["jpg", "jpeg", "gif", "png", "webp"];

    const WIDTH_FULL = 'full';

    const WIDTH_CONTAINER = 'container';

    const HEIGHT_SMALL = 'small';

    const HEIGHT_MEDIUM = 'medium';

    const HEIGHT_LARGE = 'large';

    const HEIGHT_ORIGINAL = 'original';

    #[\Override]
    public function getType()
    {
        return _t(self::class . ".BlockType", "Image");
    }

    private static array $db = [
        "Width" => "Varchar",
        "Height" => "Varchar",
        'Caption' => 'Text',
    ];

    private static array $has_one = [
        "Image" => Image::class,
    ];

    private static array $summary_fields = [
        "Image.CMSThumbnail" => "Image",
        "Title" => "Title",
    ];

    private static array $owns = ["Image"];

    public function getAllowedFileTypes(): array
    {
        $types = $this->config()->get("allowed_file_types");
        if (empty($types)) {
            $types = ['jpg', 'jpeg', 'gif', 'png', 'webp'];
        }
        return array_unique($types);
    }

    #[\Override]
    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function ($fields): void {
            $fields->addFieldsToTab("Root.Main", [
                DropdownField::create(
                    "Width",
                    _t(self::class . ".WIDTH", "Width"),
                    [
                        self::WIDTH_CONTAINER => _t(self::class . ".CONTAINER_WIDTH", "Content width"),
                        self::WIDTH_FULL => _t(self::class . ".BROWSER_WIDTH", "Browser width")
                    ]
                ),
                DropdownField::create(
                    "Height",
                    _t(self::class . ".HEIGHT", "Height"),
                    [
                        self::HEIGHT_SMALL => _t(self::class . ".HEIGHT_SMALL", "Small"),
                        self::HEIGHT_MEDIUM => _t(self::class . ".HEIGHT_MEDIUM", "Medium"),
                        self::HEIGHT_LARGE => _t(self::class . ".HEIGHT_LARGE", "Large"),
                        self::HEIGHT_ORIGINAL => _t(self::class . ".HEIGHT_ORIGINAL", "Original")
                    ]
                ),
                UploadField::create(
                    "Image",
                    _t(self::class . ".SLIDE_IMAGE", "Image")
                )
                ->setAllowedExtensions($this->getAllowedFileTypes())
                ->setIsMultiUpload(false)
                ->setDescription(
                    _t(
                        self::class . "ALLOWED_FILE_TYPES",
                        "Allowed file types: {types}",
                        [
                            'types' => implode(",", $this->getAllowedFileTypes())
                        ]
                    )
                ),
                TextareaField::create(
                    'Caption',
                    _t(self::class . ".CAPTION", "Caption")
                )
            ]);
        });
        return parent::getCMSFields();
    }
}
