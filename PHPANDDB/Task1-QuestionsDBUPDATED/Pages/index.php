<?php
session_start();
include("..\DataAccess\Database.php");
include("..\phpActions\Signin.php");
$userData = "";
if (isset($_SESSION['user_id'])) {
    $signin = new SignIn();
    $userData = $signin->check_login($_SESSION['user_id']);

} else {
    header("Location:SignIn.php");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    print_r($_POST);
}
function formatHeader($data)
{
    echo "<div class='user-info'>";
    echo "<h2 class='user-name'>" . $data['username'] . "</h2>";
    echo "</div>";
    echo "<div class='welcome-message'>";
    echo "<h2>Welcome to QuizMaker</h2>";
    echo "</div>";
    echo "<div class='logout-button'>";
    echo "<h2><a href='logout.php' class='logout-button'>Log-out</a></h2>";
    echo "</div>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link type="text/css" rel="stylesheet" href="..\CSS\indexPage.css" />
</head>

<body>
    <header>
        <?php formatHeader($userData) ?>
    </header>
    <main>
        <div id="sidebar">
            <a href="#">Attempt a multiple choice exam</a>
            <a href="SeeAllQuestions.php">View All users questions</a>
            <a href="addQuestion.php">Add new Question</a>
        </div>
        <section id='content'>
            <h2 id='IndexPageh2'>Questions You added</h2>
            <?php
            include_once("Edit-DeleteQuestions.php");
            ?>

        </section>
    </main>
</body>

</html>