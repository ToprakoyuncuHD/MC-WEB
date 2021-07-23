<?php

namespace OpenMCWeb;

use PDO;

class DBConnections
{
    public $connection;
    public $handle;

    private $query;

    private $passthruVars = array();

    /**
     * @param $connection PDO The connection to the database server
     */
    public function __construct($connection)
    {
        $this->connection = $connection;

        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    /**
     * @param $call Callable PDO function to call
     * @return mixed Output of the PDO call
     */
    private function doPDO($call)
    {
        try {
            return $call();
        } catch (\PDOException $e) {
            die('<span style="color:red; font-weight: bolder;">PDO Error ' . $e->getCode() . ':</span> ' .
                $e->getMessage() . '<br><br><span style="font-weight: bolder;">In File: </span>' . $e->getFile() .
                ' Line ' . $e->getLine());
        }
    }

    /**
     * @param $query String Database query
     * @return boolean Did it work?
     *
     * Creates the query to execute
     */
    public function makeQuery($query)
    {
        $this->query = $query;
        if (!($handle = $this->doPDO(function () {
            return $this->connection->prepare($this->query);
        }))
        ) {
            return false;
        }

        $this->handle = $handle;

        return true;
    }

    /**
     * @param $placeholder mixed Placeholder in query
     * @param $var mixed Replacement
     * @param $type int PDO Parameter type
     *
     * Binds variables to query made at makeQuery() (securely)
     */
    public function bind($placeholder, $var, $type = PDO::PARAM_STR)
    {
        $this->handle->bindParam($placeholder, $var, $type);
    }

    /**
     * Executes the query made at makeQuery()
     */
    public function executeHandle()
    {
        $this->doPDO(function () {
            $this->handle->execute();
        });
    }

    /**
     * @param $bindarray Array Array that has binds.
     *
     *
     * Executes the query made at makeQuery() with binds from the $bindarray parameter
     */
    public function executeHandleWithBindArray($bindarray)
    {
        $this->passthruVars['bindarray'] = $bindarray;
        $this->doPDO(function () {
            $this->handle->execute($this->passthruVars['bindarray']);
        });
    }

    /**
     * @return array Query results from database
     *
     * Returns all the rows returned fro the query made at makeQuery()
     */
    public function returnResult()
    {
        return $this->doPDO(function () {
            $this->handle->setFetchMode(PDO::FETCH_ASSOC);
            return $this->handle->fetchAll();
        });
    }

    /**
     * Cleans the variables
     */
    public function clean()
    {
        $this->passthruVars = null;
        $this->handle = null;
        $this->query = null;
    }

    /**
     * Closes the database handle.
     */
    public function close()
    {
        $this->clean();

        $this->connection = null;
    }
}