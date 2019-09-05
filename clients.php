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
  $admin=$_SESSION["ADMIN"];
  if(isset($_GET['box'])){
    if(isset($_GET['id'])&&$_GET['box']=='delete'){
        $client=$admin->showclientdata($_GET['id']);
        if(is_file($client->getProfileImage()))unlink($client->getProfileImage());
        $admin->deleteObject($client);
        $Message='1 Client Deleted';
     }elseif($_GET['box']=='edited'){
      $Message='1 Client Edited'; 
      }
 }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Clients Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
    </head>
    <body>
        
        <?php
         require 'nav.php';
         if (isset($Message)){
            echo' <div class="alert alert-success alert-dismissible fade show " role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                    '.$Message.' 
                 </div>';
        }?>
<div class="row rowsearch">
<div class="input-group-btn col-lg-4">
  <input  type="text" name="search" placeholder="Search" class="form-control searchinput" onkeyup="showtable(this.value,'client')">
<button class="btn btn-default" type="submit" style="background-color:  #d9d9d9
;"><i class="fa fa-search" aria-hidden="true" style="color: #f2f2f2";></i>
</button>
</div>
<a class="btn btn-primary addnew" href="#" onclick="getclients(1)"><i class="fa fa-check" aria-hidden="true"></i> Show Verfied Clients</a>
        <a class="btn btn-primary addnew" href="#" onclick="getclients(0)"><i class="fa fa-times" aria-hidden="true"></i> Show Unverfied Clients</a>
</div>
        <div class="table-responsive" id="show">
          <table class="table table-striped text-center">
          <thead class="thead-inverse ">
          <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Username</th>
              <th>Email</th>
              <th>Verify</th>
              <th>Registration Date</th>
              <th>Profile Image</th>
              <th>Options</th>
          </tr>
          </thead>
          <tbody>
          <?php
          $clients=$admin->showObjects('Client');
          if($clients){
          foreach($clients as $client){
              echo "<tr>
                      <td> ". $client->getId()."</td>
                      <td> ". $client->getName()."</td>
                      <td> ". $client->getPhone()."</td>
                      <td> ". $client->getUsername()."</td>
                      <td> ". $client->getEmail()."</td>
                      <td> ". $client->getVerify()."</td>
                      <td> ". $client->getRegistrationDate()."</td>
                      <td><img src='".$client->getProfileImage()."'height='40px' width='50px' alt='none'/></td>
                      <td> <a class='btn btn-primary' href='editclient.php?id=". $client->getId()."'><i class='fa fa-wrench' aria-hidden='true'></i> Edit </a>
                           <a class='btn btn-danger delete' onclick='return confirm(\"Are You Sure You Want To Delete This Client\")' href='?box=delete&id=".$client->getId()."'><i class='fa fa-trash' aria-hidden='true'></i> Delete </a>
                      </td>
                   </tr>";   
          }
        }
          ?>
          </tbody>
          </table>
        </div>
        <a class="btn btn-primary addnew" href="testimonials.php"><i class="fa fa-commenting" aria-hidden="true"></i> Show Testimonials</a>
        <a class="btn btn-primary addnew" href="contact-us.php"><i class="fa fa-envelope-o" aria-hidden="true"></i> Show Contact-Us</a>
        <script  src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/valid.js"></script>
        <script type="text/javascript">
          document.getElementById('client').classList.add('active');
        </script>
    </body>
</html>
<?php
}else header('Location: login.php');
?>




