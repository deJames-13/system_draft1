<?php
// error_reporting(E_ERROR | E_PARSE);

require_once 'db-manager.php';

final class DatabaseConfig extends DatabaseManager
{
    const HOST = "localhost";
    const USER = "root";
    const PASS = "";
    const DATABASE = "deh_system_db";

    public function __construct()
    {
        try {
            $this->setConnectionInfo(
                self::HOST,
                self::USER,
                self::PASS,
                self::DATABASE
            )->connect();
        } catch (\Throwable $th) {
            // check if database exists else create from sql file: ../db/deh_database_contained.sql
            $conn = $this->getConnection();
            $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . self::DATABASE . "'";
            $result = $conn->query($sql);

            if (!$result) {
                die("Error checking if database exists: " . $conn->error);
            }

            if ($result->num_rows == 0) {
                $sql = file_get_contents('../db/deh_database_contained.sql');

                if (!$conn->multi_query($sql)) {
                    die("Error creating database: " . $conn->error);
                }

                // Consume remaining results
                while ($conn->more_results()) {
                    $conn->next_result();
                    $conn->use_result();
                }

                // Reconnect after creating the database
                $this->setConnectionInfo(
                    self::HOST,
                    self::USER,
                    self::PASS,
                    self::DATABASE
                )->connect();
            } else {
                die("Error: " . $th->getMessage());
            }
        }

        return $this;
    }
}
