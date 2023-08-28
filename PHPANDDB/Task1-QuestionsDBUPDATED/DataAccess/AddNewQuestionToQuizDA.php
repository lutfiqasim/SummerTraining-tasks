<?php
session_start();
include_once("Database.php");
include_once("..\phpActions\EditQuizes.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['action'], $_POST['data'], $_POST['qid'])) {
        $questionsToAdd = $_POST['data'];
        try {
            $addNewQuestions = new EditQuizes();
            // print_r($_POST['data']);
            $q = $addNewQuestions->addNewQuestionsToQuiz($_POST['qid'], $_POST['data']);
            
            echo "Added new questions successfully";
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
}

?>