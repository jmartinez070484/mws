<?php 

namespace App\Helpers;

class Helper {

	/*

        Return script

    */
    static function fileVersion($file = null){
        $fileVersion = null;

        if($file){
            $scriptPath = public_path().$file;
            
            if(file_exists($scriptPath)){
                $fileVersion = $file.'?v='.filemtime($scriptPath);
            }
        }

        return $fileVersion;
    }

    /*

        Return object instance

    */
    public static function instance(){
        if(!(self::$instance instanceof self)){
            self::$instance = new self;
        }

        return self::$instance;
    }
}