<?php
function displayResultFormat($score, $questionData, $correctAnswers,$quizTitle)
{
    echo "<div id='score-div'><p>Your score in quiz: $quizTitle is: $score out of " . (count($questionData) * 10) . "</p></div>";
    // Display question-answer cards
    foreach ($questionData as $item) {
        $questionId = $item['key']; //['key']
        $userAnswer = $item['value']; //['value'];
        checkAnswer($correctAnswers, $questionId, $userAnswer);
    }
    echo "<br>";
    echo "<a href='index.php'>Go back to the main Page</a></div>";
}
function displayPreviousAttempt($score, $questionData, $correctAnswers, $quizTitle)
{

    echo "<div id='score-div'><p style='font-size:24px;'>Your score in quiz: $quizTitle is: $score out of " . (count($questionData) * 10) . "</p></div>";
    // Display question-answer cards
    foreach ($questionData as $item) {
        $questionId = $item->key; //['key']
        $userAnswer = $item->value; //['value'];
        checkAnswer($correctAnswers, $questionId, $userAnswer);
    }
    echo "<br>";
    echo "<a href='index.php'>Go back to the main Page</a></div>";
}
function checkAnswer($correctAnswers, $questionId, $userAnswer)
{
    foreach ($correctAnswers as $correctAnswer) {
        if ($correctAnswer['questionId'] == $questionId) {
            //Wrong answer
            if ($userAnswer !== $correctAnswer['answerSyntax']) {
                echo "<div class='card wrongAnswer'>
        <p>Question: {$correctAnswer['question-Syntax']}</p>
        <p>Your Answer: $userAnswer</p>
        <p>Correct Answer: {$correctAnswer['answerSyntax']}</p>
      </div>";
            } else {
                echo "<div class='card correctAnswer'>
        <p>Question: {$correctAnswer['question-Syntax']}</p>
        <p>Your Answer: $userAnswer</p>
        <p>Correct Answer: {$correctAnswer['answerSyntax']}</p>
      </div>";
            }

        }
    }
}



?>