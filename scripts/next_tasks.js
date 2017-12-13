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
    return "< 24h"
  }
  else if (days == 1){
    return  days +" Day";
  }else {
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

function ordertasks(taskA,taskB){
  return taskA.dateDue - taskB.dateDue;
}
function processTasks(){
  let header = document.createElement("header");
  header.setAttribute("class","next_task_header");
  let title = document.createElement("h2");
  title.setAttribute("class","title_next_tasks");
  title.innerHTML = "Next Deliveries: ";
  header.appendChild(title);
  next_tasks_section.appendChild(header);
  let alltasks = [];
  if (this.responseText.length > 0){
    const projects = JSON.parse(this.responseText);
    projects.forEach(project =>{
      project.forEach(task =>{
        alltasks.push(task);
      });
    });
    alltasks.sort(ordertasks);
    alltasks.forEach(task => {
      let taskDiv = getTaskDiv(task);
      if (task.isChecked == "1" || time_left(task.dateDue) == null){
        taskDiv.style.display = "none";
      }
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
