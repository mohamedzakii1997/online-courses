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

if (isset($_GET['id']))
{
$news=new News();
$news->setnewsid($_GET['id']);
$news=$news->getOne();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>News Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
    </head>
    <body>
    	<?php require 'cnav.php'; ?>
    	<div class="container">
    		<div class="row justify-content-between">
    			<div class="col-lg-5" style="height: 300px;border: 1px solid #ddd;padding:0">
    				<img src="<?php echo $news->getimage();?>" alt='News Image' style='width:100%;height: 100%;'>
    			</div>
    			<h2 class="col-lg-6"><?php echo $news->getheader(); ?> </h2>
    		</div>
    		<br>
    		<p style="color:#808080"><?php echo $news->getdescription(); ?> </p>
    	</div>
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script  src="js/ajax2.js"></script>
	</body>
</html>
<?php 
}else header('Location: home.php');


?>