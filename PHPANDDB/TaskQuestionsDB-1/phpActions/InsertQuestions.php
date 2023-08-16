<?php

class UploadQuestion
{
    private $error = "";

    public function addQuestion($data, $index)
    {
        try {
            // Validate input
            if (empty($data['questionSyntax'][$index])) {
                throw new Exception("Please enter question Syntax");
            }

            $question_syntax = $data['questionSyntax'][$index];
            $query = "INSERT INTO questions (`question-Syntax`) VALUES ('$question_syntax')";

            $conn = new Database();
            $conn->write($query);

            $this->addChoices($data, $index);
            return $this->error;
        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $err = "The question already exists in the database. Thanks for trying";
                return $err;
            } else {
                return "An error occurred: " . $e->getMessage();
            }
        }
    }

    private function addChoices($data, $index)
    {
        try {
            $choiceIndex = "choice" . $index . "";
            $givenChoices = $data[$choiceIndex];
            $correctChoice = $data['correctAnswer'][$index];
            $question_id = $this->getLastInsertedQuestion($data, $index);
            $database = new Database();

            // Insert correct answer into answers table
            $insertCorrectChoice = "INSERT INTO answers (answerSyntax, questionId) VALUES ('$correctChoice', '$question_id')";
            $database->write($insertCorrectChoice);

            // Insert all choices into answers table
            foreach ($givenChoices as $choice) {
                if ($choice != "") {
                    $choiceInsertQuery = "INSERT INTO answers (answerSyntax, questionId) VALUES ('$choice', '$question_id')";
                    $database->write($choiceInsertQuery);
                }
            }

            $this->addQuestionCorrectAnswer($data, $index);
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function addQuestionCorrectAnswer($data, $index)
    {
        try {
            if (empty($data['questionSyntax'][$index]) || empty($data['correctAnswer'][$index])) {
                throw new Exception("Please enter question and correct Answer to proceed");
            }

            $question_syntax = $data['questionSyntax'][$index];
            $conn = new Database();

            // Get question ID
            $questionIDquery = "SELECT id FROM questions WHERE `question-Syntax` = '$question_syntax' LIMIT 1";
            $questionID = $conn->read($questionIDquery)[0]['id'];

            // Get correct answer ID
            $correctAnswer = $data['correctAnswer'][$index];
            $correctAnswerIDquery = "SELECT id FROM answers WHERE answerSyntax = '$correctAnswer' AND questionId = '$questionID' LIMIT 1";
            $correctAnswerID = $conn->read($correctAnswerIDquery)[0]['id'];

            // Update question row with correct answer ID
            $queryToUpdateCorrectAnswer = "UPDATE questions SET correctAnswer = '$correctAnswerID' WHERE id = '$questionID'";
            $conn->write($queryToUpdateCorrectAnswer);
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function getLastInsertedQuestion($data, $index)
    {
        $conn = new Database();
        $question_syntax = $data['questionSyntax'][$index];
        $questionIDquery = "SELECT id FROM questions WHERE `question-Syntax` = '$question_syntax' LIMIT 1";
        $questionID = $conn->read($questionIDquery)[0]['id'];
        return $questionID;
    }
}
















// class UploadQuestion
// {
//     private $error = "";

//     public function addQuestion($data)
//     {
//         try {
//             if (!empty($data['questionSyntax'])) {
//                 $question_syntax = $data['questionSyntax'];
//                 $query = "INSERT INTO questions (`question-Syntax`) VALUES ('$question_syntax')";
//                 $conn = new Database();
//                 $conn->write($query);
//                 if ($this->error == "") {
//                     $this->addChoices($data);
//                 }
//             } else {
//                 $this->error .= "Please enter question Syntax";
//             }
//         } catch (Exception $e) {
//             if ($e->getCode() == 1062) { //Duplicate questions
//                 $this->error .= "Question already exists in our data base";
//             } else {
//                 $this->error .= $e->getMessage();
//             }
//         } finally {
//             return $this->error;
//         }
//     }

//     private function addQuestionCorrectAnswer($data)
//     {
//         try {
//             if (!empty($data['questionSyntax']) && !empty($data['correctAnswer'])) {
//                 $question_syntax = $data['$questionSyntax'];
//                 $questionIDquery = "SELECT id from questions WHERE (`question-Syntax`) ='$question_syntax' LIMIT 1";
//                 $correctAnswer = $data['correctAnswer'];
//                 $conn = new Database();
//                 $questionID = $conn->read($questionIDquery);
//                 $correctAnswerquery = "SELECT id from answers JOIN questions WHERE answerSyntax ='$correctAnswer' and questions.id = '$questionID' LIMIT 1";
//                 $correctAnswerID = $conn->read($correctAnswerquery);
//                 $queryToAddCorrectAnswer = "INESRT INTO questions (correctAnswer) VALUE('$correctAnswerID') Where question.id ='$questionID'";
//                 $conn->save($queryToAddCorrectAnswer);
//             } else {
//                 $this->error .= "Please enter question and correct Answer to procced";
//             }
//         } catch (Exception $e) {
//             $this->error .= $e->getMessage();
//         } finally {
//             return $this->error;
//         }
//     }
//     private function addChoices($data)
//     {
//         try {
//             //Array of different choices
//             $givenChoices = $data['choice'];
//             $correctChoice = $data['correctAnswer'];
//             $question_id = $this->getLastInsertedQuestion($data);
//             $database = new Database();
//             $insertCorrectChoice = "INSERT INTO answers (answerSyntax,questionId) VALUES ('$correctChoice', '$question_id')";
//             $database->write($insertCorrectChoice);
//             foreach ($givenChoices as $index => $choice) {
//                 $choiceInsertQuery = "INSERT INTO answers (answerSyntax,questionId ) VALUES ('$choice', '$question_id')";
//                 $database->write($choiceInsertQuery);
//             }
//             if ($this->error == "") {
//                 $this->addQuestionCorrectAnswer($data);
//             }

//         } catch (Exception $e) {
//             throw $e;
//         }
//     }
//     private function getLastInsertedQuestion($data)
//     {
//         $conn = new Database();
//         $question_syntax = $data['questionSyntax'];
//         $questionIDquery = "SELECT id from questions WHERE (`question-Syntax`) ='$question_syntax' LIMIT 1";
//         return $conn->read($questionIDquery);
//     }
// }
?>