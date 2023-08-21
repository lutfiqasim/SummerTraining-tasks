<?php

/**
 * search for questions to be updated
 * And then display it in a nice format to be updated by user 
 * 
 */

include("Database.php");
include('..\phpActions\searchQuestion.php');
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['action']) && isset($_GET['id'])) {
        try {
            $action = $_GET['action'];
            $searchKey = $_GET['id'];
            $search = new SearchQuestions();
            if ($action === "editQuestion" || $action === "ShowAsQuestion") {
                $data = $search->retriveQuestionById($searchKey);
            } else if ($action === "number") {
                $data = $search->retriveQuestionById($searchKey);
            } else if ($action === "text") {
                $data = $search->retriveQuestionBySyntax($searchKey);
            } else {
                echo "Search key type not accepted";
                return;
            }
            if (((isset($_GET['type']) && $_GET['type'] === 'ShowAsQuestion')) || $action === "ShowAsQuestion") {
                echo displayAsQuestion($data);
            } else {
                echo dataDisplayFormat($data);
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<h3>Data not set</h3>";
        echo $_GET['action'];
        echo $_GET['id'];
    }
}

function dataDisplayFormat($data)
{

    if (!isset($data[0]['question_id'])) {
        print_r($data);
        return;
    }
    echo "<noscript>";
    echo "<form method='post' action='updateAQuestionDA.php'>";
    echo "</noscript>";
    echo "<div id='updateQuestionsDiv'>";
    echo "<h3 style=color:green;>Please fill in only data you want to update</h3>";
    echo "<h5  style=color:green;>Note: Each choice must be unique from the other and each question should at least have two choices</h5>";
    echo "<hr/>";
    // echo "Question_id: ";
    echo "<input id='questionIdLabel' name ='action' value ='{$data[0]['question_id']}' style='display:none;'></input>\n";
    echo "<br/>";
    echo "<label for='questionSyntax'>Question_syntax: <br/>{$data[0]['question_syntax']}:</label>\n";
    echo "<input id='questionSyntax' type='text' placeholder='Enter new question Syntax'></input>";
    // echo "<input id='questionSyntax'name='questionSyntax' type='text' placeholder='Enter new question Syntax'></input>";
    echo "<br/>";
    echo "<hr><br/>";
    // echo "CorrectAnswerid: {$data[0]['correct_answer_id']}<br/>";
    echo "<br/>";
    echo "<label for='CorrectAnswerSyntax'>Correct Answer: <br/>{$data[0]['correct_answer_syntax']}:</label>\n";
    echo "<input id='CorrectAnswerSyntax' type='text' placeholder='Enter new correct answer Syntax'></input>";
    // echo "<input id='CorrectAnswerSyntax' name='newCorrectAnswer' type='text' placeholder='Enter new correct answer Syntax'></input>";
    echo "<hr><br/>";
    foreach ($data as $entry) {
        if ($entry['choice_id'] == $data[0]['correct_answer_id']) {
            continue;
        }
        // echo "Choice.id: {$entry['choice_id']}<br/>";
        echo "<div class='choice'>";
        echo "<span class='deleteChoice'>×</span><br>";
        echo "<label for='choice{$entry['choice_id']}'> Choice: <br/>old Choice: {$entry['choice_syntax']}:</label>\n";
        echo "<input id='{$entry['choice_id']}' class='newChoice' type='text' placeholder='Enter new choice answer Syntax'></input>";
        // echo "<input id='{$entry['choice_id']}' name='newChoice{$entry['choice_id']}' class='newChoice' type='text' placeholder='Enter new choice answer Syntax'></input>";
        echo "<hr><br/>";
        echo "</div>";
        echo "\n";
    }
    echo "<br/>";
    echo "<button class='addChoiceBtn'>Add More choices</button><br>";
    echo "<button id ='updateButton' name='action' value='update'>Update Question data</button>";
    echo "<button id='cancelUpdate' name='action' value='cancelUpdate'>Cancel</button>";
    echo "</div>";
    echo "<noscript>";
    echo "</form>";
    echo "</noscript>";
}
function displayAsQuestion($data)
{
    echo "<noscript>";
    echo "<form method='post' action='updateAQuestionDA.php'>";
    echo "</noscript>";
    echo "<div id='{$data[0]['question_id']}' class='choicesDiv' style='min-width:800px'>";
    echo "<h3> {$data[0]['question_syntax']}</h3><br/>";
    $choicesData = array();
    foreach ($data as $entry) {
        $choicesData[] = $entry['choice_syntax'];
    }
    shuffle($choicesData);
    foreach ($choicesData as $choice) {
        echo (" <input type='radio' id='$choice' name='answer1'value='$choice'/><label class='radioChoices' for='$choice'>{$choice}</label> <br>");
    }
    echo "<hr/><button id='delete' name='action' value='deleteView'>delete Question</button>";
    echo "<button id='startUpdate' name='action' value='EditView'>Edit Question</button>";
    echo "<button id='cancelUpdate' name='action' value='cancelUpdate'>Go back</button>";
    echo "<hr/></div>";
    echo "<noscript>";
    echo "</form>";
    echo "</noscript>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display As question</title>

    <noscript>
        <style>
            .choicesDiv {
                border: 1px solid #ccc;
                padding: 10px;
                margin: 10px;
                border-radius: 5px;
                background-color: #f9f9f9;
            }

            .choicesDiv h3 {
                font-size: 18px;
                margin-bottom: 10px;
            }

            .choicesDiv .radioChoices {
                display: inline-block;
                margin-left: 5px;
            }

            .choicesDiv .radioChoices::before {
                content: "\2022";
                /* Bullet point */
                margin-right: 5px;
            }

            .choicesDiv input[type="radio"] {
                margin-right: 5px;
            }

            /* UPDATE STYLE */
            #updateQuestionsDiv {
                font-family: Arial, sans-serif;
                padding: 20px;
                border: 1px solid #ccc;
                background-color: #f9f9f9;
            }

            h3 {
                color: green;
            }

            h5 {
                color: green;
            }

            hr {
                border: 1px solid #ccc;
            }

            label {
                display: block;
                margin-top: 10px;
            }

            input[type="text"] {
                width: 100%;
                padding: 5px;
                margin-top: 5px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            .choice {
                margin-top: 20px;
                position: relative;
            }

            .deleteChoice {
                position: absolute;
                top: 0;
                right: 0;
                cursor: pointer;
            }

            .addChoiceBtn {
                margin-top: 20px;
                padding: 5px 10px;
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            #updateButton {
                margin-top: 20px;
                padding: 10px 20px;
                background-color: #28a745;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
        </style>
    </noscript>
</head>

<body>

</body>

</html>