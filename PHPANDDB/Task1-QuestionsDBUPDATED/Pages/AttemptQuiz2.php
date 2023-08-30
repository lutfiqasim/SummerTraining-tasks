<?php
session_start();
include("..\DataAccess\Database.php");
include("..\phpActions\Signin.php");
include_once("Header-SideBar.php");
include_once('..\phpActions\GetQuestions.php');
include_once("..\DataAccess\GetQuizesDA.php");
$userData = "";
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    $signin = new SignIn();
    $userData = $signin->check_login($_SESSION['user_id']);
} else {
    header("Location:SignIn.php?message=Please login");
}
function displayAttemptQuiz()
{
    displayQuizesFormat();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\CSS\startQuiz.css">
    <link rel="stylesheet" href="..\CSS\indexPage.css">
    <title>Choose A Quiz</title>
</head>

<body>
    <div id="dialog" title='Inform'></div>
    <header>
        <?php formatHeader($userData);
        ?>
    </header>
    <main>
        <?php
        formatSideBar($_SESSION['role']);
        // if ($_SESSION['role'] == "Teacher") {
        //     header("Location:CreateAQuiz.php");
        // } else {
        echo displayAttemptQuiz();
        // }
        ?>

    </main>
</body>

</html>