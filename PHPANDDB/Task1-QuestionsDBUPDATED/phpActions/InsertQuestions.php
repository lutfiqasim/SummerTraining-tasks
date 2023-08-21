<?php

class UploadQuestion
{
    private $error = "";

    public function addQuestion($data, $userId)
    {
        try {
            // Validate input
            if (empty($data['questionSyntax'])) {
                throw new Exception("Please enter question Syntax");
            }

            $question_syntax = $data['questionSyntax'];
            $query = "INSERT INTO questions (`question-Syntax`,userId ) VALUES (?,?)";

            $conn = new Database();
            $conn->write($query, [$question_syntax, $userId]);

            $this->addChoices($data);
            return $this->error;
        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $err = "The question already exists in the database. Thanks for trying";
                return $err;
            } else {
                return "An error occurred: " . $e->getMessage()."Error is : " .$userId."";
            }
        }
    }

    private function addChoices($data)
    {
        try {
            $choiceIndex = "choice";
            $givenChoices = $data[$choiceIndex];
            $question_id = $this->getLastInsertedQuestion($data);
            $database = new Database();

            // Insert correct answer into answers table
            if (isset($data['correctAnswer'])) {
                $correctChoice = $data['correctAnswer'];
                $insertCorrectChoice = "INSERT INTO answers (answerSyntax, questionId) VALUES (?, ?)";
                $database->write($insertCorrectChoice, [$correctChoice, $question_id]);
            }
            // Insert all choices into answers table
            foreach ($givenChoices as $choice) {
                if ($choice != "") {
                    $choiceInsertQuery = "INSERT INTO answers (answerSyntax, questionId) VALUES (?, ?)";
                    $database->write($choiceInsertQuery, [$choice, $question_id]);
                }
            }

            $this->addQuestionCorrectAnswer($data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function addQuestionCorrectAnswer($data)
    {
        try {
            if (empty($data['questionSyntax']) || empty($data['correctAnswer'])) {
                throw new Exception("Please enter question and correct Answer to proceed");
            }

            $question_syntax = $data['questionSyntax'];
            $conn = new Database();

            // Get question ID
            $questionIDquery = "SELECT id FROM questions WHERE `question-Syntax` = ? LIMIT 1";
            $questionID = $conn->read($questionIDquery, [$question_syntax])[0]['id'];

            // Get correct answer ID
            $correctAnswer = $data['correctAnswer'];
            $correctAnswerIDquery = "SELECT id FROM answers WHERE answerSyntax = ? AND questionId = ? LIMIT 1";
            $correctAnswerID = $conn->read($correctAnswerIDquery, [$correctAnswer, $questionID])[0]['id'];

            // Update question row with correct answer ID
            $queryToUpdateCorrectAnswer = "UPDATE questions SET correctAnswer = ? WHERE id = ?";
            $conn->write($queryToUpdateCorrectAnswer, [$correctAnswerID, $questionID]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    // For already inserted questions where new choice is added in the update
    public function insertNewChoice($data, $question_id)
    {
        try {
            $database = new Database();
            $choiceInsertQuery = "INSERT INTO answers (answerSyntax, questionId) VALUES (?, ?)";
            $this->error .= $database->write($choiceInsertQuery, [$data, $question_id]);
            if ($this->error == "") {
                return " Successful";
            }
            return $this->error;
        } catch (Exception $e) {
            throw new Exception("Error Inserting new Choice: " . $e->getMessage(), 1);
        }
    }

    private function getLastInsertedQuestion($data)
    {
        $conn = new Database();
        $question_syntax = $data['questionSyntax'];
        $questionIDquery = "SELECT id FROM questions WHERE `question-Syntax` = ? LIMIT 1";
        $questionID = $conn->read($questionIDquery, [$question_syntax])[0]['id'];
        return $questionID;
    }
}