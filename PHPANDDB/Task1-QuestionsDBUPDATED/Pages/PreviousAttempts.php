<?php
session_start();
include_once("..\DataAccess\Database.php");
include_once("..\phpActions\Signin.php");
include_once("..\phpActions\SaveAttempts.php");
include_once("..\phpActions\GetQuestions.php");
include_once("displayQuizResultFormat.php");
include_once('..\phpActions\GetQuiz.php');
include_once('..\phpActions\GetQuestions.php');
// include_once("..\DataAccess\StartQuizDA.php"); 
$userData = "";
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    $signin = new SignIn();
    $userData = $signin->check_login($_SESSION['user_id']);
} else {
    header("Location:index.php?message=AccessNotAllowed");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="..\CSS\previousAttempt.css" />
    <title>Previous Attempts</title>
</head>

<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['quiz']) && isset($_GET['requested'])) {
        try {
            $quizId = $_GET['quiz'];
            $userid = $_SESSION['user_id'];
            $getAttempts = new SaveAttempts($userid, $quizId);
            if ($_GET['requested'] == "best") {
                $bestscore = $getAttempts->getBestAttemptScore($quizId, $userid);
                if ($bestscore === "Attempt quiz to get score") {
                    echo "<div style='margin:80px 0;font-size:28px;text-align: center; color: red;'>Attempt quiz first to get a result<br/><a href='AttemptQuiz2.php'>Go back</a></div>";
                } else {
                    // $best_attempt_question_answer = json_decode(($getAttempts->getBestAttemptData($quizId, $userid))[0]['best_Attempt_Answers']);
                    $best_attempt_question_answer = $getAttempts->getBestAttemptData($quizId, $userid);
                    displayAttemptData($bestscore, $quizId, $userid, $best_attempt_question_answer);
                    // print_r($best_attempt_question_answer);
                }
            } elseif ($_GET['requested'] == "last") {
                $lastScore = $getAttempts->getLastAttemptScore($quizId, $userid);
                if ($lastScore === "Attempt quiz to get score") {
                    echo "<div style='margin:80px 0;font-size:28px;text-align: center; color: red;'>Attempt quiz first to get a result<br/><a href='AttemptQuiz2.php'>Go back</a></div>";
                } else {
                    $allPreviousAttempts = $getAttempts->getLastAttemptsData($quizId, $userid);
                    generateAttemptsTable($quizId, $allPreviousAttempts);
                }
            }
        } catch (Exception $e) {
            echo "<div style='margin:80px 0;font-size:28px;text-align: center; color: red;'>Attempt quiz first to get a result<br/>We are encountring some errors,Try again later</div>";
            echo "<div style='margin:80px 0;font-size:28px;text-align: center; color: red;'>Attempt quiz first to get a result<br/><a href='AttemptQuiz2.php'>Go back</a></div>";

        }
    } else {
        header("Location:index.php?message=Access Denied");
    }
    function displayAttemptData($score, $quizId, $userid, $best_attempt_question_answer)
    {
        $getQuiz = new GetQuiz();
        $quizTitle = $getQuiz->getQuizData($quizId);
        //Holds key:question id AND value:user previous answer
        $correctAns = getCorrectAnswers($best_attempt_question_answer);
        dsiplayPreviousHelper($score, $best_attempt_question_answer, $correctAns, $quizTitle, $quizId);
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

    function generateAttemptsTable($quizId, $attemptsData)
    {
        include_once("Header-SideBar.php");
        global $userData;
        formatInnerPagesHeader($userData);
        echo "<div style='margin:10px;margin-top:25px;font-size:18px;text-align: center;'>Quiz 1 </div>";
        echo '<table class="attempts-table">';
        echo '<tr>
                <th>Attempt#</th>
                <th>Score</th>
                <th>Time Taken</th>
                <th></th>
              </tr>';
        //   <th>Quiz</th>
    
        foreach ($attemptsData as $index => $attempt) {
            $attemptNumber = $index + 1;
            // $quizName = "Attempt " . $attempt['id'];
            $score = $attempt['score'];
            $timeTaken = $attempt['ti'];

            echo '<tr>
            <form action="attempts_details_page.php" method="post">
                <input style="display:none;" name="quizId" value =' . $quizId . '></input>
                <input style="display:none;" name="score" value =' . $score . '></input>
                <td>' . $attemptNumber . '</td>
                <td>' . $score . '</td>
                <td>' . $timeTaken . '</td>
                <td><button name="details" value="' . $attempt['id'] . '">View Details</button></td>
            </form>' .
                "<td><form method='post' action='QuizPage.php'>".
            '<input type="hidden" name="quiz_id" value="' . $quizId . '">'.
            '<button type="submit" name="start" value="ReTake">Re-take Exam</button>
            </form></td>' . '</tr>';

        }
        echo '</table>';
        echo '<a  href="AttemptQuiz2.php">Go back </a>';
    }

    ?>
</body>

</html>