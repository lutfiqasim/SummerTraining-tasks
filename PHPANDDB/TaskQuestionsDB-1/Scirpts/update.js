$(document).ready(function () {
    $(document).on("click", ".updateButton", function (event) {
        event.preventDefault();
        console.log("HERe");
        const updatingArray = [];
        const newQSyntax = String($("#questionSyntax").val().trim());
        const correctAns = String($("#CorrectAnswerSyntax").val().trim());
        const numberOfChoices = $("#updateQuestionsDiv").find(".newChoice");
        const questionId = $("#questionIdLabel").text();
        updatingArray.push({ key: "questionId", value: questionId });

        if (newQSyntax !== "") {
            updatingArray.push({ key: "newQuestion", value: newQSyntax });
        }

        if (correctAns !== "") {
            updatingArray.push({ key: "newCorrectAnswer", value: correctAns });
        }

        const choicesArray = [];
        numberOfChoices.each(function () {
            const choice = String($(this).val().trim());
            if (choice !== "") {
                choicesArray.push({ key: $(this).attr("id"), value: choice });
            }
        });

        if (choicesArray.length > 0) {
            updatingArray.push({ key: "choicesUpdate", value: choicesArray });
        }

        if (updatingArray.length === 1) {
            showDialog("Please fill in data to update before clicking the button");
        } else {
            console.log(updatingArray);
            sendDataToUpdate(updatingArray);
        }
    });

    function sendDataToUpdate(dataArray) {
        $.ajax({
            url: "updateAQuestionDA.php",
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
            }
        });
    }

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

    function showDialog(dialogText) {
        $("#dialog").text(dialogText).css("color", "red").dialog();
    }
});



// $(document).ready(function () {
//     $(document).on("click", "#updateButton", function (event) {
//         event.preventDefault();
//         let updatingArray = [];
//         const newQSyntax = $("#questionSyntax").val();
//         const correctAns = $("#CorrectAnswerSyntax").val();
//         const numberOfChoices = $("#updateQuestionsDiv").find(".newChoice");

//         $questionId = $("#questionIdLabel").text();
//         updatingArray.push({ key: "questionId", value: $questionId });
//         if (newQSyntax.trim() !== "") {
//             updatingArray.push({ key: "newQuestion", value: newQSyntax });
//         }
//         if (correctAns.trim() !== "") {
//             updatingArray.push({ key: "newCorrectAnswer", value: correctAns });
//         }
//         let choicesArray = [];
//         numberOfChoices.each(function () {
//             let choice = $(this).val();
//             console.log("Choice adding\n");
//             if (choice.trim() !== "") {
//                 console.log($(this).attr("id"));
//                 choicesArray.push({ key: $(this).attr("id"), value: choice });
//             }
//         });

//         if (choicesArray.length > 0) {
//             updatingArray.push({ key: "choicesUpdate", value: choicesArray });
//         }

//         if (updatingArray.length === 1) {
//             showDialog("Please fill in data to update before clicking the button");
//         } else {
//             console.log("Start Updating");
//             sendDataToUpdate(updatingArray);
//         }
//     });

//     function sendDataToUpdate(dataArray) {
//         $.ajax({
//             url: "updateAQuestionDA.php",
//             method: "POST",
//             data: {
//                 action: "Update",
//                 data: dataArray
//             },
//             success: function (response) {
//                 $("#EditQuestion-div").empty().css("display", "block");
//                 // history.go(0);
//                 $("#dataContainer").empty();
//                 showDialog(response);
//                 // sortshowData("SortAscending");
//                 showList();
//             },
//             error: function (xhr, status, error) {
//                 console.log("AJAX ERROR: ", error);
//             }
//         });
//     }
// });

// function showList() {
//     $.ajax({
//         url: "Edit-DeleteQuestions.php",
//         method: "POST",
//         data: {
//             action: "SortAscending"
//         },
//         success: function (response) {
//             $("#dataContainer").html(response);
//         }, error: function (xhr, status, error) {
//             console.log("AJAX ERROR", error);
//         }

//     });
// }
// function showDialog(dialogText) {
//     $("#dialog").text(dialogText).css("color", "red").dialog();
// }
