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
$admin =$_SESSION["ADMIN"];
if(isset($_GET['do'])){
  	if(isset($_GET['id'])&&$_GET['do']=='delete'){
  		$course=$admin->get_course($_GET['id']);
  		if(is_file($course->getimage()))unlink($course->getimage());
        $admin->deleteObject($course);
        $Message='1 Course Deleted';
       }elseif ($_GET['do']=='edited') $Message='1 Course Edited';
       elseif ($_GET['do']=='added') $Message='1 Course Added';
}
$all_courses=$admin->showObjects('Course');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Courses Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
    </head>
    <body>
    	<?php 
    		require 'nav.php';
    		if(isset($Message)){
    			echo' <div class="alert alert-success alert-dismissible fade show " role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                    '.$Message.' 
                 </div>';
    		}
    	?>
<div class="row rowsearch">
<div class="input-group-btn col-lg-4">
  <input  type="text" name="search" placeholder="Search" class="form-control searchinput" onkeyup="showtable(this.value,'course')">
<button class="btn btn-default" type="submit" style="background-color:  #d9d9d9
;"><i class="fa fa-search" aria-hidden="true" style="color: #f2f2f2";></i>
</button>
</div>
</div>
<div class="table-responsive" id="show">
	<table class="table table-striped text-center">
	    <thead class="thead-inverse ">
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Hours</th>
				<th>Price</th>
				<th>Start Date</th>
				<th>Category</th>
				<th>State</th>
				<th>Image</th>
				<th>Options</th>
			</tr>
		</thead>
		<tbody>
		 <?php
		 if($all_courses){
		foreach ($all_courses as $obj) {

				 echo "<tr>";
			echo "<td>".$obj->getcourseid()."</td>";
			echo "<td>".$obj->getname()."</td>";
			echo "<td>".$obj->gethours()."</td>";
			echo "<td>".$obj->getprice()."</td>";
			echo "<td>".$obj->getstartDate()."</td>";
			echo "<td>".$obj->getCategory()."</td>";
			echo "<td>";
				if($obj->getState()) echo "Active";
				else echo "UnActive";
			echo "</td>";
			echo "<td><img src='".$obj->getimage()."' width='60px' height='40px' alt='none'/></td>";
			echo "<td><a href='addeditcourse.php?do=edit&id=".$obj->getcourseid()."' class='btn btn-primary'><i class='fa fa-wrench' aria-hidden='true'></i> Edit</a> ";
			echo "<a href='?do=delete&id=".$obj->getcourseid()."' onclick='return confirm(\"Are You Sure You Want To Delete This Course\")' class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>";
			echo "</tr>";
			}
		}
		 ?>
	</tbody>		 		
	</table>
</div>		

<a href='addeditcourse.php?do=add' class="btn btn-primary addnew"><i class="fa fa-plus" aria-hidden="true"></i> Add New Course</a>
 		<script  src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
          document.getElementById('course').classList.add('active');
        </script>
         <script src="js/valid.js"></script>
    </body>
</html>


<?php
}else header("Location: login.php");

?>