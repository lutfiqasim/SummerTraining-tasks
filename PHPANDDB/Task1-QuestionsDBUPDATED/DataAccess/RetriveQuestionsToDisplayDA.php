<?php
include_once("Database.php");
include_once('..\phpActions\GetQuestions.php');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    $getQuestionAsOption = new GetQuestions();
    
    $questions = $getQuestionAsOption->getQuestionsAsOptions();
    echo json_encode($questions);
}
