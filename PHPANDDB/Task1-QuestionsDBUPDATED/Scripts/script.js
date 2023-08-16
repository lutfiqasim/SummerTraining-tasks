$(document).ready(function () {
    $("#User-Entered-Questions").on("click", ".addMoreChoices", function () {
        let listItem = $("<li>").addClass("choices-input");
        let nameAttr = $(this).parent().find(".choices li input").attr("name");
        let input1 = $("<input>").attr("type", "text").attr("placeholder", "Choice").attr("name", nameAttr);
        listItem.append(input1);
        $(this).parent().find(".choices").append(listItem);
    });

    $("#addQuestionBtn").click(function (e) {
        e.preventDefault();
        const questionDivs = $("div.questionsToAdd");
        let flag = true;

        questionDivs.each(function (index) {
            if (flag) {
                const currentQuestionDiv = $(this);
                flag = validateForm(currentQuestionDiv, index + 1);
            } else {
                return false;
            }
        });

        if (flag) {
            $("form").submit();
        }
    });

    function validateForm(currentQuestion, index) {
        const questionInput = currentQuestion.find('input[type="text"][placeholder="Enter Question"]');
        const correctAnswerInput = currentQuestion.find('.CorrectAnswer');
        const choicesInputs = currentQuestion.find('.choices-input input[type="text"]');

        if (questionInput.val() == '') {
            showDialog(`Question for q.${index} must be specified`);
            questionInput.css("border-color", "red");
            return false;
        } else if (correctAnswerInput.val() == '') {
            showDialog("Correct Answer must be specified");
            correctAnswerInput.css("border-color", "red");
            return false;
        } else {
            let flag = true;
            let numberOfChoices = 1;
            let choiceValues = new Set();
            choiceValues.add(correctAnswerInput.val());
            choicesInputs.each(function () {
                const choiceValue = $(this).val().trim();

                if (choiceValue === '') {
                    return; // Skip empty choices
                }

                if (choiceValues.has(choiceValue)) {
                    showDialog("Choices must be unique");
                    flag = false;
                } else {
                    console.log(choiceValues);
                    choiceValues.add(choiceValue);
                    numberOfChoices++;
                }
            });

            if (numberOfChoices < 2) {
                showDialog(`For multiple choice we need at least two choices for q.${index}`);
                return false;
            }

            return flag;
        }
    }


    function showDialog(dialogText) {
        $("#dialog").text(dialogText).css("color", "red").dialog();
    }

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('message')) {
        const statusDiv = $('#status');
        if (urlParams.get('message') === 'success') {
            statusDiv.text("Thanks for Adding questions to our Website");
            statusDiv.css('color', 'green');
        } else if (urlParams.get('message') !== '') {
            statusDiv.text(urlParams.get('message'));
            statusDiv.css('color', 'red');
        }
        statusDiv.css('display', 'block');
    }
});







































// $(document).ready(function () {
//     // Event handler for dynamically newly added "Add more choices" buttons using event (on)
//     $("#User-Entered-Questions").on("click", ".addMoreChoices", function () {
//         console.log("Entered here");
//         let listItem = $("<li>").addClass("choices-input");
//         let nameAttr = $(this).parent().find(".choices li input").attr("name");
//         // Create two input elements for choices since two are at least needed
//         let input1 = $("<input>").attr("type", "text").attr("placeholder", "Choice").attr("name", nameAttr);
//         // const input2 = $("<input>").attr("type", "text").attr("placeholder", "Choice").attr("name", nameAttr);
//         console.log("LIST TITEM")
//         listItem.append(input1);//input2
//         console.log(listItem);
//         $(this).parent().find(".choices").append(listItem);
//         listItem = "";
//     });

//     // Event handler for the "Start Adding" button
//     // $("#startAdding").click(function () {
//     //     // Get the number of questions from the input field
//     //     $("#status").css("display", "none");

//     //     // const numberOfQuestions = parseFloat($("#numberOfQuestions").val());

//     //     console.log(numberOfQuestions);

//     //     const parentElement = $("#User-Entered-Questions");
//     //     // if (!isNaN(numberOfQuestions) && numberOfQuestions <= 10 && numberOfQuestions > 0) {
//     //     // Calculate the number of questions to add
//     //     // const questionsToAdd = numberOfQuestions - parentElement.find(".questionsToAdd").length;


//     //     addQuestionLabels(1, 1, parentElement);
//     //     $(".questionsToAdd").slideDown("slow");
//     //     const questionDiv = $("div.questionsToAdd");
//     //     console.log("StartAdding\n");
//     //     console.log(questionDiv);
//     //     $("#addQuestionBtn").css({ "display": "block" });



//     //     // } else {
//     //     // Display an error message and slide up the questions area
//     //     // showDialog("Please enter a valid number between 1-10");
//     //     // }
//     // });

//     // Function to add question labels and input fields
//     //Note-To-Self:
//     /*
//         addQuestionLabel hierarchy
//         explained below to achive the html
//     */
//     // function addQuestionLabels(number, questionNum, parentElement) {

