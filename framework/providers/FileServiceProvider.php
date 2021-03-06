<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'FileService.php';

/**
 * Implementation of the FileService.
 */
class FileServiceProvider implements ProviderInterface, FileService
{
    private $fileStore;
    
    private $logger;

    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                $serviceRepository->registerService('FileService', $this);
                
                $this->logger = Logger::getLogger();
                break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Application Load Direct Inject functions
    ////////////////////////////////////////////////////////////////////////////
    public function setFileStore($imageStore)
    {
        // check $image store ends with a forward slash, if not add one
        $lastChar = substr($imageStore, strlen($imageStore) -1);
        if ($lastChar != chr(47))
        {
            $imageStore = $imageStore . "/";
        }

        $this->fileStore = $imageStore;
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the FileService interface
    ////////////////////////////////////////////////////////////////////////////
    public function uploadedFileAvailable($postAttributeName) {
        
        global $HTTP_POST_FILES;
        
        $uploadedFileAvailable = false;
        
        if(!isset($_FILES) && isset($HTTP_POST_FILES))
        {
            $_FILES = $HTTP_POST_FILES;
        }

        if ($_FILES[$postAttributeName]['error'] > 0) {
            
            $error_code = $_FILES[$postAttributeName]["error"];
            $errDesc = $this->file_upload_error_message($error_code);
            
            error_log("FileServiceProvider: uploadedFileAvailable - Error: " . $errDesc);
            
        } else {
        
            if(isset($_FILES[$postAttributeName]))
            {
                $uploadedFileAvailable = true;
            }
        }

        
        return $uploadedFileAvailable;
    }
    
    public function uploadedFileName($postAttributeName) {
        
        if(!$this->uploadedFileAvailable($postAttributeName))
        {
            return false;
        }
        
        $filename = basename($_FILES[$postAttributeName]['name']);
        
        if(empty($filename))
        {
            return false;
        }
        
        return $filename;
    }
    
    public function uploadedFileSize($postAttributeName) {
        
        if(!$this->uploadedFileAvailable($postAttributeName))
        {
            return false;
        }
        
        $fileSize = basename($_FILES[$postAttributeName]['size']) / 1024;
        
        if(empty($fileSize))
        {
            return false;
        }
        
        return $fileSize;
    }
    
    public function uploadedFileSizeString($postAttributeName, $round = 1) {
        
        if(!$this->uploadedFileAvailable($postAttributeName))
        {
            return false;
        }
        
        $fileSize = basename($_FILES[$postAttributeName]['size']);
        
        if(empty($fileSize))
        {
            return false;
        }
                
        $fileSizeString = "";
        
        if ($fileSize >= 0 && $fileSize <= 1023) {
            
            $fileSizeString = $fileSize . " bytes";
            
        } else if ($fileSize >= 1024 && $fileSize <= 1048575) {
            
            $kb = round(($fileSize / 1024));
            $fileSizeString = "$kb Kb";
            
        } else if ($fileSize >= 1048576 && $fileSize <= 1073741823) {
            
            $mb = round(($fileSize / 1048576), $round);
            $fileSizeString = "$mb Mb";
            
        } else if ($fileSize >= 1073741824 ) {
            
            $gb = round(($fileSize / 1073741824), $round);
            $fileSizeString = "$gb Gb";
        }
        
        return $fileSizeString;
    } 
    
    public function uploadedFileType($postAttributeName) {
        
        if(!$this->uploadedFileAvailable($postAttributeName))
        {
            return false;
        }
        
        $fileType = basename($_FILES[$postAttributeName]['type']);
        
        if(empty($fileType))
        {
            return false;
        }
        
        return $fileType;
    }
    
    public function uploadedFileExtension($filename) {
        
        $start = strpos($filename, ".") + 1;
        
        $len = strlen($filename);
        $end = $len = $start;
        
        return substr($filename, $start, $end);
    }
    
    public function upload($postAttributeName, $filename)
    {
        if(!$this->uploadedFileAvailable($postAttributeName))
        {
            $this->logger->log(Logger::LOG_LEVEL_WARNING,
                              'FileServiceProvider: upload',
                              "No uploaded file found");
            return false;
        }

        if(!$this->uploadedFileName($postAttributeName))
        {
            $this->logger->log(Logger::LOG_LEVEL_WARNING,
                              'FileServiceProvider: upload',
                              "The name of the upload file was not found.");
            return false;
        }

        $newFile = $this->fileStore . $filename;

        $result = @move_uploaded_file($_FILES[$postAttributeName]['tmp_name'], $newFile);

        if(empty($result))
        {            
            $this->logger->log(Logger::LOG_LEVEL_WARNING,
                              'FileServiceProvider: upload',
                              "There was an error moving the uploaded file. [" + $result + "]");
            
            return false;
        }
        
        return true;
    }
    
    private function file_upload_error_message($error_code) {
        
        $errorDesc = "";
        
        switch ($error_code) { 
            case UPLOAD_ERR_INI_SIZE: 
                $errorDesc =  'The uploaded file exceeds the upload_max_filesize directive in php.ini'; 
                break;
            case UPLOAD_ERR_FORM_SIZE: 
                $errorDesc =  'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form'; 
                break;
            case UPLOAD_ERR_PARTIAL: 
                $errorDesc =  'The uploaded file was only partially uploaded'; 
                break;
            case UPLOAD_ERR_NO_FILE: 
                $errorDesc =  'No file was uploaded'; 
                break;
            case UPLOAD_ERR_NO_TMP_DIR: 
                $errorDesc =  'Missing a temporary folder'; 
                break;
            case UPLOAD_ERR_CANT_WRITE: 
                $errorDesc =  'Failed to write file to disk'; 
                break;
            case UPLOAD_ERR_EXTENSION: 
                $errorDesc =  'File upload stopped by extension'; 
                break;
            default: 
                $errorDesc =  'Unknown upload error'; 
        } 
        
        return $errorDesc;
    }
}

?>
