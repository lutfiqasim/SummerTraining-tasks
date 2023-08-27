<?php

class EditQuizes
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

    public function deleteQuestionFromQuiz($quizId, $questionId)
    {
        try {
            if (empty($quizId) || empty($questionId)) {
                throw new Exception("question was not found", 1);
            }
            $query = "DELETE FROM quizes_questions WHERE quizId  = ? and questionId = ?";
            $conn = new Database();
            $conn->delete($query, [$quizId, $questionId]);
            return "Removed question succesffully";

        } catch (Exception $e) {
            throw new Exception("Error Removing question", 1);

        }
    }

}