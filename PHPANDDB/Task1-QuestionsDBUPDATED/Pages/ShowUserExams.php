<?php
session_start();
include("..\DataAccess\Database.php");
include("..\phpActions\Signin.php");
include_once("Header-SideBar.php");
include_once('..\phpActions\GetQuestions.php');
include_once("..\DataAccess\GetQuizesDA.php");
$userData = "";
if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == "Teacher") {
    $signin = new SignIn();
    $userData = $signin->check_login($_SESSION['user_id']);

} else {
    header("Location:SignIn.php?message=Please login");
}
function displayFormat()
{
    displayCurrentUserQuizes($_SESSION['user_id']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\CSS\startQuiz.css">
    <link rel="stylesheet" href="..\CSS\indexPage.css">
    <?php
    if ($_SESSION['role'] == "Teacher") {
        echo "<link type='text/css' rel='stylesheet' href='..\CSS\DeleteQuestions.css' />";
        echo '<script type="text/javascript" src="..\Scripts\EditDeleteQuiz.js" defer="defer"></script>';
    }

    ?>
    <title>My quizes</title>

</head>

<body>
    <div id="dialog" title='Inform'></div>
    <header>
        <?php formatHeader($userData) ?>
    </header>
    <main>

        <?php
        formatSideBar($_SESSION['role']);

        if ($_SESSION['role'] == "Teacher") {
            displayFormat();
        } else {
            displayAttemptQuiz();
        }
        ?>
        <div class='noScript' style='font-size:18px;text-align:center;color:green;margin:0 400px '>
            <?php
            if (isset($_GET['message'])) {
                echo $_GET['message'];
            }
            ?>
        </div>
    </main>
</body>

</html>