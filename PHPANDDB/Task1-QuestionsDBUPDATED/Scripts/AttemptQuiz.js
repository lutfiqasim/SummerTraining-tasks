$(document).ready(function () {
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