$(document).ready(function () {
    $("body").on("click", "#SubmitAnswers", function (e) {
        e.preventDefault();

        // Select all direct children divs of the body
        const questionDivs = $("section > div");
        const quizId = $("#quizId").attr("value");
        answer = [];
        questionDivs.each(function (index, div) {
            isSelected = false;
            radioButtons = $(div).children("input");
            radioButtons.each(function (index2, radioBtn) {
                if (radioBtn.checked) {
                    answer.push({ key: $(div).attr("id"), value: $(radioBtn).attr("value") });
                    isSelected = true;
                    $(div).css("border", "none");
                    return false;
                }
            });
            if (!isSelected) {
                // console.log(radioBtn.checked);
                $(div).css("border", "2px solid red");
                showDialog("you have To answer all questions before submitting");
                return false;
            }
        });

        if (answer.length == questionDivs.length) {//All questions have been answered
            console.log("BEFORE");
            console.log(answer);
            checkAnswer(quizId,answer);
        }

    });

    function checkAnswer(quizId,questionAnswers) {
        $.ajax({
            url: "..\\DataAccess\\checkAnsweredQuestions.php",
            method: "POST",
            data: {
                action: "check",
                id: quizId,
                data: questionAnswers
            },
            success: function (response) {
                // Show a dialog with deletion success message
                // showDialog(`${response}`);
                $("body").html(response);
                // console.log(response);
            },
            error: function (xhr, status, error) {
                console.log("AJAX ERROR: ", error);
            }
        });
    }
});


function showDialog(dialogText) {
    $("#dialog").text(dialogText).css("color", "red").dialog();
}