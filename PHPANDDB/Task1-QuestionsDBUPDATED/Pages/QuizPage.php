<?php
include_once("..\DataAccess\StartQuizDA.php");
$questionData = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['quiz_id'],$_POST['start'])) {
        $quiz_id = $_POST['quiz_id'];
        $questionData = getQuestions($quiz_id);
    }else{
        header("Location:PreviousAttempts.php?quiz=".$_POST['quiz_id']."&requested=".$_POST['attempt']);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="..\CSS\DeleteQuestions.css" />
    <link type="text/css" rel="stylesheet" href="..\CSS\QuizResult.css" />
    <!-- JQuery and dialogs -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- Dialog -->
    <script type="text/javascript" src="..\Scripts\Quiz.js" defer="defer"></script>
    <title>Attempt Quiz</title>
</head>

<body>
    <div id="dialog" title='Alert'></div>
    <section class="questions">
        <h2>Please Answer All questions</h2>
        <?php
        if ($questionData != "") {
            echo $questionData;
        }else{
            
        }
        ?>
    </section>
</body>

</html>