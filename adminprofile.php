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
    if(isset($_GET['do'])&& $_GET['do']=='change' && isset($_POST['change'])){
        if(isset($_FILES['image'])&& !empty($_FILES['image']['name'])){
            if(getimagesize($_FILES['image']['tmp_name'])){
                $file_name = $_FILES['image']['name'];
                $file_tmp =$_FILES['image']['tmp_name'];
                $filepath="images/".$file_name;
                if(is_file($admin->getProfileImage())) unlink($admin->getProfileImage());
                $admin->setProfileImage(filter_var($filepath,FILTER_SANITIZE_STRING));
                move_uploaded_file($file_tmp,$admin->getProfileImage());
            }
        }
        $admin->setName(filter_var($_POST['name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $admin->setEmail(filter_var($_POST['email'],FILTER_SANITIZE_EMAIL));
        $admin->editProfile($_POST['name'],$_POST['email']);
        header('Location: dashboard.php?do=edited');
        die();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Profile Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
    </head>
    <body>
    	<?php require 'nav.php'; ?>

        <div class="container">
            <div class="imgContainer text-center">
                <img class="imgProfile" src="<?php echo $admin->getProfileImage(); ?>" alt="There are No profile Image Available">
            </div>
            <button class="btn btn-primary uploadImage" id="upload"><i class="fa fa-upload" aria-hidden="true"></i> Upload Image</button>
        	<form class="editform" method="POST" action="?do=change" enctype="multipart/form-data">
                <input type="file" name="image" hidden id="image">
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-address-card" aria-hidden="true"></i></span>
                        <input  type="text" name="username" class="form-control" value="<?php echo $admin->getUsername();?>"  autocomplete="off" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                        <input  type="text" name="name"  class="form-control" value="<?php echo $admin->getName();?>" required>
                    </div>
                </div> 
        		<div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                        <input  type="email" name="email"  class="form-control" value="<?php echo $admin->getEmail();?>" required>
                    </div>
                </div>
                <button type="submit" name="change" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> Change</button>   
        	</form>
        </div>
    	<script  src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
            document.getElementById('upload').onclick= function(){
                document.getElementById('image').click();
            };
        </script>
    </body>
</html>

<?php
}else header('Location: login.php');