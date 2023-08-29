<?php
include_once("Database.php");
include_once('..\phpActions\GetQuiz.php');
function getQuestions($quiz_id, $displayAsQuiz = true)
{
    $getQuestions = new GetQuiz();
    $quizTitle = $getQuestions->getQuizData($quiz_id);
    $Questiondata = $getQuestions->getQuiz($quiz_id);
    $dataToDisplay = "<section id='quizId' value='$quiz_id' style='margin-left:45%;margin-bottom:20px;font-size:28px'>Quiz: " . $quizTitle . "</section>";
    if ($displayAsQuiz) { //Display as a quiz for user
        foreach ($Questiondata as $data) {
            $dataToDisplay .= displayAsQuestion($data);
        }
        $dataToDisplay .= "<button id='SubmitAnswers' name='submit' value='submit'>Submit Answers</button>";
    } else { //display for edit for Teacher
        foreach ($Questiondata as $data) {
            $dataToDisplay .= displayForEdit($data);
        }
        $dataToDisplay .= " <div id='Add-new-Quiz-Question-Form' style='display:none;'><form method='post' id='quiz-form'>
        <label for='question-list'>Select Question:</label>
        <select id='question-list' required>
            <option value='' disabled selected>Select a question</option><br>
            <!-- Question options will be added here using JavaScript(AttemptQuiz) -->
        </select>
        <button id='add-question-btn'>Add Question</button>
        <div id='choosen-question-toAdd' style='border:1px solid green;margin-top:10px;max-width:400px;'>
            <ul style='padding:10px;' id='added-questions'>
            </ul>
        </div>
        <button id='create-quiz-btn'>AddToQuiz</button>
    </form></div>";
        $dataToDisplay .= "<button id='AddNewQuestion' name='Addquestion'>Add a new question</button>";
        $dataToDisplay .= "<a href='ShowUserExams.php'>Go back Exam page</a></div>";
    }
    return $dataToDisplay;
}

function displayAsQuestion($data)
{
    $formatedData = "<noscript>
    <form method='post' action='checkAnsweredQuestions.php'></noscript>
    <div id='{$data[0]['question_id']}' class='choicesDiv' style='min-width:800px'><h3> {$data[0]['question_syntax']}</h3><br/>";

    $choicesData = array();
    foreach ($data as $entry) {
        $choicesData[] = $entry['choice_syntax'];
    }

    shuffle($choicesData);

    foreach ($choicesData as $choice) {
        $formatedData .= " <input type='radio' id='$choice' name='{$data[0]['question_id']}' value='$choice'/><label class='radioChoices' for='$choice'>{$choice}</label> <br>";
    }

    $formatedData .= "
    <hr/></div>
    <noscript>
    </form>
    </noscript>";
    return $formatedData;
}
function displayForEdit($data)
{
    $formatedData = "<noscript>
    <form method='post' action='#'></noscript>
    <div id='{$data[0]['question_id']}' class='choicesDiv' style='min-width:800px'>" . "<span class='deletequestion'>×</span>" . "<h3>{$data[0]['question_syntax']}</h3>" . "<br/>";
    $choicesData = array();
    foreach ($data as $entry) {
        $choicesData[] = $entry['choice_syntax'];
    }

    shuffle($choicesData);

    foreach ($choicesData as $choice) {
        $formatedData .= " <input type='radio' id='$choice' name='{$data[0]['question_id']}' value='$choice'/><label class='radioChoices' for='$choice'>{$choice}</label> <br>";
    }

    $formatedData .= "
    <hr/></div>
    <noscript>
    </form>
    </noscript>";
    return $formatedData;
}





// function constructQuestionsArray($data)
// {
//     // Initialize an empty array to store the reconstructed data
//     $reconstructedData = array();

//     // Loop through the retrieved data to reconstruct it
//     foreach ($data as $item) {
//         $questionId = $item['question_id'];

//         // If the question ID is not already in the reconstructed array, create a new entry
//         if (!isset($reconstructedData[$questionId])) {
//             $reconstructedData[$questionId] = array(
//                 'question_id' => $item['question_id'],
//                 'question_syntax' => $item['question_syntax'],
//                 'correct_answer_syntax' => $item['correct_answer_syntax'],
//                 'choices' => array()
//             );
//         }

//         // Add each choice to the choices array for the corresponding question
//         $reconstructedData[$questionId]['choices'][] = array(
//             'choice_id' => $item['choice_id'],
//             'choice_syntax' => $item['choice_syntax']
//         );
//     }

//     // Convert the associative array to a simple indexed array
//     $finalReconstructedData = array_values($reconstructedData);
//     return $finalReconstructedData;
// }


//Can be used in the future
// echo "<pre>";
// print_r($data);
// echo "</pre>";
// // displayAsQuestion($data);
// $finalReconstructedData = constructQuestionsArray($data);
// $x = 0;
// $dataToDisplay = "";
// foreach ($finalReconstructedData as $data) {
//     $dataToDisplay .= displayAsQuestion($data);
//     $x += 1;
//     if ($x == $numberOfQuestions) {
//         break;
//     }
// }
// $dataToDisplay .= "<button id='SubmitAnswers' name='submit' value='submit'>Submit Answers</button>";
// return $dataToDisplay;
?>