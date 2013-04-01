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
 * Implementation of the DataService.
 *
 * This implementation provides database access to a MySQL database using PDO.
 *
 * @package indyframework/providers
 */

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'DatabaseService.php';

class MySQLPDODatabaseServiceProvider implements ProviderInterface, DatabaseService
{
    private $db_conn;

    private $host;
    private $name;
    private $username;
    private $passwd;

    private $logger;

    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                $serviceRepository->registerService('DatabaseService', $this);

                $this->logger = Logger::getLogger();

                break;
            }
            case APPLICATION_INIT:
            {
                try
                {
                    $this->db_conn = new PDO("mysql:host=$this->host;dbname=$this->name", $this->username, $this->passwd);
                    
                    // ideally these should be set as properties
                    //$this->db_conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                }
                catch(PDOException $e)
                {
                    $this->logger->log(Logger::LOG_LEVEL_CRITICAL,
                                      'MySQLPDODatabaseServiceProvider',
                                      "Unable to get a connection to the database : " . $e->getMessage());
                }
                break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Application Load Direct Inject functions
    ////////////////////////////////////////////////////////////////////////////
    public function setHost($host)
    {
        $this->host = $host;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->passwd = $password;
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the DatabaseService interface
    ////////////////////////////////////////////////////////////////////////////
    public function select($query, $data)
    {
        $result = null;
        try
        {
            $stmt = $this->db_conn->prepare($query);

            $stmt->execute($data);

            $result = $stmt->fetchAll();
        }
        catch(PDOException $e)
        {
            $this->logger->log(Logger::LOG_LEVEL_WARNING,
                              'MySQLPDODatabaseServiceProvider',
                              "SELECT statement failed : " . $e->getMessage());
        }

        return $result;
    }

    public function insert($query, $data, $commit = true)
    {
        $insertID = -1;

        try
        {
            //$this->db_conn->beginTransaction();

            $stmt = $this->db_conn->prepare($query);
            $stmt->execute($data);

            //$this->commit();

            $insertID = $this->db_conn->lastInsertId();
        }
        catch(PDOException $e)
        {
            $this->logger->log(Logger::LOG_LEVEL_WARNING,
                              'MySQLPDODatabaseServiceProvider',
                              "INSERT statement failed : " . $e->getMessage());
        }

        return $insertID;
    }

    public function update($query, $data, $commit = true)
    {
        $numRowsAffect = 0;

        try
        {
            //$this->db_conn->beginTransaction();

            $stmt = $this->db_conn->prepare($query);
            $stmt->execute($data);

            //$this->commit();

            $numRowsAffect = $stmt->rowCount();
        }
        catch(PDOException $e)
        {
            $this->logger->log(Logger::LOG_LEVEL_WARNING,
                              'MySQLPDODatabaseServiceProvider',
                              "UPDATE statement failed : " . $e->getMessage());
        }

        return $numRowsAffect;
    }

    public function commit()
    {
        $this->db_conn->commit();
    }

    public function rollback()
    {
        $this->db_conn->rollBack();
    }

    public function serverTime()
    {
        $serverTime = "";

        $query = "SELECT NOW() AS serverTime";
        $result -> $this->select($query, null);

        foreach($result as $row)
        {
            $serverTime = $row['serverTime'];
        }

        return $serverTime;
    }
}

?>