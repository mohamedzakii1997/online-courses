var l1=document.getElementById('star1'),
l2=document.getElementById('star2'),
l3=document.getElementById('star3'),
l4=document.getElementById('star4'),
l5=document.getElementById('star5'),
link=document.getElementById('rate'),
val,
client=document.getElementById('c_id'),
ins=document.getElementById('ins')
;
l1.onclick=function(){
val=document.getElementById('star-1').value;
};

l2.onclick=function(){
    val=document.getElementById('star-2').value;
    };

    
l3.onclick=function(){
    val=document.getElementById('star-3').value;
    };

    
l4.onclick=function(){
    val=document.getElementById('star-4').value;
    };

    
l5.onclick=function(){
    val=document.getElementById('star-5').value;
    };

    
link.onclick=function(){
    xhttp = new XMLHttpRequest();      
    xhttp.open("GET", "notify.php?action=rate&id="+ins.value+"&rate="+val+"&c_id="+client.value, true);
    xhttp.send();
    alert('you rate your intructor thank you for participation');
    };