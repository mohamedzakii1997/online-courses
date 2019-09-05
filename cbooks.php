<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Books Page</title>
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
        $books= Book::showAll();
         ?>
    	<section class="home-courses">
    		<div class="container section">
              <h2>Books On Sale</h2>
                <?php if($books){ ?>
              <ul class="coursesLists">
                  <li class="active">All</li>
                  <?php 
                    foreach ($books as $book) {
                        echo " <li>".$book->getCategory()."</li>";
                    }
                  ?>
              </ul>
              <?php } ?>
                <div class="row justify-content-around">
                	<?php
                    if($books){
                		foreach ($books as  $book) {
                			echo '<div class="card" style="width: 20rem;" data-category="'.$book->getcategory().'">
				                  <div class="slide-overlay" data-id='.$book->getId().'>View details</div>
				                    <img class="card-img-top insCardImg" src="'.$book->getImg().'" alt="Card image cap">
				                    <div class="card-body">
				                      <h3 class="card-text">'.$book->getName().'</h3>
				                      <p>Author: '.$book->getAuthor().'</p>
                                      <p>Edition: '.$book->getEdition().'</p>
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
        			location.href='book.php?id='+this.getAttribute('data-id');
        		};
        	}
            var categories= document.querySelectorAll('.coursesLists li'),
                cards= document.querySelectorAll('.card');
                for(var i=0 ; i<categories.length;i++){
                    categories[i].onclick=function(){
                        document.querySelector('.coursesLists li.active').classList.remove('active');
                        this.classList.add('active');
                        for(var k=0; k<cards.length;k++){
                            if(this.textContent=='All') cards[k].style.display='block';
                           else if(cards[k].getAttribute('data-category')==this.textContent)
                                cards[k].style.display='block';
                            else cards[k].style.display='none';
                        }
                    };
                }
                document.getElementById('booksNav').classList.add('active');
        </script>
        <?php if (isset($_SESSION['INSTRUCTOR'])||isset($_SESSION['CLIENT']))
        echo '<script  src="js/ajax2.js"></script>'; ?>
    </body>
</html>
