$(document).ready(function () {
    $(".noScript").css("display", "none");
    $("main").on("click", "#deleteQuiz", function (e) {

        if (confirm("Are you sure you want to delete quiz?")) {

        } else {
            e.preventDefault();
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
    $("#dialog").css({ "font-size": "16px", "color": "green" }).text(dialogText).dialog();
}