<?php

/**
 * Indy Framework
 *
 * An open source application development framework for PHP
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2011, IndyFramework.org
 * @link		http://www.indyframework.org
 */

/**
 * Singleton class that provides logging functionality.
 *
 * @package indyframework/core
 */

class Logger
{
    const LOG_LEVEL_DEBUG    = 1;
    const LOG_LEVEL_INFO     = 2;
    const LOG_LEVEL_WARNING  = 3;
    const LOG_LEVEL_CRITICAL = 4;
    const LOG_LEVEL_FATAL    = 5;

    private $levelToLog = Logger::LOG_LEVEL_INFO;
    private $logFilename;

    private static $logger;

    /**
     * Private constructor as this is a Singleton
     */
    private function  __construct($logLevel = Logger::LOG_LEVEL_INFO)
    {
        $this->levelToLog = $logLevel;
    }

    /**
     * Should only be called once during the loading of the framework.
     * This function can be used to change the default logging level. Calling
     * the function a send time will have no effect.
     *
     * @param <type> $logLevel Miniumum level to log.
     */
    public static function createLogger($logLevel)
    {
        if (!isset (self::$logger))
        {
            self::$logger = new Logger($logLevel);
        }
    }

    /**
     * Returns an instance of the Logger class, if an instance of Logger does not
     * already exist a new one will be created and then returned.
     *
     * @return Logger 
     */
    public static function getLogger()
    {
        if (!isset (self::$logger))
        {
            self::$logger = new Logger();
        }

        return self::$logger;
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Properties
    ////////////////////////////////////////////////////////////////////////////
    /**
     * Sets the minimim logging level that will be outputted.
     *
     * @param <type> $level
     */
    public function setLogLevel($level)
    {
        $this->levelToLog = $level;
    }

    /**
     * Sets an altenative file that logging will be outputted too.
     *
     * @param string $filename full patha and filename to log too.
     */
    public function setLogFilename($filename)
    {
        $this->logFilename = $filename;
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Public function
    ////////////////////////////////////////////////////////////////////////////
    /**
     * Logs an error message
     *
     * @param <type> $logLevel The levelt to log the message as
     * @param string $generatingClass the name of the class that is generating
     * the log
     * @param string $message the message of the log
     * @param Exception $exception the Exception that has been thrown, this is
     * optional
     */
    public function log($logLevel, $generatingClass, $message, $exception = null)
    {
        if ($this->isLoggable($logLevel))
        {
            $logOutput = $this->createOuputMessage($logLevel, $generatingClass, $message, $exception);

            if (isset ($this->logFilename))
            {
                error_log($logOutput, 3, $this->logFilename);
            }
            else
            {
                error_log($logOutput, 0);
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// private function
    ////////////////////////////////////////////////////////////////////////////
    private function getLogLevelDesc($logLevel)
    {
        $desc = "";
        
        switch ($logLevel)
        {
            case Logger::LOG_LEVEL_DEBUG:    $desc = "DEBUG";    break;
            case Logger::LOG_LEVEL_INFO:     $desc = "INFO";     break;
            case Logger::LOG_LEVEL_WARNING:  $desc = "WARNING";  break;
            case Logger::LOG_LEVEL_CRITICAL: $desc = "CRITICAL"; break;
            case Logger::LOG_LEVEL_FATAL:    $desc = "FATAL";    break;
        }

        return $desc;
    }

    private function isLoggable($logLevel)
    {
        $doLog = false;

        if ($logLevel >= $this->levelToLog)
        {
            $doLog = true;
        }

        return $doLog;
    }

    private function createOuputMessage($logLevel, $filename, $message, IndyFrameworkException $exception = null)
    {
        $logLevelDesc = $this->getLogLevelDesc($logLevel);

        $output = "";

        $output .= "IndyFramework ";
        
        if (isset ($exception))
        {
            $output .= $exception->exceptionType . " ";
        }

        $output .= $logLevelDesc . " : ";
        $output .= $filename . ' - ';
        $output .= $message;
        
        if (isset ($exception))
        {
            $output .= " (";
            $output .= $exception->__toString();
            $output .= " )";
        }

        return $output;
    }
}

?>
