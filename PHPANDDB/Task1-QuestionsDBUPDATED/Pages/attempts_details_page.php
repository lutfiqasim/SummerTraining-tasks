<?php
session_start();
include_once("..\DataAccess\Database.php");
include_once("..\phpActions\SaveAttempts.php");
include_once("displayQuizResultFormat.php");
include_once('..\phpActions\GetQuiz.php');
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
} else {
    header("Location:index.php");
}

if (($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['details'])))
{
    $attemptId = $_POST['details'];
    $quizId = $_POST['quizId'];
    $score = $_POST['score'];
    $userid= $_SESSION['user_id'];
    $getAttempts = new SaveAttempts($userid, $quizId);
    $attempt_question_answer = $getAttempts ->getAttemptData($attemptId);
    displayAttemptData($score,$quizId,$userid,$attempt_question_answer);
}

function displayAttemptData($score, $quizId, $userid, $attempt_question_answer)
{
    $getQuestions = new GetQuiz();
    $quizTitle = $getQuestions->getQuizData($quizId);
    //Holds key:question id AND value:user previous answer
    $correctAns = getCorrectAnswers($attempt_question_answer);
    dsiplayPreviousHelper($score, $attempt_question_answer, $correctAns, $quizTitle,$quizId);
}
function getCorrectAnswers($data)
{
    $idvalues = [];
    foreach ($data as $item) {
        $idvalues[] = $item['questionId'];
    }
    $getAnswer = new GetQuestions();
    return ($getAnswer->getCorrectAnswers($idvalues));
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attempt Details</title>
    <link type="text/css" rel="stylesheet" href="..\CSS\previousAttempt.css" />
</head>
<body>
    
</body>
</html>