<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quiz Results</title>
    <!-- Add your CSS and other header content here -->
</head>

<body>
    
    <?php
    include_once("Database.php");
    include_once("..\phpActions\GetQuestions.php");

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        if (isset($_POST['action']) && $_POST['action'] == "check") {
            if (isset($_POST['data'])) {
                $questionData = $_POST['data'];
                $idvalues = [];
                $answers = [];
                foreach ($questionData as $key => $value) {
                    $idvalues[] = $value['key'];
                }
                $getAnswer = new GetQuestions();
                $correctAnswers = ($getAnswer->getCorrectAnswers($idvalues));
                $score = checkScore($questionData, $correctAnswers);
                echo "<div id='score-div'><p>Your score is: $score out of " . (count($questionData) * 10) . "</p></div>";

                // Display question-answer cards
                foreach ($questionData as $value) {
                    $questionId = $value['key'];
                    $userAnswer = $value['value'];

                    foreach ($correctAnswers as $correctAnswer) {
                        if ($correctAnswer['questionId'] == $questionId) {
                            //Wrong answer
                            if ($userAnswer !== $correctAnswer['answerSyntax']) {
                                echo "<div class='card wrongAnswer'>
                            <p>Question: {$correctAnswer['question-Syntax']}</p>
                            <p>Your Answer: $userAnswer</p>
                            <p>Correct Answer: {$correctAnswer['answerSyntax']}</p>
                          </div>";
                            } else {
                                echo "<div class='card correctAnswer'>
                            <p>Question: {$correctAnswer['question-Syntax']}</p>
                            <p>Your Answer: $userAnswer</p>
                            <p>Correct Answer: {$correctAnswer['answerSyntax']}</p>
                          </div>";
                            }

                        }
                    }
                }

                echo "<a href='index.php'>Go back to the main Page</a></div>";
            }
        }
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
    ?>

    <!-- Add your CSS link for styling the cards -->

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