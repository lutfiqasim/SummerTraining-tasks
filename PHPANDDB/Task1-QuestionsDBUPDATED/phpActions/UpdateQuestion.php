<?php
class UpdateQuestion
{
    public function updateQuestionSyntax($id, $newSyntax)
    {
        $query = "UPDATE questions SET `question-Syntax` = ? WHERE id = ?";
        try {
            $conn = new Database();
            $result = $conn->update($query, [$newSyntax, $id]);

            if ($result === 'success') {
                return "Updated requested data, Thanks for your feedback";
            } else {
                throw new Exception("Failed to update question", 1);
            }
        } catch (Exception $e) {
            throw new Exception("Error occurred while updating Question: " . $e->getMessage(), 4);
        }
    }

    // For updating correct Answer we retrieve its id from question id
    public function updateCorrectAnswer($qId, $newSyntax)
    {
        $query = "SELECT correctAnswer FROM questions WHERE id = ?";
        try {
            $conn = new Database();
            $result = $conn->read($query, [$qId]);
            return $this->updateChoice($result[0]['correctAnswer'], $newSyntax);
        } catch (Exception $e) {
            throw new Exception("Error occurred while updating correctAnswer: " . $e->getMessage(), 4);
        }
    }

    public function updateChoice($choiceId, $newSyntax)
    {
        $query = "UPDATE answers SET answerSyntax = ? WHERE id = ?";
        try {
            $conn = new Database();
            $result = $conn->update($query, [$newSyntax, $choiceId]);
            if ($result == 'success') {
                return "Updated requested data, Thanks for your feedback";
            } else {
                throw new Exception("Failed to update choice", 1);
            }
        } catch (Exception $e) {
            throw new Exception("Error occurred while updating choice: " . $e->getMessage(), 4);
        }
    }
}
?>