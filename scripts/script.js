let addToDoForm = document.getElementById("add_todo_form");

let todo_items_ol = document.getElementById("todo_items");

let add_todo_item_button = document.getElementById("add_todo_item_button");

let submit_todo_button = document.getElementById("submit_todo_button");

let todo_title = document.getElementById("todo_title");

let todo_category = document.getElementById("todo_category");

let todo_color = document.getElementById("todo_color");

let item_counter = 0;

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
  }

if (add_todo_item_button != null){
    add_todo_item_button.addEventListener('click',(event)=>{
        event.preventDefault();
        console.log("Button clicked");
        let newListItem = document.createElement("li");
        let newTextInput = document.createElement("input");
        let dateDueInput = document.createElement("input");
        let priorityInput = document.createElement("input");
        newTextInput.setAttribute("type","text");
        newTextInput.setAttribute("placeholder","add your item");
        newTextInput.style.backgroundColor = "rgb(0,255,0)";
        dateDueInput.setAttribute("type","date");
        priorityInput.setAttribute("type","number");
        priorityInput.setAttribute("min","1");
        priorityInput.setAttribute("max","10");
        priorityInput.setAttribute("step","1");
        priorityInput.setAttribute("value","1");
        priorityInput.addEventListener('input',event => {
            console.log("priority changed");
            newTextInput.style.backgroundColor = getRGBForPriority(priorityInput.value);
        });
    
        newListItem.appendChild(newTextInput);
        newListItem.appendChild(dateDueInput);
        newListItem.appendChild(priorityInput);
        todo_items_ol.appendChild(newListItem);
    
        submit_todo_button.disabled = false;
        item_counter++;
    });
}



if (submit_todo_button != null){
    submit_todo_button.addEventListener('click',(event)=>{
        event.preventDefault();
        let list_item_values = [];
        let list_items = todo_items_ol.children;
        for (let i = 0; i < list_items.length; i++){
            let inputs = list_items[i].children;
            list_item_values.push({
                text:inputs[0].value,
                datedue:inputs[1].value,
                priority:inputs[2].value
            });
        }
        let get_encoded = encodeForAjax({
            title: todo_title.value,
            category: todo_category.value,
            color:todo_color.value,
            items:JSON.stringify(list_item_values)
        });
        console.log("GET_ENCODED:" + get_encoded);
        let request = new XMLHttpRequest();
        request.onload = requestListener;
        request.open("get", "action_save_list.php?" + get_encoded ,true);
        request.send();
        console.log("submit clicked");
    
    
    });
}


function requestListener () {
    console.log(this.responseText);
}

function getRGBForPriority(priority){
    let priorityInt = parseInt(priority);
    let gComponent, rComponent;
    if (priorityInt < 6){
        gComponent = 255;
        rComponent = Math.floor((priorityInt - 1)/4 * 255);
    }else{
        rComponent = 255;
        gComponent = Math.floor((priorityInt -6)/4 * (-204) + 204);
    }
    return "rgb(" + rComponent + "," + gComponent + ",0)";
}

function new_project_click(){
    console.log("new project clicked");
}