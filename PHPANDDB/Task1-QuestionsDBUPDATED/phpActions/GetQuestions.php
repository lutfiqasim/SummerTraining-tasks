<?php

class GetQuestions
{
    private $error = "";

    public function retriveQuestions()
    {
        try {
            $query = "SELECT * from questions";
            $conn = new Database();
            $data = $conn->read($query);
            if ($this->error == "") {
                return $data;
            } else {
                return $this->error;
            }
        } catch (Exception $e) {
            return "Error accord while getting data:\n" . $e->getMessage();
        }
    }
    public function retriveQuestionsByUser($userId)
    {
        try {
            $query = "SELECT * from questions Where userId=?";
            $conn = new Database();
            $data = $conn->read($query, [$userId]);
            if ($this->error == "") {
                return $data;
            } else {
                return $this->error;
            }
        } catch (Exception $e) {
            return "Error accord while getting data:\n" . $e->getMessage();
        }
    }

    public function retriveQuestionsAscendingOrder()
    {
        try {
            $query = "SELECT * from questions ORDER BY id";
            $conn = new Database();
            $data = $conn->read($query);
            if ($this->error == "") {
                return $data;
            } else {
                return $this->error;
            }
        } catch (Exception $e) {
            return "Error accord while getting data:\n" . $e->getMessage();
        }
    }
    public function retriveQuestionsDescendingOrder()
    {
        try {
            $query = "SELECT * from questions ORDER BY id DESC";
            $conn = new Database();
            $data = $conn->read($query);
            if ($this->error == "") {
                return $data;
            } else {
                return $this->error;
            }
        } catch (Exception $e) {
            return "Error accord while getting data:\n" . $e->getMessage();
        }
    }

    /**
     * Summary of getQuizQuestions
     * @param mixed $numberOfQuestions
     * @return array|string
     */
    // Not used
    public function getRandomQuestions($numberOfQuestions)
    {
        try {
            //Retrive question and answers from data base
            //Note when using limit by $numberOfQuestions
            //It retrives random number of questions but less than the limit 
            //It didn't give the exact amount
            $query = " 
            SELECT
            q.id AS question_id,
            q.`question-Syntax` AS question_syntax,
            q.correctAnswer AS correct_answer_id,
            ca.`answerSyntax` AS correct_answer_syntax,
            a.id AS choice_id,
            a.`answerSyntax` AS choice_syntax
        FROM
            questions q
        LEFT JOIN
            answers ca ON q.correctAnswer = ca.id
        LEFT JOIN
            answers a ON q.id = a.questionId
        ORDER BY RAND()";

            $conn = new Database();
            $data = $conn->read($query); //,[$numberOfQuestions]
            return $data;

        } catch (Exception $e) {
            return "Error accord while retriving questions: " . $e->getMessage();
        }
    }
    public function getCorrectAnswers($questionids)
    {
        try {

            // $query = "SELECT answerSyntax from answers a JOIN questions q where a.id IN () "; 
            $placeholders = implode(',', array_fill(0, count($questionids), '?'));

            $query = "SELECT questionId,`question-Syntax`,answerSyntax FROM answers a 
                      JOIN questions q ON a.id = q.correctAnswer
                      WHERE q.id IN ($placeholders)";

            $conn = new Database();
            $data = $conn->read($query, $questionids);
            return $data;


        } catch (Exception $e) {
            return "Error accord while retriving correctAnswers: " . $e->getMessage();
        }
    }

    public function getQuestionsAsOptions()
    {
        try {
            $query = "SELECT id,`question-Syntax` from questions";
            $conn = new Database();
            $data = $conn->read($query);
            if ($this->error == "") {
                return $data;
            } else {
                return $this->error;
            }
        } catch (Exception $e) {
            return "Error accord while getting data:\n" . $e->getMessage();
        }
    }

    //Note: This is only implmeemnted until i update SaveAttempts get Attempt data

    public function getAnswerSyntax($answerId)
    {
        try{
            $query = "SELECT answerSyntax as syntax FROM answers WHERE id = ?";
            $conn = new Database();
            $result = $conn ->read($query,[$answerId]);
            return $result;
        }catch(Exception $e)
        {
            throw new Exception("Error Getting answer syntax: ".$e->getMessage(), 1);
            
        }
    }

}
?>