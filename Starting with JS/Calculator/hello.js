const listContainer = document.getElementById("list-container");
function calculateValue(value) {
    value = String(value);
    if (value.length === 0) {
        alert("Enter an expression first");
        return "";
    }

    const stack = [];
    const myArr = value.split(" ");
    let answer = myArr[0];

    for (let i = 0; i < myArr.length; i++) {
        if (isNumber(myArr[i].trim())) {
            stack.push(myArr[i].trim());
        }
    }
    let evaluated = false;
    for (let i = 0; i < myArr.length; i++) {
        if (!isNumber(myArr[i].trim())) {
            answer = evaluate(myArr[i]);
            evaluated = true;
        }
    }
    // return evaluate();
    answer = String(answer);

    if (isNumber(answer)) {
        if (evaluated)
            previousCalc(value, answer);
        return answer;
    }
    else if (answer === "Cannot divide by zero") {
        alert(answer);
        return "Cannot divide by zero";
    } else {

        alert("Answer not a number check expression and try again\nExample of valid expression: 8 * 8");
        return "";
    }

    function evaluate(operation) {
        let ans = 0;
        const x = parseFloat(stack.pop());
        const y = parseFloat(stack.pop());

        switch (operation) {
            case '+':
                ans = y + x;
                break;
            case '-':
                ans = y - x;
                break;
            case '*':
                ans = y * x;
                break;
            case '/':
                if (x !== 0) {
                    ans = y / x;
                } else {
                    return "Cannot divide by zero";
                }
                break;
            default:
                break;
        }

        stack.push(ans);
        return parseFloat(stack[0]);
    }
}

function isNumber(value) {
    if (typeof value === "string") {
        return !isNaN(value);
    }
}

function previousCalc(value, answer) {

    addTask(value + "=" + answer);


    function addTask(task) {
        const li = document.createElement("li");
        li.innerHTML = task;
        listContainer.appendChild(li);
        const span = document.createElement("span");
        span.innerHTML = "\u00d7"; //cross icon
        li.appendChild(span);
        saveData();
    }


    function saveData() {
        //Whatever is contained in list container will be stored in our local 
        //Storage of the browser
        //By key data 
        localStorage.setItem("data", listContainer.innerHTML);
    }

}


function showTasks() {
    console.log("LOADED DATA");
    listContainer.innerHTML = localStorage.getItem("data");
}

function clearAllCalculations() {
    listContainer.innerHTML = '';
}

listContainer.addEventListener("click", function (e) {
    //if clicked on list item mark it as checked o
    //if already checked remove the check
    if (e.target.tagName === "LI") {
        e.target.classList.toggle("checked");
        //Move item to end of list
        // let newItem = e.target;
        // listContainer.removeChild(e.target);
        // listContainer.appendChild(newItem);
    }
    //if its a span delete it
    else if (e.target.tagName === "SPAN") {
        e.target.parentElement.remove();
    }
    localStorage.setItem("data", listContainer.innerHTML);
}, false);


window.onload = showTasks();