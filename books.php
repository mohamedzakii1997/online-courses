<?php
spl_autoload_register(function ($class){
    require 'classes/'.$class.'.inc';
});
session_start();
if(isset($_COOKIE['Admincookie'])){
    $user=unserialize($_COOKIE['Admincookie']);
     $_SESSION['Admin']=$user;
}
if(isset($_SESSION["ADMIN"])){
  $admin=$_SESSION["ADMIN"];
  if(isset($_GET['box'])){
    if(isset($_GET['id'])&&$_GET['box']=='delete'){
        $book=$admin->showbook($_GET['id']);
        if(is_file($book->getImg())) unlink($book->getImg());

        $admin->deleteObject($book);
        $Message='1 Book Deleted';
     }elseif($_GET['box']=='edited'){
      $Message='1 Book Edited'; 
      }elseif($_GET['box']=='added'){
        $Message='1 Book Added';
      }
 }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Book Page</title>
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
  <input  type="text" name="search" placeholder="Search" class="form-control searchinput" onkeyup="showtable(this.value,'book')">
<button class="btn btn-default" type="submit" style="background-color:  #d9d9d9
;"><i class="fa fa-search" aria-hidden="true" style="color: #f2f2f2";></i>
</button>
</div>
</div>
        <div class="table-responsive" id="show">
          <table class="table table-striped text-center">
          <thead class="thead-inverse ">
          <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Price</th>
              <th>Category</th>
              <th>Edition</th>
              <th>Course Id</th>
              <th>Cover Image</th>
              <th>Options</th>
          
          </tr>
          </thead>
          <tbody>
          <?php
          $books=$admin->showObjects('Book');
          if($books){
          for($i=0;$i<count($books);$i++){
              echo "<tr>
                      <td> ". $books[$i]->getId()."</td>                      
                      <td> ". $books[$i]->getName()."</td>
                      <td> ". $books[$i]->getPrice()."</td>
                      <td> ". $books[$i]->getCategory()."</td>
                      <td> ". $books[$i]->getEdition()."</td>
                      <td> ". $books[$i]->getCourseId()."</td>
                      <td><img src='".$books[$i]->getImg()."'height='40px' width='50px' alt='none'/></td>
                      <td> <a class='btn btn-primary' href='addeditbook.php?do=edit&id=". $books[$i]->getId()."'><i class='fa fa-wrench' aria-hidden='true'></i> Edit </a>
                           <a class='btn btn-danger delete' onclick='return confirm(\"Are You Sure You Want To Delete\")' href='?box=delete&id=".$books[$i]->getId()."'><i class='fa fa-trash' aria-hidden='true'></i> Delete </a>
                      </td>
                   </tr>";   
          }
        }
          ?>
          </tbody>
          </table>
        </div>
        <a href='addeditbook.php?do=add' class='btn btn-primary addnew  '><i class="fa fa-plus" aria-hidden="true"></i> Add New Book </a>
        <script  src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/valid.js"></script>
        <script type="text/javascript">
          document.getElementById('book').classList.add('active');
        </script>
    </body>
</html>
<?php
}else header('Location: login.php');
?>




