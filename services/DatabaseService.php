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
 * Service that provider Database functionality.
 *
 * @package indyframework/services
 */

interface DatabaseService extends ServiceInterface
{
    /**
     * Performs a SELECT query against a database, and returns and array of the
     * results.
     *
     * @param string $query the quuery to execute
     * @param array $data
     * @return array
     */
    public function select($query, $data);

    /**
     *
     * @param string $query The name of the table to modify
     * @param array $data an ARRAY of KEY=>VALUE pairs which represents the
     * COLUMN=>VALUE relationship.  e.g.  array('name' => 'Mark')
     * @param <boolean> $commit flag to indicate if command should be commited
     * after execution
     * @return int insert_id
     */
    public function insert($query, $data, $commit = false);

    /**
     *
     * @param string $query
     * @param array $updates
     * @param <boolean> $commit flag to indicate if command should be commited
     * after execution
     * @return int number of rows affected by the UPDATE command
     */
    public function update($query, $data, $commit = false);

    /**
     * Commits any outstanding transactions
     */
    public function commit();

    /**
     * Rolls back anby outstanding transactions
     */
    public function rollback();


    /**
     * Returns the time as defined by the server.
     *
     * @return string format of string will be dependant of the underlying
     * database.
     */
    public function serverTime();
}

?>
