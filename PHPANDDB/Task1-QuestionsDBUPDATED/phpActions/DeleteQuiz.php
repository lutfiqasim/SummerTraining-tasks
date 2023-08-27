<?php

class DeleteQuiz
{
    private $eror = "";

    public function deleteCurrentQuiz($quizId)
    {
        try {
            if (empty($quizId)) {
                throw new Exception("No quiz was found", 1);
            }
            $query = "DELETE FROM quizes WHERE id = ?";
            $conn = new Database();
            $conn->delete($query, [$quizId]);
            return true;
        } catch (Exception $e) {
            throw new Exception("Error Deleting question: " . $e->getMessage());

        }
    }

}