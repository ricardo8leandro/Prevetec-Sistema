<?php
    namespace App\Controller;
    
    class Controller {
        
        use \Src\Traits\TraitCrypt;
        use \Src\Traits\TraitUrlParser;

        public function __construct(){
        	if((count($this->parseUrl()) == 1) || ($this->parseUrl()[1] == "")){
        		if(method_exists($this,'index')){
        			$this->index();	
        		}
        	}
        }

        protected function debug($arr){
            echo "<pre>";
            print_r($arr);
            echo "</pre>";
            exit;
        }

        protected function rotate_image($filename, $exif){

            if (!empty($exif['Orientation']))
            {
                $image = imagecreatefromjpeg($filename);

                switch ($exif['Orientation'])
                {
                    case 3:
                        $image = imagerotate($image, 180, 0);
                        break;

                    case 6:
                        $image = imagerotate($image, -90, 0);
                        break;

                    case 8:
                        $image = imagerotate($image, 90, 0);
                        break;
                }

                imagejpeg($image, $filename, 90);
            }
            
        }

        protected function resize_img($file_name, $exif){

            $maxDim = 800;

            list($width, $height, $type, $attr) = getimagesize( $file_name );

            if ( $width > $maxDim || $height > $maxDim ) {
                
                $target_filename = $file_name;

                $ratio = $width/$height;

                if( $ratio > 1) {
                    $new_width = $maxDim;
                    $new_height = $maxDim/$ratio;
                } else {
                    $new_width = $maxDim*$ratio;
                    $new_height = $maxDim;
                }

                $src = imagecreatefromstring( file_get_contents( $file_name ) );
                $dst = imagecreatetruecolor( $new_width, $new_height );
                imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                imagedestroy( $src );
                imagejpeg($dst, $file_name ); // adjust format as needed
                imagedestroy( $dst );

                $this->rotate_image($target_filename, $exif);
            }
        }
    }