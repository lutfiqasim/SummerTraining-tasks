<?php
include_once("..\phpActions\GetQuizes.php");
include_once("..\phpActions\SaveAttempts.php");

function displayQuizesFormat()
{

    $getQuizes = new GetQuizes();
    $quizesData = $getQuizes->retrieveQuizes();


    // Loop through each retrieved quiz data and generate HTML forms
    echo '<div class="quizes-div">';
    $userId = $_SESSION['user_id'];
    foreach ($quizesData as $quizData) {
        $quizId = $quizData['id'];
        $quizName = $quizData['quiz_name'];
        $getPreviousAttempts = new SaveAttempts($userId, $quizId);
        $bestPreviousAttempt = $getPreviousAttempts->getBestAttemptScore($quizId, $userId);
        $lastAttempt = $getPreviousAttempts->getLastAttemptScore($quizId, $userId);
        $addedByUsername = $quizData['user_name'];
        echo '<form class="form-card" action="QuizPage.php" method="post">';
        echo '<input type="hidden" name="quiz_id" value="' . $quizId . '">'; // Hidden field for quiz ID
        echo '<p>Quiz Name: ' . $quizName . '</p>';
        echo '<p>Added by: ' . $addedByUsername . '</p><br/>';
        echo '<p style="font-size:12px;color:green;">Best Attempt Score :' . $bestPreviousAttempt . '</p>';
        echo '<p style="font-size:12px;color:green;">last Attempt Score :' . $lastAttempt . '</p>';
        echo '<button type="submit" name="start">Start Quiz</button>';
        echo '<button type="submit" name="attempt" value="best">See previous best attempt</button>';
        echo '<button type="submit" name="attempt" value="last">See previous best attempt</button>';
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
    if (count($quizesData) > 0) {
        foreach ($quizesData as $quizData) {
            $quizId = $quizData['id'];
            $quizName = $quizData['quiz_name'];
            $addedByUsername = $quizData['user_name'];
            $getPreviousAttempts = new SaveAttempts($userId, $quizId);
            $numberOfParticipants = $getPreviousAttempts->numberOfparticipantsOfQuiz($quizId);

            $scoreStats = $getPreviousAttempts->getScoresStats($quizId);
            $totalScore = $scoreStats['totalQuestions'] * 10;
            echo '<form class="form-card" action="EditDeleteQuiz.php" method="post">';
            echo '<input type="hidden" name="quiz_id" value="' . $quizId . '">'; // Hidden field for quiz ID
            echo '<p>Quiz Name: ' . $quizName . '</p>';
            echo '<p>Added by: ' . $addedByUsername . '</p>';
            echo "<p>number of participants: $numberOfParticipants</p>";
            echo "<p>Best Score: {$scoreStats['maxBestScore']} / $totalScore</p>";
            echo "<p>Avg score of last attempts: {$scoreStats['averageLastScore']} / $totalScore</p>";
            echo '<button type="submit" name="val" value ="Show">Show/Edit</button>';
            echo '<button id="deleteQuiz" type="submit"  name="val" value ="Delete">Delete Quiz</button>';
            echo '</form>';
        }
    } else {
        echo "<p style='font-size:24px;color:Green;margin-top:30px;padding:10px'>You have not created any exams yet !!!</p>";
    }
    echo '</div>';

}