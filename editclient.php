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
        if(isset($_GET['id'])){
        $admin=$_SESSION["ADMIN"];
        if(isset($_POST['edit'])){
            $client=new Client();
            if($client->sanitize($_POST['username'],$_POST['password'],$_POST['email'],$_POST['name'],$_POST['phone'],$_GET['id'])){
                if(isset($_POST['verify'])&&$_POST['verify']=='yes'){
                    $client->setVerify(true);
                }else $client->setVerify(false);
                if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){
                    if(getimagesize($_FILES['image']['tmp_name'])){
                        $file_name = $_FILES['image']['name'];
                        $file_tmp =$_FILES['image']['tmp_name'];
                        $filepath="images/".$file_name;
                        $client->setProfileImage(filter_var($filepath,FILTER_SANITIZE_STRING));
                        if(is_file($_POST['prev_image'])) unlink($_POST['prev_image']);
                        move_uploaded_file($file_tmp,$filepath);                        
                    } else{
                        $errors[]='You Entered Invalid Image';
                    }
                }
            }else $errors[]='You Enter Username Used Before';
            if(!isset($errors)){
                $admin->editObject($client);
            header('Location: clients.php?box=edited');
            }
        }
        $client=$admin->showclientdata($_GET['id']);
        
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Client Data</title>
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
        <div class="container">
            <form method='POST' name='clientform' action="editclient.php?id=<?php echo $client->getId() ;?>" class='editform' enctype="multipart/form-data">
                <div class="form-group">
                    <label>Name</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                        <input type='text' id='name' name='name' maxlength="30" class="form-control" value="<?php echo $client->getName() ;   ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Username </label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-address-card" aria-hidden="true"></i></span>
                        <input type='text' id='username' name='username' class="form-control" maxlength='30' value="<?php echo $client->getUsername() ;?>" required>
                     </div>
                </div>
                <div class="form-group">
                    <label> password</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                        <input type='password'  id="password" class="form-control" name='password' maxlength="30">
                    </div>
                </div>
                <div class="form-group">
                    <label> Email</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                        <input type='email' id='email' name='email' class="form-control" value="<?php echo $client->getEmail(); ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Client Image </label>
                    <input type="file" name="image" class="form-control" >
                </div>
                <input type="hidden" name="prev_image" value="<?php echo $client->getProfileImage();?>">
                <div class="form-group">
                    <label> Verify</label>
                    <input type='checkbox' name='verify' value='yes' <?php if($client->getVerify()=='1')echo "checked"; ?> >
                </div>
                <div class="form-group">
                    <label> Phone</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-phone" aria-hidden="true"></i></span>
                        <input type='text' id='phone' name='phone' class="form-control" value="<?php echo $client->getPhone(); ?>" required>
                    </div>
                </div>
                <button  name='edit' id='edit' type="submit" class="btn btn-primary"><i class="fa fa-sign-in" aria-hidden="true"></i> Save</button>
                <div class="invalid-feedback">
                    Please provide a valid Data.
                </div>
            </form>
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
         }else header("Location: clients.php");
    }else header('Location: login.php');
?>