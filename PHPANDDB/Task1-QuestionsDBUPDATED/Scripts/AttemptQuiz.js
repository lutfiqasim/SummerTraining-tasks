$(document).ready(function () {

    //A map that contains all questions to be added to current quiz
    let questionsToAdd = [];

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
            const option = $("<option>").val(question.id).text(question['question-Syntax']);
            $('#question-list').append(option);
        });

        //After populating select change it to select 2 format

        $("#question-list").select2();
    }
    // End of populating options with questions


    // Start of adding questions to Quiz
    $("#add-question-btn").click(function (e) {
        e.preventDefault();
        const quizTitle = $("#quizTitle");
        if (String($(quizTitle).val()) === "") {
            $(quizTitle).css("border-color", "red");
            showDialog("Enter quiz title first");
            return false;
        }
        const $selectedOption = $('#question-list option:selected');
        if ($selectedOption.text() == "Select a question") {
            showDialog("Please choose a valid choice");
            return false;
        }
        // Check if the selected question is already in the array
        const questionExists = questionsToAdd.some(q => q.key === $selectedOption.val());

        if (!questionExists) {
            // Add the question to the array and display it
            $($selectedOption).attr('disabled','disabled');
            questionsToAdd.push({ key: $selectedOption.val(), value: $selectedOption.text() });
            const question = $("<div class='questionToBeAdded'>").val($selectedOption.val()).text($selectedOption.text());
            const delteBtn = $("<span class='deleteChoice' style='float:right;' >×</span><br/><hr/>");
            $(question).append(delteBtn);
            $("#added-questions").append(question);
        } else {
            showDialog("Question already added!!!");
        }
    });


    //deletion of question to be added from list
    $("#choosen-question-toAdd").on("click", ".deleteChoice", function () {
        if (confirm(`Do you want to remove this ${$(this).parent().text()} ?`)) {
            $(this).parent().remove();
            const questionKey = $(this).parent().val();
            //Filter: returns a new array that includes all elements from the original array except the ones that match the condition
            questionsToAdd = questionsToAdd.filter(q => q.key !== questionKey);

            //Enable the choice again
            $("#question-list").find(`option[value="${questionKey}"]`).prop("disabled", false);
        }
    });

    //Create quiz
    $("#create-quiz-btn").click(function (e) {
        e.preventDefault();
        if (!checkForTitleAndQuestions()) {
            showDialog("Specify title and questions")
            return false;
        }
        //Create a quiz 
        const quizTitle = $("#quizTitle").val();
        createQuiz(quizTitle, questionsToAdd);

    });

    function checkForTitleAndQuestions() {
        const quizTitle = $("#quizTitle");
        if (String($(quizTitle).val()) === "") {
            $(quizTitle).css("border-color", "red");
            showDialog("Enter quiz title first");
            return false;
        }
        else if (questionsToAdd.length <= 0) {
            return false;
        }
        return true;
    }

    function createQuiz(quizTitle, questionTobeAdded) {
        $.ajax({
            url: "..\\DataAccess\\AddQuizDA.php",
            method: "POST",
            data: {
                action: "CreateQuiz",
                title: quizTitle,
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
    // End of adding questions to Quiz and adding quiz




    $(".noScript").css("display", "none");
    //Check for messages in url
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('message')) {
        if (urlParams.get('message')) {
            showDialog(urlParams.get('message'));
            window.history.replaceState({}, document.title, "/" + "Summer%20Training%201/PHPANDDB//Task1-QuestionsDBUPDATED/Pages/CreateAQuiz.php");
        }
    }

});
//  display a dialog with a message
function showDialog(dialogText) {
    $("#dialog").css({ "font-size": "18px", "color": "green", "font-style": "italic" }).text(dialogText).dialog();
}

// $("#createAQuizBtn").click(function () {
    //     let rows = $("table tr:not(:first-child)");
    //     let quizTitle = $("#quizTitle");
    //     if (quizTitle.val() !== "") {
    //         let questionTobeAdded = [];
    //         rows.each(function (index) {
    //             let id = $(this).find(".id").attr("value");//question id
    //             //Is choosen?
    //             let isChecked = $(this).find("input[type='checkbox']").prop("checked");
    //             //Added it to this exam dataSet
    //             if (isChecked) {
    //                 questionTobeAdded.push(id);
    //             }
    //         });

    //         console.log(questionTobeAdded);
    //         if (questionTobeAdded.length >= 5) {
    //             createQuiz(quizTitle.val(), questionTobeAdded);
    //         } else {
    //             showDialog("You must at least specifiy 5 questions");
    //         }
    //     } else {
    //         quizTitle.css({ "border-color": "red" });
    //         showDialog("Specify quiz title first");
    //     }


    // });





    ///previous actions before updating 
    // $("#start-button").click(function (e) {
    //     e.preventDefault();
    //     // showDialog("Comming soon");
    //     const numberOfQuestions = $("#num-questions").val();

    //     if (numberOfQuestions > 15 || numberOfQuestions < 0) {
    //         showDialog("You have to choose a number between 1-15");
    //     } else {
    //         $("form").submit();
    //     }

    // });