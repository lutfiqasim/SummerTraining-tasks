$(document).ready(function () {

    $("#dataContainer").on("click", ".deletequestion", function () {
        const questionId = parseFloat($(this).parent().siblings('.id').html());

        if (confirm(`Do you want to delete question with id = ${questionId}?`)) {
            $(this).parent().parent().remove();
            deleteQuestion(questionId);
        }
    });

    $("#dataContainer").on("click", ".editQuestion", function () {
        const questionId = parseFloat($(this).parent().siblings('.id').html());
        startSearch("number", questionId);
    });

    $(document).on("click", "#descending", function () {
        $("#dataContainer").empty();
        sortData("SortDescending");
    });

    $(document).on("click", "#ascending", function () {
        $("#dataContainer").empty();
        sortData("SortAscending");
    });

});

function deleteQuestion(questionId) {
    $.ajax({
        url: "Edit-DeleteQuestions.php",
        method: "POST",
        data: {
            action: "delete",
            id: questionId
        },
        success: function (response) {
            showDialog(`Deleted question with id = ${questionId} successfully`);
        },
        error: function (xhr, status, error) {
            console.log("AJAX ERROR: ", error);
        }
    });
}

function startSearch(searchBy, searchId) {
    $.ajax({
        url: "searchForQuestion.php",
        method: "GET",
        data: {
            action: searchBy,
            id: searchId
        },
        success: function (response) {
            $("#dataContainer").html(response);
        },
        error: function (xhr, status, error) {
            console.log("AJAX ERROR: ", error);
        }
    });
}

function sortData(sortAction) {
    $.ajax({
        url: "Edit-DeleteQuestions.php",
        method: "POST",
        data: {
            action: sortAction
        },
        success: function (response) {
            $("#dataContainer").html(response);
        },
        error: function (xhr, status, error) {
            console.log("AJAX ERROR: ", error);
        }
    });
}

function showDialog(dialogText) {
    $("#dialog").css({ "font-size": "16px", "color": "red" }).text(dialogText).dialog();
}


// $(document).ready(function () {

//     $("#dataContainer").on("click", ".deletequestion", function () {

//         const dataId = parseFloat($(this).parent().siblings('.id').html());
//         //Delete button
//         if (confirm(`Do you want to delete question with id = ${dataId}?`) == true) {
//             // console.log(dataId);
//             console.log("Entered if");
//             $(this).parent().parent().remove();
//             $.ajax({
//                 url: "Edit-DeleteQuestions.php",
//                 method: "POST",
//                 data: {
//                     action: "delete",
//                     id: dataId
//                 },
//                 success: function (response) {
//                     showDialog(`Deleted question with id = ${dataId} succesfully`);
//                 }, error: function (xhr, status, error) {
//                     console.log("AJAX ERROR: ", error);
//                 }
//             });
//         } else {
//             return;
//         }
//     });



//     // Edit button
//     $("#dataContainer").on("click", ".editQuestion", function () {
//         //container of the whole table row
//         const container = $(this).parent().parent();
//         const dataId = parseFloat($(this).parent().siblings('.id').html());
//         console.log("ENTered HERE");
//         startSearch("number", dataId);
//     });

//     function startSearch(searchBy, dataSearch) {
//         $.ajax({
//             url: "searchForQuestion.php",
//             method: "GET",
//             data: {
//                 action: searchBy,
//                 id: dataSearch
//             }, success: function (response) {
//                 // console.log(response);
//                 $("#dataContainer").empty();
//                 $("#dataContainer").html(response);
//             }, error: function (xhr, status, error) {
//                 console.log("AJAX ERROR: ", error);
//             }
//         });
//     }

//     //For sorting ascending and descending of data
//     // _________________________________________________
//     $(document).on("click", "#descending", function () {
//         $("#dataContainer").empty();
//         $.ajax({
//             url: "Edit-DeleteQuestions.php",
//             method: "POST",
//             data: {
//                 action: "SortDescending"
//             },
//             success: function (response) {
//                 $("#dataContainer").html(response);
//             }, error: function (xhr, status, error) {
//                 console.log("AJAX ERROR", error);
//             }

//         });
//     });
//     $(document).on("click", "#ascending", function () {
//         $("#dataContainer").empty();
//         showList();
//     });
//     // _________________________________________________
// });
// function showDialog(dialogText) {
//     $("#dialog").css({ "font-size": "16px", "color": "red" }).text(dialogText).dialog();
// }

// function showList(){
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