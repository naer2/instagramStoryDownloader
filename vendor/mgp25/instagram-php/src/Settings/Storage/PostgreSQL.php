<?php

namespace InstagramAPI\Settings\Storage;

use InstagramAPI\Settings\Storage\Components\PDOStorage;
use PDO;

/**
 * Class PostgreSQL.
 */
class PostgreSQL extends PDOStorage
{
    /**
     * PostgreSQL constructor.
     *
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct('PostgreSQL');
    }

    /**
     * Create a new PDO connection to the database.
     *
     * {@inheritdoc}
     */
    protected function _createPDO(
        array $locationConfig)
    {
        $username = ($locationConfig['dbusername'] ? $locationConfig['dbusername'] : 'root');
        $password = ($locationConfig['dbpassword'] ? $locationConfig['dbpassword'] : '');
        $host = ($locationConfig['dbhost'] ? $locationConfig['dbhost'] : 'localhost');
        $dbName = ($locationConfig['dbname'] ? $locationConfig['dbname'] : 'instagram');
        $port = ($locationConfig['dbport'] ? $locationConfig['dbport'] : '5432');

        return new PDO("pgsql:host={$host};port={$port};dbname={$dbName};user={$username};password={$password}");
    }

    /**
     * @todo unnecessary for postgres. need use INTERFACE and after remove this func from this class
     *
     * {@inheritdoc}
     */
    protected function _enableUTF8()
    {
    }

    /**
     * Automatically create the database table if necessary.
     *
     * {@inheritdoc}
     */
    protected function _autoCreateTable()
    {
        $dbName = $this->_pdo->query("SELECT to_regclass('{$this->_dbTableName}');")->fetchColumn();

        if ($dbName) {
            return;
        }

        $this->_pdo->exec("
            create table {$this->_dbTableName}
                (
                  username      varchar(150) not null,
                  settings      text,
                  id            serial       not null
                    constraint {$this->_dbTableName}_id_pk
                    primary key,
                  cookies       text,
                  last_modified timestamp
                );
        ");
    }
}
