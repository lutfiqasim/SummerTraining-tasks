<?php


class CreateQuiz
{
    private $error = "";

    public function createQuiz($data)
    {
        try {
            if (empty($data)) {
                throw new Exception("Must specify questions");
            }
            $title = $data['title'];
            $userId = $_SESSION['user_id'];
            $query = "INSERT INTO quizes (name,userid) VALUES (?,?)";
            $conn = new Database();
            $this->error = $conn->write($query, [$title, $userId]);
            $questionId = $this->getLastInsertedQuiz($title);
            $this->insertQuestions($data, $questionId[0]['id']);
            return true;
        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $err = "The quiz name already exists in the database. please enter another name";
                throw new Exception($err, 1);

            } else {
                throw new Exception("Error Creating quiz 1: " . $e->getMessage());
            }

        }
    }
    private function insertQuestions($data, $questionId)
    {
        $questionToAdd = $data['data'];
        try {
            $query = "INSERT INTO quizes_questions (quizId,questionId) VALUES (?,?)";
            $conn = new Database();
            foreach ($questionToAdd as $question) {
                $conn->write($query, [$questionId, $question['key']]);
            }
            return true;
        } catch (Exception $e) {
            throw new Exception("Error While adding questions:" . $e->getMessage());

        }
    }


    public function DeleteQuiz($quizId)
    {
        try{
            $query = "Delete * question";
        }catch(Exception $e){
            throw new Exception("Error Deleting question: ".$e->getMessage());
            
        }
    }
    private function getLastInsertedQuiz($data)
    {
        $conn = new Database();
        $questionIDquery = "SELECT id FROM quizes WHERE name  = ? LIMIT 1";
        $questionID = $conn->read($questionIDquery, [$data]);
        return $questionID;
    }
}