<?php
include_once("..\DataAccess\EditDeleteQuizDA.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['val']) && $_POST['val'] == "Delete") {
        try {
            $quizId = $_POST['quiz_id'];
            $result = deleteQuiz($quizId);
            if ($result) {
                header("Location:ShowUserExams.php?message=Deleted quiz successfully");
            } else {
                header("Location:ShowUserExams.php?message=An error accord try again");
            }
        } catch (Exception $e) {
            echo "An error accord try again later";
        }

    }else{
        echo "Else";
        print_r($_POST);
    }
}