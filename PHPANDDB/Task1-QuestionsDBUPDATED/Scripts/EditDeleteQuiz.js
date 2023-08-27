$(document).ready(function () {
    $(".noScript").css("display", "none");
    $("main").on("click", "#deleteQuiz", function (e) {

        if (confirm("Are you sure you want to delete quiz?")) {
        } else {
            e.preventDefault();
        }

    });


    //inside EditDeleteQuiz.php
    $("body").on("click", ".deletequestion", function () {

        const questionId = $(this).parent().attr("id");
        const quizId = $(document).find("#quizId").attr("value");
        const allQuestions = $(document).find(".choicesDiv");
        let numberOfQuestions = allQuestions.length;

        if ((numberOfQuestions - 1) >= 5) {//Proceed deleting
            if (confirm("Are you sure you want to delete this question?")) {
                deleteQuestionFromQuiz(quizId, questionId);
            }
        } else {
            showDialog("Can't delete choice each quiz must at least have 5 questions");
        }

    });

    //Check for messages in url
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('message')) {
        if (urlParams.get('message')) {
            showDialog(urlParams.get('message'));
            window.history.replaceState({}, document.title, "/" + "Summer%20Training%201/PHPANDDB//Task1-QuestionsDBUPDATED/Pages/AttemptQuiz.php");
        }
    }
    // Function to delete a question
    function deleteQuestionFromQuiz(quizId, questionId) {
        $.ajax({
            url: "..\\DataAccess\\DeleteQuestionQuizDA.php",
            method: "POST",
            data: {
                action: "delete",
                quiz: quizId,
                question: questionId
            },
            success: function (response) {
                // Show a dialog with deletion success message
            
                if(confirm(response)){

                }
                location.reload();

            },
            error: function (xhr, status, error) {
                console.log("AJAX ERROR: ", error);
            }
        });
    }
});

//  display a dialog with a message
function showDialog(dialogText) {
    $("#dialog").css({ "font-size": "16px", "color": "red" }).text(dialogText).dialog();
}