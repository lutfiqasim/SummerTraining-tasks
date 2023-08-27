<?php

class GetQuizes
{

    /**
     * Summary of error
     * @var string
     */
    private $error = "";

    /**
     * Summary of retrieveQuizes
     * @throws \Exception
     * @return array
     */
    public function retrieveQuizes()
    {
        $query = "SELECT q.id, q.name AS quiz_name, u.username AS user_name FROM quizes q
          JOIN users u ON q.userid = u.id";

        try {

            $conn = new Database();

            $quizes = $conn->read($query);

            return $quizes;

        } catch (Exception $e) {
            throw new Exception("Error Retriving quizes: " . $e->getMessage());

        }

    }

    /**
     * Summary of retriveCurrentUserQuizes
     * @throws \Exception
     * @return array
     */
    public function retriveCurrentUserQuizes($userId)
    {
        $query = "SELECT q.id, q.name AS quiz_name, u.username AS user_name FROM quizes q
          JOIN users u ON q.userid = u.id
          Where q.userid = ?";

        try {

            $conn = new Database();

            $quizes = $conn->read($query, [$userId]);

            return $quizes;

        } catch (Exception $e) {
            throw new Exception("Error Retriving quizes: " . $e->getMessage());

        }

    }



}