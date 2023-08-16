<?php
class UpdateQuestion
{
    public function updateQuestionSyntax($id, $newSyntax)
    {
        $query = "UPDATE questions SET `question-Syntax` = '$newSyntax'
        WHERE id = '$id'";
        try {
            $conn = new Database();
            $result = $conn->update($query);

            if ($result === 'success') {
                return "Updated requested data,Thanks for your feedback";
            } else {
                throw new Exception("Failed to update question", 1);
            }
        } catch (Exception $e) {
            throw new Exception("Error accord while updating Question:  " . $e->getMessage(), 4);
        }
    }
    //For updating correct Answer we retrive its id from question id
    public function updateCorrectAnswer($qId, $newSyntax)
    {
        $query = "SELECT correctAnswer FROM questions WHERE id ='$qId'";
        try {
            $conn = new Database();
            $result = $conn->read($query);
            return $this->updateChoice($result[0]['correctAnswer'], $newSyntax);
        } catch (Exception $e) {
            throw new Exception("Error accord while updating correctAnswer: " . $e->getMessage(), 4);
        }
    }
    public function updateChoice($choiceId, $newSyntax)
    {
        $query = "UPDATE answers SET answerSyntax = '$newSyntax'
        WHERE id = '$choiceId'";
        try {
            $conn = new Database();
            $result = $conn->update($query);
            if ($result == 'success') {
                return "Updated requested data,Thanks for your feedback";
            } else {
                throw new Exception("Failed to update question", 1);
            }
        } catch (Exception $e) {
            throw new Exception("Error accord while updating choice: " . $e->getMessage(), 4);
        }
    }

}
?>