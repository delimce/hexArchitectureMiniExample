<?php

namespace App\Infrastructure\Persistence\Mysql;

use PDO;


abstract class PdoAbstractRepository
{
    /** @var PDO $db */
    private $db;

    public function __construct()
    {
        $connectionUrl = sprintf('mysql:host=%s;dbname=%s', $_ENV['DBHOST'], $_ENV['DBNAME']);
        $this->db = new PDO($connectionUrl, $_ENV['DBUSER'], $_ENV['DBPASSWORD']);
    }

    /**
     * @param string $sql
     * @param array $params
     * 
     * @return bool
     */
    protected function executeSQL(string $sql, $params = []): bool
    {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * @param string $sql
     * @param array $params
     * @return ?array
     */
    public function query(string $sql, $params = []): ?array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch() ?: null;
    }
}
