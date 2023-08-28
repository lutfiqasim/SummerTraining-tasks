<?php
session_start();
include("..\DataAccess\Database.php");
include("..\phpActions\Signin.php");
include_once("Header-SideBar.php");
$userData = "";
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    $signin = new SignIn();
    $userData = $signin->check_login($_SESSION['user_id']);
} else {
    header("Location:SignIn.php?message=Please login");
}

function formatIndexHeader($data)
{
    echo "<div class='user-info'>";
    echo "<img src='..\..\..\..\..\Social Website\images\user_male.jpg' width='20px'/>";
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
    <!-- JQuery and dialogs -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- Dialog -->
    <title>Main Page</title>
    <link type="text/css" rel="stylesheet" href="..\CSS\indexPage.css" />
</head>

<body>
    <header>
        <?php formatIndexHeader($userData) ?>
    </header>
    <main>
        <?php
        formatSideBar($_SESSION['role']);
        ?>
        <section id='content'>

            <?php
            if ($userData['role'] == "Teacher") {
                echo "<h2 id='IndexPageh2'>Questions You added</h2>";
                include_once("Edit-DeleteQuestions.php");
            } else {
                echo "<h2 id='IndexPageh2'>Welcome " . $userData['username'] . "</h2>";
                echo "<br/><hr/>";
                echo "<div style='font-size:18px;color:red;'><p><a href='https://localhost/Summer%20Training%201/PHPANDDB//Task1-QuestionsDBUPDATED/Pages/AttemptQuiz2.php'>Try attempting one of our exams</a></p></div>";
            }
            ?>

        </section>
    </main>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        $(document).ready(function () {
            if (urlParams.has('message')) {
                if (urlParams.get('message')) {
                    showDialog(urlParams.get('message'));
                    window.history.replaceState({}, document.title, "/" + "Summer%20Training%201/PHPANDDB//Task1-QuestionsDBUPDATED/Pages/index.php");
                }
            }
            function showDialog(dialogText) {
                $("#dialog").css({ "font-size": "18px", "color": "green", "font-style": "italic" }).text(dialogText).dialog();
            }
        });


    </script>
</body>

</html>