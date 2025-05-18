<?php

namespace App\Traits;

trait HasUploadFile
{
    private function uploadFile(string $file, string $path): false|string|null
    {
        if ($this->request->hasFile($file)) {
            $file = $this->request->file($file);
            $fileName = $file->getClientOriginalName();
            $file->storeAs($path, $file->getClientOriginalName(), 'public');
            return "$path/$fileName";
        }
        return null;
    }
}
