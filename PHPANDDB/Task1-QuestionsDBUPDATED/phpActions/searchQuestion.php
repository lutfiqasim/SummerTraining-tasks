<?php

class SearchQuestions
{
    private $error = "";

    public function retriveQuestionById($id)
    {
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
        WHERE
            q.id = ?
    ";
        try {
            $conn = new Database();
            $data = $conn->read($query, [$id]);
            if (empty($data)) {
                throw new Exception("No question was found", 1);
            }
            return $data;
        } catch (Exception $e) {
            throw new Exception("Error occurred while getting data:\n" . $e->getMessage(), 4);
        }
    }

    public function retriveQuestionBySyntax($syntax)
    {
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
        WHERE
            q.`question-Syntax` = ?
    ";
        try {
            $conn = new Database();
            $data = $conn->read($query, [$syntax]);
            if (empty($data)) {
                throw new Exception("No question was found", 1);
            }
            return $data;
        } catch (Exception $e) {
            return "Error occurred while getting data:\n" . $e->getMessage();
        }
    }
}
?>