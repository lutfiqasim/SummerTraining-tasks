<?php
session_start();
include_once("..\DataAccess\Database.php");
include_once('..\phpActions\DeleteQuestions.php');
include_once('..\phpActions\GetQuestions.php');

//Student user isn't allowed to Add questions
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] !== "Teacher") {
        header("Location:SignIn.php?message=Access denied for entered URL");
        die();
    }
} else {
    header("Location:SignIn.php?message=");
    die();

}
function displayUserData()
{
    $getData = new GetQuestions();
    $questions = $getData->retriveQuestions();
    displayFormat($questions);

}

function displayFormat($questions)
{
    $header = "<section id='tabs''>
    <nav>
        <ul>
            <li>
                <a href='index.php'>Main Page</a>
            </li>
            <li>
                <a href='AddQuestion.php'>Add question</a>
            </li>
        </ul>
    </nav>
</section>";
    echo $header;
    echo "<table style='width:100%'>";
    // echo "<tr>";
    echo "</div>";
    // echo "</tr>";
    echo "<tr><th>ID</th><th>Question</th></tr>";
    $i = 1;
    foreach ($questions as $question) {
        echo "<tr>";
        echo "<td class='id'>" . $i . "</td>";
        echo "<input type='text' id='DataId' name='id' style='display:none' value={$question['id']}/>";
        echo "<td>" . $question['question-Syntax'] . "</td>";
        echo "</tr>";
        $i += 1;
    }

    echo "</table>";
}



?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit-DeleteQuestions</title>
    <!-- JQuery and dialogs -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- Dialog -->
    <link type="text/css" rel="stylesheet" href="..\CSS\navBar.css" />
    <link type="text/css" rel="stylesheet" href="..\CSS\DeleteQuestions.css" />
    <script type="text/javascript" src="..\Scripts\delete.js" defer="defer"></script>
    <script type="text/javascript" src="..\Scripts\update.js" defer="defer"></script>

</head>

<body>
    <main>
        <div id="dialog" title="Warning"></div>
        <section id="dataContainer">
            <?php
            displayUserData();
            ?>
        </section>

    </main>
</body>

</html>