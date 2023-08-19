$(document).ready(function () {

    $("#signup").click(function (e) {
        e.preventDefault();
        console.log("HERE");
        if (validateSignUp()) {
            $(".signup-form").submit();
        }
    });

    function validateSignUp() {
        const mailFormat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        const userName = $("#signup-username").val();
        const userEmail = $("#signup-email").val();
        const userPassword = $("#signup-password").val();
        const rePassword = $("#signup-confirm-password").val();
        if (checkEmptyString(userName)) {
            showDialog("Enter User name Please");
        } else if (checkEmptyString(userEmail)) {
            showDialog("Enter User Email Please");
        } else if (!(userEmail.match(mailFormat))) {
            alert("Enter valid email\neg:email@example.com");
        } else if (checkEmptyString(userPassword) || checkEmptyString(rePassword)) {
            showDialog("Enter password please");
        } else if (userPassword.length < 6 || rePassword.length < 6) {
            showDialog("Password must be at least 6 characters");
        } else if (userPassword !== rePassword) {
            showDialog("Password doesn't match");
        } else {//all checked data are correct
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
    $(".no-script").css("display", "none");
});

function showDialog(dialogText) {
    $("#dialog").text(dialogText).css("color", "red").dialog();
}
//Checks for signup tries 
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('message') && urlParams.get('message') != '') {
        showDialog(urlParams.get('message'));
    }
});