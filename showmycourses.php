<?php 
spl_autoload_register(function ($class){
    require 'classes/'.$class.'.inc';
});
session_start();
 if(isset($_COOKIE['INSTRUCTORcookie'])){
    $user=unserialize($_COOKIE['INSTRUCTORcookie']);
     $_SESSION['INSTRUCTOR']=$user;

}
if(isset($_SESSION["INSTRUCTOR"])){
	if (isset($_POST['submit'])){
if(isset($_FILES['upload']) && !empty($_FILES['upload']['tmp_name']) ){
$filename=$_FILES['upload']['name'];
$filetmp=$_FILES['upload']['tmp_name'];
$arr=explode('.',$filename);

$file_ext=strtolower(end($arr));
$extensions=array("pdf","docx","pptx");
if(in_array($file_ext,$extensions)){
	$filepath='resources/'.$filename;
	move_uploaded_file($filetmp,$filepath);
$ins=$_SESSION['INSTRUCTOR'];
$ins->upload_myresource($filepath,$_POST['c_id']);

}}
else {$error='you enter invaid data or the file not document';}

}


$ins=$_SESSION['INSTRUCTOR'];

$result=$ins->getmycourses();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Instructor-Courses Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
    </head>
    <body>
    	<?php
 require 'cnav.php';
 if(isset($error)){
 	echo '<div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                    </button>'.$error.'</div>';
 }
?>
<?php 

if(empty($result)){
	echo' <div class="alert alert-success alert-dismissible fade show " role="alert">
                  sorry you not teach any course
                 </div>';
}
else{

	echo '<div class="table-responsive">
	<table class="table table-striped text-center" id="myTable">
	    <thead class="thead-inverse ">
			<tr>
			    <th>id</th>
				<th>Name</th>
				<th>hours</th>
				<th>start Date</th>
			    <th>lecture Time</th>
			    <th>Resources</th>
			    <th>My Students</th>
			</tr>
			</thead>

		<tbody>';
$i=1;
foreach ($result as $value) {
	echo "<tr>";
echo "<td>".$value['courseId']."</td>";		
echo "<td>".$value['name']."</td>";
echo "<td>".$value['hours']."</td>";
echo "<td>".$value['startDate']."</td>";
echo "<td>".$value['lectureTime']."</td>";

echo '<td> <button  class="btn btn-primary registerCourse" data-toggle="modal" data-target="#exampleModal" id="up" onclick="getid(
'.$i.'
)"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Upload </button>
           </td>';

  echo '<td> <button  class="btn btn-primary registerCourse" data-toggle="modal" data-target="#Modal" id="up" onclick="showstudents(
'.$i.'
)"><i class="fa fa-eye" aria-hidden="true"></i> View Students</button>
           </td>';         
	
	echo "</tr>";

$i++;
}
echo "</tbody>		 		
	</table>
</div>		
";
//form to upload
echo '
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Resourse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
</button>
                  </div>
                  <div class="modal-body">
                    <form action="" method="post" id="payment" enctype="multipart/form-data"> 
                        <input type="hidden" name="c_id" value="" id="hiden">
                        <label>Upload File</label> <input type="File" name="upload" value="">
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" value="upload" class="btn btn-primary" form="payment">
</div>
                </div>
              </div>
</div>

';

// show instructor student by ajax
echo '
<div class="modal fade bd-example-modal-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">My Students</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
</button>
                  </div>
                  <div class="modal-body">
                    <div class="table-responsive" id="students">
	<table class="table table-striped text-center">
	    <thead class="thead-inverse ">
			<tr>
			    <th>email</th>
				<th>Name</th>
				
			</thead>

		<tbody>

		</tbody>		 		
	</table>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
                </div>
              </div>
</div>


';




}




?>

<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
        	//document.getElementById("up").onclick=function(row){
//document.getElementById("hiden").value=5;
//function to set course id in input hidden to update this resourse 
function getid(row){
	var cell=document.getElementById("myTable").rows[row].cells;
document.getElementById("hiden").value=cell[0].textContent;
}

function showstudents(row){

var cell=document.getElementById("myTable").rows[row].cells;


	xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("students").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET","notify.php?action=showstudent&id="+cell[0].textContent,true);
  xhttp.send();
}

	
        </script>
<?php if (isset($_SESSION['INSTRUCTOR']))
        echo '<script  src="js/ajax2.js"></script>'; ?>

        
</body>
</html>	





<?php 
}else header('Location: home.php');
?>