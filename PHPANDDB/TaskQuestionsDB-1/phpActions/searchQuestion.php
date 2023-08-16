<?php

class SearchQuestions
{
    private $error = "";

    public function retriveQuestionById($id)
    {
        // $query = "SELECT * from questions q INNER JOIN answers a where q.id= '$id' and a.questionId = '$id'";
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
            q.id = '$id'
    ";
        try {
            $conn = new Database();
            $data = $conn->read($query);
            if ($this->error == "") {
                if (empty($data)) {
                    throw new Exception("No question was found", 1);
                }
                return $data;
            } else {
                throw new Exception($this->error->getMessage(), 3);
            }
        } catch (Exception $e) {
            throw new Exception("Error accord while getting data:\n" . $e->getMessage(), 4);
        }
    }
    public function retriveQuestionBySyntax($syntax)
    {
        // $query = "SELECT * from questions where `question-Syntax`= '$syntax' limit 1";
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
            q.`question-Syntax` = '$syntax'
    ";
        try {
            $conn = new Database();
            $data = $conn->read($query);
            if ($this->error == "") {
                if (empty($data)) {
                    throw new Exception("No question was found", 1);
                }
                return $data;
            } else {
                throw new Exception($this->error->getMessage(), 3);
            }
        } catch (Exception $e) {
            return "Error accord while getting data:\n" . $e->getMessage();
        }
    }
}

?>