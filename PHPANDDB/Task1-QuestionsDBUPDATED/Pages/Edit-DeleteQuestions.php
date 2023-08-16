<?php
/**
 * EDIT / DELETE QUESTION HTML WITH THE DATA RETRIVED display 
 * 
 * 
 */

include("..\DataAccess\Database.php");
include('..\phpActions\DeleteQuestions.php');
include('..\phpActions\GetQuestions.php');
function displayData()
{
    $getData = new GetQuestions();
    $questions = $getData->retriveQuestions(); // Assuming this returns an array of question data
    displayFormat($questions);

}
function displaySorted($action)
{
    if ($action === 'SortDescending') {
        $getData = new GetQuestions();
        $questions = $getData->retriveQuestionsDescendingOrder();
        displayFormat($questions);
    } else {
        // echo "else statment";
        $getData = new GetQuestions();
        $questions = $getData->retriveQuestionsAscendingOrder();
        displayFormat($questions);
    }
}
function displayFormat($questions)
{
    echo "<table style='width:100%'>";
    // echo "<tr>";
    echo "<div id ='sort'>";
    echo "<div id='descending' class='sortingBtn'>" . "Sort Descending Order" . "</div>";

    echo "<div class='flex-spacer'></div>";
    echo "<div id='ascending' class='sortingBtn'>" . "Sort Ascending Order" . "</div>";
    echo "<noscript>";
    echo "<div class='sortingBtn'>" . "<a href='AddQuestion.php'>Add Question</a>" . "</div>";
    echo "</noscript>";
    echo "</div>";
    // echo "</tr>";
    echo "<tr><th>ID</th><th>Question</th></tr>";

    foreach ($questions as $question) {
        echo "<form method='get' action='..\DataAccess\searchForQuestion.php'> ";
        echo "<tr>";
        echo "<td class='id'>" . $question['id'] . "</td>";
        echo "<input type='text' id='DataId' name='id' style='display:none' value={$question['id']}/>";
        echo "<td>" . $question['question-Syntax'] . "</td>";
        echo "<td><noscript><button type='submit' name='action' value='ShowAsQuestion'></noscript><span class ='ViewQuestion'>View</span><noscript></button></noscript></td>";
        echo "<td> <noscript><button type='submit' name='action' value='editQuestion'></noscript><span class='editQuestion'>Edit</span><noscript></button></noscript></td>";
        echo "<td><span class='deletequestion'>×</span></td>";
        echo "</tr>";
        echo "</form>";
    }

    echo "</table>";
}
function deleteQuestion($data)
{
    $questionId = $data['id'];
    $delete = new DeleteQuestions();
    $response = $delete->deleteQuestion($questionId);
    if ($response != "") {
        echo "\nERROR ACCORD: " . $response;
    } else {
        echo "deleted question with id= " . $questionId . " successfully";
    }
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
    <link type="text/css" rel="stylesheet" href="..\CSS\DeleteQuestions.css" />
    <script type="text/javascript" src="..\Scripts\delete.js" defer="defer"></script>
    <script type="text/javascript" src="..\Scripts\update.js" defer="defer"></script>
</head>

<body>
    <main>
        <div id="dialog" title="Warning"></div>
        <section id="dataContainer">
            <?php
            if (isset($_POST['action'])) {
                if ($_POST['action'] === "delete") {
                    deleteQuestion($_POST);
                } else {
                    displaySorted($_POST['action']);
                }
            } else {
                displayData();
            }
            ?>
        </section>

    </main>
</body>

</html>