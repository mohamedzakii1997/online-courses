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
        $branch= new Branch();
        $branch->setbranchid($_GET['id']);	
        $admin->deleteObject($branch);
        $Message='1 Branch Deleted';
       }elseif ($_GET['do']=='edited') $Message='1 Branch Edited';
       elseif ($_GET['do']=='added') $Message='1 Branch Added';
}
$branches=$admin->showObjects('Branch');

?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Branchs Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
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


<div class="row rowsearch">
<div class="input-group-btn col-lg-4">
  <input  type="text" name="search" placeholder="Search" class="form-control searchinput" onkeyup="showtable(this.value,'branch')">
<button class="btn btn-default" type="submit" style="background-color:  #d9d9d9
;"><i class="fa fa-search" aria-hidden="true" style="color: #f2f2f2";></i>
</button>
</div>
</div>
    	<div class="table-responsive" id="show">
	<table class="table table-striped text-center">
	    <thead class="thead-inverse ">
			<tr>
				<th>Location</th>
				<th>Description</th>
				<th>Phone</th>
				<th>Options</th>
			</tr>
			</thead>

		<tbody>

<?php
if($branches){
foreach ($branches as $obj) {
	echo "<tr>";
	echo "<td>".$obj->getlocation()."</td>";
		echo "<td>".$obj->getdescription()."</td>";
		echo "<td>".$obj->getphone()."</td>";
	echo "<td><a href='addeditbranch.php?do=edit&id=".$obj->getbranchid()."' class='btn btn-primary'><i class='fa fa-wrench' aria-hidden='true'></i> Edit</a> ";	
	echo "<a href='?do=delete&id=".$obj->getbranchid()."' onclick='return confirm(\"Are You Sure You Want To Delete\")' class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>";
	echo "</tr>";
}
}
 ?>



	</tbody>		 		
	</table>
</div>		

<a href='addeditbranch.php?do=add' class="btn btn-primary addnew"><i class="fa fa-plus" aria-hidden="true"></i> Add New Branch</a>
 		<script  src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/valid.js"></script>
        <script type="text/javascript">
          document.getElementById('branch').classList.add('active');
        </script>
    </body>
</html>		
<?php
}else header('Location: login.php');
?>	