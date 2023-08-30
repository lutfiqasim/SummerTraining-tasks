<?php
session_start();

//Student user isn't allowed to Add questions
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == "Student") {
        header("Location:index.php?message=Accessdenied");
        // die();
    }
} else {
    header("Location:index.php?message=Access denied");
}

?>
<!-- 

Add questions page HTML

 -->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Questions</title>
    <!-- JQuery and dialogs -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- Dialog -->
    <link type="text/css" rel="stylesheet" href="..\CSS\addQuestionsStyle.css" />
    <link type="text/css" rel="stylesheet" href="..\CSS\navBar.css" />
    <script type="text/javascript" src="..\Scripts\script.js" defer="defer"></script>
</head>

<body>
    <header>
        <div style="color: red;">
            <h1>Add a multiple choice question</h1>
            <!-- <noscript>
                <a href="Edit-DeleteQuestions.php" style="text-decoration:none;">Edit\Delete Questions</a>
            </noscript> -->
        </div>
    </header>
    <main>
        <section id="tabs">
            <nav>
                <ul>
                    <li>
                        <a href="index.php">Main page</a>
                    </li>
                    <li>
                        <!-- <a href="AddQuestion.php">Add Questions</a> -->
                        <a href="SeeAllQuestions.php">See all user Questions</a>
                    </li>
                </ul>
            </nav>
        </section>
        <div id="dialog" title="inform"></div>
        <section>
            <?php
            if (isset($_GET['message'])) {
                $message = $_GET['message'];
                echo "<h2 style='color:red;'>{$message}</h2>";
            }
            ?>
            <!-- action="testconnection.php" -->
            <form method="post" action="..\DataAccess\UploadQuestion.php">
                <fieldset>
                    <legend>Quiz:</legend>
                    <div id="User-Entered-Questions">
                        <div class="questionsToAdd" style="display: block;"><input type="text"
                                placeholder="Enter Question" required="required" name="questionSyntax"><input
                                type="text" placeholder="Correct Answer" required="required" class="CorrectAnswer"
                                name="correctAnswer">
                            <ul class="choices">
                                <li class="choices-input"><input type="text" placeholder="Choice" required="required"
                                        name="choice[]"></li>
                            </ul>
                            <button class="addMoreChoices" type="button">
                                Add more choices
                            </button>
                        </div>
                    </div>
                    <div id="status" style="color: black; margin-top:10px; display: none;">
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const urlParams = new URLSearchParams(window.location.search);
                            if (urlParams.has('message')) {
                                const statusDiv = document.getElementById('status');
                                statusDiv.append("Thanks for Adding questions to our Website");
                                statusDiv.style.display = 'block';
                                statusDiv.style.color = 'green';
                                window.history.replaceState({}, "", "/" + "Summer%20Training%201/PHPANDDB//Task1-QuestionsDBUPDATED/Pages/AddQuestion.php");
                            }
                        });
                    </script>
                    <button id="addQuestionBtn" type="submit">Add questions</button>
                    <!-- <input type="submit" value="Add question"/> -->
                </fieldset>
            </form>
        </section>
    </main>
</body>

</html>