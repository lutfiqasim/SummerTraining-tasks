<?php

include_once("..\phpActions\GetQuizes.php");

function displayQuizesFormat()
{

    $getQuizes = new GetQuizes();
    $quizesData = $getQuizes->retrieveQuizes();
    // Loop through each retrieved quiz data and generate HTML forms
    echo '<div class="quizes-div">';
    foreach ($quizesData as $quizData) {
        $quizId = $quizData['id'];
        $quizName = $quizData['quiz_name'];
        $addedByUsername = $quizData['user_name'];
        echo '<form class="form-card" action="QuizPage.php" method="post">';
        echo '<input type="hidden" name="quiz_id" value="' . $quizId . '">'; // Hidden field for quiz ID
        echo '<p>Quiz Name: ' . $quizName . '</p>';
        echo '<p>Added by: ' . $addedByUsername . '</p>';
        echo '<button type="submit">Start Quiz</button>';
        echo '</form>';
    }
    echo '</div>';

}
function displayCurrentUserQuizes($userId)
{

    $getQuizes = new GetQuizes();
    $quizesData = $getQuizes->retriveCurrentUserQuizes($userId);
    // Loop through each retrieved quiz data and generate HTML forms
    echo '<div class="quizes-div">';
    foreach ($quizesData as $quizData) {
        $quizId = $quizData['id'];
        $quizName = $quizData['quiz_name'];
        $addedByUsername = $quizData['user_name'];
        echo '<form class="form-card" action="EditDeleteQuiz.php" method="post">';
        echo '<input type="hidden" name="quiz_id" value="' . $quizId . '">'; // Hidden field for quiz ID
        echo '<p>Quiz Name: ' . $quizName . '</p>';
        echo '<p>Added by: ' . $addedByUsername . '</p>';
        echo '<button type="submit" name="Show">Show/Edit</button>';
        echo '<button id="deleteQuiz" type="submit"  name="val" value ="Delete">Delete Quiz</button>';
        echo '</form>';
    }
    echo '</div>';

}