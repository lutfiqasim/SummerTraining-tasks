$(document).ready(function () {
    //View question button
    // Event handler for showing as a question
    $("#createAQuizBtn").click(function(){
        console.log("HERE");
    });
      $("main").on("click", ".editQuestion", function () {
        console.log("Here");
        // Get the question ID from the HTML
        $("#IndexPageh2").html("Edit question data");
        const questionId = parseFloat($(this).parent().siblings('.id').html());
        // Start searching for the question with the given ID
        startSearch("number", questionId);
    });
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
});