<?php
session_start();
include("..\DataAccess\Database.php");
include("..\phpActions\Signin.php");
include_once("Header-SideBar.php");
include_once('..\phpActions\GetQuestions.php');
$userData = "";
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    $signin = new SignIn();
    $userData = $signin->check_login($_SESSION['user_id']);

} else {
    header("Location:SignIn.php?message=Please login");
}

// function displayCreateQuiz()
// {
//     $form = "<form method='post' action='QuizPage.php' class='quiz-container'>
//             <h1>Create a new Quiz!</h1>
//             <label for='num-questions'>Enter number of questions (maximum:15):</label>
//             <input type='number' name='numberOfQuestions' id='num-questions' min='1' value='5' max='15'>
//             <button id='start-button'>Start</button>
//         </form>";
//     echo $form;
// }
function displayCreateQuiz()
{
    $getData = new GetQuestions();
    $questions = $getData->retriveQuestions();
    displayFormat($questions);

}

function displayFormat($questions)
{
    echo "<input id='quizTitle' type='text' placeholder='enter quiz Title' name='quizTitle' requrired='required'>";
    echo "<table style='width:100%'>";
    // echo "<tr>";
    // echo "</tr>";
    echo "<tr><th>ID</th><th>Question</th></tr>";
    $i = 1;
    foreach ($questions as $question) {
        echo "<tr>";
        echo "<td class='id' value={$question['id']}>" . $i . "</td>";
        echo "<input type='text' class='DataId' name='id' style='display:none' value={$question['id']}/>";
        echo "<td>" . $question['question-Syntax'] . "</td>";
        // echo "<td><noscript><button type='submit' name='action' value='ShowAsQuestion'></noscript><span class ='ViewQuestion'>View</span><noscript></button></noscript></td>";
        echo "<td><input type='checkbox'/></td>";
        // echo "<td><div class='showqDiv'>HEre</div></td>";
        echo "</tr>";
        $i += 1;
    }

    echo "</table>";
    echo "<button id='createAQuizBtn' name='createQuiz' type='submit'> Create Quiz </button>";
}
function displayAttemptQuiz()
{
    $form = "<div>This page will be created soon!!!</div>";
    echo $form;
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
    if ($_SESSION['role'] == 1) {
        echo "<script src='..\Scripts\AttemptQuiz.js'></script>";
        echo "<link type='text/css' rel='stylesheet' href='..\CSS\DeleteQuestions.css' />";
        // echo "<link type='text/javascript' href='..\Scripts\createAQuiz.js' defer='defer'/>";
    }
    ?>
    <title>Start Quiz</title>

</head>

<body>
    <div id="dialog" title='Inform'></div>
    <header>
        <?php formatHeader($userData) ?>
    </header>
    <main>
        <div class='noScript'>
            <?php
            if (isset($_GET['message'])) {
                echo $_GET['message'];
            }
            ?>
        </div>
        <?php
        formatSideBar($_SESSION['role']);
        if ($_SESSION['role'] == 1) {
            displayCreateQuiz();
        } else {
            displayAttemptQuiz();
        }
        ?>



    </main>
</body>

</html>