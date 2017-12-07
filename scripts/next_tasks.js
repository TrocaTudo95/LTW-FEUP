let next_tasks_section = document.getElementById("next_tasks_display");

onload();

function time_left(dateDue){
  var d = new Date();
  var n = d.getTime()/1000 // time in seconds

  var timeLeft = dateDue - n;
  var days = Math.floor(timeLeft/86400);
  var hours = Math.floor((timeLeft%86400)/3600);

  if(days == 0){
    return "...In "+ hours +" Hours.";
  }else
  {
    return "...In "+ days +" Days and "+ hours + " Hours."
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
  if (this.responseText.length > 0){
  const tasks = JSON.parse(this.responseText);
  tasks.forEach(task => {
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
  infoSpan.innerHTML = task.information;
  let timeLeft = document.createElement("span");
  timeLeft.setAttribute("class","timeleft");
  timeLeft.innerHTML = time_left(task.dateDue);
  taskDiv.appendChild(infoSpan);
  taskDiv.appendChild(timeLeft);
  return taskDiv;
}
