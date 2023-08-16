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
            $query = "DELETE FROM questions WHERE id = '$question_id'";
            $conn = new Database();
            $conn->delete($query);
            return $this->error;
        } catch (Exception $e) {
            return "An error accourd while deleting: ".$e->getMessage();
        }
    }
}


?>