<?php

namespace InstagramAPI\Settings\Storage;

use InstagramAPI\Settings\Storage\Components\PDOStorage;
use PDO;

/**
 * Persistent storage backend which uses a MySQL server.
 *
 * Read the PDOStorage documentation for extra details about this backend.
 *
 * @author SteveJobzniak (https://github.com/SteveJobzniak)
 */
class MySQL extends PDOStorage
{
    /**
     * Constructor.
     *
     * {@inheritdoc}
     */
    public function __construct()
    {
        // Configure the name of this backend.
        parent::__construct('MySQL');
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

        return new PDO("mysql:host={$host};dbname={$dbName}",
                       $username, $password);
    }

    /**
     * Enable UTF-8 encoding on the connection.
     *
     * {@inheritdoc}
     */
    protected function _enableUTF8()
    {
        $this->_pdo->query('SET NAMES UTF8')->closeCursor();
    }

    /**
     * Automatically create the database table if necessary.
     *
     * {@inheritdoc}
     */
    protected function _autoCreateTable()
    {
        // Detect the name of the MySQL database that PDO is connected to.
        $dbName = $this->_pdo->query('SELECT database()')->fetchColumn();

        // Abort if we already have the necessary table.
        $sth = $this->_pdo->prepare('SELECT count(*) FROM information_schema.TABLES WHERE (TABLE_SCHEMA = :tableSchema) AND (TABLE_NAME = :tableName)');
        $sth->execute([':tableSchema' => $dbName, ':tableName' => $this->_dbTableName]);
        $result = $sth->fetchColumn();
        $sth->closeCursor();
        if ($result > 0) {
            return;
        }

        // Create the database table. Throws in case of failure.
        // NOTE: We store all settings as a JSON blob so that we support all
        // current and future data without having to alter the table schema.
        $this->_pdo->exec('CREATE TABLE `'.$this->_dbTableName.'` (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            settings MEDIUMBLOB NULL,
            cookies MEDIUMBLOB NULL,
            last_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY (username)
        ) COLLATE="utf8_general_ci" ENGINE=InnoDB;');
    }
}
