let addToDoForm = document.getElementById("add_todo_form");

let todo_items_ol = document.getElementById("todo_items");

let add_todo_item_button = document.getElementById("add_todo_item_button");

let submit_todo_button = document.getElementById("submit_todo_button");

let todo_title = document.getElementById("todo_title");

let todo_category = document.getElementById("todo_category");

let todo_color = document.getElementById("todo_color");

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
  }

add_todo_item_button.addEventListener('click',(event)=>{
    event.preventDefault();
    console.log("Button clicked");
    let newListItem = document.createElement("li");
    let newInput = document.createElement("input");
    newInput.setAttribute("type","text");
    newInput.setAttribute("placeholder","add your item");
    newListItem.appendChild(newInput);
    todo_items_ol.appendChild(newListItem);
    if (submit_todo_button.disabled){
        submit_todo_button.disabled = false;
    }
});

submit_todo_button.addEventListener('click',(event)=>{
    event.preventDefault();
    let list_item_values = [];
    let list_items = todo_items_ol.children;
    for (let i = 0; i < list_items.length; i++){
        input_item = list_items[i].firstChild;
        list_item_values.push(input_item.value);
    }
    let get_encoded = encodeForAjax({
        title: todo_title.value,
        category: todo_category.value,
        color:todo_color.value,
        items:list_item_values 
    });
    console.log("GET_ENCODED:" + get_encoded);
    let request = new XMLHttpRequest();
    request.onload = requestListener;
    request.open("get", "action_save_list.php?" + get_encoded ,true);
    request.send();
    console.log("submit clicked");


});

function requestListener () {
    console.log(this.responseText);
}