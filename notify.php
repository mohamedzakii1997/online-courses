<?php 
spl_autoload_register(function ($class){
    require 'classes/'.$class.'.inc';
});
if(isset($_GET['q']) && $_GET['q']=='message'){
$data=array();
$output='';

if($_GET['type'] == 'client'){
$client= new Client ();
$all= $client->getnotify($_GET['id']);
 }elseif($_GET['type'] == 'instructor'){
  $ins=new Instructor();
  $all= $ins->getnotify($_GET['id']);
 }

 
$arr=$all[0];
foreach ($arr as $value) {
	$out=
  '
	 <a class="dropdown-item" href="shownews.php?id='.$value['newsId'].'">
       	 '.$value['header'].'</a>
     
 	';
  $output .= $out;
} 
$output.='<div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="allnews.php">See All</a>';

$data[]=$output;
if($all[1]!= 0)
$data[]=$all[1];
else $data[]='';

 echo json_encode($data);
$client=null;
}
elseif(isset($_GET['q']) && $_GET['q']=='update'){
if($_GET['type'] == 'client'){
$client= new Client ();
$client->update_unseen($_GET['id']);
$client=null;}

elseif($_GET['type'] == 'instructor'){
$ins=new Instructor();
$ins->update_unseen($_GET['id']);
$ins=null;
}
}
elseif(isset($_GET['action']) && $_GET['action'] == 'rate' ){
  $client=new Client();
  $instructor = new Instructor ();
  $instructor->setId($_GET['id']);
   $instructor->setRate($_GET['rate']);
   $client->setId($_GET['c_id']);
   $client->rateInstructor($instructor);
  $client->updateinsrate($instructor);
  $instructor=null;
  $client=null;
}
elseif(isset($_GET['action']) && $_GET['action'] == 'showstudent'){
	$ins=new Instructor();
	$result=$ins->showmystudents($_GET['id']);
    if($result==0){echo 'You Dont Have Any Student Yet';}
    else{

    echo '<table class="table table-striped text-center">
	    <thead class="thead-inverse ">
			<tr>
			    <th>email</th>
				<th>Name</th>
			</thead>

		<tbody>';

    	foreach ($result as  $value) {
    		# ...
        echo '<tr>';
    	echo '<td>'.$value['name'].'</td>';
    	echo '<td>'.$value['email'].'</td>';
    	echo '</tr>';	
    	}
    	echo '
</tbody>		 		
	</table>	
    	';
    }

   } elseif (isset($_GET['action']) && $_GET['action'] == 'download') {
  $client= new Client();
  $result=$client->showdownloads($_GET['c_id']);
  $arr=explode(',', $result);
    foreach ($arr as $value) {
      echo ' <div class="panel panel-default" style="margin-bottom: 10px;">
                   <div class="panel-body">'.
                   basename($value)
                   .
                   '
                   <a href="?filename='.basename($value).'" class="btn btn-primary addnew" style="float:right"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
                      </div>
                   </div>';
    }
 

}elseif(isset($_GET['action'])&& $_GET['action']=='getcourses'&& isset($_GET['id'])){
  $client= new Client();
  $client->setId($_GET['id']);
  $courses=$client->getUnRegisteredCourses();
  if($courses){
    foreach ($courses as $cou)
    echo "<option value=".$cou['courseId'].">".$cou['name']."</option>";
  }
}
?>