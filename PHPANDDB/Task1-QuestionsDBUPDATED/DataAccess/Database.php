<?php

class Database
{
    private $host = "localhost:3307";
    private $username = "root";
    private $password = "";
    private $dbname = "quizesdb";

    private $conn;


    /**
     * Summary of __construct
     * @throws \Exception
     */
    function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            throw new Exception("Database connection failed: " . $this->conn->connect_error);
        }
    }

    public function close()
    {
        if ($this->conn) {
            $this->conn->close();
            $this->conn = null;
        }
    }
    /**
     * Summary of read
     * @param mixed $query
     * @param mixed $params
     * @throws \Exception
     * @return array
     */
    function read($query, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }

            if (!empty($params)) {
                $paramTypes = str_repeat("s", count($params)); // Assuming all parameters are strings
                $stmt->bind_param($paramTypes, ...$params);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            return $data;
        } catch (Exception $e) {
            throw new Exception("Error reading data: " . $e->getMessage());
        }
    }
    /**
     * Summary of write
     * @param mixed $query
     * @param mixed $params
     * @throws \Exception
     * @return bool
     */
    function write($query, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }

            if (!empty($params)) {
                $paramTypes = str_repeat("s", count($params)); // Assuming all parameters are strings
                $stmt->bind_param($paramTypes, ...$params);
            }

            $stmt->execute();
            return true;
        } catch (Exception $e) {
            throw new Exception("Error writing data: " . $e->getMessage());
        }
    }

    /**
     * Summary of delete
     * @param mixed $query
     * @param mixed $params
     * @throws \Exception
     * @return bool
     */
    function delete($query, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }

            if (!empty($params)) {
                $paramTypes = str_repeat("s", count($params)); // Assuming all parameters are strings
                $stmt->bind_param($paramTypes, ...$params);
            }

            $stmt->execute();

            return true;
        } catch (Exception $e) {
            throw new Exception("Error deleting data: " . $e->getMessage());
        }
    }
    /**
     * Summary of update
     * @param mixed $query
     * @param mixed $params
     * @throws \Exception
     * @return string
     */
    function update($query, $params = [])
    {

        try {
            $stmt = $this->conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Update prepare failed: " . $this->conn->error, 1);
            }

            if (!empty($params)) {
                //All input parameters are taken as strings
                $paramTypes = str_repeat("s", count($params));
                $stmt->bind_param($paramTypes, ...$params);
            }
            $stmt->execute();
            $affectedRows = $stmt->affected_rows;

            return $affectedRows > 0 ? 'success' : 'no_change';
        } catch (Exception $e) {
            throw new Exception("Error updating data: " . $e->getMessage(), 1);

        }

    }

}