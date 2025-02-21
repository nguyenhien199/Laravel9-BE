<?php

namespace App\Rules;

use Illuminate\Http\UploadedFile;

/**
 * Class ImageFileRule
 *
 * @package App\Rules
 */
class ImageFileRule extends Core\BaseRule
{
    /**
     * @var int <p>Maximum File size (bytes).</p>
     */
    private int $maxSize;

    /**
     * @var array <p>Allowed File extensions.</p>
     */
    private array $allowedExtensions;

    /**
     * ImageFileRule Constructor
     *
     * @param int|null   $maxSize           <p>Maximum File size (bytes)  (If set 0 -> Unlimited).</p>
     * @param array|null $allowedExtensions <p>The allowed extension list (If set [] -> Unlimited).</p>
     */
    public function __construct(int $maxSize = null, array $allowedExtensions = null)
    {
        $this->maxSize = (is_int($maxSize) && $maxSize >= 0)
            ? $maxSize
            : maximum_size_when_uploading_images();

        $this->allowedExtensions = (is_array($allowedExtensions))
            ? $allowedExtensions
            : types_allowed_when_uploading_images();

        $this->message = trans('validation.file');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute <p>Attribute key.</p>
     * @param mixed  $value     <p>Attribute value.</p>
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (empty($value)) {
            return true;
        }

        if (!($value instanceof UploadedFile) || !$value->isFile() || !is_file($value->getRealPath())) {
            $this->message = trans('validation.file');
            return false;
        }

        $fileSizeInBytes = $value->getSize();
        if ($this->maxSize > 0 && $fileSizeInBytes > $this->maxSize) {
            $this->message = trans('validation.max.file', ['attribute' => $attribute, 'max' => $this->maxSize / 1024]);
            return false;
        }

        $fileExtension = $value->getClientOriginalExtension();
        if (count($this->allowedExtensions) > 0 && !in_array($fileExtension, $this->allowedExtensions)) {
            $this->message = trans('validation.mimes', ['attribute' => $attribute, 'values' => implode(', ', $this->allowedExtensions)]);
            return false;
        }

        return true;
    }
}
