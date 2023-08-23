<?php
include_once("Database.php");
include_once('..\phpActions\GetQuestions.php');
function getQuestions($numberOfQuestions)
{
    $getQuestions = new GetQuestions();
    $data = $getQuestions->getQuizQuestions($numberOfQuestions);
    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";
    // displayAsQuestion($data);
    $finalReconstructedData = constructQuestionsArray($data);
    $x = 0;
    $dataToDisplay = "";
    foreach ($finalReconstructedData as $data) {
        $dataToDisplay .= displayAsQuestion($data);
        $x += 1;
        if ($x == $numberOfQuestions) {
            break;
        }
    }
    $dataToDisplay .= "<button id='SubmitAnswers' name='submit' value='submit'>Submit Answers</button>";
    return $dataToDisplay;
}

function displayAsQuestion($data)
{
    $formatedData = "<noscript>
     <form method='post' action='updateAQuestionDA.php'></noscript>
     <div id='{$data['question_id']}' class='choicesDiv' style='min-width:800px'><h3> {$data['question_syntax']}</h3><br/>";
    $choicesData = array();
    foreach ($data['choices'] as $entry) {
        $choicesData[] = $entry['choice_syntax'];
    }
    shuffle($choicesData);
    foreach ($choicesData as $choice) {
        $formatedData .= " <input type='radio' id='$choice' name='{$data['question_id']}'value='$choice'/><label class='radioChoices' for='$choice'>{$choice}</label> <br>";
    }
    $formatedData .= "
    <hr/></div>
    <noscript>
    </form>
    </noscript>";
    return $formatedData;
}


function constructQuestionsArray($data)
{
    // Initialize an empty array to store the reconstructed data
    $reconstructedData = array();

    // Loop through the retrieved data to reconstruct it
    foreach ($data as $item) {
        $questionId = $item['question_id'];

        // If the question ID is not already in the reconstructed array, create a new entry
        if (!isset($reconstructedData[$questionId])) {
            $reconstructedData[$questionId] = array(
                'question_id' => $item['question_id'],
                'question_syntax' => $item['question_syntax'],
                'correct_answer_syntax' => $item['correct_answer_syntax'],
                'choices' => array()
            );
        }

        // Add each choice to the choices array for the corresponding question
        $reconstructedData[$questionId]['choices'][] = array(
            'choice_id' => $item['choice_id'],
            'choice_syntax' => $item['choice_syntax']
        );
    }

    // Convert the associative array to a simple indexed array
    $finalReconstructedData = array_values($reconstructedData);
    return $finalReconstructedData;
}

?>