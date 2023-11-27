<?php

class DatabaseManager
{
    // ##################################################
    // Connection Properties
    // ##################################################
    private ?mysqli $connection = null;
    private ?mysqli_result $result = null;
    private ?mysqli_stmt $statement = null;
    private ?string $query = null;
    private ?string $host = null;
    private ?string $username = null;
    private ?string $password = null;
    private ?string $database = null;

    // ##################################################
    // Constructor
    // ##################################################

    public function __construct(
        string $host = null,
        string $username = null,
        string $password = null,
        string $database = null
    ) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        return $this;
    }

    // ##################################################
    // Getters and Setters
    // ##################################################
    public function getQuery(): string
    {
        return $this->query;
    }
    public function getDatabaseName(): string
    {
        return $this->database;
    }
    public function getConnection(): mysqli
    {
        return $this->connection;
    }

    public function setConnectionInfo(string $host, string $username, string $password, string $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        return $this;
    }

    // ##################################################


    // ##################################################
    // Methods
    // ##################################################
    /*
    * Database connection managing 
    * connect()     - connects to the database
    * disconnect()  - disconnects from the database
    */
    public function connect()
    {
        if ($this->connection) {
            return $this->connection;
        }

        $this->connection = mysqli_connect($this->host, $this->username, $this->password)
            or throw new Exception("Could not connect to database");

        mysqli_select_db($this->connection, $this->database)
            or throw new Exception("Error selecting database", 1);
        return $this;
    }


    public function disconnect()
    {
        if ($this->connection) {
            mysqli_close($this->connection);
            $this->connection = null;
        }

        if ($this->statement) {
            $this->statement->close();
            $this->statement = null;
        }

        if ($this->result) {
            $this->result->close();
            $this->result = null;
        }

        return $this;
    }

    // ##################################################
    // SQL Query Functions
    // ##################################################
    /** 
     *  prepareStatement() - prepares a query with params and returns into statement
     *  
     *   @param query   - the query to be prepared
     *   @param params  - the params to be binded to the query
     *   @return mysqli_stmt
     */
    public function prepareStatement(string $query, array $params = []): mysqli_stmt
    {
        error_reporting(E_ERROR | E_PARSE);


        if (!$this->connection) {
            throw new Exception("No connection to database");
        }

        $this->query = $query;


        $this->statement = mysqli_prepare($this->connection, $this->query)
            or throw new Exception("Could not prepare statement: " . mysqli_error($this->connection));

        if (!empty($params)) {
            $types = "";
            $values = [];

            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= "i";
                } elseif (is_float($param)) {
                    $types .= "d";
                } elseif (is_string($param)) {
                    $types .= "s";
                } else {
                    $types .= "b";
                }
                $values[] = $param;
            }

            array_unshift($values, $types);

            $bindParams = array($this->statement, ...$values);
            call_user_func_array("mysqli_stmt_bind_param", $bindParams);
        }

        if (!mysqli_stmt_execute($this->statement)) {
            throw new Exception("Could not execute statement: " . mysqli_error($this->connection));
        }

        return $this->statement;
    }


    /**
     *  executeQuery() - executes a query with params and returns an array
     *  
     *  @param query   - the query to be executed
     *  @param params  - the params to be binded to the query
     *  @return array
     */
    public function executeQuery(string $query, array $params = []): array
    {

        $this->connect() or throw new Exception("No connection to database");

        $this->query = $query;
        $this->prepareStatement($this->query, $params);
        $this->result = mysqli_stmt_get_result($this->statement);

        if (!$this->result) {
            throw new Exception("Could not get result: " . mysqli_error($this->connection));
        }

        $rows = [];
        while ($row = mysqli_fetch_assoc($this->result)) {
            $rows[] = $row;
        }

        return $rows;
    }


    /** 
     *  executeNonQuery() - executes a query with params and returns a boolean
     *  
     *   @param query   - the query to be executed
     *   @param params  - the params to be binded to the query
     *   @return bool
     */
    public function executeNonQuery(string $query, array $params = []): bool
    {

        $this->connect() or throw new Exception("No connection to database");

        $this->query = $query;
        if ($this->prepareStatement($this->query, $params)) {
            return true;
        }

        return false;
    }


    /** 
     *  select() - executes a select query and returns an array
     *  
     * @param tableName - the table to be selected from;
     * { "myTable" }
     *
     * c@param columns - the columns to be selected;
     * { default = "*" }
     * { ["col1", "col2"] }
     *
     * @param where - the conditions to be applied;
     * { default = [] }
     * { ["col1" => "value1", "col2" => "value2"] }
     * { ["col1" => ["=", "value1"], "col2" => ["=", "value2"]] }
     *
     * @param orderBy - the order of the results;
     * default = ""
     * "col1 ASC, col2 DESC"
     *
     * @param groupBy - the grouping of the results;
     * { default = "" }
     * { "col1, col2" }
     *
     * @param limit - the limit of the results;
     * { default = 0 }
     * { 10 }
     * 
     * @return array
     */
    public function select(
        string $tableName,
        array $columns = [],
        array $where = [],
        string $orderBy = "",
        string $groupBy = "",
        int $limit = 0
    ): array {
        error_reporting(E_ERROR | E_PARSE);

        $query = "SELECT " . ($columns ? implode(', ', array_map([$this->connection, 'real_escape_string'], $columns)) : '*') . " FROM " . $this->connection->real_escape_string($tableName);

        if (!empty($where)) {
            $conditions = [];
            foreach ($where as $key => $value) {
                $operator = '=';
                if (is_array($value) && count($value) === 2) {
                    list($operator, $value) = $value;
                }
                $conditions[] =  $this->connection->real_escape_string($key) . " $operator " . "\"" . $this->connection->real_escape_string($value) . "\"";
            }
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        if (!empty($orderBy)) {
            $query .= " ORDER BY " . $this->connection->real_escape_string($orderBy);
        }

        if (!empty($groupBy)) {
            $query .= " GROUP BY " . $this->connection->real_escape_string($groupBy);
        }

        if ($limit > 0) {
            $query .= " LIMIT " . (int) $limit;
        }


        return $this->executeQuery($query);
    }


    /** 
     *  insert() - executes an insert query and returns a boolean
     *  
     * @param tableName - the table to be inserted into;
     * { "myTable" }
     *
     * @param data - the data to be inserted;
     * { "col1" => "value1", "col2" => "value2" }
     *
     * @return bool
     */
    public function insert_into(string $tableName, array $data): bool
    {
        $params = [];
        $query = "INSERT INTO "
            . '`' . $this->connection->real_escape_string($tableName) . '`'
            . " SET "
            . implode(', ', array_map(function ($key, $value) use (&$params) {
                $params[] = $value;
                return $this->connection->real_escape_string($key) . ' = ?';
            }, array_keys($data), $data));
        return $this->executeNonQuery($query, $params);
    }

    /** 
     *  update() - executes an update query and returns a boolean
     *  
     * @param tableName - the table to be updated;
     * { "myTable" }
     *
     * @param data - the data to be updated;
     * { "col1" => "value1", "col2" => "value2" }
     *
     * @param where - the conditions to be applied;
     * { default = [] }
     * { ["col1" => "value1", "col2" => "value2"] }
     * { ["col1" => ["=", "value1"], "col2" => ["=", "value2"]] }
     *
     * @return bool
     */
    public function update_into(string $tableName, array $data, array $where): bool
    {
        $params = [];
        $query = "UPDATE "
            . $this->connection->real_escape_string($tableName)
            . " SET "
            . implode(', ', array_map(function ($key, $value) use (&$params) {
                $params[] = $value;
                return $this->connection->real_escape_string($key) . ' = ?';
            }, array_keys($data), $data));

        if (!empty($where)) {
            $conditions = [];
            foreach ($where as $key => $value) {
                $operator = '=';
                if (is_array($value) && count($value) === 2) {
                    list($operator, $value) = $value;
                }
                $conditions[] = $this->connection->real_escape_string($key) . " $operator " . $this->connection->real_escape_string($value);
            }
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        return $this->executeNonQuery($query, $params);
    }

    /** 
     *  delete() - executes a delete query and returns a boolean
     *  
     * @param tableName - the table to be deleted from;
     * { "myTable" }
     *
     * @param where - the conditions to be applied;
     * { default = [] }
     * { ["col1" => "value1", "col2" => "value2"] }
     * { ["col1" => ["=", "value1"], "col2" => ["=", "value2"]] }
     *
     * @return bool
     */
    public function delete_from(string $tableName, array $where): bool
    {
        $params = [];
        $query = "DELETE FROM "
            . $this->connection->real_escape_string($tableName);

        if (!empty($where)) {
            $conditions = [];
            foreach ($where as $key => $value) {
                $operator = '=';
                if (is_array($value) && count($value) === 2) {
                    list($operator, $value) = $value;
                }
                $conditions[] = $this->connection->real_escape_string($key) . " $operator " . $this->connection->real_escape_string($value);
            }
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        return $this->executeNonQuery($query, $params);
    }

    // ##################################################




    // ##################################################
    // Extras
    // ##################################################
    /*
    * listTables() - lists all the tables in the database and returns an assoc array
    */
    public function listTables(): array
    {
        $this->connect() or throw new Exception("No connection to database");

        $query = "SHOW TABLES";

        $this->result = mysqli_query($this->connection, $query)
            or throw new Exception("Could not list tables");

        $tables = [];

        while ($row = mysqli_fetch_assoc($this->result)) {
            $tables[] = $row;
        }

        $this->disconnect();
        return $tables;
    }

    // count rows
    public function countRows(string $tableName): int
    {
        $this->connect() or throw new Exception("No connection to database");

        $query = "SELECT COUNT(*) FROM " . $this->connection->real_escape_string($tableName);

        $this->result = mysqli_query($this->connection, $query)
            or throw new Exception("Could not count rows");

        $row = mysqli_fetch_assoc($this->result);

        $this->disconnect();
        return (int) $row['COUNT(*)'];
    }

    // get max
    public function getMax(string $tableName, string $column): int
    {
        $this->connect() or throw new Exception("No connection to database");

        $query = "SELECT MAX(" . $this->connection->real_escape_string($column) . ") FROM " . $this->connection->real_escape_string($tableName);

        $this->result = mysqli_query($this->connection, $query)
            or throw new Exception("Could not get max");

        $row = mysqli_fetch_assoc($this->result);

        $this->disconnect();
        return (int) $row['MAX(' . $column . ')'];
    }

    // get min
    public function getMin(string $tableName, string $column): int
    {
        $this->connect() or throw new Exception("No connection to database");

        $query = "SELECT MIN(" . $this->connection->real_escape_string($column) . ") FROM " . $this->connection->real_escape_string($tableName);

        $this->result = mysqli_query($this->connection, $query)
            or throw new Exception("Could not get min");

        $row = mysqli_fetch_assoc($this->result);

        $this->disconnect();
        return (int) $row['MIN(' . $column . ')'];
    }


    // ##################################################
    // Prepared by deJames-13
    // ##################################################

}
