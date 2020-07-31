<?php 

namespace App\Helpers;

class Helper {

    /*

        Feed Media Type

    */
    static function feedMediaType($mediaFile){
        $pathInfo = pathinfo($mediaFile);
        $extension = $pathInfo['extension'] ? $pathInfo['extension'] : null;
        $imageExtensions = ['png','jpg','jpeg'];
        $videoExtensions = ['mp4','mov','avi'];
        $media = '';
        
        if(in_array($extension,$imageExtensions)){
            $media = '<img src="'.$mediaFile.'" alt="" />';
        }else if(in_array($extension,$videoExtensions)){
            $media = '<video controls><source src="'.$mediaFile.'" type="video/'.$extension.'"></video>';
        }

        return $media;
    }

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