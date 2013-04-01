<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

interface ImageService extends ServiceInterface
{
    /**
     * resizes an image
     * @param <type> $image the original image to be resized
     * @param <type> $destination where the new version of the file should be placed
     * @param <type> $width new width of the image
     * @param <type> $height new height of the image
     */
    public function resizeImage($image, $destination, $width, $height);
}
?>
