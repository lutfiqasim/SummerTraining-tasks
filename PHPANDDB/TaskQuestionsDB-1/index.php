<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quiz-Maker</title>
    <!-- JQuery and dialogs -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- Dialog -->
    <!-- <link type="text/css" rel="stylesheet" href="addQuestionsStyle.css" /> -->
    <!-- <script type="text/javascript" src="Scirpts/script.js" defer="defer"></script> -->
    <script>
        $(document).ready(function () {
            $("#tabs").tabs();
        });

    </script>
</head>
<body>
    <main>
        <section id="tabs">
            <nav>
                <ul>
                    <li>
                        <a href="AddQuestion.php">Add Questions</a>
                    </li>
                    <li>
                        <a href="Edit-DeleteQuestions.php">Edit\Delete Questions</a>
                    </li>
                    <li>
                        <a href="EditQuestion.php">Search\Edit Question</a>
                    </li>
                </ul>
            </nav>
        </section>


    </main>
</body>

</html>