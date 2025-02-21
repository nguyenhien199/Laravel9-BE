<?php

namespace App\Services\Core;

use App\Constants\FileSystemConst;
use App\Exceptions\GeneralException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class BaseUploadService
 *
 * @package App\Services\Core
 */
abstract class BaseUploadService
{
    /**
     * Parent Upload path.
     *
     * @var string
     */
    protected string $parentPath = FileSystemConst::UPLOAD_PATH;

    /**
     * Get file upload full url.
     *
     * @param string      $filePath
     * @param string|null $disk
     * @return string
     */
    public function getFileFullUrl(string $filePath = '', string $disk = null): string
    {
        if (empty($filePath)) {
            return '';
        }

        $domain = fn_cut_full_domain_name($filePath, false);
        if (!empty($domain)) {
            return $filePath;
        }

        $disk = empty($disk) ? config('filesystems.default') : trim(strtolower($disk));
        return match ($disk) {
            FileSystemConst::PUBLIC_DISK => url($filePath),
            FileSystemConst::S3_DISK     => $filePath,
            FileSystemConst::LOCAL_DISK  => '',
            default                      => '',
        };
    }

    /**
     * Store file by content base64.
     *
     * @param string      $encode
     * @param string      $subPath
     * @param string|null $disk
     * @return string
     * @throws GeneralException
     */
    public function storeFileByBase64(string $encode, string $subPath = '', string $disk = null): string
    {
        $decode = $this->decodeFileBase64($encode);

        $content = $decode['content'];

        $subPath = rtrim($subPath, '/');
        $subPath = ltrim($subPath, '/');
        $subPath = !empty($subPath) ? $subPath.'/' : '';

        $path = $this->getParentPath($disk).$subPath.$decode['name'];

        return $this->store($path, $content, $disk);
    }

    /**
     * Store file.
     *
     * @param string|UploadedFile $content
     * @param string              $filename
     * @param string              $subPath
     * @param string|null         $disk
     * @return string
     * @throws GeneralException
     */
    public function storeFile(string|UploadedFile $content, string $filename = '', string $subPath = '', string $disk = null): string
    {
        if (empty($content)) {
            throw new GeneralException(__("File content is empty."));
        }

        $extension = '';
        if ($content instanceof UploadedFile) {
            $extension = $content->getClientOriginalExtension();
            $content = $content->getContent();
        }

        $filename = mb_remove_special_characters($filename);
        $filename = !empty($filename) ? $filename : $this->genNewFilename();
        $filename = !empty($extension) ? $filename.'.'.$extension : $filename;

        $subPath = mb_rtrim($subPath, '/');
        $subPath = mb_ltrim($subPath, '/');
        $subPath = !empty($subPath) ? $subPath.'/' : '';

        $path = $this->getParentPath($disk).$subPath.$filename;

        return $this->store($path, $content, $disk);
    }

    /**
     * Get upload path.
     * (realpath: /storage/app/public/ . $this->parentPath)
     *
     * @param string|null $disk
     * @return string
     */
    protected function getParentPath(string $disk = null): string
    {
        $disk = empty($disk) ? config('filesystems.default') : trim(strtolower($disk));
        return $disk === FileSystemConst::LOCAL_DISK
            ? 'public/'.Str::replaceFirst('public/', '', $this->parentPath)
            : $this->parentPath;
    }

    /**
     * Decode File Base64.
     *
     * @param string $encode <p>Base64 encode.</p>
     * @return array [name, content]
     * @throws GeneralException
     */
    protected function decodeFileBase64(string $encode): array
    {
        if (empty($encode)) {
            throw new GeneralException(__("The File encode is empty."));
        }
        [$extension, $content] = explode(';', $encode);
        $tmpExtension = explode('/', $extension);
        $content = explode(',', $content)[1];
        $filename = $this->genNewFilename().'.'.$tmpExtension[1];

        return [
            'name'    => $filename,
            'content' => base64_decode($content)
        ];
    }

    /**
     * Process File Url.
     *
     * @param string $url    <p>File url.</p>
     * @param string $extDef <p>Extension default.</p>
     * @return array [name, content]
     * @throws GeneralException
     */
    protected function processFileUrl(string $url = '', string $extDef = 'txt'): array
    {
        $info = pathinfo($url);
        if (!is_array($info)) {
            throw new GeneralException(__("File info ':attribute' not found.", ['attribute' => $url]));
        }
        $ext = $info["extension"] ?? $extDef;
        $filename = $this->genNewFilename().'.'.$ext;
        $content = file_get_contents($url);

        return [
            'name'    => $filename,
            'content' => $content
        ];
    }

    /**
     * Gen new filename.
     *
     * @return string
     */
    protected function genNewFilename(): string
    {
        return str::random(12).time();
    }

    /**
     * Store File.
     *
     * @param string $path    <p>Path file.</p>
     * @param string $content <p>Content file.</p>
     * @return string URL file after uploaded.
     * @throws GeneralException
     */
    protected function store(string $path, string $content = '', string $disk = null): string
    {
        $disk = empty($disk) ? config('filesystems.default') : trim(strtolower($disk));
        if (in_array($disk, FileSystemConst::getKeyDisks())) {
            $storage = Storage::disk($disk);
        }
        else {
            throw new GeneralException(__("Filesystem disk ':attribute' does not exists.", ['attribute' => $disk]));
        }

        $filePath = $storage->url($path);
        $storage->put($path, $content);

        return $filePath;
    }
}
