<?php

namespace App\Rules;

/**
 * Class ImageBase64Rule
 *
 * @package App\Rules
 */
class ImageBase64Rule extends Core\BaseRule
{
    /**
     * ImageBase64Rule Constructor
     */
    public function __construct()
    {
        $this->message = trans('validation.string');
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
        if (!is_string($value)) {
            $this->message = trans('validation.string');
            return false;
        }
        // Strip out data uri scheme information (see RFC 2397).
        if (!str_contains($value, ';base64')) {
            $this->message = trans('validation.custom.base64', ['attribute' => $attribute]);
            return false;
        }

        [, $value] = explode(';', $value);
        [, $value] = explode(',', $value);

        // Strict mode filters for non-base64 alphabet characters.
        // Decoding and then encoding should not change the data.
        if (base64_decode($value, true) === false || base64_encode(base64_decode($value)) !== $value) {
            $this->message = trans('validation.custom.base64', ['attribute' => $attribute]);
            return false;
        }

        // Check the allowed Image types
        $allowedMimes = types_allowed_when_uploading_images();
        if (!empty($allowedMimes) && !$this->validate_mimes_base64($value, $allowedMimes)) {
            $this->message = trans('validation.mimetypes', ['attribute' => $attribute, 'values' => implode(',', $allowedMimes)]);
            return false;
        }

        $binaryData = base64_decode($value);

        // temporarily store the decoded data on the filesystem to be able to pass it to the fileAdder
        $tmpFile = tempnam(sys_get_temp_dir(), 'medialibrary');
        file_put_contents($tmpFile, $binaryData);

        // limit the image size to 2mb
        $ImageSize = filesize($tmpFile);
        unlink($tmpFile);

        $maxSize = maximum_size_when_uploading_images();
        if ($ImageSize > $maxSize) {
            $this->message = trans('validation.max.file', ['attribute' => $attribute, 'max' => round($maxSize / 1024)]);
            return false;
        }

        return true;
    }

    /**
     * Validate mimes of a base64 content.
     *
     * @param string $base64data
     * @param array  $allowedMimes example ['png', 'jpg', 'jpeg', ...]
     * @return bool
     */
    private function validate_mimes_base64(string $base64data, array $allowedMimes): bool
    {
        $binaryData = base64_decode($base64data);

        // Temporarily store the decoded data on the filesystem to be able to pass it to the fileAdder.
        $tmpFile = tempnam(sys_get_temp_dir(), 'medialibrary');
        file_put_contents($tmpFile, $binaryData);

        // No allowedMimeTypes, then any type would be ok.
        if (empty($allowedMimes)) {
            unlink($tmpFile);
            return true;
        }

        // Check the MimeTypes.
        $validation = \Illuminate\Support\Facades\Validator::make(
            ['file' => new \Illuminate\Http\File($tmpFile)],
            ['file' => 'mimes:'.implode(',', $allowedMimes)]
        );

        unlink($tmpFile);
        return !$validation->fails();
    }

}
