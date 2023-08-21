<?php
session_start();
include("Database.php");
include("..\phpActions\InsertQuestions.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Data format
    /**
     * Array 
     * ( [questionSyntax] => Array ( [0] => TEST QUESTION ) 
     * [correctAnswer] => Array ( [0] => TESTQUESTION CORRECT ) 
     * [choice] => Array ( [0] => TESTQUESTION CHOICE [1] => TESTQUESTION CHOICE2 [2] => TESTQUESTION CHOICE3 ) )
     * 
     */
    try {
        $validation = validateInsertedQuestion($_POST);
        if ($validation === true) {
            $insertQuestion = new UploadQuestion();
            $result = $insertQuestion->addQuestion($_POST,$_SESSION['user_id']);
            if ($result != "") {
                // header("Location:..\Pages\AddQuestion.php?message=" . $result);
                // header("Location: " . $_SERVER['HTTP_REFERER'] . "?message=" . $result);
                header("Location:..\Pages\AddQuestion.php?message=" . $result);

            } else {
                header("Location:..\Pages\AddQuestion.php?message=Added-data-successfully");
                // header("Location:..\Pages\AddQuestion.php?message=Added-data-successfully");
                // header("Location: " . $_SERVER['PHP_SELF'] . "?message=Added-data-successfully");
            }
        } else {
            header("Location:..\Pages\AddQuestion.php?message=" . $validation);
            // header("Location: " . $_SERVER['PHP_SELF'] . "?message=" . $validation);
        }

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function validateInsertedQuestion($data)
{
    if (isset($data['questionSyntax'])) {
        if (sizeof($data) < 3) {
            return false;
        }
        $correctChoice = $data['correctAnswer'];
        if ($correctChoice === "") {
            return "Must specify correct Choice";
        }
        $choices = $data['choice'];
        if (!countNumberOfChoices($choices)) {
            return "Multiple Choice questions must have at least 2 choices";
        }
        if (hasDuplicates($choices, $correctChoice)) {
            return "Each choice must be unique";
        }
        return true;
    } else {
        return "Need to enter question sentax";
    }

}
function hasDuplicates($array, $correctValue)
{
    $array[] = $correctValue;
    $countedValues = array_count_values($array);

    foreach ($countedValues as $valueCount) {
        if ($valueCount > 1) {
            return true; // Found duplicates
        }
    }

    return false; // No duplicates found
}
function countNumberOfChoices($choicesArray)
{
    $numberOfChoices = 1;
    foreach ($choicesArray as $choice) {
        if ($choice !== "") {
            $numberOfChoices += 1;
        }
    }
    return $numberOfChoices >= 2;
}
?>