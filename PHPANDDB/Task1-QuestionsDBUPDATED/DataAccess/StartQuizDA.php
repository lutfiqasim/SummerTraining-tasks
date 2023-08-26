<?php
include_once("Database.php");
include_once('..\phpActions\GetQuiz.php');
function getQuestions($numberOfQuestions)
{
    $getQuestions = new GetQuiz();
    $Questiondata = $getQuestions->getQuiz($numberOfQuestions);
    $dataToDisplay = "";
    foreach ($Questiondata as $data) {
        $dataToDisplay .= displayAsQuestion($data);
    }
    $dataToDisplay .= "<button id='SubmitAnswers' name='submit' value='submit'>Submit Answers</button>";
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