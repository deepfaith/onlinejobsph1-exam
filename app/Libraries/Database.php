<?php

namespace Libraries;

/**
 * PDO Database Class
 * Connect to database
 * Create prepared statements
 * Bind values
 * Return rows and results
 */
class Database
{
    /**
     * DB_HOST
     * @var string
     */
    private $host = DB_HOST;
    /**
     * DB_USER
     * @var string
     */
    private $user = DB_USER;
    /**
     * DB_PASS
     * @var string
     */
    private $pass = DB_PASS;
    /**
     * DB_NAME
     * @var string
     */
    private $dbname = DB_NAME;

    /**
     * PHP Data Object
     * @var \PDO
     */
    private $dbh;
    /**
     * query statement
     * @var
     */
    private $stmt;
    /**
     * errors
     * @var string
     */
    private $error;

    public function __construct()
    {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        );

        // Create PDO instance
        try {
            $this->dbh = new \PDO($dsn, $this->user, $this->pass, $options);
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    /**
     * Prepare statement with query
     * @param $sql
     * @return void
     */
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Bind values
     * @param $param
     * @param $value
     * @param $type
     * @return void
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = \PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = \PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Execute prepared statment
     * @return mixed
     */
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     * Get results as array of objects
     * @return mixed
     */
    public function results()
    {
        $this->execute();
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Get result as an object
     * @return mixed
     */
    public function result()
    {
        $this->execute();
        return $this->stmt->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Get row count
     * @return mixed
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
