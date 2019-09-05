<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Instructors Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
    </head>
    <body>
    	<?php 
    	spl_autoload_register(function ($class){
   			 require 'classes/'.$class.'.inc';
		});
        session_start();
if(isset($_COOKIE['clientcookie'])){
    $user=unserialize($_COOKIE['clientcookie']);
     $_SESSION['CLIENT']=$user;

}
 elseif(isset($_COOKIE['SUPERVISORcookie'])){
    $user=unserialize($_COOKIE['SUPERVISORcookie']);
     $_SESSION['SUPERVISOR']=$user;

}
 elseif(isset($_COOKIE['INSTRUCTORcookie'])){
    $user=unserialize($_COOKIE['INSTRUCTORcookie']);
     $_SESSION['INSTRUCTOR']=$user;

}
 elseif(isset($_COOKIE['Admincookie'])){
    $user=unserialize($_COOKIE['Admincookie']);
     $_SESSION['ADMIN']=$user;

}
    	require 'cnav.php';
        $instructors= Instructor::showAll();
         ?>
    	<section class="home-courses">
    		<div class="container section">
              <h2>Our Instructors</h2>
                <div class="row justify-content-around">
                	<?php
                    if($instructors){
                		foreach ($instructors as  $instructor) {
                			echo '<div class="card" style="width: 20rem;">
				                  <div class="slide-overlay" data-id='.$instructor->getId().'>View details</div>
				                    <img class="card-img-top insCardImg" src="'.$instructor->getProfileImage().'" alt="Card image cap">
				                    <div class="card-body">
				                      <h3 class="card-text">'.$instructor->getName().'</h3>
				                      <p>Career: '.$instructor->getCarrer().'</p>
                                      <p>Rate: '.$instructor->getRate().'/10</p>
				                    </div>
				                </div>';
	                 	}
                     }
                	?>
            	</div>
            </div>
        </section>
 		<script  src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
        	var overlays= document.querySelectorAll('.card .slide-overlay');
        	for (var i=0 ; i<overlays.length ; i++){
        		overlays[i].onclick=function(){
        			location.href='instructor.php?id='+this.getAttribute('data-id');
        		};
        	}
            document.getElementById('instructorsNav').classList.add('active');
        </script>
    <?php if (isset($_SESSION['INSTRUCTOR'])||isset($_SESSION['CLIENT']))
        echo '<script  src="js/ajax2.js"></script>'; ?>
    </body>
</html>
