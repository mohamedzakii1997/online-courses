<?php 
spl_autoload_register(function ($class){
    require 'classes/'.$class.'.inc';
});
session_start();
        if(isset($_COOKIE['clientcookie'])){
    $user=unserialize($_COOKIE['clientcookie']);
     $_SESSION['CLIENT']=$user;

}
elseif(isset($_COOKIE['INSTRUCTORcookie'])){
    $user=unserialize($_COOKIE['INSTRUCTORcookie']);
     $_SESSION['INSTRUCTOR']=$user;

}


 if (isset($_SESSION['INSTRUCTOR'])||isset($_SESSION['CLIENT'])){

if(isset($_SESSION['CLIENT'])) $user=$_SESSION['CLIENT'];
elseif(isset($_SESSION['INSTRUCTOR'])) $user= $_SESSION['INSTRUCTOR'];

echo '
<!DOCTYPE html>
<html>
<head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>all News Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
';
require 'cnav.php'; 

$all= $user->getnotify($user->getId());
$result=$all[0];
foreach ($result as $value) {

	echo '<div class="alert alert-info" role="alert">'.'<a href="shownews.php?id='.$value['newsId'].'" class="alert-link">'.$value['header'].

	'</a></div>';
}


echo '<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script  src="js/ajax2.js"></script>
  </body></html>';
}
else {
    header("Location: home.php");
}
?>