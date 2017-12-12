let addToDoForm = document.getElementById("add_todo_form");

let todo_items_ol = document.getElementById("todo_items");

let add_todo_item_button = document.getElementById("add_todo_item_button");

let submit_todo_button = document.getElementById("submit_todo_button");

let todo_title = document.getElementById("todo_title");

let todo_category = document.getElementById("todo_category");

let todo_color = document.getElementById("todo_color");

let item_counter = 0;

let projectsSection = document.querySelector('section#projects');

let newProjectForm;

let newTaskDiv;

let currentDisplayingProject = null;

if (projectsSection != null){
    updateProjects();
}

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
    console.log("click");
    if (newProjectForm == null){
        newProjectForm = getNewProjectForm();
        projectsSection.appendChild(newProjectForm);
    }
    newProjectForm.style.display = "block";
}

function getNewProjectForm(){
    let wrapper = document.createElement("section");
    let content = document.createElement("div");
    let header = document.createElement("header");
    let header_title = document.createElement("h2");
    let form = document.createElement("form");
    let title_description = document.createElement("p");
    let title_input = document.createElement("input");
    let category_description = document.createElement("p");
    let category_input = document.createElement("input");
    let submit_button = document.createElement("input");
    header_title.innerHTML = "Create Project";
    form.setAttribute("method","get");
    form.setAttribute("class","flex-column");
    title_description.innerHTML = "Project title";
    title_input.setAttribute("placeholder","Enter a project title");
    title_input.setAttribute("id","new-project-title");
    category_description.innerHTML = "Project category";
    category_input.setAttribute("placeholder","Enter a project category");
    category_input.setAttribute("id","new-project-category");
    submit_button.setAttribute("type","submit");
    submit_button.onclick = function(event){
        let value = createNewProject(event);
        if (value == -1){
            alert("Wrong Inputs");
        }else{
            wrapper.style.display = "none";
            title_input.value = "";
            category_input.value = "";
        }

    }
    content.setAttribute("class","modal-content");
    wrapper.setAttribute("class","modal");
    form.appendChild(title_description);
    form.appendChild(title_input);
    form.appendChild(category_description);
    form.appendChild(category_input);
    form.appendChild(submit_button);
    header.appendChild(header_title);
    content.appendChild(header);
    content.appendChild(form);
    wrapper.appendChild(content);
    return wrapper;
}


function createNewProject(event){
    event.preventDefault();
    let newTitle = document.getElementById("new-project-title").value;
    let newCategory = document.getElementById("new-project-category").value;
    if (newTitle.length == 0 || newTitle.length > 140 || newCategory.length == 0 || newCategory.length > 140){
        return -1;
    }
    let queryString = "/?project_title=" + newTitle + "&project_category=" + newCategory;
    let request = new XMLHttpRequest();
    request.onload = handleProjectCreated;
    request.open("get", "action_create_new_project.php" + queryString,true);
    request.send();
}

function handleProjectCreated(){
    updateProjects();
}

function exist_task_in_project(project,search_value){
    for (let i=0; i< project.tasks.length;i++){
      let task=project.tasks[i].information;
      if(task.toLowerCase().startsWith(search_value.toLowerCase()))
          return true;
    }
    return false
}

function onProjectsLoaded(){
    if (this.responseText != null && this.responseText.length > 0){
        let search_bar_value = document.getElementById("searchfield").value;
        let filter = document.getElementById('filter');
        let filter_value= filter.options[filter.selectedIndex].text;
        let projects= JSON.parse(this.responseText);
        console.log("projects loaded");
        let projects_parsed;
        if (search_bar_value.length > 0){
            if(filter_value == "Name"){
                projects_parsed = projects.filter(project =>{
                    return project.name.toLowerCase().indexOf(search_bar_value.toLowerCase()) >= 0;
                });
            }
            else if (filter_value == "Category"){
                projects_parsed = projects.filter(project =>{
                    return project.category.toLowerCase().indexOf(search_bar_value.toLowerCase()) >= 0
                });
            }
              else if (filter_value == "Task"){
                projects_parsed = projects.filter(project =>{
                    return exist_task_in_project(project,search_bar_value)
                });
              }
        }
        projects_parsed = projects_parsed || projects;
        clearProjectsDisplay();
        createProjectsPreview(projects_parsed);
        if (newProjectForm == null){
            newProjectForm = getNewProjectForm();
        }
        projectsSection.appendChild(newProjectForm);
    }
}

function clearProjectsDisplay(){
  while(projectsSection.hasChildNodes()){
    projectsSection.removeChild(projectsSection.lastChild);
  }
}

function updateProjects(){
    let request = new XMLHttpRequest();
    request.onload = onProjectsLoaded;
    request.open("get", "action_get_user_projects.php",true);
    request.send();
}

