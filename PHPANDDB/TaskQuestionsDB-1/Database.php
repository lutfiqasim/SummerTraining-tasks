<?php
class Database
{
    private $host = "localhost:3307";
    private $username = "root";
    private $password = "";
    private $dbname = "quizesdb";

    function connect()
    {
        try {
            $con = mysqli_connect($this->host, $this->username, $this->password, $this->dbname);
            return $con;
        } catch (Exception $error) {
            throw $error;
        }

    }

    function read($query)
    {
        try {
            $conn = $this->connect();
            $result = mysqli_query($conn, $query);

            if (!$result) {
                throw new Exception("Query execution failed: " . mysqli_error($conn));
            }

            $data = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row; // Appends to end of array
            }

            return $data;
        } catch (Exception $e) {
            throw new Exception("Error reading data: " . $e->getMessage());
        }
    }




    function write($query)
    {
        try {
            $conn = $this->connect();

            if ($conn->connect_error) {
                throw new Exception("Database connection failed: " . $conn->connect_error);
            }

            $result = mysqli_query($conn, $query);

            if (!$result) {
                throw new Exception("Query execution failed: " . mysqli_error($conn));
            }

            return true;
        } catch (Exception $e) {
            throw new Exception("Error writing data: " . $e->getMessage());
        }
    }


    function delete($query)
    {
        $conn = $this->connect();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        return true;
    }

    function update($query)
    {
        $conn = $this->connect();

        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        if (!$stmt->execute()) {
            throw new Exception("Couldn't execute query: " . $stmt->error, $stmt->errno);
        }

        //success if affected rows >0
        $affectedRows = $stmt->affected_rows;

        return $affectedRows > 0 ? 'success' : 'no_change';
    }


}