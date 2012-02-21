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
            
            echo "Error: " . $_FILES["file"]["error"];
            
        } else {
        
            if(isset($_FILES[$postAttributeName]))
            {
                $uploadedFileAvailable = true;
            }
        }

        
        return $uploadedFileAvailable;
    }
    
    public function uploadedFileName($postAttributeName) {
        
        if(!$this->uploadedFileAvailable())
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
    
    public function getUploadedFileSize($postAttributeName) {
        
        if(!$this->uploadedFileAvailable())
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
    
    public function getUploadedFileSizeString($postAttributeName, $round = 2) {
        
        if(!$this->uploadedFileAvailable())
        {
            return false;
        }
        
        $fileSize = basename($_FILES[$postAttributeName]['size']);
        
        
        if(empty($fileSize))
        {
            return false;
        }
        
        $fileSize = round($round, 2);
        
        $fileSizeString = "";
        
        if ($fileSize >= 0 && $fileSize <= 1023) {
            
            $fileSizeString = $fileSize . " bytes";
            
        } else if ($fileSize >= 1024 && $fileSize <= 1048575) {
            
            $fileSizeString = $fileSize . " Mb";
            
        } else if ($fileSize >= 1048576 && $fileSize <= 1073741823) {
            
            $fileSizeString = $fileSize . " Gb";
            
        } else if ($fileSize >= 1073741824 ) {
            
            $fileSizeString = $fileSize . " Tb";
        }
        
        return $fileSizeString;
    } 
    
    public function getUploadedFileType($postAttributeName) {
        
        if(!$this->uploadedFileAvailable())
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
    
    public function getUploadedFileExtension($filename) {
        
        $start = strpos($filename, ".") + 1;
        
        $len = strlen($filename);
        $end = $len = $start;
        
        return substr($filename, $start, $end);
    }
    
    public function upload($postAttributeName, $filename)
    {
        if(!$this->uploadedFileAvailable())
        {
            $this->logger->log(Logger::LOG_LEVEL_WARNING,
                              'FileServiceProvider: upload',
                              "No uploaded file found");
            return false;
        }

        if(!$this->uploadedFileName())
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
                              "There was an error moving the uploaded file.");
            return false;
        }
        
        return true;
    }
}

?>
