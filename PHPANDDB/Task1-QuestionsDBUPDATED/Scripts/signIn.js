$(document).ready(function () {

    $("#login-btn").click(function (e) {
        e.preventDefault();
        if (validateSignIn()) {
            $(".login-form").submit();
        }
    });


    function validateSignIn() {
        const userName = $("#username").val();
        const password = $("#password").val();
        if (checkEmptyString(userName)) {
            showDialog("Enter user Name first");
        } else if (checkEmptyString(password)) {
            showDialog("Enter password First");
        } else {
            return true;
        }
        return false;
    }

    function checkEmptyString(value) {
        if (typeof value == 'string' && value.trim() == "") {
            return true;
        }
        return false;
    }

    //Hide all no script contents
    $(".no-script").css({ "display": "none", "color": "green" });
});




//For getting message data from header
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('message') && urlParams.get('message') != '') {
        showDialog(urlParams.get('message'));
    }
});
function showDialog(dialogText) {
    $("#dialog").text(dialogText).css("color", "red").dialog();
}