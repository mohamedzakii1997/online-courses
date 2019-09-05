<?php
spl_autoload_register(function ($class){
    require 'classes/'.$class.'.inc';
});
session_start();
        if(isset($_COOKIE['clientcookie'])){
    $user=unserialize($_COOKIE['clientcookie']);
     $_SESSION['CLIENT']=$user;

}
 elseif(isset($_COOKIE['SUPERVISORcookie'])){
    $user=unserialize($_COOKIE['SUPERVISORcookie']);
     $_SESSION['SUPERVISOR']=$user;

}
 elseif(isset($_COOKIE['INSTRUCTORcookie'])){
    $user=unserialize($_COOKIE['INSTRUCTORcookie']);
     $_SESSION['INSTRUCTOR']=$user;

}
 elseif(isset($_COOKIE['Admincookie'])){
    $user=unserialize($_COOKIE['Admincookie']);
     $_SESSION['ADMIN']=$user;

}
if(isset($_SESSION['ADMIN'])||isset($_SESSION['CLIENT'])||isset($_SESSION['INSTRUCTOR'])||isset($_SESSION['SUPERVISOR'])){
	if(isset($_GET['do'])&& $_GET['do']='change'){
		if(isset($_POST['change'])){
			if (!($_POST['newPassword']==$_POST['resumePassword'])) $message='You Didn\'t Enter The Same New Password';
			if(!isset($message)){
				if(isset($_SESSION['CLIENT'])){
					if(sha1($_POST['oldPassword'])==$_SESSION['CLIENT']->getPassword()){
						$_SESSION['CLIENT']->changePassword($_POST['newPassword'],'clients');
						header('Location: login.php');
					}else $message='You Entered Wrong Old Password';

				}elseif(isset($_SESSION['INSTRUCTOR'])){
					if(sha1($_POST['oldPassword'])==$_SESSION['INSTRUCTOR']->getPassword()){
						$_SESSION['INSTRUCTOR']->changePassword($_POST['newPassword'],'instructors');
						header('Location: login.php');
					}else $message='You Entered Wrong Old Password';

				}elseif(isset($_SESSION['SUPERVISOR'])){
					if(sha1($_POST['oldPassword'])==$_SESSION['SUPERVISOR']->getPassword()){
						$_SESSION['SUPERVISOR']->changePassword($_POST['newPassword'],'supervisors');
						header('Location: login.php');
					}else $message='You Entered Wrong Old Password';

				}elseif(isset($_SESSION['ADMIN'])){
					if(sha1($_POST['oldPassword'])==$_SESSION['ADMIN']->getPassword()){
						$_SESSION['ADMIN']->changePassword($_POST['newPassword'],'admins');
						header('Location: login.php');
					}else $message='You Entered Wrong Old Password';
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Password Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
    </head>
    <body>
    	<?php 
    		require 'cnav.php';
    		if(isset($message)){
    			echo '<div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                    </button>';
                                    echo $message;
                                    echo '</div>';
    		}
    	?>
    	<div class="container ">
    		<form class="editform" action="?do=change" method="POST">
    			<div class="form-group">
					<label>Old Password</label>
					<div class="input-group">
  						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
						<input  type="password" name="oldPassword"  class="form-control" value="<?php if(isset($_POST['change'])&&isset($_POST['oldPassword'])) echo $_POST['oldPassword']; ?>" required autocomplete="new-password" maxlength="30">
					</div>
				</div>
				<div class="form-group">
					<label>New Password</label>
					<div class="input-group">
  						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-unlock" aria-hidden="true"></i></span>
						<input  type="password" name="newPassword"  class="form-control" value="<?php if(isset($_POST['change'])&&isset($_POST['newPassword'])) echo $_POST['newPassword']; ?>" required autocomplete="new-password" maxlength="30" pattern=".{5,30}">
					</div>
				</div>
				<div class="form-group">
					<label>Resume New Password</label>
					<div class="input-group">
  						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-unlock" aria-hidden="true"></i></span>
						<input  type="password" name="resumePassword"  class="form-control" value="<?php if(isset($_POST['change'])&&isset($_POST['resumePassword'])) echo $_POST['resumePassword']; ?>" required autocomplete="new-password" maxlength="30" pattern=".{5,30}">
					</div>
				</div>
				<button type="submit" id="change" name="change" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> Change</button>
    		</form>
    	</div>
 		<script  src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <?php if (isset($_SESSION['INSTRUCTOR'])||isset($_SESSION['CLIENT']))
        echo '<script  src="js/ajax2.js"></script>'; ?>
    </body>
</html>

<?php
}else header('Location: login.php');