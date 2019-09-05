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
		$super_info=$adm->get_super($_GET['id']);
		$do='update';
	}elseif ($do == 'update' && isset($_POST['save'])) {
		$super= new Supervisor();
		if(isset($_FILES['image'])&& !empty($_FILES['image']['name'])){
			if(getimagesize($_FILES['image']['tmp_name'])){
				$file_name = $_FILES['image']['name'];
				$file_tmp =$_FILES['image']['tmp_name'];
				$filepath="images/".$file_name;
				$super->setProfileImage(filter_var($filepath,FILTER_SANITIZE_STRING));
				if(is_file($_POST['prev_image']))unlink($_POST['prev_image']);
				move_uploaded_file($file_tmp,$filepath);
			}else{
				$errors[]='You Entered Invalid Image';
			}
		}
		//echo $super->validateMe($_POST['name'],$_POST['username'],$_POST['password'],$_POST['email'],$_POST['salary'],$_POST['address'],$_POST['phone'],$_POST['id']);
		if(!$super->sanitize($_POST['name'],$_POST['username'],$_POST['password'],$_POST['email'],$_POST['salary'],$_POST['address'],$_POST['phone'],$_POST['id'])){	
			$errors[]='You Entered Username Used Before';
		}
		if(!isset($errors)){
		$adm->editObject($super);
		header('Location: super.php?do=edited');
		}

	}elseif ($do == 'add' && isset($_POST['save'])) {
		$super= new Supervisor();
			if(isset($_FILES['image'])&& !empty($_FILES['image']['name'])&&getimagesize($_FILES['image']['tmp_name'])){
				$file_name = $_FILES['image']['name'];
				$file_tmp =$_FILES['image']['tmp_name'];
				$filepath="images/".$file_name;
				$super->setProfileImage(filter_var($filepath,FILTER_SANITIZE_STRING));
				move_uploaded_file($file_tmp,$filepath);
			}else{
				$errors[]='You Entered Invalid Image';
			}
//	$s=20;	
//$s = $super->validateMe($_POST['name'],$_POST['username'],$_POST['password'],$_POST['email'],$_POST['salary'],$_POST['address'],$_POST['phone']);		
	//echo $s;	/
			if(!$super->sanitize($_POST['name'],$_POST['username'],$_POST['password'],$_POST['email'],$_POST['salary'],$_POST['address'],$_POST['phone'])){	
			$errors[]='You Entered Username Used Before ';

		//var_dump($super->validateMe($_POST['name'],$_POST['username'],$_POST['password'],$_POST['email'],$_POST['salary'],$_POST['address'],$_POST['phone']));
		}
		if(!isset($errors)){
		$adm->addObject($super);
		header('Location: super.php?do=added');
		}
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Supervisor Data</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
    </head>
    <body>
    	<?php 
    		require 'nav.php';
    		if(isset($errors)){
    			echo '<div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                    </button>';
                                    foreach ($errors as $error) {
                                    	echo $error."<br>";
                                    }
                                    echo '</div>';
    		}
    	?>
    	<div class="container ">
    		<form class="editform" action="?do=<?php echo $do; ?>" method="POST" enctype="multipart/form-data">
    			<input type="hidden" name="id" value="<?php if(isset($_POST['save'])&&isset($_POST['id'])) echo $_POST['id']; elseif($do=='update') echo $super_info->getId();?>">
    			<div class="form-group">
					<label>Supervisor Name</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
						<input  type="text" name="name"  class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['name'])) echo $_POST['name']; elseif($do=='update') echo $super_info->getName();?>" required>
					</div>
				</div>
				<div class="form-group">
					<label>Username</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-address-card" aria-hidden="true"></i></span>
						<input  type="text" name="username" id="username" class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['username'])) echo $_POST['username']; elseif($do=='update') echo $super_info->getUsername();?>" required autocomplete="off" maxlength="30">
					</div>
				</div>
				<div class="form-group">
					<label>Password</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
						<input  type="password" name="password"  class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['password'])) echo $_POST['password']; ?>" <?php if($do!='update') echo 'required'; ?> autocomplete="new-password" maxlength='30'>
					</div>
				</div>
				<div class="form-group">
					<label>Email</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-envelope" aria-hidden="true"></i></span>
						<input  type="email" name="email"  class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['email'])) echo $_POST['email']; elseif($do=='update') echo $super_info->getEmail();?>" required>
					</div>
				</div>
				<div class="form-group">
					<label>Phone</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-phone" aria-hidden="true"></i></span>
						<input  type="number" name="phone"  class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['phone'])) echo $_POST['phone']; elseif($do=='update') echo $super_info->getPhone();?>" required>
					</div>
				</div>
				<div class="form-group">
					<label>Salary</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-money" aria-hidden="true"></i></span>
						<input  type="number" name="salary" class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['salary'])) echo $_POST['salary']; elseif($do=='update') echo $super_info->getSalary();?>" required>
					</div>
				</div>
				
				<div class="form-group">
					<label>Address</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
						<input  type="text" name="address"  class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['address'])) echo $_POST['address']; elseif($do=='update') echo $super_info->getAddress();?>" required>
					</div>
				</div>
				<div class="form-group">
					<label>Profile Image </label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-picture-o" aria-hidden="true"></i></span>
						<input type="file" name="image" class="form-control" <?php if($do!= 'update') echo "required" ;?> >
					</div>
				</div>
				<input type="hidden" name="prev_image" value="<?php if(isset($_POST['save'])&&isset($_POST['prev_image'])) echo $_POST['prev_image']; elseif($do=='update') echo $super_info->getProfileImage();?>">

				
				<button type="submit" id="save" name="save" class="btn btn-primary"><i class="fa fa-sign-in" aria-hidden="true"></i> Save</button>				<div class="invalid-feedback">
					Please Enter Valid Data
				</div>
    		</form>
    	</div>
    	<script  src="js/jquery-3.2.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
          document.getElementById('supervisor').classList.add('active');
        </script>
    </body>
</html>
<?php 
	}else header('Location: super.php');
} else header('Location: login.php');
?>