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
		$bookinfo=$adm->showbook($_GET['id']);
		$do='update';
	}elseif ($do == 'update' && isset($_POST['save'])) {
		$book= new Book();
		if(isset($_FILES['image'])&& !empty($_FILES['image']['name'])){
			if(getimagesize($_FILES['image']['tmp_name'])){
				$file_name = $_FILES['image']['name'];
				$file_tmp =$_FILES['image']['tmp_name'];
				$filepath="images/".$file_name;
				$book->setImg(filter_var($filepath,FILTER_SANITIZE_STRING));
				if(is_file($_POST['prev_image']))unlink($_POST['prev_image']);
				move_uploaded_file($file_tmp,$filepath);
			}else{
				$errors[]='You Entered Invalid Image';
			}
		}
		if(!isset($errors)){
		$book->sanitize($_POST['name'],$_POST['price'],$_POST['number'],$_POST['category'],$_POST['author'],$_POST['edition'],$_POST['description'],$_POST['id'],$_POST['courseid']);
		$adm->editObject($book);
		header('Location: books.php?box=edited');
		}

	}elseif ($do == 'add' && isset($_POST['save'])) {
		$book= new Book();
			if(isset($_FILES['image'])&& !empty($_FILES['image']['name'])&&getimagesize($_FILES['image']['tmp_name'])){
				$file_name = $_FILES['image']['name'];
				$file_tmp =$_FILES['image']['tmp_name'];
				$filepath="images/".$file_name;
				$book->setImg(filter_var($filepath,FILTER_SANITIZE_STRING));
				move_uploaded_file($file_tmp,$filepath);
			}else{
				$errors[]='You Entered Invalid Image';
			}
            $book->sanitize($_POST['name'],$_POST['price'],$_POST['number'],$_POST['category'],$_POST['author'],$_POST['edition'],$_POST['description'],'',$_POST['courseid']);
            
		if(!isset($errors)){
		$adm->addObject($book);
		header('Location: books.php?box=added');
		}
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Book Data</title>
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
			<input type="hidden" name="id" value="<?php if(isset($_POST['save'])&&isset($_POST['id'])) echo $_POST['id']; elseif($do=='update') echo $bookinfo->getId(); ?>">
    			<div class="form-group">
					<label>Book Name</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-book" aria-hidden="true"></i></span>
						<input  type="text" id='name' name="name"  class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['name'])) echo $_POST['name']; elseif($do=='update') echo $bookinfo->getName();?>" required>
					</div>
				</div>
				<div class="form-group">
					<label>Author</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
						<input  type="text" id='author' name="author"  class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['author'])) echo $_POST['author']; elseif($do=='update') echo $bookinfo->getAuthor();?>" required>
					</div>
				</div>
				<div class="form-group">
					<label>Number of Books</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-list-ol" aria-hidden="true"></i></span>
						<input  type="number" name="number"  class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['number'])) echo $_POST['number']; elseif($do=='update') echo $bookinfo->getNumber();?>" required>
					</div>
				</div>
				<div class="form-group">
					<label>Edition</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-code-fork" aria-hidden="true"></i></span>
						<input  type="number" id='edition' name="edition"  class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['edition'])) echo $_POST['edition']; elseif($do=='update') echo $bookinfo->getEdition();?>" required >
					</div>
				</div>
				<div class="form-group">
					<label>Price</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-credit-card-alt" aria-hidden="true"></i></span>
						<input  type="number" id='price' name="price"  class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['price'])) echo $_POST['price']; elseif($do=='update') echo $bookinfo->getPrice();?>" required>
					</div>
				</div>
				<div class="form-group">
					<label>Category</label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-list-alt" aria-hidden="true"></i></span>
						<input  type="text" id='category' name="category"  class="form-control" value="<?php if(isset($_POST['save'])&&isset($_POST['category'])) echo $_POST['category']; elseif($do=='update') echo $bookinfo->getCategory();?>" required>
					</div>
				</div>
				<div class="form-group">
					<label>Cover Image </label>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><i class="fa fa-picture-o" aria-hidden="true"></i></span>
						<input type="file" name="image" class="form-control" <?php if($do!= 'update') echo "required" ;?> >
					</div>
				</div>
				<input type="hidden" name="prev_image" value="<?php if(isset($_POST['save'])&&isset($_POST['prev_image'])) echo $_POST['prev_image']; elseif($do=='update') echo $bookinfo->getImg();?>">

				<div class="form-group">
					<label>Book Description</label>
					<textarea rows="4" cols="50" name="description"  required><?php if (isset($_POST['save'])&&isset($_POST['description'])) echo $_POST['description']; elseif($do=='update') echo $bookinfo->getDescription(); ?></textarea>
				</div> 
                <div class="form-group">
					<label>Course Id</label>
						<select name="courseid" id='cid'>
							<?php 
							 echo "<option value='' >None</option>";
								$courses=Course::getAllIds();
								if($courses){
								foreach ($courses as $cid) {
									echo "<option value ='".$cid['courseId']."'";
									if (isset($_POST['save'])&&isset($_POST['courseid'])){
										if($_POST['courseid']==$cid['courseId']) echo "selected";
									}
									elseif($do=='update'){
										if($bookinfo->getCourseId()==$cid['courseId']) echo "selected";
									}
                                    echo ">".$cid['courseId']."</option>";
								}
							}
							?>
						</select>	
				</div>
				<button type="submit" id="save" name="save" class="btn btn-primary"><i class="fa fa-sign-in" aria-hidden="true"></i> Save</button>
				<div class="invalid-feedback">
					Please Enter Valid Data
				</div>
    		</form>
    	</div>
    	<script  src="js/jquery-3.2.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
          document.getElementById('book').classList.add('active');
        </script>
    </body>
</html>
<?php 
	}else header('Location: books.php');
} else header('Location: login.php');
?>