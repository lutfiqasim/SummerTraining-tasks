<?php

class SaveAttempts
{
    private $error = "";
    private $firstAttempt;

    /**
     * Summary of __construct
     * @param mixed $userId
     * @param mixed $quiz_id
     */
    function __construct($userId, $quiz_id)
    {
        //Check whether user has attempt this quiz before or not
        $this->firstAttempt = $this->modifyAttempts($userId, $quiz_id);
    }
    private function modifyAttempts($userid, $quiz_id)
    {
        try {
            $query = "SELECT COUNT(*) AS record_count FROM user_quizes_log WHERE userid = ? AND quizId = ?";
            $conn = new Database();
            $result = $conn->read($query, [$userid, $quiz_id]);
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
    public function saveAttemptData($quizId, $userid, $newAttemptScore, $newAttemptAnswers)
    {
        try {
            if (empty($quizId) || empty($userid) || (empty($newAttemptScore) && $newAttemptScore !=0)|| empty($newAttemptAnswers)) {
                throw new Exception("Data Missing here", 1);
            }
            $conn = new Database();
            if ($this->firstAttempt) { //User first attempt insert new records
                $query = "INSERT INTO user_quizes_log (userid,quizId,best_Attempt_Score,best_Attempt_Answers,last_Attempt_Score,Last_Attempt_Answers)
                 VALUES (?,?,?,?,?,?)";
                $result = $conn->write($query, [$userid, $quizId, $newAttemptScore, $newAttemptAnswers, $newAttemptScore, $newAttemptAnswers]);
                return "Inserte: " . $result;
            } else { //Update existing records
                $this->error .= $this->updateBestAttempt($quizId, $userid, $newAttemptScore, $newAttemptAnswers);
                $this->error .= $this->updateLastAttempt($quizId, $userid, $newAttemptScore, $newAttemptAnswers);
                return $this->error;
            }
        } catch (Exception $e) {
            throw new Exception("Error Saving attempt: " . $e->getMessage() . "[id:" . $quizId . ", userid:" . $userid . ", attemptScore:" . $newAttemptScore . ", answer: " . $newAttemptAnswers . "]" . " status:" . $this->firstAttempt); //. "[id:" . $quizId . ", userid:" . $userid . ", attemptScore:" . $newAttemptScore . ", answer: " . $newAttemptAnswers . "]" . " status:" . $this->firstAttempt)

        }
    }


    private function updateBestAttempt($quiz_id, $userId, $newbestAttemptScore, $newbestAttemptAnswers)
    {
        try {
            $currentBestAttemptScore = $this->getBestAttemptScore($quiz_id, $userId);
            if ($currentBestAttemptScore < $newbestAttemptScore) //New best score achieved
            {
                $query = "UPDATE user_quizes_log 
                    SET best_Attempt_Score = ?, best_Attempt_Answers = ? 
                        WHERE userid = ? AND quizId = ?";
                $conn = new Database();
                $result = $conn->update($query, [$newbestAttemptScore, $newbestAttemptAnswers, $userId, $quiz_id]);
                if ($result == "success") {
                    // return true;
                } else {
                    // return false;
                }
                return "This: " . $currentBestAttemptScore;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    private function updateLastAttempt($quizId, $userid, $newlastAttemptScore, $newlastAttemptAnswers)
    {
        try {
            $query = "UPDATE user_quizes_log SET last_Attempt_Score = ?, Last_Attempt_Answers = ? WHERE userid = ? AND quizId = ?";
            $conn = new Database();
            $result = $conn->update($query, [$newlastAttemptScore, $newlastAttemptAnswers, $userid, $quizId]);
            if ($result == "success") {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return $e->getMessage();
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
            $query = "SELECT best_Attempt_Score as bestScore FROM user_quizes_log WHERE userid = ? AND quizId = ?";
            $conn = new Database();
            $bestScore = $conn->read($query, [$userID, $quizId]);
            return $bestScore[0]['bestScore'];
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
            $query = "SELECT last_Attempt_Score  as lastAttemptScore FROM user_quizes_log WHERE userid = ? AND quizId = ?";
            $conn = new Database();
            $bestScore = $conn->read($query, [$userID, $quizId]);
            return $bestScore[0]['lastAttemptScore'];
        } catch (Exception $e) {
            throw new Exception("Error Getting best score: " . $e->getMessage(), 1);
        }
    }
    public function getBestAttemptData($quizId, $userID)
    {
        if ($this->firstAttempt) {
            return "Attempt quiz to get score";
        }
        try {
            if (empty($quizId) || empty($userID)) {
                throw new Exception("quiz and user data are missing can't process request", 1);
            }
            $query = "SELECT best_Attempt_Score,best_Attempt_Answers FROM user_quizes_log WHERE userid = ? AND quizId = ? ";
            $conn = new Database();
            $result = $conn->read($query, [$userID, $quizId]);
            return $result;
        } catch (Exception $e) {
            throw new Exception("Error Getting best attempt data: " . $e->getMessage(), 1);

        }
    }

    public function getLastAttemptData($quizId, $userId)
    {
        if ($this->firstAttempt) { //no previous attempts
            return "Attempt quiz to get score";
        }
        try {
            if (empty($quizId) || empty($userId)) {
                throw new Exception("quiz and user data are missing can't process request", 1);
            }
            $query = "SELECT last_Attempt_Score ,Last_Attempt_Answers FROM user_quizes_log WHERE userid = ? AND quizId = ? ";
            $conn = new Database();
            $result = $conn->read($query, [$userId, $quizId]);
            return $result;
        } catch (Exception $e) {
            throw new Exception("Error getting attempt: " . $e->getMessage() . ", userId:" . $userId . ", quiz id :" . $quizId, 1);

        }
    }


}