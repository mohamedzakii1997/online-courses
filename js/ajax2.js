var drop =document.getElementById("down"),
    span=document.getElementById("sp"),
    notificNav=document.querySelector('.notificNav'),
    nav=document.getElementById("userid"),
     role=document.getElementById("role");



xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var arr= JSON.parse(this.responseText);
      document.getElementById("mess").innerHTML = arr[0];
      if(arr[1]=="")
        document.getElementById("sp").style.display="none";
      else
      document.getElementById("sp").innerHTML = arr[1];
    }
  };
  xhttp.open("GET", "notify.php?q=message&type="+role.value+"&id="+nav.value, true);
  xhttp.send();

function getmessages(){
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var arr= JSON.parse(this.responseText);
      document.getElementById("mess").innerHTML = arr[0];
 if(arr[1]=="")
        span.style.display="none";
      else
      span.style.display='inline';
      span.innerHTML = arr[1];
    }
  };
  xhttp.open("GET", "notify.php?q=message&type="+role.value+"&id="+nav.value, true);
  xhttp.send();
}
notificNav.onclick=function(){
xhttp = new XMLHttpRequest();
xhttp.open("GET", "notify.php?q=update&type="+role.value+"&id="+nav.value, true);
  xhttp.send();
span.style.display="none";
};




setInterval(getmessages, 5000);




