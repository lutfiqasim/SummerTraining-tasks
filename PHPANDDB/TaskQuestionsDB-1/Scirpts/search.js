$(document).ready(function () {

    $("input[type='radio']").click(function () {
        const radioId = $(this).attr("id");
        if (radioId === "searchByQID") {//Show id bar to search for question
            updateSearchMethod("Search By id");
        } else {//Show show text field for question
            updateSearchMethod("Search by name");
        }
    });

    function updateSearchMethod(searchMethod) {
        $("#searchLabel").text(searchMethod);
        $("#searchQuestionToEdit-div").slideDown("slow");
        $("#EditQuestion-div").empty().css("display", "none");
        if (searchMethod === "Search By id") {
            $("#searchBar").attr("type", "number");
        } else {
            $("#searchBar").attr("type", "text");
        }
    }

    $("#startSearch").click(function (event) {
        event.preventDefault();
        const dataSearch = $("#searchBar").val().trim();
        const searchBy = $("#searchBar").attr("type");
        $("#EditQuestion-div").empty().css("display", "block");
        startSearch(searchBy, dataSearch);
    });


    //Edit button
    $("#dataContainer").on("click", ".editQuestion", function () {
        //container of the whole table row
        const container = $(this).parent().parent();
        const dataId = parseFloat($(this).parent().siblings('.id'.html()));
        console.log("ENTered HERE");
        startSearch("number", dataId);
    });

    function startSearch(searchBy, dataSearch) {
        $.ajax({
            url: "searchForQuestion.php",
            method: "GET",
            data: {
                action: searchBy,
                id: dataSearch
            }, success: function (response) {
                // console.log(response);
                $("#EditQuestion-div").empty();
                $("#EditQuestion-div").html(response);
            }, error: function (xhr, status, error) {
                console.log("AJAX ERROR: ", error);
            }
        });
    }
});