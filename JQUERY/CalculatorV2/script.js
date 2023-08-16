$(document).ready(function () {

    $("#equalBtn").click(function () {
        value = String($("input[name='display']").val());
        if (value.length === 0) {
            console.log("HERE");
            showDialog("Enter an expression first");
        } else {

            const myArr = value.split(/\s+/);
            console.log(myArr);
            if (myArr.length !== 3) {
                showDialog("expression not valid need to be x operator y");
                $("input[name='display']").val("");
                return;

            } else {

                let answer = evaluateValue(myArr);
                $("input[name='display']").val(String(answer));
                if (answer === "Can't divide by zero") {
                    showDialog(answer);
                    return "";
                }
                console.log("answer");
                console.log(typeof (answer));
                if (isNaN(answer)) {
                    showDialog("Answer Not a Number check expression and try again");
                    return "";
                }
                addTask(value + " = " + answer);

            }
        }
    });

    $("#slide").click(function () {
        if($("#list-container").is(":hidden")){
            $("#list-container").slideDown("slow");
            $("#slide").text("Hide Equations");
        }else{
            $("#list-container").slideUp("slow");
            $("#slide").text("Show equations");
        }
        // $("#list-container").slideToggle("slow");
    });
    function evaluateValue(expression) {
        let x = parseFloat(expression[0].trim());
        let operator = String(expression[1].trim());
        let y = parseFloat(expression[2].trim());
        console.log(`x= ${x}` + `y=${y}`);
        if (y === 0) {
            return "Can't divide by zero";
        }
        let ans;
        switch (operator) {
            case '+':
                ans = y + x;
                break;
            case '-':
                ans = x - y;
                break;
            case '*':
                ans = y * x;
                break;
            case '/':
                if (x !== 0) {
                    ans = x / y;
                } else {
                    return "Cannot divide by zero";
                }
                break;
            default:
                break;
        }
        return ans;
    }


    function addTask(task) {
        // const li = document.createElement("li");
        // li.innerHTML = task;
        console.log(task);
        const listItem = $("<li></li>").text(String(task));
        const spans = $("<span></span>").addClass("delete-btn");
        spans.text("\u00d7");
        listItem.append(spans);
        $("#list-container").append(listItem);
        // listContainer.appendChild(li);
        // const span = document.createElement("span");
        // span.innerHTML = "\u00d7"; //cross icon
        saveData();

    }

});

//Delete previous calculation on span click
$(document).ready(function () {
    $("#list-container").on("click", ".delete-btn", function () {
        $(this).parent().remove(); // Remove the parent <li> element when the span is clicked
        saveData();
    });
});

function showDialog(dialogText) {
    $("#dialog").css({ "font-size": "16px", "color": "red" }).text(dialogText).dialog();
}
function clearAllCalculations() {
    $("#list-container").empty();
    saveData();
}

function showTasks() {
    console.log("LOADED DATA");
    // console.log(localStorage.getItem("data"));
    if (localStorage.getItem("data") !== "") {
        $("#list-container").append(localStorage.getItem("data"));
    }
    // listContainer.innerHTML = localStorage.getItem("data");
}
function saveData() {
    //Whatever is contained in list container will be stored in our local 
    //Storage of the browser
    //By key data 
    console.log("SAVING DATA");
    console.log($("#list-container").val);
    localStorage.setItem("data", $("#list-container").html());
}


window.onload = showTasks();