<?php

class GetQuiz
{
    private $error = "";


    public function getQuizData($quiz_id)
    {
        try {
            $query = "SELECT name FROM quizes WHERE id =?";
            $conn = new Database();
            $data = $conn->read($query,[$quiz_id]);
            return $data[0]['name'];
        } catch (Exception $e) {
            throw new Exception("Error Processing Request", 1);

        }
    }
    public function getQuiz($quizId)
    {
        try {
            $qustionIds = $this->getQuestions($quizId);
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
            WHERE q.id = ?";

            $data = [];
            $conn = new Database();
            foreach ($qustionIds as $question) {
                $data[] = $conn->read($query, [$question]);
            }

            return $data;
        } catch (Exception $e) {
            throw new Exception("Error getting quiz: " . $e->getMessage(), 2);

        }
    }
    private function getQuestions($quizId)
    {
        try {
            $questionIds = array();
            $query = "SELECT questionId FROM quizes_questions WHERE quizID = ?";
            $conn = new Database();
            $result = $conn->read($query, [$quizId]);
            if ($result) {
                //Filter only question ids
                foreach ($result as $row) {
                    $questionIds[] = $row['questionId'];
                }
            }

            return $questionIds;
        } catch (Exception $e) {
            throw new Exception("Error Retriving questions: " . $e->getMessage(), 1);

        }

    }


}