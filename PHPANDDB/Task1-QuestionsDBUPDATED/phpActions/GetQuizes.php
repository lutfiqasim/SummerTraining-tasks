<?php


class GetQuizes
{

    private $error = "";

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



}