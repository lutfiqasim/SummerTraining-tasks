<?php
include_once("Database.php");
include_once("..\phpActions\EditQuizes.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['quiz'], $_POST['question'])) {
        $deleteQuestion = new EditQuizes();
        $result = $deleteQuestion->deleteQuestionFromQuiz($_POST['quiz'], $_POST['question']);
        echo $result;
    } else {
        echo "Couldn't remove question";
        exit();
    }
} else {
    header("Location:index.php");
}
?>