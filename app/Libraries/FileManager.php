<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;

class FileManager {

    static $path;

    public static function path($path) {
        self::$path = $path;
        return new self;
    }


    public static function saveImage($file, $filename=null) {
        $filename   =  (empty($filename)) ? time().'.'.$file->getClientOriginalExtension() : $filename;

        $image = Image::make($file->path())->fit(500);

        if(!$image->save(public_path(self::$path) . '/' . $filename, 100)) {
            return false;
        }

        return $filename;
    }


    public static function save($file, $filename=null) {
        $profileName   =  (empty($filename)) ? time().'.'.$file->getClientOriginalExtension() : $filename;
        $file->move(public_path(self::$path), $profileName);
    }

    public static function destroy($file) {
        if(file_exists(public_path(self::$path .'/' . $file))) {
            return unlink(public_path(self::$path .'/' . $file));
        }
    }


}