<?php
include("Database.php");
include('..\phpActions\DeleteQuestions.php');


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        try {
            $deletChoice = new DeleteQuestions();
            $result = $deletChoice->deleteChoice($_POST['id']);
            if ($result !== "") {
                return "An error accord";
            } else {
                return "Deleted choice succssfully";
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}


?>