<?php
include_once("..\DataAccess\EditDeleteQuizDA.php");
include_once("..\DataAccess\StartQuizDA.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['val']) && $_POST['val'] == "Delete") {
        try {
            $quizId = $_POST['quiz_id'];
            $result = deleteQuiz($quizId);
            if ($result) {
                header("Location:ShowUserExams.php?message=Deleted quiz successfully");
            } else {
                header("Location:ShowUserExams.php?message=An error accord try again");
            }
        } catch (Exception $e) {
            echo "An error accord try again later";
        }

    } else if (isset($_POST['val']) && $_POST['val'] == "Show") {
        echo getQuestions($_POST['quiz_id'], false);
    }
} else {
    header("Location:index.php?message='Access Not allowed'");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Quiz</title>
    <!-- JQuery and dialogs -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- Dialog -->
    <link type='text/css' rel='stylesheet' href='..\CSS\show-editQuizes.css' />
    <script type="text/javascript" src="..\Scripts\EditDeleteQuiz.js" defer="defer"></script>
</head>

<body>
    <div id="dialog" title='warning'></div>
    <div id='quizId' value='<?php echo $_POST['quiz_id'] ?>' style='display:none;'></div>
</body>

</html>