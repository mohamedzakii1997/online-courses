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
        <title>Instructor Page</title>
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
        $instructor= new Instructor();
        $instructor->setId($_GET['id']);
        $instructor=$instructor->getOne();
        ?>
        <div class="container">
            <div class="row">
                <div class="insimgContainer text-center">
                    <img class="imgProfile" src="<?php echo $instructor->getProfileImage(); ?>" alt="There are No profile Image Available">
                </div>
                <div class="courseinfo">
                    <p class="coursep"><span class="defintion">Instructor Name:</span> <?php echo $instructor->getName(); ?></p>
                    <p class="coursep"><span class="defintion">Career:</span> <?php echo $instructor->getCarrer();?></p>
                    <p class="coursep"><span class="defintion">Work Date:</span> <?php echo $instructor->getWorkDate(); ?></p>
                    <p class="coursep"><span class="defintion">Email:</span> <?php echo $instructor->getEmail(); ?></p>
                    <span class="courseCategory"><?php echo $instructor->getRate()."/10";?></span>
                </div>
            </div>
            <h2 class="courseHeader"> Description</h2>
            <p class="courseDescription"><?php echo $instructor->getDescription();?></p>
            <hr>
            <?php if(isset($_SESSION['CLIENT'])){
            if(!$_SESSION['CLIENT']->verifyrate()&&$_SESSION['CLIENT']->verifyins($instructor)==true){ ?>
            <div class="star-rating">
            <input id="star-5" type="radio" name="rating" value="10">
            <label id="star5" for="star-5" title="5 stars">
                    <i class="active fa fa-star" aria-hidden="true"></i>
            </label>
            <input id="star-4" type="radio" name="rating" value="8">
            <label id="star4" for="star-4" title="4 stars">
                    <i class="active fa fa-star" aria-hidden="true"></i>
            </label>
            <input id="star-3" type="radio" name="rating" value="6">
            <label id="star3" for="star-3" title="3 stars">
                    <i class="active fa fa-star" aria-hidden="true"></i>
            </label>
            <input id="star-2" type="radio" name="rating" value="4">
            <label id="star2" for="star-2" title="2 stars">
                    <i class="active fa fa-star" aria-hidden="true"></i>
            </label>
            <input id="star-1" type="radio" name="rating" value="2">
            <label id="star1" for="star-1" title="1 star">
                    <i class="active fa fa-star" aria-hidden="true"></i>
            </label>
        </div>
        <?php  echo '<a href="?id=<?php echo $instructor->getId(); ?>&action=rate"  name="rate" id="rate" class="btn btn-primary registerCourse">Rate Him</a>';           
            ?>
<input type='hidden' id='ins' value="<?php echo $instructor->getId();?>">
<input type='hidden' id='c_id' value="<?php echo $_SESSION['CLIENT']->getId();?>">
        </div>
        <script src="js/rating.js"></script>
         <?php }}?>  
        <script  src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
            document.getElementById('instructorsNav').classList.add('active');

        </script>
<?php if (isset($_SESSION['INSTRUCTOR'])||isset($_SESSION['CLIENT']))
        echo '<script  src="js/ajax2.js"></script>'; ?>
    </body>
</html>