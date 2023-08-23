<?php
session_start();
include("..\DataAccess\Database.php");
include("..\phpActions\Signin.php");
include_once("Header-SideBar.php");
$userData = "";
if (isset($_SESSION['user_id'])) {
    $signin = new SignIn();
    $userData = $signin->check_login($_SESSION['user_id']);

} else {
    header("Location:SignIn.php?message=Please login");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\CSS\startQuiz.css">
    <link rel="stylesheet" href="..\CSS\indexPage.css">
    <script src="..\Scripts\AttemptQuiz.js"></script>

    <title>Start Quiz</title>

</head>

<body>
    <div id="dialog" title='Inform'></div>
    <header>
        <?php formatHeader($userData) ?>
    </header>
    <main>
        <?php
        echo $sidebar;
        ?>
        <form method="post" action="QuizPage.php" class="quiz-container">
            <h1>Welcome to the Quiz!</h1>
            <label for="num-questions">Enter number of questions (maximum:15):</label>
            <input type="number" name='numberOfQuestions' id="num-questions" min="1" value="5" max="15">
            <button id="start-button">Start</button>
        </form>
    </main>
</body>

</html>