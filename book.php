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
if (!(isset($_GET['id'])) || !(is_numeric($_GET['id']))){
	header('location: home.php');
	die();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Book Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
    </head>
    <body>
    	<?php 
    	require 'cnav.php';
    	$book= new Book();
    	$book->setId($_GET['id']);
    	$book=$book->getOne();
		?>
		<div class="container">
			<div class="row">
				<div class="insimgContainer text-center">
	                <img class="imgProfile" src="<?php echo $book->getImg(); ?>" alt="There are No profile Image Available">
	            </div>
	            <div class="courseinfo">
	            	<p class="coursep"><span class="defintion">Book Name:</span> <?php echo $book->getName(); ?></p>
	            	<p class="coursep"><span class="defintion">Author:</span> <?php echo $book->getAuthor();?></p>
	            	<p class="coursep"><span class="defintion">Price:</span> <?php echo $book->getPrice(); ?></p>
                    <p class="coursep"><span class="defintion">Edition:</span> <?php echo $book->getEdition(); ?></p>
                    <p class="coursep"><span class="defintion">Available Books:</span> <?php echo $book->getNumber();?></p>
	            	<span class="courseCategory"><?php echo $book->getCategory();?></span>
	            </div>
        	</div>
        	<h2 class="courseHeader"> Description</h2>
        	<p class="courseDescription"><?php echo $book->getDescription();?></p>
            <hr>
            <?php 
                if(isset($_SESSION['CLIENT'])){
                    $client=$_SESSION['CLIENT'];
        	       echo '<button  class="btn btn-primary registerCourse" data-toggle="modal" data-target="#exampleModal">Buy Now</button>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Payment with <i class="fa fa-cc-paypal" style="color:#3498db ;font-size:30px" aria-hidden="true"></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="payment">
                      <input type="hidden" name="cmd" value="_xclick">
                      <input type="hidden" name="business" value="center@gmail.com">
                      <input type="hidden" name="item_name" value="';  echo $book->getName(); echo'">
                      <input type="hidden" name="amount" value="'; echo $book->getPrice(); echo '">
                      <input type="hidden" name="item_number" value="'; echo $book->getId(); echo'">
                      <input type="hidden" name="notify_url" value="http://localhost/center/check.php?check=book">
                      <input type="hidden" name="return" value="http://localhost/center/cbooks.php">
                        <label>Enter The Number Of Copies</label> <input type="number" name="quantity" value="1">
                      <input type="hidden" name="currency_code" value="USD">
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" value="Pay Now" class="btn btn-primary" form="payment">
                  </div>
                </div>
              </div>
            </div>';
        }
            ?>
		</div>
 		<script  src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
            document.getElementById('booksNav').classList.add('active');
        </script>
        <?php if (isset($_SESSION['INSTRUCTOR'])||isset($_SESSION['CLIENT']))
        echo '<script  src="js/ajax2.js"></script>'; ?>
    </body>
</html>