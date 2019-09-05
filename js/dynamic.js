document.getElementById("getStarted").onclick = function () {
    "user strict";
	window.location.href = "login.php";
};
window.onscroll = function(){
	'user strict';
 if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
        document.getElementById("top").style.display = "block";
    } else {
        document.getElementById("top").style.display = "none";
    }
};
document.getElementById("top").onclick=function(){
	document.body.scrollTop = 0; // For Chrome, Safari and Opera 
    document.documentElement.scrollTop = 0
};