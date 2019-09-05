<?php 
spl_autoload_register(function ($class){
             require 'classes/'.$class.'.inc';
        });
if (!(isset($_GET['id'])) || !(is_numeric($_GET['id']))){
  header('location: home.php');
  die();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Course Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
    </head>
    <body>
    	<?php 
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
    	require 'cnav.php';
    	$course= new Course();
    	$course->setcourseid($_GET['id']);
    	$course=$course->getOne();
		?>
		<div class="container">
			<div class="row">
				<div class="courseimgContainer text-center">
	                <img class="imgProfile" src="<?php echo $course->getimage(); ?>" alt="There are No profile Image Available">
	            </div>
	            <div class="courseinfo">
	            	<p class="coursep"><span class="defintion">Name:</span> <?php echo $course->getname(); ?></p>
	            	<p class="coursep"><span class="defintion">Price:</span> <?php echo $course->getprice();?> &dollar;</p>
	            	<p class="coursep"><span class="defintion">Date:</span> <?php echo $course->getstartDate(); ?></p>
	            	<p class="coursep"><span class="defintion">Available Places:</span> <?php echo $course->getMax(); ?></p>
	            	<p class="coursep"><span class="defintion">Instructor:</span><?php
	            		$instructor= new Instructor();
	            		$instructor->setId($course->getins_id());
	            		$instructor= $instructor->getOne();
                  if($instructor){
	            	 echo '<a href="instructor.php?id='.$instructor->getId().'">'.$instructor->getName(); }?></a></p>
	            	<span class="courseCategory"><?php echo $course->getcategory();?></span><br>
	            </div>
        	</div>
        	<div class="row"> <div class="courseHours text-center"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $course->gethours();?> </div></div>
        	<h2 class="courseHeader"> Description</h2>
        	<p class="courseDescription"><?php echo $course->getdescription();?></p>
        	<hr>
        	<h2 class="courseHeader"> Content</h2>
        	<p class="courseDescription"><?php echo $course->getcontent();?></p>
        	<hr>
        	<h2 class="courseHeader">Lectures Times</h2>
        	<p class="courseDescription"><?php echo $course->getlecturetime();?></p>
        	<hr>
        	<h2 class="courseHeader">Certifications</h2>
        	<p class="courseDescription"><?php echo $course->getcertifications();?></p>
        	<hr>
          <?php if(isset($_SESSION['CLIENT'])){
                  $client=$_SESSION['CLIENT'];
                  if(!$client->checkCourseRegistration($course->getcourseid())){
            ?>
            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
              <input type="hidden" name="cmd" value="_xclick">
              <input type="hidden" name="business" value="center@gmail.com">
              <input type="hidden" name="item_name" value="<?php echo $course->getname(); ?>">
              <input type="hidden" name="amount" value="<?php echo $course->getprice(); ?>">
              <input type="hidden" name="item_number" value=" <?php echo $course->getcourseid(); ?>">
              <input type="hidden" name="notify_url" value="http://127.0.0.1/Center/check.php?check=course">
              <input type="hidden" name="return" value="http://127.0.0.1/Center/ccourses.php">
              <input type="hidden" name="quantity" value="1">
              <input type="hidden" name="currency_code" value="USD">
              <button type="submit" class="btn btn-primary registerCourse"><i class="fa fa-check" aria-hidden="true"></i> Register Now</button>
            </form>
            <?php }} ?>
		</div>
 		<script  src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
            document.getElementById('coursesNav').classList.add('active');
        </script>
        <?php if (isset($_SESSION['INSTRUCTOR'])||isset($_SESSION['CLIENT']))
        echo '<script  src="js/ajax2.js"></script>'; ?>
    </body>
</html>