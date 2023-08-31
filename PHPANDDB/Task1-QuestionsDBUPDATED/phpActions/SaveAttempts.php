<?php

class SaveAttempts
{
    private $error = "";
    private $firstAttempt;

    private $conn;

    /**
     * Summary of __construct
     * @param mixed $userId
     * @param mixed $quiz_id
     */
    function __construct($userId, $quiz_id)
    {
        //Check whether user has attempt this quiz before or not
        $this->conn = new Database();
        $this->firstAttempt = $this->modifyAttempts($userId, $quiz_id);
    }
    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close(); // Close the database connection
        }
    }

    private function modifyAttempts($userid, $quiz_id)
    {
        try {
            $query = "SELECT COUNT(*) AS record_count FROM user_quizes_log WHERE userid = ? AND quizId = ?";
            $result = $this->conn->read($query, [$userid, $quiz_id]);
            if (isset($result[0]['record_count']) && $result[0]['record_count'] > 0) { //Update data Not first attempt
                return false;
            } else { //Create a new record first time attempting quiz
                $this->error .= "[Entered here]: " . $result[0]['record_count'] . ", user id:" . $userid . ", quizId:" . $quiz_id;
                return true;
            }
        } catch (Exception $e) {
            throw new Exception("Error updating attemps: " . $e->getMessage(), 12);
        }
    }
    public function saveAttemptData($quizId, $userid, $newAttemptAnswersId, $score)
    {
        $lastInsertedId = "";
        try {
            if (empty($quizId) || empty($userid) || empty($newAttemptAnswersId) || (empty($score) && $score != 0)) {
                throw new Exception("Data Missing", 1);
            }
            // $conn = new Database();
            //User first attempt insert new records
            $query = "INSERT INTO user_quizes_log (userid,quizId,score)
                 VALUES (?,?,?)";
            $result = $this->conn->write($query, [$userid, $quizId, $score]); //$newAttemptScore, $newAttemptAnswers, $newAttemptScore, $newAttemptAnswers
            $lastInsertedId = $this->getLastInsertedRecord();
            $query2 = "INSERT INTO user_attempts_answers (attemptId,questionId,userAnswer) VALUES (?,?,?)";
            foreach ($newAttemptAnswersId as $questiondata) {
                $questionId = $questiondata['key'];
                $userAnswer = $questiondata['value'];
                $answerId = $this->getAnswerID($questionId, $userAnswer);
                $this->conn->write($query2, [$lastInsertedId[0]['id'], $questionId, $answerId]);
            }

            return true;

        } catch (Exception $e) {
            throw new Exception("HERE:" . $e->getMessage()); //. "[id:" . $quizId . ", userid:" . $userid . ", attemptScore:" . $newAttemptScore . ", answer: " . $newAttemptAnswers . "]" . " status:" . $this->firstAttempt)

        }
    }


    public function getBestAttemptScore($quizId, $userID)
    {
        if ($this->firstAttempt) {
            return "Attempt quiz to get score";
        }
        try {
            if (empty($quizId) || empty($userID)) {
                throw new Exception("quiz and user data are missing can't process request", 1);
            }
            $query = "SELECT MAX(score) as maxScore FROM user_quizes_log WHERE userid = ? AND quizId = ?";
            // $conn = new Database();
            $bestScore = $this->conn->read($query, [$userID, $quizId]);
            return $bestScore[0]['maxScore'];
        } catch (Exception $e) {
            throw new Exception("Error Getting best score: " . $e->getMessage(), 1);
        }
    }
    public function getLastAttemptScore($quizId, $userID)
    {
        if ($this->firstAttempt) {
            return "Attempt quiz to get score";
        }
        try {
            if (empty($quizId) || empty($userID)) {
                throw new Exception("quiz and user data are missing can't process request", 1);
            }
            $query = "SELECT score as lastAttemptScore FROM user_quizes_log WHERE userid = ? AND quizId = ? ORDER BY timeTaken DESC LIMIT 1";
            // $conn = new Database();
            $bestScore = $this->conn->read($query, [$userID, $quizId]);
            return $bestScore[0]['lastAttemptScore'];
        } catch (Exception $e) {
            throw new Exception("Error Getting best score: " . $e->getMessage(), 1);
        }
    }
    //Get best attempt of current user
    public function getBestAttemptData($quizId, $userID)
    {
        try {
            if (empty($quizId) || empty($userID)) {
                throw new Exception("quiz and user data are missing can't process request", 1);
            }
            $query = "SELECT id as id FROM user_quizes_log WHERE userid = ? AND quizId = ? ORDER BY score DESC LIMIT 1";
            $result = $this->conn->read($query, [$userID, $quizId]); //Gets best attempt id
            $attemptId = $result[0]['id'];
            $queryGetUserQuestionAnswer = "SELECT questionId,userAnswer FROM user_attempts_answers WHERE attemptId = ?";
            $result = $this->conn->read($queryGetUserQuestionAnswer, [$attemptId]);
            return $result;
        } catch (Exception $e) {
            throw new Exception("Error Getting best attempt data: " . $e->getMessage(), 1);

        }
    }

    public function getAttemptData($attemptId)
    {
        try {
            if (empty($attemptId)) {
                throw new Exception("quiz and user data are missing can't process request", 1);
            }
            $queryGetUserQuestionAnswer = "SELECT questionId,userAnswer FROM user_attempts_answers WHERE attemptId = ?";
            $result = $this->conn->read($queryGetUserQuestionAnswer, [$attemptId]);
            return $result;
        } catch (Exception $e) {
            throw new Exception("Error Getting best attempt data: " . $e->getMessage(), 1);

        }

    }

    public function getLastAttemptsData($quizId, $userId)
    {
        try {
            if (empty($quizId) || empty($userId)) {
                throw new Exception("quiz and user data are missing can't process request", 1);
            }
            $query = "SELECT id, score,timeTaken as ti  FROM user_quizes_log WHERE userid = ? AND quizId = ? ";
            // $conn = new Database();
            $result = $this->conn->read($query, [$userId, $quizId]);
            return $result;
        } catch (Exception $e) {
            throw new Exception("Error getting attempt: " . $e->getMessage() . ", userId:" . $userId . ", quiz id :" . $quizId, 1);

        }
    }

    public function numberOfparticipantsOfQuiz($quiz_id)
    {
        try {
            $query = "SELECT COUNT(*) as participantNO FROM user_quizes_log WHERE quizId = ? ";
            // $conn = new Database();
            $result = $this->conn->read($query, [$quiz_id]);
            return $result[0]['participantNO'];
        } catch (Exception $e) {
            throw new Exception("Error getting count", 1);
        }
    }

    public function getScoresStats($quiz_id)
    {
        try {
            $query = "SELECT AVG(score) as avgScore, MAX(score) as maxScore FROM user_quizes_log WHERE quizId = ?";
            $numberOfQuestionsQuery = "SELECT COUNT(*) as numberOfquestions FROM quizes_questions WHERE quizId = ? ";
            // $conn = new Database();
            $avgScore_MAxScore = $this->conn->read($query, [$quiz_id]);
            $totalQuestions = $this->conn->read($numberOfQuestionsQuery, [$quiz_id]);
            $stats = array(
                'averageLastScore' => $avgScore_MAxScore[0]['avgScore'],
                'maxBestScore' => $avgScore_MAxScore[0]['maxScore'],
                'totalQuestions' => $totalQuestions[0]['numberOfquestions']
            );

            return $stats;
        } catch (Exception $e) {
            throw new Exception("Error getting scores stats:" . $e->getMessage(), 1);
        }
    }

    private function getLastInsertedRecord()
    {
        try {
            $query = "SELECT LAST_INSERT_ID() as id FROM user_quizes_log";
            // $conn = new Database();
            $result = $this->conn->read($query);

            if (!empty($result)) {
                return $result; //[0]['id']  
            } else {
                throw new Exception("No last inserted ID found.");
            }

        } catch (Exception $e) {
            throw new Exception("Error getting last inserted record: " . $e->getMessage());
        }
    }


    //just for now need to be updated so that i don't have to retrive it each time from db
    private function getAnswerID($questionId, $answerSyntax)
    {
        try {
            $query = "SELECT id as ansId from answers WHERE answerSyntax =? AND questionId = ?";
            // $conn = new Database();

            $result = $this->conn->read($query, [$answerSyntax, $questionId]);
            return $result[0]['ansId'];
        } catch (Exception $e) {

        }
    }

}