//     //     // for (let i = 0; i < number; i++) {
//     //     // Create a new div with class "questionsToAdd"
//     //     const newDiv = $("<div>").addClass("questionsToAdd");
//     //     const spans = $("<span></span>").addClass("delete-btn").text("\u00d7");
//     //     // Create an input element for the question
//     //     const questionInput = $("<input>").attr("type", "text").attr("placeholder", "Enter Question").attr("required", "required").attr("name", "questionSyntax[]");
//     //     const correctChoice = $("<input>").attr("type", "text").attr("placeholder", "Correct Answer").attr("required", "required").addClass("CorrectAnswer").attr("name", "correctAnswer[]");
//     //     // Create a list for choices
//     //     const choicesList = $("<ul>").addClass("choices");

//     //     // Create a list item for choices input
//     //     const choicesInputItem = $("<li>").addClass("choices-input");

//     //     // Create input elements for choices
//     //     const choiceInput1 = $("<input>").attr("type", "text").attr("placeholder", "Choice").attr("required", "required").attr("name", `choice[]`);
//     //     // const choiceInput2 = $("<input>").attr("type", "text").attr("placeholder", "Choice").attr("name", `choice${(questionNum + i - number)}[]`);//attr("required", "required")

//     //     // Append choices input elements to the list item
//     //     choicesInputItem.append(choiceInput1);//choiceInput2

//     //     // Append the choices list item to the choices list
//     //     choicesList.append(choicesInputItem);

//     //     // Append question input and choices list to the new div
//     //     newDiv.append(questionInput, correctChoice, spans, choicesList);

//     //     // Create a button for adding more choices
//     //     const addMoreButton = $("<button>").addClass("addMoreChoices").attr("type", "button").text("Add more choices");

//     //     // Append the button to the new div
//     //     newDiv.append(addMoreButton);

//     //     // Append the new div to the parent element
//     //     parentElement.append(newDiv);
//     //     // }
//     // }
//     //Activate delete button
//     // $(document).on("click", ".delete-btn", function () {
//     //     $(this).parent().remove();
//     //     const questionDivs = $("div.questionsToAdd");
//     //     if (questionDivs.length === 0) {
//     //         $("#addQuestionBtn").css({ "display": "none" });
//     //     }
//     // });
//     //Add questions
//     $("#addQuestionBtn").click(function (e) {
//         e.preventDefault();
//         const questionDivs = $("div.questionsToAdd");
//         let flag = true;
//         questionDivs.each(function (index, element) {
//             if (flag) {
//                 const currentQuestionDiv = $(this);
//                 flag = validateForm(currentQuestionDiv, index + 1);
//             } else {
//                 return false;
//             }
//             // console.log("Question:", questionInput.val());
//             // console.log("Correct Answer:", correctAnswerInput.val());
//             // choicesInputs.each(function (choiceIndex) {
//             //     console.log(`Choice ${choiceIndex + 1}:`, $(this).val());
//         });
//         console.log(flag)
//         if (flag) {
//             $("form").submit();
//         }
//     });
//     function validateForm(currentQuestion, index) {
//         // Access child elements within the current questionDiv
//         const questionInput = currentQuestion.find('input[type="text"][placeholder="Enter Question"]');
//         const correctAnswerInput = currentQuestion.find('.CorrectAnswer');
//         const choicesInputs = currentQuestion.find('.choices-input input[type="text"]');
//         if (questionInput.val() == '' || questionInput.val() == null) {
//             showDialog(`Question for q.${index} must be specified `);
//             questionInput.css("border-color", "red");
//             return false;
//         } else if (correctAnswerInput.val() == '' || correctAnswerInput.val() == null) {
//             showDialog("Correct Answer must be specified");
//             questionInput.css("border-color", "red");
//             return false;
//         } else {
//             let flag = true;
//             let numberOfChoices = 0;
//             choicesInputs.each(function (choiceIndex) {
//                 if ($(this).val() === correctAnswerInput.val()) {
//                     showDialog("Correct Answer must be unique; no need to re-enter it");
//                     flag = false; // Set the flag to false
//                     // return false;
//                 } else if ($(this).val() !== '' && $(this).val() !== null) {
//                     numberOfChoices += 1;
//                 }
//             });
//             if (numberOfChoices >= 1)
//                 return flag;
//             else {
//                 console.log(`number of choices = ${numberOfChoices}`);
//                 showDialog(`For multiple choice we need at least two choices for q.${index}`);
//                 return false;
//             }
//         }
//     }
//     function showDialog(dialogText) {
//         $("#dialog").text(dialogText).css("color", "red").dialog();
//     }
// });
// //work for status where it checks if user sumbitied questions or not
// $(document).ready(function () {
//     const urlParams = new URLSearchParams(window.location.search);

//     if (urlParams.has('message')) {
//         const statusDiv = $('#status');

//         if (urlParams.get('message') === 'success') {
//             statusDiv.text("Thanks for Adding questions to our Website");
//             statusDiv.css('color', 'green');
//         } else if (urlParams.get('message') !== '') {
//             statusDiv.text(urlParams.get('message'));
//             statusDiv.css('color', 'red');
//         }

//         statusDiv.css('display', 'block');
//     }
// });

