const questions = document.getElementById("questions");
// const answer1 = document.querySelectorAll("input[name='answer1']");
// const question2 = document.getElementById("question2");
// const answer2 = document.querySelectorAll("input[name='answer2']");
// const question3 = document.getElementById("question3");
// const answer3 = document.querySelectorAll("input[name='answer3']");
const formSelector = document.querySelectorAll("form fieldset .radioGroup");
const btn = document.querySelector("input[type='submit']");
function checkSelected(question, answer) {
    let isSelected = false;
    for (const radioBtn of answer) {
        if (radioBtn.checked) {
            isSelected = true;
        }
    }
    if (!isSelected) {
        alert("You have to select an answer for question NO."+question.id);
    }
    return isSelected;
}
btn.addEventListener("click", (e) => {
    e.preventDefault();
    let selected = true;
    for (let i = 0; i < formSelector.length && selected; i++) {
        let answers = formSelector[i].querySelectorAll("input[type='radio']");
        let questions = formSelector[i].querySelector("p")
        selected = checkSelected(questions,answers)
    }
    if(selected){
        document.getElementById("status").style.display ="block";
    }else{
        document.getElementById("status").style.display ="none";
    }
})