function displayCurrentProject(){
    let project = currentDisplayingProject;
    let modal= document.createElement("div");
    modal.setAttribute("id","modal"+project.id);
    modal.setAttribute("class","modal");
    let modal_content =document.createElement("div");
    modal_content.setAttribute("class","modal-content");
    let header = document.createElement("header");
    header.setAttribute("id","project");
    let deleteProjectSymbol = getDeleteSymbol();
    deleteProjectSymbol.addEventListener('click',function(event){
        event.stopPropagation();
        deleteProject(project.id);
    })
    let close = document.createElement("span");
    close.setAttribute("class","close");
    close.innerHTML="&times;";
    close.onclick=function() {
        modal.parentNode.removeChild(modal);
        updateProjects();
    }
    let project_title =document.createElement("span");
    project_title.setAttribute("class","project_title");
    project_title.innerHTML=project.name;
    let num_tasks = document.createElement("span");
    num_tasks.setAttribute("class","num_tasks");
    num_tasks.innerHTML= project.tasks.length;
    let project_category = document.createElement("p");
    project_category.setAttribute("class","project_category");
    project_category.innerHTML= project.category;
    let tasks_section = document.createElement("section");
    tasks_section.setAttribute("class","tasks round_corners");
    let tasks = project.tasks;
    console.log(project);
    for (let i = 0; i < tasks.length; i++){
        let task = tasks[i];
        let timestampMiliseconds = parseInt(task.dateDue) * 1000;
        let date= new Date(timestampMiliseconds);
        let day=date.getDate();
        let month= date.getMonth() + 1;
        let year= date.getFullYear();
        let task_div = document.createElement("div");
        task_div.setAttribute("class","task_div_lay");
        let task_info = document.createElement("textarea");
        task_info.value = task.information;
        let task_date =document.createElement("input");
        task_date.setAttribute("class","date");
        task_date.setAttribute("type","date");
        task_date.value = year+"-"+month+"-"+day;
        let task_priority = document.createElement("input");
        task_priority.setAttribute("class","priority");
        task_priority.setAttribute("type","number");
        task_priority.setAttribute("min",0);
        task_priority.setAttribute("max",1000);
        task_priority.value = task.priority;
        let checkbox = document.createElement("input");
        checkbox.setAttribute("class","checkbox");
        checkbox.setAttribute("type","checkbox");
        if (task.isChecked == "1"){
            checkbox.checked = true;
            task_info.className = "task-item line-through";
        }else{
            checkbox.checked = false;
            task_info.className = "task-item noDecoration";
        }
        checkbox.onclick = function(event){
            handleCheckboxClick(event,task.id);
            if (task_info.classList[1] == "noDecoration"){
                task_info.className = "task-item line-through";
            }else{
                task_info.className = "task-item noDecoration";
            }
        }
        let deleteTaskSymbol = getDeleteSymbol();
        deleteTaskSymbol.addEventListener('click',event =>{
            event.stopPropagation();
            deleteTask(task.id);
            tasks_section.removeChild(task_div);
            tasks.splice(i,1);
        })
        task_div.appendChild(checkbox);
        task_div.appendChild(task_info);
        task_div.appendChild(task_date);
        task_div.appendChild(task_priority);
        task_div.appendChild(deleteTaskSymbol);
        tasks_section.appendChild(task_div);
    }
    let button = document.createElement("i");
    button.setAttribute("class","fa fa-plus");
    button.setAttribute("aria-hidden","true");
    button.onclick = function(){
        addTask(header,project.id);
    }
    projectsSection.appendChild(modal);
    modal.style.display = "block";
    modal.appendChild(modal_content);
    header.appendChild(project_title);
    header.appendChild(num_tasks);
    header.appendChild(project_category);
    header.appendChild(deleteProjectSymbol);
    header.appendChild(close);
    header.appendChild(button);
    modal_content.appendChild(header);
    modal_content.appendChild(tasks_section);
}

function getDeleteSymbol(){
    let deleteSymbol = document.createElement("i");
    deleteSymbol.className = "fa fa-minus";
    deleteSymbol.setAttribute("aria-hidden","true");
    deleteSymbol.style.zIndex = 1;
    deleteSymbol.style.cssFloat = "right";
    deleteSymbol.style.padding = " 10px";
    return deleteSymbol;
}

function deleteProject(projectid){
    let request = new XMLHttpRequest();
    request.onload = function(){
        if (this.responseText == "0"){
            updateProjects();
        }else{
            alert("You do not own the project");
        }
    }
    request.open("get","action_delete_project.php/?projectid="+projectid,true);
    request.send();
}

function deleteTask(taskid){
    let request = new XMLHttpRequest();
    request.onload = function(){
        if (this.responseText != "0"){
            alert(this.responseText);
        }
    }
    request.open("get","action_delete_task.php/?taskid="+taskid,true);
    request.send();
}

