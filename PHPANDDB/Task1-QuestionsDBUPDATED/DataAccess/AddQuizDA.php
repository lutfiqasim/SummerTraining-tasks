<?php
session_start();
include_once("Database.php");
include_once("..\phpActions\CreateQuiz.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['action'], $_POST['data'], $_POST['title'])) {
        $questionsToAdd = $_POST['data'];
        validateRequest($_POST['title'], $questionsToAdd);
        try {
            $createquiz = new CreateQuiz();
            $q = $createquiz->createQuiz($_POST);
            if ($q) {
                // header("Location:..\Pages\AttemptQuiz.php?message=Added question succesffully");
                echo "Added quiz successfully";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
}
function validateRequest($title, $data)
{
    if ($title == "") {
        header("Location:..\AttemptQuiz.php?message=enter title first");
        die();
    }
    if (count($data) < 5) {
        header("Location:..\AttemptQuiz.php?message=Must specify at least 5 questions");
        die();
    }
}


?>