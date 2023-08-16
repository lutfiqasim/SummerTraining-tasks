//Note to self 
//Check updated answers for replication

$(document).ready(function () {

    //off to remove any previous binding of the button so that if its decleared again
    //it doesn't go through the functionality twice
    $("#dataContainer").off("click", "#updateButton").on("click", "#updateButton", function (event) {
        event.preventDefault();
        console.log("updateButton function declearing ");
        const updatingArray = [];
        const newQSyntax = String($("#questionSyntax").val().trim());
        const correctAns = String($("#CorrectAnswerSyntax").val().trim());
        const numberOfChoices = $("#updateQuestionsDiv").find(".newChoice");
        const newAddedChoices = $("#updateQuestionsDiv").find(".newAddedChoice");
        const questionId = $("#questionIdLabel").attr("value");
        console.log(questionId);
        updatingArray.push({ key: "questionId", value: questionId });

        if (newQSyntax !== "") {
            updatingArray.push({ key: "newQuestion", value: newQSyntax });
        }

        if (correctAns !== "") {
            updatingArray.push({ key: "newCorrectAnswer", value: correctAns });
        }


        //For updating already existing choices
        const choicesArray = [];
        numberOfChoices.each(function () {
            const choice = String($(this).val().trim());
            if (choice !== "") {
                choicesArray.push({ key: $(this).attr("id"), value: choice });
            }
        });

        //For adding new added choices by user
        const newChoicesArray = [];
        let i = 0;
        newAddedChoices.each(function () {
            const choice = String($(this).val().trim());
            if (choice !== "") {
                newChoicesArray.push({ key: i, value: choice });
            }
        });
        if (choicesArray.length > 0) {
            updatingArray.push({ key: "choicesUpdate", value: choicesArray });
        }
        if (newChoicesArray.length > 0) {
            updatingArray.push({ key: "NewAddedChoices", value: newChoicesArray });
        }
        if (updatingArray.length === 1) {
            showDialog("Please fill in data to update before clicking the button");
        } else {
            console.log(updatingArray);
            //Check for new choices if valid
            if (validateChoices())
                sendDataToUpdate(updatingArray);
            else
                showDialog("Each choice must be unique");
        }
    });

    function sendDataToUpdate(dataArray) {
        $.ajax({
            url: "..\\DataAccess\\updateAQuestionDA.php",
            method: "POST",
            data: {
                action: "Update",
                data: dataArray
            },
            success: function (response) {
                // Clear and show success message
                $("#EditQuestion-div").empty().css("display", "block");
                showDialog(response);
                // Reload the question list
                showList();
            },
            error: function (xhr, status, error) {
                // Show error message
                showDialog("An error occurred during the update process.");
                console.log("AJAX ERROR: ", error);
                console.log("AJAX ERROR2: ", error, "Response Text: ", xhr.responseText);
            }
        });
    }
    //get data from db and show them in table fromat
    function showList() {
        $.ajax({
            url: "Edit-DeleteQuestions.php",
            method: "POST",
            data: {
                action: "SortAscending"
            },
            success: function (response) {
                $("#dataContainer").html(response);
            },
            error: function (xhr, status, error) {
                console.log("AJAX ERROR", error);
            }
        });
    }
    //Add new choice button action
    $("#dataContainer").on("click", ".addChoiceBtn", function () {
        const choiceDiv = $("<div class='choice'></div>")
        let delteBtn = $("<span class='deleteChoice'>×</span><br>");
        let choiceLabel = $("<label>").text("New Choice:");
        let line = $("<hr><br>");
        let newChoiceInput = $("<input>").attr({
            class: 'newAddedChoice',
            type: 'text',
            placeholder: 'Enter new choice answer Syntax'
        });
        choiceDiv.append(delteBtn, choiceLabel, newChoiceInput, line);
        choiceDiv.insertBefore(".addChoiceBtn");
    });

    //Delete choice
    $("#dataContainer").on("click", ".deleteChoice", function () {
        const currchoice = $(this).parent();
        //Div containing all labels and choices select all previous choices inside
        const mainDivChoices = $(this).parent().parent().find(".newChoice");
        if (currchoice.find("input").hasClass("newAddedChoice")) {//Newly added choice isn't in database yet
            currchoice.remove();
        }
        else if (mainDivChoices.length > 1) {
            // let choiceSentax = currchoice.find("label").attr("text");
            let choiceId = currchoice.find("input").attr("id");
            if (confirm("Do you want to delete this choice?")) {
                currchoice.remove();
                deleteChoiceFromDB(choiceId);
            }
        } else {
            showDialog("Multiple choice questions need at least 2 choices Please enter new choice before deleting");
        }
    });
});

function deleteChoiceFromDB(choiceId) {
    $.ajax({
        url: "..\\DataAccess\\deleteChoice.php",
        method: "POST",
        data: {
            action: "delete",
            id: choiceId
        },
        success: function (response) {
            // Show a dialog with deletion success message
            showDialog(`Deleted choice successfully`);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.log("AJAX ERROR: ", error);
        }
    });
}
function showDialog(dialogText) {
    $("#dialog").text(dialogText).css("color", "red").dialog();
}

function validateChoices() {
    const allChoices = $(".newChoice, .newAddedChoice");
    const uniqueChoices = new Set();
    let correctAnswer = $("#CorrectAnswerSyntax").val().trim();

    if (correctAnswer !== "") {
        uniqueChoices.add(correctAnswer);
    }

    for (const choice of allChoices) {
        const choiceValue = $(choice).val().trim();
        if (choiceValue === "") {
            continue;
        }
        else if (uniqueChoices.has(choiceValue)) {
            return false;
        }

        uniqueChoices.add(choiceValue);
    }

    return true;
}