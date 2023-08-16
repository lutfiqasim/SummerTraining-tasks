<?php
?>
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
    <link type="text/css" rel="stylesheet" href="addQuestionsStyle.css" />
    <script type="text/javascript" src="Scirpts/script.js" defer="defer"></script>
</head>

<body>
    <header>
        <div style="color: red;">
            <h1>Add a multiple choice question</h1>
        </div>
    </header>
    <main>
        <!-- <div id="dialog" title="Warning"></div> -->
        <section>
            <!-- action="testconnection.php" -->
            <form method="post" action="testconnection.php">
                <fieldset>
                    <legend>Quiz:</legend>
                    <div id="User-Entered-Questions">
                        <div class="AddQuestionChoice">
                            <label for="numberOfQuestions">Choose number of questions you want to add</label>
                            <input id="numberOfQuestions" type="number" min="1" max="10" />
                            <button id="startAdding" type="button">Start Adding</button>
                        </div>
                    </div>
                    <div id="status" style="color: black; display: none;">
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const urlParams = new URLSearchParams(window.location.search);
                            if (urlParams.has('message') && urlParams.get('message') === 'success') {
                                const statusDiv = document.getElementById('status');
                                statusDiv.append("Thanks for Adding questions to our Website");
                                statusDiv.style.display = 'block';
                                statusDiv.style.color = 'green';
                            } else if (urlParams.has('message') && urlParams.get('message') != '') {
                                const statusDiv = document.getElementById('status');
                                statusDiv.append(urlParams.get('message'));
                                statusDiv.style.display = 'block';
                                statusDiv.style.color = 'red';
                            }
                        });
                    </script>
                    <button id="addQuestionBtn" style="display:none;" type="submit">Add questions</button>
                    <!-- <input type="submit" value="Add question"/> -->
                </fieldset>
            </form>
        </section>
    </main>
</body>

</html>