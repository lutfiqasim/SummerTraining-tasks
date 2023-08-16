<?php

include("Database.php");
include("phpActions/InsertQuestions.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // print_r($questionSyntaxArray);
    try {
        $questionSyntaxArray = $_POST['questionSyntax'];
        $insertQuestion = new UploadQuestion();
        for ($i = 0; $i < count($questionSyntaxArray); $i++) {
            $result = $insertQuestion->addQuestion($_POST, $i);
            if ($result != "") {
                echo "HERE";
                header("Location:index.php?message=" . $result);
            } else {
                // echo "HERE@";
                // header("Location:AddQuestion.html?Thanks for submitting form");
                header("Location:index.php?message=success");
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>