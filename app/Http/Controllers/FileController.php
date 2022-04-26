<?php

namespace App\Http\Controllers;

use App\Enums\FilesPaths;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public static function store(UploadedFile $file, string $path = null, string $name = null): bool|string
    {
        if (!$path) {
            $path = FilesPaths::Attachments->value;
        }

        if (!$name) {
            // TODO: check for file extension
            $name = now()->timestamp . '_' . $file->getClientOriginalName();
        }

        $stored = $file->storeAs($path, $name);

        return $stored ? $name : false;
    }

    public static function delete(string $path)
    {
        Storage::delete($path);
    }
}
