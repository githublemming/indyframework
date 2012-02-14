<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'ImageService.php';

/**
 * Implementation of the FileService.
 */
class ImageServiceProvider implements ProviderInterface, ImageService
{
    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                $serviceRepository->registerService('ImageService', $this);
                break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the ImageService interface
    ////////////////////////////////////////////////////////////////////////////
    public function resizeImage($originalImage, $destination, $toWidth, $toHeight)
    {
        list($width, $height) = getimagesize($originalImage);

        if (($width < $toWidth) && ($height < $toHeight))
        {
              return false;
        }

        $xscale=$width/$toWidth;
        $yscale=$height/$toHeight;

        if ($yscale>$xscale)
        {
            $new_width = round($width * (1/$yscale));
            $new_height = round($height * (1/$yscale));
        }
        else
        {
            $new_width = round($width * (1/$xscale));
            $new_height = round($height * (1/$xscale));
        }

        $imageResized = imagecreatetruecolor($new_width, $new_height);
        $imageTmp     = imagecreatefromjpeg ($originalImage);
        
        imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        imagejpeg($imageResized, $destination, 75);

        // need to free up any used memory here
        imagedestroy($imageResized);
        imagedestroy($imageTmp);
    }
}

?>
