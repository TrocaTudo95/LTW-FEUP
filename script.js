let addToDoForm = document.getElementById("add_todo_form");

let todo_items_ol = document.getElementById("todo_items");

let add_todo_item_button = document.getElementById("add_todo_item_button");

let submit_todo_button = document.getElementById("submit_todo_button");

add_todo_item_button.addEventListener('click',(event)=>{
    event.preventDefault();
    console.log("Button clicked");
    let newListItem = document.createElement("li");
    let newInput = document.createElement("input");
    newInput.setAttribute("type","text");
    newInput.setAttribute("placeholder","add your item");
    newListItem.appendChild(newInput);
    todo_items_ol.appendChild(newListItem);
});

submit_todo_button.addEventListener('click',(event)=>{
    event.preventDefault();
    console.log("submit clicked");
    let list_items = todo_items_ol.children;
    for (let i = 0; i < list_items.length; i++){
        input_item = list_items[i].firstChild;
        console.log("value = " + input_item.value);
    }

})