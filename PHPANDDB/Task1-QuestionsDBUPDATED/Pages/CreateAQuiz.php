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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\CSS\startQuiz.css">
    <link rel="stylesheet" href="..\CSS\indexPage.css">
    <!-- SELECT 2 jquery for search -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!--  -->
    <?php
    if ($_SESSION['role'] == "Teacher") {
        echo "<script src='..\Scripts\AttemptQuiz.js'></script>";
        echo "<link type='text/css' rel='stylesheet' href='..\CSS\DeleteQuestions.css' />";
        // echo "<link type='text/javascript' href='..\Scripts\createAQuiz.js' defer='defer'/>";
    }

    ?>
    <title>Create A Quiz</title>

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
        if ($_SESSION['role'] == "Teacher") {
            // displayCreateQuiz();
        } else {
            header("Location:AttemptQuiz2.php");
        }
        ?>
        <h1 style='margin:20px 0 0 20px;'>Create a New Quiz</h1>
        <form method='post' id="quiz-form">
            <label for="quizTitle">Quiz Name:</label>
            <input id="quizTitle" type="text" placeholder='enter quiz Title' name='quizTitle' required>
            <label for="question-list">Select Question:</label>
            <select id="question-list" required>
                <option value="" disabled selected>Select a question</option><br>
                <!-- Question options will be added here using JavaScript(AttemptQuiz) -->
            </select>

            <button id="add-question-btn">Add Question</button>
            <div id='choosen-question-toAdd' style='border:1px solid green;margin-top:10px'>
                <ul style='padding:10px;' id="added-questions">
                    <!-- List of added questions will be added here -->
                </ul>
            </div>
            <button id="create-quiz-btn">Create Quiz</button>
        </form>
    </main>
</body>

</html>

<?php
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
// function displayCreateQuiz()
// {
//     $getData = new GetQuestions();
//     $questions = $getData->retriveQuestions();
//     displayFormat($questions);

// }

// function displayFormat($questions)
// {
//     // echo "<input id='quizTitle' type='text' placeholder='enter quiz Title' name='quizTitle' requrired='required'>";
//     // echo "<table style='width:100%'>";
//     // echo "<tr>";
//     // echo "</tr>";
//     // echo "<tr><th>ID</th><th>Question</th></tr>";
//     $i = 1;
//     foreach ($questions as $question) {
//         echo "<option>";
//         // echo "<tr>";
//         // echo "<td class='id' value={$question['id']}>" . $i . "</td>";
//         // echo "<input type='text' class='DataId' name='id' style='display:none' value={$question['id']}/>";
//         // echo "<td>" . $question['question-Syntax'] . "</td>";
//         // // echo "<td><noscript><button type='submit' name='action' value='ShowAsQuestion'></noscript><span class ='ViewQuestion'>View</span><noscript></button></noscript></td>";
//         // echo "<td><input type='checkbox'/></td>";
//         // // echo "<td><div class='showqDiv'>HEre</div></td>";
//         // echo "</tr>";
//         // $i += 1;
//         echo "<div class='id' value={$question['id']}>" . $question['question-Syntax'] . "</div>";
//         echo "</option>";
//         echo "<br/>";
//     }

//     // echo "</table>";
//     // echo "<button id='createAQuizBtn' name='createQuiz' type='submit'> Create Quiz </button>";
// }