<?php
error_reporting(E_ERROR | E_PARSE);

require_once 'db-manager.php';

final class DatabaseConfig extends DatabaseManager
{
    const HOST = "localhost";
    const USER = "root";
    const PASS = "";
    const DATABASE = "espinosa_lacao_lim_database_081323";

    public function __construct()
    {
        $this->setConnectionInfo(
            self::HOST,
            self::USER,
            self::PASS,
            self::DATABASE
        )->connect();
        return $this;
    }
}
