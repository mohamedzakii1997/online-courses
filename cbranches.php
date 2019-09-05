<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Branches Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
    </head>
    <body>
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
    	require 'cnav.php';
        $branches= Branch::showAll();
         ?>
        <div class="table-responsive" id="show">
              <table class="table table-striped text-center">
              <thead class="thead-inverse ">
              <tr>
                  <th>Location</th>
                  <th>Description</th>
                  <th>Phone</th>
              
              </tr>
              </thead>
              <tbody>
            <?php if($branches) {

                foreach ($branches as  $value) {
                    echo "<tr>";
                    echo '<td>'.$value->getlocation().'</td>';
                    echo '<td>'.$value->getdescription().'</td>';
                    echo '<td>'.$value->getphone().'</td>';
                    echo '</tr>';
                }
            }?>
            </tbody>
        </table>
 		<script  src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
            document.getElementById('branches').classList.add('active');
        </script>
    <?php if (isset($_SESSION['INSTRUCTOR'])||isset($_SESSION['CLIENT']))
        echo '<script  src="js/ajax2.js"></script>'; ?>
    </body>
</html>
