<?php

include("Database.php"); // Make sure Database.php includes database connection logic

// Import necessary classes
include('phpActions/UpdateQuestion.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['action']) && isset($_POST['data'])) {
        try {
            $action = $_POST['action'];
            $dataToUpdate = $_POST['data'];

            if ($action === "Update") {
                $result = updateData($dataToUpdate);
                echo $result;
            } else {
                echo "<h3>Error occurred. Please try again</h3>";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "<h3>Data not set</h3>";
    }
}

function updateData($data)
{
    try {
        $updateObj = new UpdateQuestion();
        $resultMessages = [];

        if (isset($data[0]['key']) && $data[0]['key'] == "questionId") {
            $questionData = array_shift($data);
            $questionId = $questionData['value'];

            foreach ($data as $item) {
                if (isset($item['key']) && isset($item['value'])) {
                    $key = $item['key'];
                    $value = $item['value'];

                    if ($key === "newQuestion" && !empty($value)) {
                        $resultMessages[] = "New Question: " . $updateObj->updateQuestionSyntax($questionId, $value);

                    } elseif ($key == 'newCorrectAnswer' && !empty($value)) {
                        $resultMessages[] = "Correct Answer: " . $updateObj->updateCorrectAnswer($questionId, $value);

                    } elseif ($key === 'choicesUpdate') {
                        foreach ($value as $choice) {
                            if (isset($choice['key']) && isset($choice['value']) && !empty($choice['value'])) {
                                $choiceId = $choice['key'];
                                $choiceValue = $choice['value'];
                                $resultMessages[] = "Choice update: " . $updateObj->updateChoice($choiceId, $choiceValue);
                            }
                        }
                    }
                } else {
                    $resultMessages[] = "Item not entered: " . $item['key'];
                }
            }
            return implode("\n", $resultMessages);
        } else {
            return "Error updating data, data not set";
        }
    } catch (Exception $e) {
        throw new Exception("MESSAGE: " . $e->getMessage(), 1);
    }
}
?>