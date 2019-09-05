


function showtable(str,type) {
  var xhttp;
  if (str.length == 0 || str=="") { 

   // document.getElementById("is").textContent = "555555555555";
     xhttp1 = new XMLHttpRequest();
  xhttp1.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("show").innerHTML = this.responseText;
    }
  };
  xhttp1.open("GET","ajax.php?q=all&type="+type,true);
  xhttp1.send();
    return;
  }

  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("show").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET","ajax.php?q=sp&key="+str+"&type="+type,true);
  xhttp.send();
}

function getclients(flag){

  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("show").innerHTML = this.responseText;
    }
  };  
  xhttp.open("GET","ajax.php?q=verify&flag="+flag,true);
  xhttp.send();
}


//+"&type=course"




