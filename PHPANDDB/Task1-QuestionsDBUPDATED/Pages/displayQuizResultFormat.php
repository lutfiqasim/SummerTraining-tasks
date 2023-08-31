<?php
include_once("..\phpActions\GetQuestions.php");
function displayResultFormat($score, $questionData, $correctAnswers, $quizTitle)
{
    echo "<div id='score-div'><p>Your score in quiz: $quizTitle is: $score out of " . (count($questionData) * 10) . "</p></div>";
    // Display question-answer cards
    foreach ($questionData as $item) {
        $questionId = $item['key']; //['key']
        $userAnswer = $item['value']; //['value'];
        checkAnswer($correctAnswers, $questionId, $userAnswer);
    }
    echo "<br>";
    echo "<a href='index.php'>Go back to the main Pages</a></div>";
}
function displayPreviousAttempt($score, $questionData, $correctAnswers, $quizTitle)
{

    echo "<div id='score-div'><p style='font-size:24px;'>Your score in quiz: $quizTitle is: $score out of " . (count($questionData) * 10) . "</p></div>";
    // Display question-answer cards
    foreach ($questionData as $item) {
        $questionId = $item['questionId']; //['key']
        $userAnswer = $item['userAnswer']; //['value'];
        checkAnswer($correctAnswers, $questionId, $userAnswer);
    }
    echo "<br>";

}
/*TODO:
 * Add a Attempt quiz again button inside the 
 * see previous attempts
 * in addition to inside the no attempts found
 * and as a new column inside the table 
 */
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

//used for parsing data when retrieved as question id 
//From database
/**
 * gets answer syntax from answer id and then send data to be displayed
 * 
 */
function dsiplayPreviousHelper($score, $questionData, $correctAnswers, $quizTitle, $quizId)
{
    $getQuestions = new GetQuestions();
    //Getting users' answer syntax
    for ($i = 0; $i < count($questionData); $i++) {
        $questionData[$i]['userAnswer'] = ($getQuestions->getAnswerSyntax($questionData[$i]['userAnswer']))[0]['syntax'];
    }
    displayPreviousAttempt($score, $questionData, $correctAnswers, $quizTitle);
    //Button to attempt quiz again
    echo "<div class='gobackDivs' style='float:right;'>";
    // echo "<a href='index.php'>Go back Main Page</a></div>";
    echo "<form method='post' action='QuizPage.php'>";
    echo '<input type="hidden" name="quiz_id" value="' . $quizId . '">';
    echo '<button type="submit" name="start" value="ReTake">Re-take Exam</button>';
    echo "</form>";
    echo "<a class='goBackToPreviousAttempts' href='PreviousAttempts.php?quiz=" . $quizId .
        "&requested=last'" . "</a>Go back</div>";
    echo "</div>";



}

?>