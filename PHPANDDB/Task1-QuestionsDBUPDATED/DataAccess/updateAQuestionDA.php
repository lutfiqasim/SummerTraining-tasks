<?php

include("Database.php"); // connection 
include('..\phpActions\UpdateQuestion.php'); // updating questiin
include('..\phpActions\InsertQuestions.php'); // Inserting choices
// Check if the request method is POST and required data is set
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['action'], $_POST['data'])) {
    try {
        // Extract action and data from POST request
        $action = $_POST['action'];
        $dataToUpdate = $_POST['data'];

        if ($action === "Update") {
            // Call updateData function and store result messages in array
            $resultMessages = updateData($dataToUpdate);
            // Output result messages
            echo implode("<br/>\n", $resultMessages);
        } else {
            echo "<h3>Error occurred. Please try again</h3>";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} elseif (isset($_POST['action']) && $_POST['action'] == "cancelUpdate") {
    // print_r($_POST);
    header("Location:..\Pages\Edit-DeleteQuestions.php");
    exit();

} else {
    //  required data is not set
    echo "<h3>1-Data not set</h3>";
}

// Function to update data, based on received input
function updateData($data)
{
    try {
        $updateObj = new UpdateQuestion();
        $resultMessages = []; // Array to store result messages

        // Check if the first item in the data array is the questionId
        if (isset($data[0]['key']) && $data[0]['key'] === "questionId") {
            $questionData = array_shift($data); // Remove and store the questionId item
            $questionId = $questionData['value']; // Extract the questionId value

            // Loop through the remaining data items
            // if (validateFormat($data)){
            foreach ($data as $item) {
                if (isset($item['key'], $item['value'])) {
                    $key = $item['key'];
                    $value = $item['value'];

                    // Check different keys and perform  updates based on key 
                    if ($key === "newQuestion" && !empty($value)) {
                        $resultMessages[] = "New Question: " . $updateObj->updateQuestionSyntax($questionId, $value);
                    } elseif ($key === 'newCorrectAnswer' && !empty($value)) {
                        $resultMessages[] = "Correct Answer: " . $updateObj->updateCorrectAnswer($questionId, $value);
                    } elseif ($key === 'choicesUpdate') {
                        foreach ($value as $choice) {
                            if (isset($choice['key'], $choice['value']) && !empty($choice['value'])) {
                                $choiceId = $choice['key'];
                                $choiceValue = $choice['value'];
                                $resultMessages[] = "\nChoice update: " . $updateObj->updateChoice($choiceId, $choiceValue);
                            }
                        }
                    } elseif ($key === 'NewAddedChoices') { //Newly added choices
                        $insertChoice = new UploadQuestion();

                        foreach ($value as $newChoice) {
                            if (isset($newChoice['key'], $newChoice['value']) && !empty($newChoice['value'])) {
                                $choiceValue = $newChoice['value'];
                                $resultMessages[] = "\n Inserting new Choice: " . $insertChoice->insertNewChoice($choiceValue, $questionId);
                            }
                        }

                    } else {
                        $resultMessages[] = "ELSE: UNDEFINED DATA OBJECT ";
                    }
                } else {
                    $resultMessages[] = "\nItem not entered: " . $item['key'];
                }
            }
            // }
            return $resultMessages;
        } else {
            return ["Error updating data, data not set"];
        }
    } catch (Exception $e) {
        throw new Exception("MESSAGE: " . $e->getMessage(), 1);
    }
}


function validateFormat($data)
{

    $choices = array();
    $newAddedChoices = array();
    if (isset($data['choice']))
        $choices = $data['choicesUpdate'];
    if (isset($data['$newAddedChoices']))
        $newAddedChoices = $data['NewAddedChoices'];
    $arr = array_merge($choices, $newAddedChoices);
    return hasDuplicates($arr);

}

function hasDuplicates($array)
{
    $countedValues = array_count_values($array);

    foreach ($countedValues as $valueCount) {
        if ($valueCount > 1) {
            return true; // Found duplicates
        }
    }

    return false; // No duplicates found
}

?>