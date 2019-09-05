<?php
spl_autoload_register(function ($class){
    require 'classes/'.$class.'.inc';
});
session_start();

 if(isset($_COOKIE['SUPERVISORcookie'])){
    $user=unserialize($_COOKIE['SUPERVISORcookie']);
     $_SESSION['SUPERVISOR']=$user;

}
if(isset($_SESSION["SUPERVISOR"])){
  $supervisor=$_SESSION["SUPERVISOR"];
  if(isset($_GET['id'])&&isset($_POST['coursesubmit'])&&isset($_POST['course']))
  {
    $client=new Client();
    $client->setId($_GET['id']);
    $course=new Course();
    $course->setcourseId($_POST['course']);
    $supervisor->insertclientcourse($client,$course);
    header('Location: home.php');
  }
  if(isset($_GET['id'])&&isset($_POST['booksubmit']))
  {
    $client=new Client();
    $client->setId($_GET['id']);   
    $book=new Book();
    $book->setId($_POST['book']);
    $supervisor->insertclientbook($client,$book);
    header('Location: home.php');
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
    		require 'cnav.php';
    ?>
        <div class="table-responsive" id="show">
          <table class="table table-striped text-center">
          <thead class="thead-inverse ">
          <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Username</th>
              <th>Options</th>
          </tr>
          </thead>
          <tbody>
          <?php
          $clients=$supervisor->showclientsdata();
          $books=$supervisor->showbooks();
          $courses=$supervisor->showcourses();
          if($clients){
          foreach($clients as $client){
            echo "<tr>
                    <td id='clientid'> ".$client->getId()."</td>
                    <td> ". $client->getName()."</td>
                    <td> ". $client->getUsername()."</td>
                    <td> <button  class='btn btn-primary ' data-toggle='modal' data-target='#courseModel' onclick='getunRegisteredCourses(".$client->getId().")'><i class='fa fa-plus' aria-hidden='true'></i> Add Course</button>
                         <button  class='btn btn-primary ' data-toggle='modal' data-target='#bookModel' onclick='getClient(".$client->getId().")'><i class='fa fa-plus' aria-hidden='true'></i> Add Book</button>
                    </td>
                 </tr>";   
        }
      }
          ?>
          </tbody>
          </table>
          <div class="modal fade" id="courseModel" tabindex="-1" role="dialog" aria-labelledby="courseLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="courseLabel">Add New Course</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id='courseform' method='POST' action="" >
                        <label>Select Course </label>
                        <select name='course' id="show1">
                        </select>
                </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="coursesubmit" value="Add Now" class="btn btn-primary" form="courseform">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal fade" id="bookModel" tabindex="-1" role="dialog" aria-labelledby="bookLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="bookLabel">Add New Book</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id='bookform' method='POST' action="">
                        <label>Select Book </label>
                        <select name='book'>
                            <?php  foreach ($books as $boo)
                              echo "<option value=".$boo->getId().">".$boo->getname()."</option>";
                          ?>
                        </select>
                </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="booksubmit" value="Add Now" class="btn btn-primary" form="bookform">
                  </div>
                </div>
              </div>
            </div>

        </div>
        <script  src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
          function getunRegisteredCourses(id){
            document.getElementById('courseform').setAttribute('action','?id='+id);
 xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("show1").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET","notify.php?action=getcourses&id="+id,true);
  xhttp.send();


}
function getClient(id){
  document.getElementById('bookform').setAttribute('action','?id='+id);
}

        </script>
    </body>
</html>
<?php
}else header('Location: login.php');
?>




