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
if(isset($_GET['filename'])){
if(is_file('resources/'.$_GET['filename'])){

	$filepath='resources/'.$_GET['filename'];
	$arr=explode('.',$_GET['filename']);
    $exe=end($arr);
    if($exe == 'pdf'){
      header('Content-Description: File Transfer');
      header("Content-Type: application/pdf"); 
    	header('Content-Disposition: attachment; filename='.$_GET['filename']);
      header('Content-Transfer-Encoding: binary'); 
      header('Content-Length: ' . filesize($filepath));
      ob_clean();
      readfile($filepath);
    }
   elseif($exe == 'pptx'){
     header('Content-Description: File Transfer');
header('Content-Type: application/pptx'); 
header('Content-Disposition: attachment; filename='.$_GET['filename']);
      header('Content-Transfer-Encoding: binary'); 
      header('Content-Length: ' . filesize($filepath));
      ob_clean();
      readfile($filepath);
   }
   elseif($exe == 'docx'){
         header('Content-Description: File Transfer');
header('Content-Type: application/docx'); 
   header('Content-Disposition: attachment; filename='.$_GET['filename']);
      header('Content-Transfer-Encoding: binary'); 
      header('Content-Length: ' . filesize($filepath));
      ob_clean();
      readfile($filepath);
   }
}else{$error='Please Dont Change File Name';}

}

$cl=$_SESSION['CLIENT'];
$arr=$cl->showmycourses();
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

<h2 style="color: #3498db; font-weight: bold;margin-top: 30px; margin-left: 20px"> My Registerd Courses </h2>


<div class="table-responsive">
	<table class="table table-striped text-center">
	    <thead class="thead-inverse ">
			<tr>
				<th>Name</th>
				<th>Course Hours</th>
				<th>Content</th>
				<th>Start Date</th>
				<th>Licture Time</th>
				<th> State</th>
				<th>Register Date</th>
				<th>Resources</th>
			</tr>
		</thead>
		<tbody>





<?php 
if($arr){
foreach($arr as $obj){
    if($obj['clientid']== $cl->getId()){
    	

 echo "<tr>";
		echo "<td>".$obj['name']."</td>";
		echo "<td>".$obj['hours']."</td>";
		echo "<td>".$obj['content']."</td>";
		echo "<td>".$obj['startDate']."</td>";
		echo "<td>".$obj['lectureTime']."</td>";
		echo "<td>";
			if($obj['startDate']) echo "Active";
			else echo "UnActive";
		echo "</td>";

		echo "<td>".$obj['registerdate']."</td>";
echo '<td> <button  class="btn btn-primary registerCourse" data-toggle="modal" data-target="#exampleModal" id="up" onclick=getdownload('.$obj['courseId'].')'.'><i class="fa fa-eye" aria-hidden="true"></i> Show</button>

           </td>';
 

echo '<tr/>';
    }
    }
  }
		
		 ?>



	</tbody>		 		
	</table>
</div>		


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Resourse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
</button>
                  </div>
                  <div class="modal-body" id="show">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 
</div>
                </div>
              </div>
</div>


 <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
<script>
	
function getdownload(id){

 xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("show").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET","notify.php?action=download&c_id="+id,true);
  xhttp.send();
}

</script>

<?php if (isset($_SESSION['CLIENT']))
        echo '<script  src="js/ajax2.js"></script>'; ?>
    </body>
</html>
<?php } else header('Location: home.php'); ?>
