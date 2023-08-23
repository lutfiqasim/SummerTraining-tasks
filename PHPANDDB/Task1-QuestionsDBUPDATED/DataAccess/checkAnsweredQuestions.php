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
            $corerctAnswers = ($getAnswer->getCorrectAnswers($idvalues));
            $score = checkScore($questionData, $corerctAnswers);
            echo formatAnswer($score);
        }
    }
}

function checkScore($data, $correctAnswer)
{
    $score = 0;
    foreach ($data as $value) {
        $questionId = $value['key'];
        $Answer = $value['value'];
        foreach ($correctAnswer as $val) {
            if ($val['questionId'] == $questionId) {
                if ($Answer == $val['answerSyntax']) {
                    $score += 10;
                }
            }
        }
    }
    return $score;
}
function formatAnswer($score, $data = [])
{
    $format = "<div id='score-div'><p >Your score is = '$score'<p>";
    $format.="<br/><p>Feedback will be added soon</p>";
    $format.="<a href='index.php'>Go back to main Page</a></div>";
    return $format;

}


?>