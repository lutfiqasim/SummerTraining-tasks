<?php

class EditQuizes
{
    private $error = "";

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

    public function addNewQuestionsToQuiz($quizId, $questionIds)
    {
        try {
            if (empty($quizId) || empty($questionIds)) {
                throw new Exception("Question not found", 1);
            }
            $query = "INSERT INTO quizes_questions (quizId,questionId) VALUES (?,?)";
            $conn = new Database();
            foreach ($questionIds as $questoinId) {
                $this->error .= $conn->write($query, [$quizId, $questoinId]);
            }
            if ($this->error == "") {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            throw new Exception("Error Adding new questions: " . $e->getMessage());

        }
    }

}