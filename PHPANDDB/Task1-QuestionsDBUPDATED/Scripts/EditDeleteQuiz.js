$(document).ready(function () {
    $(".noScript").css("display", "none");
    $("main").on("click", "#deleteQuiz", function (e) {

        const quizName = $(this).parent().find("p");

        if (confirm(`Are you sure you want to delete ${$(quizName.get(0)).html()}?`)) {
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

                if (confirm(response)) {

                }
                location.reload();

            },
            error: function (xhr, status, error) {
                console.log("AJAX ERROR: ", error);
            }
        });
    }

    //End of delete question from quiz



    //Add new Question to quiz

    //Get already added questions so that no duplication exists
    questionsToAdd = [];
    //All divs except for the add new question one (the one that has quiz questions)
    const divsToSelect = $('div:not(#Add-new-Quiz-Question-Form)');
    divsToSelect.each((index, div) => {
        questionsToAdd.push({ key: $(div).attr("id"), value: "question" });

    });

    $("body").on("click", "#AddNewQuestion", function () {
        $("#Add-new-Quiz-Question-Form").toggle();
        getChoices();
        //Populate with quizes select with quizes
        function getChoices() {
            $.ajax({
                url: "../DataAccess/RetriveQuestionsToDisplayDA.php",
                method: "GET",
                dataType: 'json',
                success: function (response) {
                    populateQuizzes(response);
                    // console.log(response);
                },
                error: function (xhr, status, error) {
                    console.log("AJAX ERROR: ", error);
                }
            });
        }

        function populateQuizzes(questions) {
            if (questions.length <= 0) {
                if (confirm("No questions were added to the website")) {

                }
                window.location("..\\Pages\\index.php");
            }
            // console.log("Is 'questions' an array?", Array.isArray(questions));
            questions.forEach(question => {
                const questionExists = questionsToAdd.some(q => q.key == question.id);
                if (!questionExists) {
                    const option = $("<option>").val(question.id).text(question['question-Syntax']);
                    $('#question-list').append(option);
                }
            });
        }
    });

    $("body").on("click", "#create-quiz-btn", function (e) {
        e.preventDefault();
        const quizId = $(document).find("#quizId").attr("value");
        const questionToBeAddedDivs = $("body").find(".questionToBeAdded");
        console.log($(questionToBeAddedDivs.get(0)).val());
        let questionIdsToBeAdded = [];

        questionToBeAddedDivs.each((index, div) => {
            questionIdsToBeAdded.push($(div).val());
        });
        AddquestionsToQuiz(quizId, questionIdsToBeAdded);

    });

    function AddquestionsToQuiz(quizId, questionTobeAdded) {
        $.ajax({
            url: "..\\DataAccess\\AddNewQuestionToQuizDA.php",
            method: "POST",
            data: {
                action: "addQuestionsToQuiz",
                qid: quizId,
                data: questionTobeAdded
            },
            success: function (response) {
                // Update the data container with the search result
                if (confirm(response)) {
                }
                location.reload();
            },
            error: function (xhr, status, error) {
                console.log("AJAX ERROR: ", error);
            }
        });
    }
    // Start of adding questions to Quiz
    $("#add-question-btn").click(function (e) {
        e.preventDefault();
        const $selectedOption = $('#question-list option:selected');
        if ($selectedOption.text() == "Select a question") {
            showDialog("Please choose a valid choice");
            return false;
        }
        // Check if the selected question is already in the array
        const questionExists = questionsToAdd.some(q => q.key === $selectedOption.val());

        if (!questionExists) {
            // Add the question to the array and display it
            questionsToAdd.push({ key: $selectedOption.val(), value: $selectedOption.text() });
            const question = $("<div class='questionToBeAdded'>").val($selectedOption.val()).text($selectedOption.text());
            const delteBtn = $("<span class='deleteChoice' style='float:right;' >×</span><br/><hr/>");
            $(question).append(delteBtn);
            $("#added-questions").append(question);
        } else {
            showDialog("Question already added!!!");
        }
    });


    //End of add new question to quiz

    //Check for messages in url
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('message')) {
        if (urlParams.get('message')) {
            showDialog(urlParams.get('message'));
            window.history.replaceState({}, document.title, "/" + "Summer%20Training%201/PHPANDDB//Task1-QuestionsDBUPDATED/Pages/ShowUserExams.php");
        }
    }
});

//  display a dialog with a message
function showDialog(dialogText) {
    $("#dialog").css({ "font-size": "16px", "color": "red" }).text(dialogText).dialog();
}