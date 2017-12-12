let next_tasks_section = document.getElementById("next_tasks_display");

onload();

function time_left(dateDue){
  var d = new Date();
  var n = d.getTime()/1000 // time in seconds

  var timeLeft = dateDue - n;
  var days = Math.floor(timeLeft/86400);
  if (days < 0){
    return null;
  }
  if(days == 0){
    return " To dilever today"
  }
  else{
    return  days +" Days";
}
}

function onload(){
  if (next_tasks_section != null){
    let request = new XMLHttpRequest();
    request.onload = processTasks;
    request.open("get", "action_get_user_tasks.php",true);
    request.send();
  }
}
function processTasks(){
  let header = document.createElement("header");
  header.setAttribute("class","next_task_header");
  let title = document.createElement("h2");
  title.setAttribute("class","title_next_tasks");
  title.innerHTML = "Next Deliveries: ";
  header.appendChild(title);
  next_tasks_section.appendChild(header);
  if (this.responseText.length > 0){
  const tasks = JSON.parse(this.responseText);
  let new_tasks= tasks.filter(task =>{
    let timeLeft = time_left(task.dateDue);
    return timeLeft != null;
  })
  new_tasks.forEach(task => {
    let taskDiv = getTaskDiv(task);
    next_tasks_section.appendChild(taskDiv);
  });
  }else{
  console.log("user not logged or no tasks defined");
  }
}

function getTaskDiv(task){
  let taskDiv = document.createElement("div");
  taskDiv.setAttribute("class","tasks");
  taskDiv.setAttribute("id","task"+task.id);
  let infoSpan = document.createElement("span");
  infoSpan.setAttribute("class","information");
  infoSpan.innerHTML = task.information;
  let timeLeft = document.createElement("span");
  timeLeft.setAttribute("class","timeleft");
  timeLeft.innerHTML = time_left(task.dateDue);
  taskDiv.appendChild(infoSpan);
  taskDiv.appendChild(timeLeft);
  return taskDiv;
}
