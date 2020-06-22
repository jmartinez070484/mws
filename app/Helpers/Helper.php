<?php 

namespace App\Helpers;

class Helper {

    /*

        Excerpt

    */
    static function excerpt($content,$length){
        $text = strip_tags($content);

        if(strlen($text) > $length){
            $stringCut = substr($text,0,$length);
            $text = substr($stringCut,0,strrpos($stringCut,' ')).'...';
        }
        
        return $text;
    }

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