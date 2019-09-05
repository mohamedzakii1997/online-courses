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
  if(isset($_GET['do'])&&($_GET['do']=='add'||$_GET['do']=='edit'||$_GET['do']=='update')){
$adm= $_SESSION["ADMIN"];
$do=$_GET['do'];
if($do == 'edit'&&isset($_GET['id'])){
$branch_info=$adm->get_branch($_GET['id']);
$do='update';
}
elseif ($do == 'update' && isset($_POST['save'])) {
	$branch= new Branch();
	$branch->sanitize($_POST['loc'],$_POST['desc'],$_POST['phone'],$_POST['branch_id']);
	$adm->editObject($branch);
	header('Location: branches.php?do=edited');
	die();
}

elseif ($do == 'add' && isset($_POST['save'])) {
	$branch= new Branch();
	$branch->sanitize($_POST['loc'],$_POST['desc'],$_POST['phone'],$_POST['branch_id']);
	$adm->addObject($branch);
	header('Location: branches.php?do=added');
		die();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>branch Data</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">

    </head>
    <body>
    	<?php require 'nav.php' ?>
<div class="container">

			<form class="editform" action="?do=<?php echo $do; ?>" method="POST">
				<input type="hidden" name="branch_id" value="<?php if($do=='update') echo $branch_info->getbranchid();?>">

				<div class="form-group">
					<label>location</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
						<input  type="text" name="loc" class="form-control" value="<?php if($do=='update') echo $branch_info->getlocation();?>" required>
					</div>
				</div>	<!--end news location field-->
                
                <div class="form-group">
					<label>description</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
						<input  type="text" name="desc" class="form-control" value="<?php if($do=='update') echo $branch_info->getdescription();?>" required>
					</div>
				</div>	<!--end  description field-->

                 <div class="form-group">
					<label>phone</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-phone" aria-hidden="true"></i></span>
						<input  type="number" name="phone" class="form-control" value="<?php if($do=='update') echo $branch_info->getPhone();?>" required>
					</div>
				</div>	<!--end  phone field-->
				<button type="submit" id="sub-error" name="save" class="btn btn-primary"><i class="fa fa-sign-in" aria-hidden="true"></i> Save</button>
         </form>
</div>



  <script  src="js/jquery-3.2.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
          document.getElementById('branch').classList.add('active');
        </script>
    </body>
</html>  	
<?php 
	}else header('Location: news.php');
} else header('Location: login.php');	
?>