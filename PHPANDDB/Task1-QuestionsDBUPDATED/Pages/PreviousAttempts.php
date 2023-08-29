<?php
session_start();
include_once("..\DataAccess\Database.php");
include_once("..\phpActions\Signin.php");
include_once("..\phpActions\SaveAttempts.php");
include_once("..\phpActions\GetQuestions.php");
include_once("displayQuizResultFormat.php");
include_once('..\phpActions\GetQuiz.php');
// include_once("..\DataAccess\StartQuizDA.php"); 
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    $signin = new SignIn();
    $signin->check_login($_SESSION['user_id']);
} else {
    header("Location:SignIn.php?message=AccessNotAllowed");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="..\CSS\DeleteQuestions.css" />
    <link type="text/css" rel="stylesheet" href="..\CSS\QuizResult.css" />
    <title>Previous Attempts</title>
</head>

<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['quiz']) && isset($_GET['requested'])) {
        $quizId = $_GET['quiz'];
        $userid = $_SESSION['user_id'];
        $getAttempts = new SaveAttempts($userid, $quizId);
        if ($_GET['requested'] == "best") {
            $bestscore = $getAttempts->getBestAttemptScore($quizId, $userid);
            if ($bestscore === "Attempt quiz to get score") {
                echo "<div style='margin:80px 0;font-size:28px;text-align: center; color: red;'>Attempt quiz first to get a result<br/><a href='index.php'>Go back to the main Page</a></div>";
            } else {
                displayAttemptData($bestscore, $quizId, $userid);
            }
        } elseif ($_GET['requested'] == "last") {
            $lastScore = $getAttempts->getLastAttemptScore($quizId, $userid);
            if ($lastScore === "Attempt quiz to get score") {
                echo "<div style='margin:80px 0;font-size:28px;text-align: center; color: red;'>Attempt quiz first to get a result<br/><a href='index.php'>Go back to the main Page</a></div>";
            } else {
                displayAttemptData($lastScore, $quizId, $userid);
            }
        }

    } else {
        header("Location:index.php?message=Access Denied");
    }
    function displayAttemptData($score, $quizId, $userid)
    {
        $getAttempts = new SaveAttempts($userid, $quizId);
        $getQuestions = new GetQuiz();
        $quizTitle = $getQuestions->getQuizData($quizId);
        //Holds key:question id AND value:user previous answer
        $best_attempt_question_answer = json_decode(($getAttempts->getBestAttemptData($quizId, $userid))[0]['best_Attempt_Answers']);
        $correctAns = getCorrectAnswers($best_attempt_question_answer);
        displayPreviousAttempt($score, $best_attempt_question_answer, $correctAns, $quizTitle);
        // foreach ($best_attempt_question_answer as $item) {
        //     $key = $item->key;
        //     $value = $item->value;
    
        //     // Now you can use $key and $value as needed
        //     echo "Question ID: $key, User Answer: $value<br>";
        // }
    }
    function getCorrectAnswers($data)
    {
        $idvalues = [];
        foreach ($data as $item) {
            $idvalues[] = $item->key;
        }
        $getAnswer = new GetQuestions();
        return ($getAnswer->getCorrectAnswers($idvalues));
    }
    ?>
</body>

</html>