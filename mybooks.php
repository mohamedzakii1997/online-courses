<?php 
    	spl_autoload_register(function ($class){
   			 require 'classes/'.$class.'.inc';
		});
        session_start();
    if(isset($_COOKIE['clientcookie'])){
    $user=unserialize($_COOKIE['clientcookie']);
     $_SESSION['CLIENT']=$user;

}
        if(isset($_SESSION['CLIENT'])){
$cl=$_SESSION['CLIENT'];
$tt=$cl->showmybooks();
if(isset($error)){
 	echo '<div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                    </button>'.$error.'</div>';
 }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>my courses Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
    </head>
    <body>
      <?php       require 'cnav.php'; ?>
<h2 style="color: #3498db; font-weight: bold;margin-top: 30px;margin-left: 20px"> My Books</h2>

<div class="table-responsive">
	<table class="table table-striped text-center">
	    <thead class="thead-inverse ">
			<tr>
				<th> Name</th>
				<th> Description</th>
				<th> price</th>
				<th> Edition</th>
				<th> Category</th>
				<th>Purchase Date</th>
				
			</tr>
		</thead>
		<tbody>





<?php 
if($tt){
foreach($tt as $obj){
    if($obj['clientid']== $cl->getId()){
    	

 echo "<tr>";
		echo "<td>".$obj['name']."</td>";
		echo "<td>".$obj['description']."</td>";
		echo "<td>".$obj['price']."</td>";
		echo "<td>".$obj['edition']."</td>";
		echo "<td>".$obj['category']."</td>";
		echo "<td>".$obj['purchasedate']."</td>";
    echo "</tr>";
    }
    }
}




		
	?>



	</tbody>		 		
	</table> 	
</div>		
 <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
<?php if (isset($_SESSION['CLIENT']))
        echo '<script  src="js/ajax2.js"></script>'; ?>
    </body>
</html>
<?php }else header('Location: home.php');?> 
