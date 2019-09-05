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
  if (isset($_GET['do'])) {
      if($_GET['do']=='delete'&&isset($_GET['id'])){
        $instructor=$admin->get_instructor($_GET['id']);
        if(is_file($instructor->getProfileImage()))unlink($instructor->getProfileImage());
        $admin->deleteObject($instructor);
        $Message='1 Instructor Deleted';
      }elseif ($_GET['do']=='edited') $Message='1 Instructor Edited';
       elseif ($_GET['do']=='added') $Message='1 Instructor Added';
  }
  $ins_info=$admin->showObjects('Instructor');

?>
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
 require 'nav.php'; 
if (isset($Message)){
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
  <input  type="text" name="search" placeholder="Search" class="form-control searchinput" onkeyup="showtable(this.value,'instructor')">
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
<th>Salary</th>
<th>Work Date</th>
<th>Phone</th>
<th>Image</th>
<th>Options</th>
</tr>
</thead>
<tbody>
<?php
if($ins_info){
foreach ($ins_info as $obj) {
  # code...
echo "<tr>";
 echo "<td>" . $obj->getId(). "</td>";
  echo "<td>" . $obj->getName(). "</td>";
  echo "<td>" .$obj->getSalary(). "</td>";
  echo "<td>" . $obj->getWorkdate(). "</td>";
  echo "<td>" . $obj->getphone() . "</td>";
  echo "<td><img src='".$obj->getProfileImage()."'height='40px' width='50px' alt='none'/></td>";
  echo "<td>  <a href='addeditinstructor.php?do=edit&id=".$obj->getId()."'class='btn btn-primary'><i class='fa fa-wrench' aria-hidden='true'></i>  Edit </a> 
         <a href='?do=delete&id=".$obj->getId()." 'class='btn btn-danger' onclick='return confirm(\"Are You Sure You Want To Delete This Instructor\")'><i class='fa fa-trash' aria-hidden='true'></i> Delete </a> 
   </td>";

echo"</tr>";

}
}
?>
</tbody>
 </table>

</div>
<a href='addeditinstructor.php?do=add' class='btn btn-primary addnew  '><i class="fa fa-plus" aria-hidden="true"></i> Add New Instructor </a>

        <script  src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
          document.getElementById('instructor').classList.add('active');
        </script>
        <script src="js/valid.js"></script>
      <!--   <script src="js/dynamic.js"></script> -->
    </body>
</html>
<?php 
}else header('Location: login.php');
?>