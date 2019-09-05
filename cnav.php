 <nav class="navbar navbar-expand-lg navbar-dark bg-dark dashNav sticky-top">
          <a class="navbar-brand" href="home.php">ASM School</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mr-auto">
              <?php 
               if (isset($_SESSION['ADMIN'])) {
                  echo '<li class="nav-item">
                <a class="nav-link" href="dashboard.php">Dashboard </a>
              </li>';
               }
              ?>
              <li class="nav-item" id="coursesNav">
                <a class="nav-link" href="ccourses.php">Courses</a>
              </li>
              <li class="nav-item" id="instructorsNav">
                <a class="nav-link" href="cinstructors.php">Instructors</a>
              </li>
              <li class="nav-item" id="booksNav">
                <a class="nav-link" href="cbooks.php">Books</a>
              </li>
              <li class="nav-item" id="branches">
                <a class="nav-link" href="cbranches.php">Branches</a>
              </li>
              <?php 
              if(isset($_SESSION['SUPERVISOR'])){
                ?>
                <li class="nav-item" id="clientNav">
                <a class="nav-link" href="supervisor_client.php">Clients</a>
              </li>

                <?php
              }
             if(isset($_SESSION['INSTRUCTOR'])) 
              echo '<li class="nav-item" id="instructorsNav">
                              <a class="nav-link" href="showmycourses.php">Instructor-Courses</a>
                            </li>';

              if (isset($_SESSION['ADMIN'])||isset($_SESSION['INSTRUCTOR'])||isset($_SESSION['CLIENT'])||isset($_SESSION['SUPERVISOR'])){
                echo '<li class="nav-item dropdown profile">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Profile
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item" href="';
                      if(isset($_SESSION['ADMIN'])) echo 'adminprofile.php';
                      elseif(isset($_SESSION['CLIENT'])) echo 'clientprofile.php';
                      elseif (isset($_SESSION['INSTRUCTOR'])) echo 'instructorprofile.php';
                      elseif (isset($_SESSION['SUPERVISOR'])) echo "supervisorprofile.php";
                      echo '">Edit Profile</a>
                      <a class="dropdown-item" href="changepassword.php">Change Password</a>';
                      if(isset($_SESSION['CLIENT']))     echo '<a class="dropdown-item" href="mycourses.php"> My Courses </a>
                        <a class="dropdown-item" href="mybooks.php"> My Books </a>';
                      echo '<div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="home.php?action=logout">Logout</a>
                    </div>
                  </li>';
              }
              else echo '
              <li class="nav-item login">
                <a class="nav-link" href="login.php">Login</a>
              </li>';
              ?>

 <!-- notifications -->
              <?php   if (isset($_SESSION['INSTRUCTOR'])||isset($_SESSION['CLIENT'])){
                echo '
               <li class="nav-item dropdown notificNav">
                    <a class="nav-link dropdown-toggle sahm" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-bell" aria-hidden="true"></i>
                      <span class="button__badge" id="sp"></span>
                    </a>
                    <div class="dropdown-menu" style="right:0px;left:unset" aria-labelledby="navbarDropdownMenuLink1" id="mess">
                      <a class="dropdown-item" href="adminprofile.php">Edit</a>
                      <a class="dropdown-item" href="changepassword.php">Password</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="dashboard.php?action=logout">Logout</a>
                    </div>
                  </li>';
}?><!-- end notify -->

<input type="hidden" id="userid" value="<?php  if (isset($_SESSION['INSTRUCTOR'])||isset($_SESSION['CLIENT'])){
if(isset($_SESSION['CLIENT']))
echo $_SESSION['CLIENT']->getId();
elseif(isset($_SESSION['INSTRUCTOR'])) echo $_SESSION['INSTRUCTOR']->getId();
}
?>">

<?php 
if (isset($_SESSION['INSTRUCTOR'])){

  echo '<input type="hidden" id="role" value="instructor">';
}
elseif(isset($_SESSION['CLIENT'])){
    echo '<input type="hidden" id="role" value="client">';
}

?>




            </ul>
          </div>
        </nav>