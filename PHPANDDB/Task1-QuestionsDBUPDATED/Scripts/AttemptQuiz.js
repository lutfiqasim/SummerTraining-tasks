$(document).ready(function () {
    $(".noScript").css("display", "none");
    $("#createAQuizBtn").click(function () {
        let rows = $("table tr:not(:first-child)");
        let quizTitle = $("#quizTitle");
        if (quizTitle.val() !== "") {
            let questionTobeAdded = [];
            rows.each(function (index) {
                let id = $(this).find(".id").attr("value");//question id
                //Is choosen?
                let isChecked = $(this).find("input[type='checkbox']").prop("checked");
                //Added it to this exam dataSet
                if (isChecked) {
                    questionTobeAdded.push(id);
                }
            });

            console.log(questionTobeAdded);
            if (questionTobeAdded.length >= 5) {
                createQuiz(quizTitle.val(), questionTobeAdded);
            } else {
                showDialog("You must at least specifiy 5 questions");
            }
        } else {
            quizTitle.css({ "border-color": "red" });
            showDialog("Specify quiz title first");
        }


    });


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
                // showDialog(response);
                // console.log(response);
                if(confirm("Created quiz successfully")){
                    
                }
                location.reload();
            },
            error: function (xhr, status, error) {
                console.log("AJAX ERROR: ", error);
            }
        });
    }




    ///previous actions before updating 
    $("#start-button").click(function (e) {
        e.preventDefault();
        // showDialog("Comming soon");
        const numberOfQuestions = $("#num-questions").val();

        if (numberOfQuestions > 15 || numberOfQuestions < 0) {
            showDialog("You have to choose a number between 1-15");
        } else {
            $("form").submit();
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

});
//  display a dialog with a message
function showDialog(dialogText) {
    $("#dialog").css({ "font-size": "18px", "color": "green", "font-style": "italic" }).text(dialogText).dialog();
}