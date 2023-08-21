$(document).ready(function () {

    // Event handler for deleting a question
    $("#dataContainer").on("click", ".deletequestion", function () {
        // Get the question ID from the HTML
        const questionId = parseFloat($(this).parent().siblings('.id').html());

        // Confirm deletion with the user
        if (confirm(`Do you want to delete question with id = ${questionId}?`)) {
            $(this).parent().parent().remove();
            // Call the deleteQuestion function
            deleteQuestion(questionId);
        }
    });

    // Event handler for editing a question
    $("#dataContainer").on("click", ".editQuestion", function () {
        // Get the question ID from the HTML
        $("#IndexPageh2").html("Edit question data");
        const questionId = parseFloat($(this).parent().siblings('.id').html());
        // Start searching for the question with the given ID
        startSearch("number", questionId);
    });
    // Event handler for showing as a question
    $("#dataContainer").on("click", ".ViewQuestion", function () {
        // Get the question ID from the HTML
        $("#IndexPageh2").html("View a question");
        const questionId = parseFloat($(this).parent().siblings('.id').html());
        // Start searching for the question with the given ID
        displayQuestionFormat("number", questionId);
    });


    // Event handlers  for sorting data
    $(document).on("click", "#descending", function () {
        $("#dataContainer").empty();
        // Call sortData()  with the "SortDescending" action
        sortData("SortDescending");
    });


    $(document).on("click", "#ascending", function () {
        $("#dataContainer").empty();
        // Call  sortData()  with the "SortAscending" action
        sortData("SortAscending");
    });
    // ----------------------


});

// Function to delete a question
function deleteQuestion(questionId) {
    $.ajax({
        url: "..\\Pages\\Edit-DeleteQuestions.php",
        method: "POST",
        data: {
            action: "delete",
            id: questionId
        },
        success: function (response) {
            // Show a dialog with deletion success message
            showDialog(`Deleted question with id = ${questionId} successfully`);
        },
        error: function (xhr, status, error) {
            console.log("AJAX ERROR: ", error);
        }
    });
}

// Function to start searching for a question
function startSearch(searchBy, searchId) {
    $.ajax({
        url: "..\\DataAccess\\searchForQuestion.php",
        method: "GET",
        data: {
            action: searchBy,
            id: searchId
        },
        success: function (response) {
            // Update the data container with the search result
            $("#dataContainer").html(response);
            // console.log(response);
        },
        error: function (xhr, status, error) {
            console.log("AJAX ERROR: ", error);
        }
    });
}
//Function to start searching for a question to display as question format
function displayQuestionFormat(searchBy, searchId) {
    $.ajax({
        url: "..\\DataAccess\\searchForQuestion.php",
        method: "GET",
        data: {
            action: searchBy,
            type: "ShowAsQuestion",
            id: searchId
        },
        success: function (response) {
            // Update the data container with the search result
            $("#dataContainer").html(response);
            // console.log(response);
        },
        error: function (xhr, status, error) {
            console.log("AJAX ERROR: ", error);
        }
    });
}
//  sort data
function sortData(sortAction) {
    $.ajax({
        url: "..\\Pages\\Edit-DeleteQuestions.php",
        method: "POST",
        data: {
            action: sortAction
        },
        success: function (response) {
            // Update the data container with the sorted data
            $("#dataContainer").html(response);
        },
        error: function (xhr, status, error) {
            console.log("AJAX ERROR: ", error);
        }
    });
}

//  display a dialog with a message
function showDialog(dialogText) {
    $("#dialog").css({ "font-size": "16px", "color": "red" }).text(dialogText).dialog();
}
