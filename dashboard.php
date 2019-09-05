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
    $admin=$_SESSION['ADMIN'];
	if(isset($_GET["action"])&& $_GET["action"]=="logout"){
	$admin->logout();
	header("Location: home.php");
	}
	if(isset($_GET['do']) && $_GET['do']=='backup'){
	$result=$admin->backupDatabase();

	if($result==false){$error='sorry something wromg happen when try to backup DB';}
	else{
      if(is_file('backup2.sql')){
	  $filepath='backup2.sql';
      header('Content-Description: File Transfer');
      header("Content-Type: application/sql"); 
      header('Content-Disposition: attachment; filename=backup2.sql');
      header('Content-Transfer-Encoding: binary'); 
      header('Content-Length: ' . filesize('backup2.sql'));
      ob_clean();
      readfile('backup2.sql');
}
             }
                 
}	
?>
<!DOCTYPE html>
<html>
	<head>
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Dashboard</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	    <link rel="stylesheet" type="text/css" href="css/style.css">
	    <link rel="stylesheet" href="css/font-awesome.min.css">
	</head>
	<body>
		<?php 
			require 'nav.php';
			if(isset($_GET['do'])&& $_GET['do']=='edited'){
				echo' <div class="alert alert-success alert-dismissible fade show " role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                    Profile edited successfully 
                 </div>';
			}
		?>
		<div class="container dashboardContainer countStatistics">
			<div class="row">
				<a href='?do=backup' class='btn btn-primary'><i class="fa fa-cloud-download" aria-hidden="true"></i> Download Backup</a>
				<br>
			</div>
			<hr />
			<h2>Global Statistics</h2>
			<div class="row justify-content-between text-center">
				<div class='total col-lg-3 countClient'>
					<span><?php echo $admin->getCount('Client'); ?></span>
					<p>Clients</p>
				</div>
				<div class='total col-lg-3 countInstructor'>
					<span ><?php echo $admin->getCount('Instructor'); ?></span>
					<p>Instructor</p>
				</div>
				<div class='total col-lg-3 countSupervisor'>
					<span><?php echo $admin->getCount('Supervisor'); ?></span>
					<p>Supervisors</p>
				</div>
			</div>
			<div class="row justify-content-between text-center">
				<div class='total col-lg-3 countBook'>
					<span><?php echo $admin->getCount('Book');?></span>
					<p>Book</p>
				</div>
				<div class='total col-lg-3 countCourse'>
					<span ><?php echo $admin->getCount('Course'); ?></span>
					<p>Course</p>
				</div>
				<div class='total col-lg-3 countNews'>
					<span><?php echo $admin->getCount('News'); ?></span>
					<p>News</p>
				</div>
			</div>
		</div>

		<div class="container dashboardContainer">
			<hr>
			<div class="row justify-content-center">
				<div class="btn-group dashbtngroup buttonGroups" role="group">
					<button class="btn btn-primary showCollapse " type="button" data-toggle="collapse" data-target="#books" aria-expanded="false" aria-controls="collapseExample">
					     Last 10 Book Purchase Transactions
					</button>
					<button class="btn btn-primary showCollapse " type="button" data-toggle="collapse" data-target="#courses" aria-expanded="false" aria-controls="collapseExample">
					     Last 10 Course Register Transactions
					</button>
					<button class="btn btn-primary showCollapse" type="button" data-toggle="collapse" data-target="#clients" aria-expanded="false" aria-controls="collapseExample">
					     Last 10 Client Signup 
				</button>
				</div>
			</div>
			<div class="collapse" id="books">
			  <div class="card card-body">
			    <div class="table-responsive">
					<table class="table table-striped text-center">
						<thead class="thead-inverse ">
							<tr>
								<th>Book ID</th>
								<th>Client ID</th>
								<th>Book Name</th>
								<th>Category</th>
								<th>Price</th>
								<th>Date</th>
								<th>Image</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$bookData=$admin->getBookTransactions();
							if($bookData){
							foreach ($bookData as $row) {
								echo '<tr>
								<td>'.$row['bookid'].'</td>
								<td>'.$row['clientid'].'</td>
								<td>'.$row['name'].'</td>
								<td>'.$row['category'].'</td>
								<td>'.$row['price'].'</td>
								<td>'.$row['purchasedate'].'</td>
								<td><img src="'.$row['coverImage'].'" height="40px" width="50px" alt="none"></td>
								</tr>';
							}
						}
							?>
							
						</tbody>
					 </table>
				</div>
			  </div>
			</div>
			<div class="collapse" id="courses">
			  <div class="card card-body">
			    <div class="table-responsive">
					<table class="table table-striped text-center">
						<thead class="thead-inverse ">
							<tr>
								<th>Course ID</th>
								<th>Client ID</th>
								<th>Course Name</th>
								<th>Category</th>
								<th>Price</th>
								<th>Date</th>
								<th>Image</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							$courseData= $admin->getCourseTransactions();
							if($courseData){
							foreach ($courseData as  $row) {
								echo '<tr>
								<td>'.$row['courseid'].'</td>
								<td>'.$row['clientid'].'</td>
								<td>'.$row['name'].'</td>
								<td>'.$row['category'].'</td>
								<td>'.$row['price'].'</td>
								<td>'.$row['registerdate'].'</td>
								<td><img src="'.$row['image'].'" height="40px" width="50px" alt="none"></td>
								</tr>';
							}
						}
						?>
						</tbody>
					 </table>
				</div>
			  </div>
			</div>
			<div class="collapse" id="clients">
			  <div class="card card-body">
			    <div class="table-responsive">
					<table class="table table-striped text-center">
						<thead class="thead-inverse ">
							<tr>
								<th>ID</th>
								<th>Client Name</th>
								<th>Username</th>
								<th>Email</th>
								<th>Date</th>
								<th>Image</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$clientData=$admin->getClientRegistrations();
								if($clientData){
								foreach ($clientData as $row) {
									echo '<tr>
									<td>'.$row['id'].'</td>
									<td>'.$row['name'].'</td>
									<td>'.$row['username'].'</td>
									<td>'.$row['email'].'</td>
									<td>'.$row['registrationDate'].'</td>
									<td><img src="'.$row['profileImage'].'" height="40px" width="50px" alt="none"></td>
									</tr>';
								}
							}
							?>
						</tbody>
					 </table>
				</div>
			  </div>
			</div>
			<hr>
			<h2>Ranking Statistics</h2>
			<div class="row">
				  <div class="col-4">
				    <div class="list-group" id="list-tab" role="tablist">
				      <a class="list-group-item list-group-item-action active" id="list-book-list" data-toggle="list" href="#list-book" role="tab" aria-controls="home">Most Sold Books</a>
				      <a class="list-group-item list-group-item-action" id="list-instructor-list" data-toggle="list" href="#list-instructor" role="tab" aria-controls="profile">Top Rated Instructors</a>
				      <a class="list-group-item list-group-item-action" id="list-course-list" data-toggle="list" href="#list-course" role="tab" aria-controls="settings">Most Active Courses</a>
				    </div>
				  </div>
				  <div class="col-8">
				    <div class="tab-content" id="nav-tabContent">
				      <div class="tab-pane fade show active" id="list-book" role="tabpanel" aria-labelledby="list-book-list">
				      	<div class="table-responsive">
					<table class="table table-striped text-center">
						<thead class="thead-inverse ">
							<tr>
								<th>Book ID</th>
								<th>Book Name</th>
								<th>Price</th>
								<th>Count</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$bookData=$admin->getTopBooks();
							if($bookData){
							foreach ($bookData as $row) {
								echo '<tr>
								<td>'.$row['bookid'].'</td>
								<td>'.$row['name'].'</td>
								<td>'.$row['price'].'</td>
								<td>'.$row['count'].'</td>
								</tr>';
							}}
							?>
							
						</tbody>
					 </table>
				</div>
				      </div>
				      <div class="tab-pane fade" id="list-instructor" role="tabpanel" aria-labelledby="list-instructor-list">
				      	<div class="table-responsive">
					<table class="table table-striped text-center">
						<thead class="thead-inverse ">
							<tr>
								<th>Instructor Id</th>
								<th>Name</th>
								<th>Salary</th>
								<th>Rate</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$insData=$admin->getTopInstructors();
							if($insData){
							foreach ($insData as $row) {
								echo '<tr>
								<td>'.$row['id'].'</td>
								<td>'.$row['name'].'</td>
								<td>'.$row['salary'].'</td>
								<td>'.$row['rate'].'</td>
								</tr>';
							}}
							?>
							
						</tbody>
					 </table>
				</div>
				      </div>
				      <div class="tab-pane fade" id="list-course" role="tabpanel" aria-labelledby="list-course-list">
				      	<div class="table-responsive">
					<table class="table table-striped text-center">
						<thead class="thead-inverse ">
							<tr>
								<th>Course Id</th>
								<th>Name</th>
								<th>price</th>
								<th>Instructor Id</th>
								<th>Count</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$insData=$admin->getTopCourses();
							if($insData){
							foreach ($insData as $row) {
								echo '<tr>
								<td>'.$row['courseid'].'</td>
								<td>'.$row['name'].'</td>
								<td>'.$row['price'].'</td>
								<td>'.$row['myinstructorid'].'</td>
								<td>'.$row['COUNT(*)'].'</td>

								</tr>';
							}}
							?>
							
						</tbody>
					 </table>
				</div>
				      </div>
				    </div>
				  </div>
				</div>
			<hr>
			<h2 class="dashheader">Revenues Statistics</h2>
			<p class="totalrev">Total Revenues: <span><?php echo $admin->calculateRevenue();?></span></p>
			<div class="row justify-content-between">
				<div id="chart_div"></div>
				<div id="chart_div2"></div>
				<div id="chart_div3"></div>
			</div>
		</div>
		<script  src="js/jquery-3.2.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
          document.getElementById('dashboard').classList.add('active');
    		var buttonGroups= document.querySelectorAll('.buttonGroups button');
    		for(i=0;i<buttonGroups.length;i++){
    			buttonGroups[i].onclick=function(){
    				this.classList.toggle('active');
    			};
    		}

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});


      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);
       google.charts.setOnLoadCallback(drawChart2);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'component');
        data.addColumn('number', 'revenue');
        data.addRows([
          ['Books', <?php echo json_encode(intval($admin->getBookRevenues()),JSON_HEX_TAG); ?>],
          ['Courses', <?php echo json_encode(intval($admin->getCourseRevenues()),JSON_HEX_TAG); ?>]
        ]);
        var options={
        	slices:{
        		0:{color:'#2980b9'},
        		1:{color:'#f39c12'}
        	}
        };
        // Set chart options
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data,options);
      }
      //================================================================= function 2================================================================
      function drawChart2() {
      var data = google.visualization.arrayToDataTable([
        ['Component', 'Revenue', { role: 'style' } ],
        ['Books',<?php echo json_encode(intval($admin->getBookRevenues())); ?>, 'color: #2980b9'],
        ['Courses',<?php echo json_encode(intval($admin->getCourseRevenues())); ?>, 'color: #f39c12']
      ]);
      var visualization = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
      visualization.draw(data);

  	 }
  	//================================================================ function 3 =====================================================
  	 google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart3);

      function drawChart3() {
        var data = google.visualization.arrayToDataTable([
        	<?php 
        	?>
          ['Month', 'Revenue'],
          [<?php echo json_encode(date("Y/m",time()-(5*30*24*60*60))); 
          		
          ?>,  <?php echo json_encode($admin->getRevenuesAtMonth(date('Y-m-d',time()-(5*30*24*60*60)))); ?>],
          [<?php
           echo json_encode(date("Y/m",time()-(4*30*24*60*60))); 
          		
          ?>,  <?php echo json_encode($admin->getRevenuesAtMonth(date('Y-m-d',time()-(4*30*24*60*60)))); ?>],
          [<?php
           echo json_encode(date("Y/m",time()-(3*30*24*60*60))); 
          ?>,  <?php echo json_encode($admin->getRevenuesAtMonth(date('Y-m-d',time()-(3*30*24*60*60)))); ?>],
          [<?php 
          	echo json_encode(date("Y/m",time()-(2*30*24*60*60))); 
          ?>,  <?php echo json_encode($admin->getRevenuesAtMonth(date('Y-m-d',time()-(2*30*24*60*60)))); ?>],
          [<?php
           echo json_encode(date("Y/m",time()-(30*24*60*60))); 
          ?>,  <?php echo json_encode($admin->getRevenuesAtMonth(date('Y-m-d',time()-(30*24*60*60)))); ?>],
          [<?php 
          	echo json_encode(date("Y/m",time())); 
          ?>,  <?php echo json_encode($admin->getRevenuesAtMonth(date('Y-m-d',time()))); ?>]
        ]);

        var options = {
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div3'));
        chart.draw(data, options);
      }
    </script>
    </body>
</html>
<?php 
        }else{
		  header("Location: login.php") ; 
		} 
?>
