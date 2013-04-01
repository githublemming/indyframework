<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * Service that provides FILE functionality.
 */
interface FileService extends ServiceInterface
{
    /**
     * Checks to see if a file was uploaded. 
     */
    public function uploadedFileAvailable($postAttributeName);
    
    /**
     * Returns the name of the uploaded file or false if no file has been uploaded. 
     */
    public function uploadedFileName($postAttributeName);
    
    
    /**
     * Returns the size of the file in Kb e.g. 1234
     */
    public function uploadedFileSize($postAttributeName);
    
    /**
     * Returns the size of the file in a friendly string such as
     * 
     * 123bytes
     * 456Kb
     * 789Mb
     * 
     * @param postAtributeName The uploaded file to get the size for
     * @param round the number of deciminal places to round the size too. This
     * defaults to 2.
     */
    public function uploadedFileSizeString($postAttributeName, $round = 2);
    
    /**
     * Returns the type of the file. 
     */
    public function uploadedFileType($postAttributeName);
    
    /**
     * Checks to see if a file is in the HTTP POST FILES array, and if there is
     * places the file into the fileStore with the name provided.
     *
     * @param string $filename new filename for the uploaded file.
     * @return TRUE or FALSE 
     */
    public function upload($postAttributeName, $filename);
    
    /**
     * Returns the extension of the supplied file. 
     */
    public function uploadedFileExtension($filename);
}

?>
