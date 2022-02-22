<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Http\Resources\City\CityCollection;
use App\Http\Resources\City\CityResource;
use App\Http\Resources\File\FileResource;
use App\Models\City;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function upload(Request $request)
    {
        $file = $request->file('file');

        $name = $file->getClientOriginalName();
        $hash_ame = $file->hashName();
        $size = $file->getSize();
        $extension = $file->getClientOriginalExtension();

        $disk = Storage::disk('public');

        $dir = date('Y') . '/' . date('m');
        $disk->putFile($dir, $file);

        $file = File::create([
            'extension' => $extension,
            'name' => $name,
            'hash_name' => $hash_ame,
            'size' => $size,
            'url' => $disk->url("$dir/$hash_ame"),
            'path' => $disk->path("$dir/$hash_ame"),
        ]);

        return FileResource::make($file);
    }

    public function delete(Request $request)
    {
        File::find($request->id)->delete();
    }

    public function save($file)
    {
        $name = $file->getClientOriginalName();
        $hash_ame = $file->hashName();
        $size = $file->getSize();
        $extension = $file->getClientOriginalExtension();

        $disk = Storage::disk('public');

        $dir = date('Y') . '/' . date('m');
        $disk->putFile($dir, $file);

        return [
            'extension' => $extension,
            'name' => $name,
            'hash_name' => $hash_ame,
            'size' => $size,
            'url' => $disk->url("$dir/$hash_ame"),
            'path' => $disk->path("$dir/$hash_ame"),
        ];
    }
}
