<?php 
namespace App\Traits;
trait ManageFiles{
    private static $uploadDirection="public/uploads/";
    public static function uploadFiles($file,$uploadFolder=null): string|null{
        $fileName=uniqid() . "-" . basename($file['name']);

        $realPath=realpath(__DIR__ . "../../..") . "/" . self::$uploadDirection;
        if(isset($uploadFolder)){
            $realPath=$realPath.$uploadFolder."/";
        }
        if(!is_dir($realPath)){
            mkdir($realPath,0775,true);
        }
        $fullPath=$realPath.$fileName;
        if(move_uploaded_file($file['tmp_name'],$fullPath)){
             return self::$uploadDirection . ($uploadFolder ? "$uploadFolder/" : "") . $fileName;
        }
        return null;

    }
}