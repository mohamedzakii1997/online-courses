<?php
spl_autoload_register(function ($class){
    require 'classes/'.$class.'.inc';
});
session_start();
if(isset($_COOKIE['Admincookie'])){
    $user=unserialize($_COOKIE['Admincookie']);
     $_SESSION['ADMIN']=$user;
}
if(isset($_SESSION["ADMIN"])){
  $admin=$_SESSION["ADMIN"];
if(isset($_GET['do'])){
  	if(isset($_GET['id'])&&$_GET['do']=='delete'){	
        $contact=new Contact_Us();
        $contact->setId($_GET['id']);
        $admin->deleteObject($contact);
        $Message='1 Message Deleted';
       }
 }      
$testim=$admin->showObjects('Contact_Us');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contact-Us Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
<?php
require 'nav.php';        
 if (isset($Message)){
            echo' <div class="alert alert-success alert-dismissible fade show " role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                    '.$Message.' 
                 </div>';
        }?> 
    	<div class="table-responsive">
	<table class="table table-striped text-center">
	    <thead class="thead-inverse ">
			<tr>
				<th>Contact-Us ID</th>
        <th>Client ID</th>
				<th>Message</th>
				<th>Control</th>
			</tr>

			</thead>



		<tbody>

<?php
if($testim){
foreach ($testim as $obj) {
	echo "<tr>";
		echo "<td>".$obj->getid()."</td>";
      echo "<td>".$obj->getclientid()."</td>";
		echo "<td>".$obj->getMessage()."</td>";	

	echo "<td><a href='?do=delete&id=".$obj->getid()."' onclick='return confirm(\"Are You Sure You Want To Delete\")' class='btn btn-danger'>Delete</a></td>";
	echo "</tr>";
}
}
?>

</tbody>	

	</table>
</div>		


 		<script  src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
          document.getElementById('client').classList.add('active');
        </script>
    </body>
</html>		
<?php
}else header('Location: login.php');
?>  