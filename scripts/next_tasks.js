
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
