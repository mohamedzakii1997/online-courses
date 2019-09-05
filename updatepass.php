<?php 
        spl_autoload_register(function ($class){
             require 'classes/'.$class.'.inc';
        });
        
        if(isset($_GET['email'])&& isset($_GET['code'])&&($_GET['code']!="")){

            $code=$_GET['code'];

            $email=$_GET['email'];
            $tablename='';
            $db=Database::getinstance();
            $user= $db->select("SELECT * FROM admins WHERE email=? AND lost=?",array($email,$code),'Admin',1 );
            if($db->rowcount()){
                
                $tablename='admins';
                 }
             else    
{
    $db2=Database::getinstance();
$user = $db2->select("SELECT * FROM clients WHERE email=? AND lost=?",array($email,$code),'Client',1 );

            if($db2->rowcount()){
                $tablename='clients';
            }
            else{
                $db3=Database::getinstance();
                $user= $db3->select("SELECT * FROM instructors WHERE email=? AND lost=?",array($email,$code),'Instructor',1);

            if($db3->rowcount()){$tablename='instructors';}
            else{
                $db4=Database::getinstance();
                $user= $db4->select("SELECT * FROM supervisors WHERE email=? AND lost=?",array($email,$code),'Supervisor',1);

        if($db4->rowcount()) {$tablename='supervisors';}
            
        }


            }


}
$db->close();
                if(isset($_POST['password'])&&isset($_POST['repassword'])&&$user ){
                        $password=$_POST['password'];
                        $repassword=$_POST['repassword'];
                        if($password===$repassword){
                            $user->changePassword($password,$tablename);
                            $user->resetLost($tablename);
                            $message='Password Changed';
                                      
                        }else $error='You Didn\'t Enter the Same Password';
                }

        ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Change Password Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
    </head>
    <body class="loginbody">
            <div class="login-container">
                <a href="home.php" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i> Back to Home</a>
                <hr>
                <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                        <div class="form-group">
                            <label><i class="fa fa-unlock" aria-hidden="true"></i> New Password</label>
                            <input  type="password" name="password"  class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label><i class="fa fa-unlock" aria-hidden="true"></i> Retype your password</label>
                            <input  type="password" name="repassword"  class="form-control" required="required">
                        </div>




                <button type="submit" name="create" value="submit" class="btn btn-primary"><i class="fa fa-sign-in" aria-hidden="true"></i> confirm</button>

                </form>
                <?php if (isset($error)){
                            echo '<div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                    </button>
                                    '.$error.'
                                    </div>';
                        }elseif(isset($message)){
                            echo '<div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                    </button>
                                    '.$message.'
                                    </div>';
                        }
                        ?>
            </div>
        <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script> 
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
    </body>
</html>
<?php }else header('Location: home.php'); ?>