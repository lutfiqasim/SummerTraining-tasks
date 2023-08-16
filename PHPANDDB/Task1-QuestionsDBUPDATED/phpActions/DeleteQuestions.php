<?php

class DeleteQuestions
{
    private $error = "";
    
    public function deleteQuestion($question_id)
    {
        try {
            if (empty($question_id)) {
                throw new Exception("Question not found", 1);
            }
            $query = "DELETE FROM questions WHERE id = ?";
            $conn = new Database();
            $conn->delete($query, [$question_id]);//pass it as array
            return $this->error;
        } catch (Exception $e) {
            return "An error occurred while deleting: " . $e->getMessage();
        }
    }
    
    public function deleteChoice($choiceId)
    {
        try {
            if (empty($choiceId)) {
                throw new Exception("Choice not found", 1);
            }
            $query = "DELETE FROM answers WHERE id = ?";
            $conn = new Database();
            $conn->delete($query, [$choiceId]);
            return $this->error;
        } catch (Exception $e) {
            return "An error occurred while deleting choice: " . $e->getMessage();
        }
    }
}
?>