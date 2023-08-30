<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quiz Results</title>
</head>

<body>

    <?php
    include_once("Database.php");
    include_once("..\phpActions\GetQuestions.php");
    include_once("..\phpActions\SaveAttempts.php");
    include_once("..\Pages\displayQuizResultFormat.php");
    include_once('..\phpActions\GetQuiz.php');
    session_start();
    if (isset($_SESSION['user_id'])) {


        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            if (isset($_POST['action']) && $_POST['action'] == "check") {
                if (isset($_POST['data'])) {
                    try {
                        $questionData = $_POST['data'];
                        $idvalues = [];
                        foreach ($questionData as $key => $value) {
                            $idvalues[] = $value['key'];
                        }
                        $getAnswer = new GetQuestions();
                        $correctAnswers = ($getAnswer->getCorrectAnswers($idvalues));
                        $getQuestions = new GetQuiz();
                        $quizTitle = $getQuestions->getQuizData($_POST['id']);
                        $score = checkScore($questionData, $correctAnswers);
                        displayResultFormat($score, $questionData, $correctAnswers, $quizTitle);
                        $result = SavebestAttemptAndLastAttemp($score);
                        print_r($result);
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                }
            }
        }
    } else {
        header("Location:..\Pages\index.php");
    }
    function checkScore($data, $correctAnswer)
    {
        $score = 0;
        foreach ($data as $value) {
            $questionId = $value['key'];
            $userAnswer = $value['value'];
            foreach ($correctAnswer as $val) {
                if ($val['questionId'] == $questionId) {
                    if ($userAnswer == $val['answerSyntax']) {
                        $score += 10;
                    }
                }
            }
        }
        return $score;
    }

    function SavebestAttemptAndLastAttemp($currentScore)
    {
        try {
            $quizId = $_POST['id'];
            $usreId = $_SESSION['user_id'];
            //json encode format:answer:
            //key:questionId value: user answer
            // [{"key":"7","value":"1000"},{"key":"30","value":"True"},{"key":"31","value":"Spinach "},{"key":"93","value":"Choice1 updated"},{"key":"117","value":"CorrectAnswer"}
            // $userAnswers = json_encode($_POST['data']);
            // print_r($_POST['data']);
            $saveAttempts = new SaveAttempts($usreId, $quizId);
            return $saveAttempts->saveAttemptData($quizId, $usreId, $_POST['data'],$currentScore);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1);

        }

    }

    ?>

</body>

</html>


<?php
// include_once("Database.php");
// include_once("..\phpActions\GetQuestions.php");

// if ($_SERVER['REQUEST_METHOD'] == "POST") {

//     if (isset($_POST['action']) && $_POST['action'] == "check") {
//         if (isset($_POST['data'])) {
//             $questionData = $_POST['data'];
//             $idvalues = [];
//             $answers = [];
//             foreach ($questionData as $key => $value) {
//                 $idvalues[] = $value['key'];
//             }
//             $getAnswer = new GetQuestions();
//             $corerctAnswers = ($getAnswer->getCorrectAnswers($idvalues));
//             $score = checkScore($questionData, $corerctAnswers);
//             echo formatAnswer($score);
//         }
//     }
// }

// function checkScore($data, $correctAnswer)
// {
//     $score = 0;
//     foreach ($data as $value) {
//         $questionId = $value['key'];
//         $Answer = $value['value'];
//         foreach ($correctAnswer as $val) {
//             if ($val['questionId'] == $questionId) {
//                 if ($Answer == $val['answerSyntax']) {
//                     $score += 10;
//                 }
//             }
//         }
//     }
//     return $score;
// }
// function formatAnswer($score, $data = [])
// {
//     $format = "<div id='score-div'><p >Your score is = '$score'<p>";
//     $format.="<br/><p>Feedback will be added soon</p>";
//     $format.="<a href='index.php'>Go back to main Page</a></div>";
//     return $format;

// }


?>