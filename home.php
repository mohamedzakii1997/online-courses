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
if(isset($_GET["action"])&& $_GET["action"]=="logout"){
    if(isset($_SESSION['CLIENT'])){
         $client=$_SESSION['CLIENT'];
         $client->logout();
    }
    elseif(isset($_SESSION['ADMIN'])){
      $admin=$_SESSION['ADMIN'];
      $admin->logout();
    } 
    elseif(isset($_SESSION['SUPERVISOR'])){
      $super=$_SESSION['SUPERVISOR'];
      $super->logout();
    } 
    elseif(isset($_SESSION['INSTRUCTOR'])){
      $ins=$_SESSION['INSTRUCTOR'];
      $ins->logout();
    } 
  }
  if(isset($_POST['submit'])&&isset($_POST['testi'])&&isset($_SESSION['CLIENT'])){
    $client=$_SESSION['CLIENT'];
    $test=new Testimonials();

    $test->setdescription(filter_var($_POST['testi'],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $test->setclientid($client->getId());
    $client->sendObject($test);
    $message='Your Testimonial has been added Thank You For Your Support';
  }
  if(isset($_GET['do'])){
    if( $_GET['do']=='send'){
        if(isset($_SESSION['CLIENT'])){
          if(isset($_POST['send'])&&isset($_POST['message'])){
          $client=$_SESSION['CLIENT'];
          $contact=new Contact_Us();
          $contact->setMessage(filter_var($_POST['message'],FILTER_SANITIZE_FULL_SPECIAL_CHARS));
          $contact->setClientId($client->getId());
          $client->sendObject($contact);
          $message='Message Has Been Sent';
        }

        }else header('Location: login.php');
    }else if($_GET['do']=='edited') $message='Profile Has Been Edited';
  }
?>
<!DOCTYPE html>
<html>
<head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home Page</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
      <!-- ====================================Start Header ============================================================================== -->
        <div id="header-carousel" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <?php $news=News::showAll(); 
              if($news){
              foreach ($news as $key=> $value) {
                echo '<div class="carousel-item ';
                if($key==0) echo 'active';
                echo '">
                      <img class="d-block w-100" src="'.$value->getimage().'" alt="First slide">
                      <div class="slide-overlay"></div>
                      <div class="carousel-caption slidehome">
                <a href="shownews.php?id='.$value->getnewsid().'">'.$value->getheader().'</a>
              </div>
            </div>';
              }
            }

            ?>

          <a class="carousel-control-prev" href="#header-carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#header-carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
          <ol class="carousel-indicators">
            <?php 
              for ($i=0; $i <count($news) ; $i++) { 
               echo '<li data-target="#header-carousel" data-slide-to="'.$i.'" ';
               if($i==0)
               echo 'class="active"';
               echo '></li>';
              }
            ?>
          </ol>
        </div>


        <!-- ===================================================== Start Nav ====================================================== -->
          <?php 
           if(isset($message)){
          echo' <div class="alert alert-success alert-dismissible fade show " role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                    '.$message.' 
                 </div>';
        }
          require 'cnav.php'; 
          ?>
          <!-- ======================================== Start Few Words ================================== -->
          <div class="container section">
            <div class="row justify-content-between">
              <div class="col-lg-6">
                <h2 class="fewWords">Few Words About The Company</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>
              </div>
              <div class="fewImgContainer col-lg-5">
                <img src="images/students2.jpg" alt="Students">
              </div>
            </div>
            <hr>
          </div>
        <!-- ==================================================== Start Features Section ===================================================-->
          <div class="container section">
            <h2>Features</h2>
            <div class="row text-center">
              <div class="feature col-12 col-md-6 col-lg-4">
                <i class="fa fa-graduation-cap fa-5x" aria-hidden="true"></i>
                <h3>Practical Training</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
              </div>
              <div class="feature col-12 col-md-6 col-lg-4">
                <i class="fa fa-university fa-5x" aria-hidden="true"></i>
                <h3>Best Industry leaders</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
              </div>
              <div class="feature col-12 col-md-6 col-lg-4">
                <i class="fa fa-book fa-5x" aria-hidden="true"></i>
                <h3>Book Library &amp; Store</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
              </div>
              <div class="feature col-12 col-md-6 col-lg-4">
                <i class="fa fa-thumbs-up fa-5x" aria-hidden="true"></i>
                <h3>Excellent Resourses</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
              </div>
              <div class="feature col-12 col-md-6 col-lg-4">
                <i class="fa fa-pie-chart fa-5x" aria-hidden="true"></i>
                <h3>Training Methodology</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
              </div>
              <div class="feature col-12 col-md-6 col-lg-4">
                <i class="fa fa-suitcase fa-5x" aria-hidden="true"></i>
                <h3>Develop career</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
              </div>
            </div>
          </div>
          <!-- ============================================================ popular courses ===================================================== -->
          <section class="home-courses">
            <div class="container section">
              <h2>Popular Courses</h2>
                <div class="row justify-content-between">
                  <?php $popular=Course::getTop();
                        if($popular){
                        foreach ($popular as $key => $value) {
                          if($key==3) break;
                          echo '<div class="card" style="width: 20rem;">';
                          echo '<div class="slide-overlay pop" data-id='.$value['courseid'].'>View details</div>';
                          echo '<img class="card-img-top" src="'.$value["image"].'" alt="Card image cap">';
                          echo '<div class="card-body">';
                          echo '<h3 class="card-text">'.$value['name'].'</h3>';
                          $instructor=new Instructor();
                          $instructor->setId($value['myinstructorid']);
                          $instructor=$instructor->getOne();
                          echo ' <p>Instructor:'.$instructor->getName().'</p>';
                          echo '</div></div>';
                        }
                      }
                  ?>
              </div>
              <a class="btn btn-primary d-block viewAllCourses" href="ccourses.php">View all Courses</a>
            </div>
          </section>
            <!--======================================================== Start Life ==============================================================  -->
          <section class="life">
            <div class="text-center life-overlay">
              <p>Change Your Life Today</p>
              <h3>Start With The  Best Development Courses</h3>
              <button type="button" class="btn btn-outline-primary" id="getStarted">Get Started</button>
            </div>
          </section>
            <!-- =========================================================== Start Statistics =================================================== -->
          <div class="container text-center section">
            <h2>Statistics</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>
            <div class="row">
              <div class="statistic col-sm-4 ">
                <span class="statistic-num ">6150</span>
                <p>Student Per Year</p>
              </div>
              <div class="statistic col-sm-4 ">
                <span class="statistic-num"><?php echo Instructor::getCount();?>+</span>
                <p>Certified Teachers</p>
              </div>
              <div class="statistic col-sm-4">
                <span class="statistic-num">95%</span>
                <p>Success</p>
              </div>
            </div>
          </div>
          <!-- ============================================================ Start Testimonials =================================================== -->
          <section class="testimonials text-center">
              <div class="container">
                <h2>Testimonials</h2>
                <p>what people say about our wonderful Center</p>
                <div id="testimonials" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                    <?php $tests=Testimonials::showAll();
                          if(isset($tests)){
                            foreach ($tests as $key => $value) {
                              echo '<div class="carousel-item ';
                              if($key==0) echo "active";
                              echo '">
                        <p>'.$value->getdescription().' </p>
                        <span>'.$value->getclientid().'</span>
                    </div>';
                            }
                          }
                     ?>
                  </div>
                  <ol class="carousel-indicators">
                    <?php 
                      for($i=0;$i<count($tests);$i++){
                        echo '<li data-target="#testimonials" data-slide-to="'.$i.'" class="';
                          if($i==0) echo 'active';
                        echo '"></li>';
                      }
                    ?>
                  </ol>
               </div>
               <?php if(isset($_SESSION['CLIENT'])&&!($_SESSION['CLIENT']->checkTestimonial())){
                echo' <button class="btn btn-primary" style="margin-top:30px" data-toggle="modal" data-target="#exampleModal">Add Testimonal</button>
                      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Testimonal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="?" method="post" id="testimonial">
                      <textarea placeholder="Write Your Testimonial" style="width:100%;height:300px" name="testi"></textarea>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <input type="submit" name="submit" value="Add" class="btn btn-primary" form="testimonial">
                  </div>
                </div>
              </div>
            </div>';
             } ?>
            </div>  
          </section>
          <!-- =========================================================== Start Footer ============================================================ -->
          <footer>
            <div class="container ">
              <div class="row">
                <div class="description1 col-md-6">
                  <h3>Social Media</h3>
                  <i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i>
                  <i class="fa fa-google-plus-square fa-2x" aria-hidden="true"></i>
                  <i class="fa fa-twitter-square fa-2x" aria-hidden="true"></i>
                </div>
                <div class="description col-md-6">
                  <h3>Contact Us</h3>
                  <form method="POST" action="?do=send">
                  <textarea placeholder="Message (You Must Login First)" name="message" required></textarea>
                  <button class="btn btn-primary sendContact" type="submit" name="send"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>
                  </form>
                </div>
              </div>
             <p class="text-center">Copy Rights &copy; 2017 All Rights Reserved Terms of Use and Privacy Policy. Designed by Aymon Team</p>
            </div>
          </footer>
          <button id="top">
            <i class="fa fa-angle-double-up fa-2x" aria-hidden="true"></i>
          </button>
        <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script src="js/dynamic.js"></script>
        <?php if (isset($_SESSION['INSTRUCTOR'])||isset($_SESSION['CLIENT']))
        echo '<script  src="js/ajax2.js"></script>'; ?>
        <script type="text/javascript">
          var courses=document.querySelectorAll('.pop');
          for(var i = 0; i<courses.length ;i++){
            courses[i].onclick=function(){
              location.href='course.php?id='+this.getAttribute('data-id');
            };
          }
        </script>

    </body>
</html>