// private function updateBestAttempt($quiz_id, $userId, $newbestAttemptScore, $newbestAttemptAnswers)
// {
//     try {
//         $currentBestAttemptScore = $this->getBestAttemptScore($quiz_id, $userId);
//         if ($currentBestAttemptScore < $newbestAttemptScore) //New best score achieved
//         {
//             $query = "UPDATE user_quizes_log 
//                 SET best_Attempt_Score = ?, best_Attempt_Answers = ? 
//                     WHERE userid = ? AND quizId = ?";
//             // $conn = new Database();
//             $result = $this->conn->update($query, [$newbestAttemptScore, $newbestAttemptAnswers, $userId, $quiz_id]);
//             if ($result == "success") {
//                 // return true;
//             } else {
//                 // return false;
//             }
//             return "This: " . $currentBestAttemptScore;
//         }
//     } catch (Exception $e) {
//         return $e->getMessage();
//     }
// }
// private function updateLastAttempt($quizId, $userid, $newlastAttemptScore, $newlastAttemptAnswers)
// {
//     try {
//         $query = "UPDATE user_quizes_log SET last_Attempt_Score = ?, Last_Attempt_Answers = ? WHERE userid = ? AND quizId = ?";
//         // $conn = new Database();
//         $result = $this->conn->update($query, [$newlastAttemptScore, $newlastAttemptAnswers, $userid, $quizId]);
//         if ($result == "success") {
//             return true;
//         } else {
//             return false;
//         }
//     } catch (Exception $e) {
//         return $e->getMessage();
//     }
// }