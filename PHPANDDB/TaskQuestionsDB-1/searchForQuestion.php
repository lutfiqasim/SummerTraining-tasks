<?php
// Search for questions BackEnd
include("Database.php");
include('phpActions\searchQuestion.php');

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['action']) && isset($_GET['id'])) {
        try {
            $action = $_GET['action'];
            $searchKey = $_GET['id'];
            $search = new SearchQuestions();
            if ($action === "number") {
                $data = $search->retriveQuestionById($searchKey);
            } else if ($action === "text") {
                $data = $search->retriveQuestionBySyntax($searchKey);
            } else {
                echo "Search key type not accepted";
            }
            echo dataDisplayFormat($data);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<h3>Data not set</h3>";
    }
}

function dataDisplayFormat($data)
{
    // print_r($data);
    if (!isset($data[0]['question_id'])) {
        print_r($data);
        return;
    }
    echo "<div id='updateQuestionsDiv'>";
    echo "Question_id: ";
    echo "<label id='questionIdLabel'>{$data[0]['question_id']}</label>\n";
    echo "<br/>";
    echo "<label for='questionSyntax'>Question_syntax: <br/>{$data[0]['question_syntax']}:</label>\n";
    echo "<input id='questionSyntax' type='text' placeholder='Enter new question Syntax'></input>";
    echo "<br/>";
    echo "<hr><br/>";
    // echo "CorrectAnswerid: {$data[0]['correct_answer_id']}<br/>";
    echo "<br/>";
    echo "<label for='CorrectAnswerSyntax'>Correct Answer: <br/>{$data[0]['correct_answer_syntax']}:</label>\n";
    echo "<input id='CorrectAnswerSyntax' type='text' placeholder='Enter new correct answer Syntax'></input>";
    echo "<hr><br/>";
    foreach ($data as $entry) {
        if ($entry['choice_id'] == $data[0]['correct_answer_id']) {
            continue;
        }
        // echo "Choice.id: {$entry['choice_id']}<br/>";
        echo "<label for='choice{$entry['choice_id']}'> Choice: <br/>old Choice: {$entry['choice_syntax']}:</label>\n";
        echo "<input id='{$entry['choice_id']}' class='newChoice' type='text' placeholder='Enter new choice answer Syntax'></input>";
        echo "<hr><br/>";

        echo "\n";
    }
    echo "<br/>";
    echo "<button class ='updateButton'>Update Question data</button>";
    echo "</div>";
}
?>