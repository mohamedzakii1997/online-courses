<?php
spl_autoload_register(function ($class){
    require 'classes/'.$class.'.inc';
});
$do='';
session_start();
if(isset($_COOKIE['Admincookie'])){
    $user=unserialize($_COOKIE['Admincookie']);
     $_SESSION['ADMIN']=$user;
}
if(isset($_SESSION["ADMIN"])){
  if(isset($_GET['do'])&&($_GET['do']=='add'||$_GET['do']=='edit'||$_GET['do']=='update')){
$adm=$_SESSION["ADMIN"];
$do=$_GET['do'];
if($do == 'edit'&&isset($_GET['id'])){
$news_info=$adm->get_news($_GET['id']);
$do='update';
}
elseif ($do == 'update' && isset($_POST['save'])) {
	$news= new News();
	if(isset($_FILES['image'])&& !empty($_FILES['image']['name'])){
		if(getimagesize($_FILES['image']['tmp_name'])){
			$file_name = $_FILES['image']['name'];
			$file_tmp =$_FILES['image']['tmp_name'];
			$filepath="images/".$file_name;
			$news->setimage(filter_var($filepath,FILTER_SANITIZE_STRING));
			if(is_file($_POST['prev_image']))unlink($_POST['prev_image']);
			move_uploaded_file($file_tmp,$filepath);
		}else $message="You Enter Invalid Image";
	}
	if(!isset($message)){
		$news->sanitize($_POST['header'],$_POST['desc'],$_POST['n_id']);
		$adm->editObject($news);
		header('Location: news.php?do=edited');
		die();
	}
}

elseif ($do == 'add' && isset($_POST['save'])) {
	$news= new News();
	if(isset($_FILES['image'])&& !empty($_FILES['image']['name'])&& getimagesize($_FILES['image']['tmp_name'])){
			$file_name = $_FILES['image']['name'];
			$file_tmp =$_FILES['image']['tmp_name'];
			$filepath="images/".$file_name;
			$news->setimage(filter_var($filepath,FILTER_SANITIZE_STRING));
			$news->sanitize($_POST['header'],$_POST['desc']);
			move_uploaded_file($file_tmp,$filepath);
			$all=$adm->showObjects('Client');
            foreach ($all as $value) {
            $adm->subscribe($value);
            }
            $all=$adm->showObjects('Instructor');
            foreach ($all as $value) {
            $adm->subscribe($value);
            }
			$adm->addObject($news);
			header('Location: news.php?do=added');
			die();
	}else $message='You Enter Invalid Image';
	header("location: news.php");
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
  		require "nav.php";
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
				<input type="hidden" name="n_id" value="<?php if(isset($_POST['save'])&&isset($_POST['n_id'])) echo $_POST['n_id']; elseif($do=='update') echo $news_info->getnewsid();?>">

				<div class="form-group">
					<label>header</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-header" aria-hidden="true"></i></span>
						<input  type="text" name="header" class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['header'])) echo $_POST['header']; elseif($do=='update') echo $news_info->getheader();?>" required>
					</div>
				</div>	<!--end news header field-->
                
                <div class="form-group">
					<label>description</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
						<input  type="text" name="desc" class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['desc'])) echo $_POST['desc']; elseif($do=='update') echo $news_info->getdescription();?>" required>
					</div>
				</div>	<!--end news news description field-->

                 <div class="form-group">
					<label>image</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-picture-o" aria-hidden="true"></i></span>
						<input  type="file" name="image" class="form-control" <?php if($do!='update') echo "required";?> >
					</div>
				    <input type="hidden" name="prev_image" value="<?php if(isset($_POST['save'])&&isset($_POST['prev_image'])) echo $_POST['prev_image']; elseif($do=='update') echo $news_info->getimage();?>">
				</div>	<!--end news image field-->
				<button type="submit" id="sub-error" name="save" class="btn btn-primary"><i class="fa fa-sign-in" aria-hidden="true"></i> Save</button>
         </form>
</div>



  <script  src="js/jquery-3.2.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
          document.getElementById('news').classList.add('active');
        </script>
    </body>
</html>  
<?php 
	}else header('Location: news.php');
} else header('Location: login.php');	
?>