function createProjectsPreview(projects){
    projects.forEach(project => {
        let article = document.createElement("article");
        article.setAttribute("class","projects round_corners");
        article.setAttribute("id",project.id);
        article.onclick = function(event){
            currentDisplayingProject = project;
            displayCurrentProject();
        };
        let deleteSymbol = getDeleteSymbol();
        deleteSymbol.addEventListener("click",event =>{
            event.stopPropagation();
            deleteProject(project.id);
        })
        let header = document.createElement("header");
        header.setAttribute("id","project");
        let project_title =document.createElement("span");
        project_title.setAttribute("class","project_title");
        project_title.innerHTML=project.name;
        let num_tasks = document.createElement("span");
        num_tasks.setAttribute("class","num_tasks");
        num_tasks.innerHTML= project.tasks.length;
        let project_category = document.createElement("p");
        project_category.setAttribute("class","project_category");
        project_category.innerHTML= project.category;
        let tasks_section = document.createElement("section");
        tasks_section.setAttribute("class","tasks round_corners");
        let tasks = project.tasks;
        tasks.forEach(task =>{
            let task_div = document.createElement("div");
            task_div.setAttribute("class","task");
            let task_info = document.createElement("span");
            task_info.innerHTML = task.information;
            if (task.isChecked == "1"){
                task_info.setAttribute("class","line-through");
            }else{
                task_info.setAttribute("class","noDecoration");
            }
            task_div.appendChild(task_info);
            tasks_section.appendChild(task_div);
        });
        header.appendChild(deleteSymbol);
        header.appendChild(project_title);
        header.appendChild(num_tasks);
        header.appendChild(project_category);
        article.appendChild(header);
        article.appendChild(tasks_section);

        projectsSection.appendChild(article);
    });
}

function reloadCurrentProject(){
    if (this.responseText != null){
        console.log(this.responseText);
        let new_task = JSON.parse(this.responseText);
        if (new_task != null){
            let modalDiv = document.getElementById("modal"+currentDisplayingProject.id);
            modalDiv.parentNode.removeChild(modalDiv);
            currentDisplayingProject.tasks.push(new_task);
            displayCurrentProject();
        }
    }
}

function projectAddTask(projectID,information,priority,date){
  let request = new XMLHttpRequest();
  let queryObject = {
      projectId: projectID,
      information: information,
      priority: priority,
      date: date
  };
  request.onload = reloadCurrentProject;
  request.open("get", "action_add_task.php/?" + encodeForAjax(queryObject) ,true);
  request.send();

}

function createOptions(options){
  let returnArray = [];
  options.forEach(value =>{
    let optionHTML = document.createElement('option');
    optionHTML.setAttribute('value',value);
    returnArray.push(optionHTML);

  });

  return returnArray;

}

function createTaskWindow(projectID){
  let wrapperDiv = document.createElement('div');
  let addForm = document.createElement("form");
  let inputInformation = document.createElement('textarea');
  let inputPriority = document.createElement('input');
  inputPriority.setAttribute('type','range');
  inputPriority.setAttribute('list','tickmarks');
  let tickmarks = document.createElement('datalist');
  tickmarks.id = "tickmarks";
  let arrayValues = [1,2,3,4];
  let options = createOptions(arrayValues);
  options.forEach(option => {
    tickmarks.appendChild(option);
  });
  options[0].setAttribute('label','low');
  options[1].setAttribute('label','high');
  let inputDate = document.createElement('input');
  inputDate.setAttribute('type','date');
  addForm.appendChild(inputInformation);
  addForm.appendChild(inputPriority);
  addForm.appendChild(tickmarks);
  addForm.appendChild(inputDate);
  let submit = document.createElement('input');
  submit.setAttribute('type','submit');
  submit.addEventListener('click', event =>{
    let information = inputInformation.value;
    let priority = inputPriority.value;
    let date = inputDate.value;
    projectAddTask(projectID,information,priority,date);
    addForm.reset();
  })
  let cancel = document.createElement('input');
  cancel.setAttribute('type','button');
  cancel.setAttribute('value','Cancel');
  cancel.onclick = function(){
    newTaskDiv.style.display="none";
  }
  wrapperDiv.appendChild(addForm);
  wrapperDiv.appendChild(submit);
  wrapperDiv.appendChild(cancel);
  return wrapperDiv;

}

function addTask(header,projectID){
    console.log("addtask clicked");
  if(newTaskDiv == null){
    newTaskDiv = createTaskWindow(projectID);
  }
  header.appendChild(newTaskDiv);
  newTaskDiv.style.display = "block";

}


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target.className == "modal") {
        event.target.parentNode.removeChild(event.target);
        updateProjects();
    }
}

function handleCheckboxClick(event,taskid){
    let request = new XMLHttpRequest();
    let queryString = "/?taskid="+taskid;
    request.onload = requestListener;
    request.open("get", "action_check_task.php"+queryString,true);
    request.send();
    let next_deliveries_task = document.getElementById("task"+taskid);
    if (next_deliveries_task.style.display == "none"){
        next_deliveries_task.style.display = "block";
    }else{
        next_deliveries_task.style.display = "none";
    }
}
