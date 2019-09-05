<?php
spl_autoload_register(function ($class){
    require 'classes/'.$class.'.inc';
});
session_start();
if(isset($_COOKIE['Admincookie'])){
    $user=unserialize($_COOKIE['Admincookie']);
     $_SESSION['ADMIN']=$user;
}
if(isset($_SESSION['ADMIN'])){
	if(isset($_GET['do'])&&($_GET['do']=='add'||$_GET['do']=='edit'||$_GET['do']=='update')){
$adm=$_SESSION['ADMIN'];
$do=$_GET['do'];
if($do == 'edit'&&isset($_GET['id'])){
$course_info=$adm->get_course($_GET['id']);
$do='update';
}
elseif ($do == 'update' && isset($_POST['save'])) {
	$course= new Course();
	if(isset($_FILES['image'])&& !empty($_FILES['image']['name'])){
		if(getimagesize($_FILES['image']['tmp_name'])){
			$file_name = $_FILES['image']['name'];
			$file_tmp =$_FILES['image']['tmp_name'];
			$filepath="images/".$file_name;
			$course->setimage(filter_var($filepath,FILTER_SANITIZE_STRING));
			if(is_file($_POST['prev_image']))unlink($_POST['prev_image']);
			move_uploaded_file($file_tmp,$filepath);
		}else $message='You Enter Invalid Image';
	}
	if(!isset($message)){
	if(isset($_POST['state'])&& $_POST['state']==='yes') $course->setState(true); else $course->setState(false);
	$course->sanitize($_POST['coursename'],$_POST['des_course'],$_POST['content'],$_POST['hours'],$_POST['price'],$_POST['certific'],$_POST['startdate'],$_POST['lecturetime'],$_POST['instr_id'],$_POST['category'],$_POST['max'],$_POST['c_id']);
	$adm->editObject($course);
	header('Location: courses.php?do=edited');
	die();
	}
}
elseif ($do == 'add' && isset($_POST['save'])) {
	$course= new Course();
	if(isset($_FILES['image'])&& !empty($_FILES['image']['name'])&& getimagesize($_FILES['image']['tmp_name'])){
			$file_name = $_FILES['image']['name'];
			$file_tmp =$_FILES['image']['tmp_name'];
			$filepath="images/".$file_name;
			$course->setimage(filter_var($filepath,FILTER_SANITIZE_STRING));
			if(isset($_POST['state'])&& $_POST['state']==='yes') $course->setState(true); else $course->setState(false);
			$course->sanitize($_POST['coursename'],$_POST['des_course'],$_POST['content'],$_POST['hours'],$_POST['price'],$_POST['certific'],$_POST['startdate'],$_POST['lecturetime'],$_POST['instr_id'],$_POST['category'],$_POST['max']);
			move_uploaded_file($file_tmp,$filepath);
			$adm->addObject($course);
			header('Location: courses.php?do=added');
			die();
	}else $message='You Enter Invalid Image';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Course Data</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
    </head>
    <body>
    	<?php 
    		require 'nav.php';
    		if(isset($message)){
    			echo '<div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                    </button>';
                                    	echo $message;
                                    echo '</div>';
    		}
    	?>
		<div class="container">
			<form class="editform" action="?do=<?php echo $do; ?>" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="c_id" value="<?php if(isset($_POST['save'])&&isset($_POST['c_id']))echo $_POST['c_id']; elseif($do=='update') echo $course_info->getcourseid();?>">

				<div class="form-group">
					<label>Course Name</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-leanpub" aria-hidden="true"></i></span>
						<input  type="text" name="coursename" id="c_name" class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['coursename']))echo $_POST['coursename']; elseif($do=='update') echo $course_info->getname();?>" required>
					</div>
				</div>	<!--end coursename field-->

			<!--text area for desription -->
				<div class="form-group">
					<label>Description</label>
					<textarea rows="4" cols="50" name="des_course" id="error_des" required><?php if(isset($_POST['save'])&&isset($_POST['des_course']))echo $_POST['des_course']; elseif($do=='update') echo $course_info->getdescription(); ?></textarea>
				</div> 
			<!--end description field-->

			<!--text area for content -->
				<div class="form-group">
					<label>Content</label>
					<textarea rows="4" cols="50" name="content" id="con_error" required><?php if(isset($_POST['save'])&&isset($_POST['content']))echo $_POST['content']; elseif($do=='update') echo $course_info->getcontent(); ?></textarea>
				</div> 
			<!--end content field-->

				<div class="form-group">
					<label>Hours</label>
					<div class="input-group">
	 					<span class="input-group-addon" id="basic-addon1"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
						<input type="number" name="hours" class="form-control" id="ho_error" value="<?php if(isset($_POST['save'])&&isset($_POST['hours']))echo $_POST['hours']; elseif($do=='update') echo $course_info->gethours();?>" required>
					</div>
				</div>	<!--end hours field-->

				<div class="form-group">
					<label >Price </label>
					<div class="input-group">
	  					<span class="input-group-addon" id="basic-addon1"><i class="fa fa-credit-card-alt" aria-hidden="true"></i></span>
						<input type="number" name="price" id="pr_error" class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['price']))echo $_POST['price']; elseif($do=='update') echo $course_info->getprice();?>" required>
					</div>
				</div>	<!--end prise field-->

			<!--text area for certificatiom -->
				<div class="form-group">
					<label>Certifications </label>
					<textarea rows="4" cols="50" name="certific" id="cer_error" required><?php if(isset($_POST['save'])&&isset($_POST['certific']))echo $_POST['certific']; elseif($do=='update') echo $course_info->getcertifications(); ?></textarea>
				</div> 
			<!--end certification field-->


				<div class="form-group">
					<label>Course Image </label>
					<div class="input-group">
 					 <span class="input-group-addon" id="basic-addon1"><i class="fa fa-picture-o" aria-hidden="true"></i></span>
					<input type="file" name="image" class="form-control" <?php if($do!= 'update') echo "required" ;?> >
					</div>
				</div>
				<input type="hidden" name="prev_image" value="<?php if(isset($_POST['save'])&&isset($_POST['prev_image'])) echo $_POST['prev_image']; elseif($do=='update') echo $course_info->getimage();?>">
			<!-- end image field -->


				<div class="form-group">
					<label>Start Date</label>
					<div class="input-group">
  						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar" aria-hidden="true"></i></span>
						<input type="date" name="startdate" id="st_error" class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['startdate']))echo $_POST['startdate']; elseif($do=='update') echo $course_info->getstartDate();?>" required>
					</div>
				</div>	

			<!-- end starttime field -->
			<div class="form-group">
					<label>Category</label>
					<div class="input-group">
  					<span class="input-group-addon" id="basic-addon1"><i class="fa fa-list-alt" aria-hidden="true"></i></span>
					<input type="text" name="category" id="category" class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['category']))echo $_POST['category']; elseif($do=='update') echo $course_info->getCategory();?>" required>
					</div>
				</div>	

			<!-- end starttime field -->
			<div class="form-group">
					<label>Maximum Number of Students</label>
					<div class="input-group">
  						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
					<input type="number" name="max" id="max" class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['max']))echo $_POST['max']; elseif($do=='update') echo $course_info->getMax();?>" required>
					</div>
				</div>

			<!-- end starttime field -->

			<div class="form-group">
					<label>State</label>
					<input type="checkbox" name="state" id="state" value="yes" <?php if(isset($_POST['save'])&&isset($_POST['state'])&&$_POST['state']==='yes')echo "checked"; elseif($do=='update') {
						if($course_info->getState()) echo"checked";
					}?> >
				</div>	

			<!-- end starttime field -->

				<div class="form-group">
					<label>Lectures Time</label>
					<textarea rows="4" cols="50" id="lec_error" name="lecturetime" required><?php if(isset($_POST['save'])&&isset($_POST['lecturetime']))echo $_POST['lecturetime']; elseif($do=='update') echo $course_info->getlecturetime(); ?></textarea>
				</div> 
			<!--end lecturetime field-->

				<div class="form-group">
					<label>Instructor Id</label>
						<select name="instr_id" id='ins' required>
							<?php 
								$instructors=Instructor::getAllIds();
								if($instructors){
								foreach ($instructors as $ins) {
									echo "<option value ='".$ins['id']."' ";
									if (isset($_POST['save'])&&isset($_POST['instr_id'])){
										if($_POST['instr_id']==$ins['id']) echo "selected";
									}
									elseif($do=='update'){
										if($course_info->getins_id()==$ins['id']) echo "selected";
									}
									echo ">".$ins['id']."</option>";
								}
							}
							?>
						</select>	
				</div>	<!--link of coure image to delete field-->
				<button type="submit" id="sub_error" name="save" class="btn btn-primary"><i class="fa fa-sign-in" aria-hidden="true"></i> Save</button>
			</form>
		</div>

		<script  src="js/jquery-3.2.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
          document.getElementById('course').classList.add('active');
        </script>
    </body>
</html>
<?php 
	}else header('Location: courses.php');
} else header('Location: login.php');
?>
	