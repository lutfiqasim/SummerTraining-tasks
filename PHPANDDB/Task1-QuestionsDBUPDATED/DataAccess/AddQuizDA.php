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
            // print_r($_POST['data']);
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
        header("Location:..\Pages\CreateAQuiz.php?message=enter title first");
        die();
    }
    if (count($data) <=0) {
        header("Location:..\Pages\CreateAQuiz.php?message=Must specify at least 1 question");
        die();
    }
}


?>