<?php

/**
 * Service that provides FILE functionality.
 */
interface FileService extends ServiceInterface
{
    /**
     * Checks to see if a file was uploaded. 
     */
    public function uploadedFileAvailable();
    
    /**
     * Returns the name of the uploaded file or false if no file has been uploaded. 
     */
    public function uploadedFileName();
    
    
    /**
     * Returns the size of the file 
     */
    public function getFileSize();
    
    /**
     * Returns the type of the file. 
     */
    public function getFileType();
    
    /**
     * Checks to see if a file is in the HTTP POST FILES array, and if there is
     * places the file into the fileStore with the name provided.
     *
     * @param string $filename new filename for the uploaded file.
     * @return TRUE or FALSE 
     */
    public function upload($filename);
    
    /**
     * Returns the extension of the supplied file. 
     */
    public function getFileExtension($filename);
}

?>
