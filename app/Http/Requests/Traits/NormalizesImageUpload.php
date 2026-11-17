<?php

namespace App\Http\Requests\Traits;

use Illuminate\Http\UploadedFile;
use ReflectionProperty;

trait NormalizesImageUpload
{
    /**
     * Normalize the uploaded profile image across multiple possible field names and formats.
     */
    protected function normalizeProfileImage(string $targetField = 'profile_image'): void
    {
        // 1. If already present as an uploaded file under targetField, nothing to do
        if ($this->hasFile($targetField)) {
            return;
        }

        // 2. Check common file field aliases: image, file, avatar, photo, dp
        foreach (['image', 'file', 'avatar', 'photo', 'dp'] as $alias) {
            if ($this->hasFile($alias)) {
                $this->files->set($targetField, $this->file($alias));
                $this->resetConvertedFiles();
                return;
            }
        }

        // 3. Check if sent as Base64 encoded string in request body
        $candidate = $this->input($targetField)
            ?? $this->input('image')
            ?? $this->input('file')
            ?? $this->input('avatar')
            ?? $this->input('photo')
            ?? $this->input('dp');

        if (is_string($candidate) && !empty($candidate)) {
            $file = $this->convertBase64ToUploadedFile($candidate, $targetField);
            if ($file) {
                $this->files->set($targetField, $file);
                $this->resetConvertedFiles();
            }
        }
    }

    /**
     * Reset cached converted files on Request instance so Laravel's validator sees the newly set file.
     */
    protected function resetConvertedFiles(): void
    {
        try {
            $ref = new ReflectionProperty($this, 'convertedFiles');
            $ref->setValue($this, null);
        } catch (\Throwable $e) {
            // Ignore if reflection is unavailable
        }
    }

    /**
     * Convert a Base64 encoded image string to an UploadedFile instance.
     */
    protected function convertBase64ToUploadedFile(string $value, string $filename = 'profile_image'): ?UploadedFile
    {
        $ext = 'jpg';
        if (preg_match('/^data:image\/(\w+);base64,/', $value, $type)) {
            $data = substr($value, strpos($value, ',') + 1);
            $ext = strtolower($type[1]);
            if ($ext === 'jpeg') {
                $ext = 'jpg';
            }
        } elseif (preg_match('/^[a-zA-Z0-9\/\r\n+={}]*={0,2}$/', substr($value, 0, 100))) {
            $data = $value;
        } else {
            return null;
        }

        $decoded = base64_decode($data);
        if ($decoded === false || strlen($decoded) === 0) {
            return null;
        }

        $tempPath = tempnam(sys_get_temp_dir(), 'prof_img_') . '.' . $ext;
        file_put_contents($tempPath, $decoded);

        return new UploadedFile(
            $tempPath,
            $filename . '.' . $ext,
            'image/' . ($ext === 'jpg' ? 'jpeg' : $ext),
            null,
            true
        );
    }
}
