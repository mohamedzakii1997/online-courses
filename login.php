<?php 
spl_autoload_register(function ($class){
    require 'classes/'.$class.'.inc';
});
  use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
session_start();
if(isset($_COOKIE['clientcookie'])){
    $user=unserialize($_COOKIE['clientcookie']);
     $_SESSION['CLIENT']=$user;
     header("Location: home.php");
     die();


}elseif(isset($_COOKIE['SUPERVISORcookie'])){
    $user=unserialize($_COOKIE['SUPERVISORcookie']);
    $_SESSION['SUPERVISOR']=$user;
     header("Location: home.php");
     die();
}elseif(isset($_COOKIE['Admincookie'])){
    $user=unserialize($_COOKIE['Admincookie']);
     $_SESSION['Admin']=$user;
     header("Location: home.php");
     die();

}elseif(isset($_COOKIE['INSTRUCTORcookie'])){
    
    $user=unserialize($_COOKIE['INSTRUCTORcookie']);
     $_SESSION['INSTRUCTOR']=$user;
     header("Location: home.php");
     die();
}
if(isset($_SESSION["ADMIN"])){
    header("Location: dashboard.php");
}else if (isset($_SESSION['CLIENT'])||isset($_SESSION['INSTRUCTOR'])||isset($_SESSION['SUPERVISOR'])){
    header('Location: home.php');
}
if(isset($_POST["login"])){
    $user = new User(); 
    $user->setUsername($_POST["username"]);
    $user->setPassword($_POST["password"]);
    $user=$user->login();
    if(is_null($user)) {    
        $error="You Enter Invalid Data";   
    }
    elseif($user instanceof Client){
        $_SESSION['CLIENT']=$user;
        if(isset($_POST['remember'])){
          setcookie("clientcookie",serialize($user),time()+60*60*7,"/");   
      }     
        header("Location: home.php");
    }
    elseif($user instanceof Instructor){
        $_SESSION['INSTRUCTOR']=$user;
        if(isset($_POST['remember'])){
         setcookie("INSTRUCTORcookie",serialize($user),time()+60*60*7,"/");
      }
        header("Location: home.php");
    }
    elseif($user instanceof Supervisor){
        $_SESSION['SUPERVISOR']=$user;
        if(isset($_POST['remember'])){    
          setcookie("SUPERVISORcookie",serialize($user),time()+60*60*7,"/");
     }
        header("Location: home.php");
    }
    elseif($user instanceof Admin) {
        $_SESSION['ADMIN']=$user;
        if(isset($_POST['remember'])){
          setcookie("Admincookie",serialize($user),time()+60*60*7,"/");
      }
        header("Location: dashboard.php"); 
    }
}else if (isset($_POST['signup'])){
    $client= new Client();
   if($client->sanitize($_POST['new-username'],$_POST['new-password'],$_POST['email'],$_POST['name'],$_POST['phone'])){
        $client->add();
        $_SESSION['CLIENT']=$client;
        header("Location: home.php");   
    }else
    $error="The Username Used Before Please Enter Anther Username";
}
elseif( isset($_POST['save1'])){
$email=$_POST['email1'];
$code=md5(uniqid(true));

if(filter_var($email,FILTER_VALIDATE_EMAIL)){
    
        $db=Database::getinstance();
        $db->select("SELECT email FROM admins WHERE email =?",array($email),'',0);
      
      $count=$db->rowcount();


if($count==1){ 

$db->update("UPDATE admins SET lost=? WHERE email =?",array($code,$email));
}
      
else {
    $db1=Database::getinstance();
    $db1->select("SELECT email FROM clients WHERE email =?",array($email),'',0);
      
      $count=$db1->rowcount();

if($count==1){ 

$db1->update("UPDATE clients SET lost=? WHERE email = ?",array($code,$email));}

     else {
        $db2=Database::getinstance();
        $db2->select("SELECT email FROM instructors WHERE email = ?",array($email),'',0);
      
      $count=$db2->rowcount();
if($count==1){ 

$db2->update("UPDATE instructors SET lost=? WHERE email =?",array($code,$email));}

else {
    $db3=Database::getinstance();
    $db3->select("SELECT email FROM supervisors WHERE email =?",array($email),'',0);
      
      $count=$db3->rowcount();
if($count==1){ 

$db3->query("UPDATE supervisors SET lost=? WHERE email =?",array($code,$email));}
   
   }
     
 } 

}
$db->close();

if($count==1){
  require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
//create an instance of PHPMailer
    $mail = new PHPMailer();

    //set a host
    $mail->Host = "smtp.gmail.com";
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);  
    //enable SMTP
    $mail->isSMTP();
//$mail->SMTPDebug = 3;
    //set authentication to true
    $mail->SMTPAuth = true;

    //set login details for Gmail account
    $mail->Username = "asmcenter18@gmail.com";
    $mail->Password = "Tigerwa7edbs";

    //set type of protection
    $mail->SMTPSecure = "ssl"; //or sslwe can use TLS

    //set a port
    $mail->Port = 465; //or465 587 if TLS

    //set subject
    $mail->Subject = "Reset Password From ASM Company";

    //set HTML to true
    $mail->isHTML(true);

    //set body
    $mail->Body = "Here Is the Link to Change Your Password <br /><br /> http://localhost/center/updatepass.php?email=$email&code=$code ";

    //add attachment
    //$mail->addAttachment('attachment/fbcover.png', 'Facebook cover.png');

    //set who is sending an email
    $mail->setFrom('asmcenter18@gmail.com');

    //set where we are sending email (recipients)
    $mail->addAddress($email);

    //send an email
    if ($mail->send())
        $mes= "Mail has Been Send Please Check You Email";
    else
        echo $mes=$mail->ErrorInfo;

}else{
    

$mes="You Entered unknown Email";

}


}else{$mes="Email not valid";}



}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
    </head>
    <body class="loginbody">
            <div class="login-container">
                <span class="badge badge-pill badge-primary <?php if(isset($_POST['signup'])) echo 'disableRegister';?>" id="login"><i class="fa fa-sign-in " aria-hidden="true"></i> Login</span>
                <span class="badge badge-pill badge-primary 
                <?php if(isset($_POST['login'])||!isset($_POST['signup'])) echo 'disableRegister';?>" id="signup"><i class="fa fa-user-plus" aria-hidden="true"></i> Sign Up</span>
                <hr />
                <div id="loginform">
                    <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                        <div class="form-group">
                            <label><i class="fa fa-address-card" aria-hidden="true"></i> Username</label>
                            <input type="text" name="username" autocomplete="off" class="form-control" value="<?php if(isset($_POST['username']))
                             echo $_POST['username'];?>" required maxlength="20">
                         </div>
                         <div class="form-group">
                            <label><i class="fa fa-unlock-alt" aria-hidden="true"></i> Password</label>
                            <input type="password" name="password" autocomplete="new-password" class="form-control " value="<?php if(isset($_POST['password'])) echo $_POST['password'] ;?>" required maxlength="30">
                         </div>
                         <div class="form-check"> 
                            <label class="form-check-label">
                                <input type="checkbox" name="remember" value="1" class="form-check-input">
                                     Remember Me</label>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary"><i class="fa fa-sign-in fa-2x" aria-hidden="true"></i></button>
                    </form>
                    <div class="text-center" >
                        <a href="recover.php" data-toggle="modal" data-target="#exampleModal"> Forgot Your Password ?</a><br>
                        <?php if(isset($mes) ) echo $mes;?>
                    </div>
                </div>
                <div id="signupform">
                    <form action="<?php $_SERVER['PHP_SELF']?>" method="post" >
                        <div class="form-group">
                            <label><i class="fa fa-address-card" aria-hidden="true"></i> Username</label>
                            <input type="text" name="new-username" class="form-control" autocomplete="off" value="<?php if(isset($_POST['new-username']))echo $_POST['new-username']; ?>" required maxlength="20" id="new-username">
                            <div class="invalid-feedback"><i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter Username In Range 5-30 Character</div>
                        </div>
                        <div class="form-group">
                            <label><i class="fa fa-unlock-alt" aria-hidden="true"></i> Password</label>
                            <input type="password" name="new-password" class="form-control" autocomplete="new-password" value="<?php if(isset($_POST['new-password']))echo $_POST['new-password'] ;?>" required pattern=".{5,30}" id="new-password">
                            <div class="invalid-feedback"><i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter Password In Range 5-30 Character</div>
                        </div>
                        <div class="form-group">
                            <label><i class="fa fa-user" aria-hidden="true"></i> Full Name</label>
                            <input type="text" name="name"  class="form-control" value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>" maxlength="30" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fa fa-envelope" aria-hidden="true"></i> Email</label>
                            <input type="email" name="email" class="form-control" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fa fa-phone" aria-hidden="true"></i> Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php if(isset($_POST['phone'])) echo $_POST['phone'] ;?>" required>
                        </div> 
                        <button type="submit" name="signup" class="btn btn-primary" id="signupbutton"><i class="fa fa-user-plus fa-2x" aria-hidden="true"></i></button>
                        <div class="signerror invalid-feedback"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please Enter a Valid Data.</div>
                    </form>
                </div>
                <?php if (isset($error)){
                            echo '<div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                    </button>
                                    '.$error.'
                                    </div>';
                        }
                        ?>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                     <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                        <div class="form-group">
                          <label class="forgot"><i class="fa fa-envelope" aria-hidden="true"></i> Email </label>
                          <input  type="email" name="email1"  class="form-control" required="required" placeholder="Please Enter Your Valid Email">
                        </div>
                    <button type="submit" id="sub_error" name="save1" class="btn btn-primary"><i class="fa fa-sign-in" aria-hidden="true"></i> Send New Password</button>

                    </form>
                  </div>
                </div>
              </div>
            </div>
        <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script> 
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script src="js/login.js"></script>
    </body>
</html>