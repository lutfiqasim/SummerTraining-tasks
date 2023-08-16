const inputBox = document.getElementById("input-box");
const listContainer = document.getElementById("list-container");



function addTask() {
    if (inputBox.value === '') {
        alert("You must write something!");
    }
    else {
        let li = document.createElement("li");
        li.innerHTML = inputBox.value;
        listContainer.appendChild(li);
        let span = document.createElement("span");
        span.innerHTML = "\u00d7";//cross icon
        li.appendChild(span);
    }
    inputBox.value = "";
    saveData()
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
    saveData()
}, false);


function saveData() {
    //Whatever is contained in list container will be stored in our local 
    //Storage of the browser
    //By key data 
    localStorage.setItem("data", listContainer.innerHTML);
}

function showTasks() {
    listContainer.innerHTML = localStorage.getItem("data");
}

showTasks();
