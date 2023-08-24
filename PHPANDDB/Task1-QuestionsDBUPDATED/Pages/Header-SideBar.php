<?php
function formatSideBar($userType)
{
    $sidebar = "";
    if ($userType) {
        $sidebar = "<div id='sidebar'>
        <a href='AttemptQuiz.php?message=Please check questions you want to add to quiz '>Create An exam</a>
        <a href='SeeAllQuestions.php'>View All users questions</a>
        <a href='addQuestion.php'>Add new Question</a>
        </div>";
    } else {
        $sidebar = "<div id='sidebar'>
        <a href='AttemptQuiz.php'>Attempt a multiple choice exam</a>
        </div>";
    }
    echo $sidebar;
}

function formatHeader($data)
{
    echo "<div class='user-info'>";
    echo "<img src='..\..\..\..\..\Social Website\images\user_male.jpg' width='20px'/>";
    echo "<h2 class='user-name'>" . $data['username'] . "</h2>";
    echo "</div>";
    echo "<div class='welcome-message'>";
    echo "<a href='index.php'><h2>Welcome to QuizMaker</h2></a>";
    echo "</div>";
    echo "<div class='logout-button'>";
    echo "<h2><a href='logout.php' class='logout-button'>Log-out</a></h2>";
    echo "</div>";
}

?>
<!-- Implements jquery dependencies -->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- JQuery and dialogs -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- Dialog -->
</head>

<body>

</body>

</html>