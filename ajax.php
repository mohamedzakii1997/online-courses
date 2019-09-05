<?php
spl_autoload_register(function ($class){
    require 'classes/'.$class.'.inc';
});

if(isset($_GET['q']) && $_GET['q'] == 'verify'){

$admin=new Admin();
$clients=$admin->get_verify_unverify_clients($_GET['flag']);
echo '
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
';
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
                      <td><img src='".$client->getProfileImage()."'height='40px' width='50px'/></td>
                      <td> <a class='btn btn-primary' href='editclient.php?id=". $client->getId()."'><i class='fa fa-wrench' aria-hidden='true'></i> Edit </a>
                           <a class='btn btn-danger delete' onclick='return confirm(\"Are You Sure You Want To Delete This Client\")' href='?box=delete&id=".$client->getId()."'><i class='fa fa-trash' aria-hidden='true'></i> Delete </a>
                      </td>
                   </tr>";   
          }
        }
      echo "</tbody>        
            </table>";    
}




//============= request for course table==============================

elseif (isset($_GET['q']) && $_GET['type'] == 'course') {
$admn = new  Admin();
echo '
  <table class="table table-striped text-center">
      <thead class="thead-inverse">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Hours</th>
        <th>Price</th>
        <th>Start Date</th>
        <th>Category</th>
        <th>State</th>
        <th>Image</th>
        <th>Options</th>
      </tr>
    </thead>
    <tbody>
';
if( $_GET['q'] == 'sp'){
$key=$_GET['key'];
$all_courses=$admn->search('Course',$key);

if(!is_array($all_courses)){
          if(!empty($all_courses)){
           echo "<tr>";
   echo "<td>".$all_courses->getcourseid()."</td>";
    echo "<td>".$all_courses->getname()."</td>";
    echo "<td>".$all_courses->gethours()."</td>";
    echo "<td>".$all_courses->getprice()."</td>";
    echo "<td>".$all_courses->getstartDate()."</td>";
    echo "<td>".$all_courses->getCategory()."</td>";
    echo "<td>";
      if($all_courses->getState()) echo "Active";
      else echo "UnActive";
    echo "</td>";
    echo "<td><img src='".$all_courses->getimage()."' width='60px' height='40px'/></td>";
    echo "<td><a href='addeditcourse.php?do=edit&id=".$all_courses->getcourseid()."' class='btn btn-primary'><i class='fa fa-wrench' aria-hidden='true'></i> Edit</a> ";
    echo "<a href='?do=delete&id=".$all_courses->getcourseid()."' onclick='return confirm(\"Are You Sure You Want To Delete This Course\")' class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>";
echo "</tr>";

          }
}
else{
  if($all_courses){
  foreach ($all_courses as $obj) {
   echo "<tr>";
  echo "<td>".$obj->getcourseid()."</td>";
    echo "<td>".$obj->getname()."</td>";
    echo "<td>".$obj->gethours()."</td>";
    echo "<td>".$obj->getprice()."</td>";
    echo "<td>".$obj->getstartDate()."</td>";
    echo "<td>".$obj->getCategory()."</td>";
    echo "<td>";
      if($obj->getState()) echo "Active";
      else echo "UnActive";
    echo "</td>";
    echo "<td><img src='".$obj->getimage()."' width='60px' height='40px'/></td>";
    echo "<td><a href='addeditcourse.php?do=edit&id=".$obj->getcourseid()."' class='btn btn-primary'><i class='fa fa-wrench' aria-hidden='true'></i> Edit</a> ";
    echo "<a href='?do=delete&id=".$obj->getcourseid()."' onclick='return confirm(\"Are You Sure You Want To Delete This Course\")' class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>";
echo "</tr>";

}
}
}



}else{
    $all_courses=$admn->showObjects('Course');
  foreach ($all_courses as $obj) {
   echo "<tr>";
  echo "<td>".$obj->getcourseid()."</td>";
    echo "<td>".$obj->getname()."</td>";
    echo "<td>".$obj->gethours()."</td>";
    echo "<td>".$obj->getprice()."</td>";
    echo "<td>".$obj->getstartDate()."</td>";
    echo "<td>".$obj->getCategory()."</td>";
    echo "<td>";
      if($obj->getState()) echo "Active";
      else echo "UnActive";
    echo "</td>";
    echo "<td><img src='".$obj->getimage()."' width='60px' height='40px'/></td>";
    echo "<td><a href='addeditcourse.php?do=edit&id=".$obj->getcourseid()."' class='btn btn-primary'><i class='fa fa-wrench' aria-hidden='true'></i> Edit</a> ";
    echo "<a href='?do=delete&id=".$obj->getcourseid()."' onclick='return confirm(\"Are You Sure You Want To Delete This Course\")' class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>";
echo "</tr>";
}


echo "</tbody>		 		
	</table>";
$admn=null;
}

}


//================================request for intructor table===========================

elseif (isset($_GET['q']) && $_GET['type'] == 'instructor') {
$admin = new  Admin();
echo '
<table class="table table-striped text-center">
<thead class="thead-inverse ">
<tr>
<th>ID</th>
<th>Name</th>
<th>Salary</th>
<th>Work Date</th>
<th>Phone</th>
<th>Image</th>
<th>Options</th>
</tr>
</thead>
<tbody>
';
if($_GET['q'] == 'sp'){
$key=$_GET['key'];
$ins_info=$admin->search('Instructor',$key);
if(!is_array($ins_info)){
          if(!empty($ins_info)){
        echo "<tr>";
         echo "<td>" . $ins_info->getId(). "</td>";
          echo "<td>" . $ins_info->getName(). "</td>";
          echo "<td>" .$ins_info->getSalary(). "</td>";
          echo "<td>" . $ins_info->getWorkdate(). "</td>";
          echo "<td>" . $ins_info->getphone() . "</td>";
          echo "<td><img src='".$ins_info->getProfileImage()."'height='40px' width='50px'/></td>";
          echo "<td>  <a href='addeditinstructor.php?do=edit&id=".$ins_info->getId()."'class='btn btn-primary'><i class='fa fa-wrench' aria-hidden='true'></i>  Edit </a> 
                 <a href='?do=delete&id=".$ins_info->getId()." 'class='btn btn-danger' onclick='return confirm(\"Are You Sure You Want To Delete This Instructor\")'><i class='fa fa-trash' aria-hidden='true'></i> Delete </a> 
           </td>";

        echo"</tr>";
}
}
else{
  if($ins_info){
foreach ($ins_info as $obj) {
  # code...
          echo "<tr>";
           echo "<td>" . $obj->getId(). "</td>";
            echo "<td>" . $obj->getName(). "</td>";
            echo "<td>" .$obj->getSalary(). "</td>";
            echo "<td>" . $obj->getWorkdate(). "</td>";
            echo "<td>" . $obj->getphone() . "</td>";
            echo "<td><img src='".$obj->getProfileImage()."'height='40px' width='50px'/></td>";
            echo "<td>  <a href='addeditinstructor.php?do=edit&id=".$obj->getId()."'class='btn btn-primary'><i class='fa fa-wrench' aria-hidden='true'></i>  Edit </a> 
                   <a href='?do=delete&id=".$obj->getId()." 'class='btn btn-danger' onclick='return confirm(\"Are You Sure You Want To Delete This Instructor\")'><i class='fa fa-trash' aria-hidden='true'></i> Delete </a> 
             </td>";
          echo"</tr>";

}
}
}
}
else{
$ins_info=$admin->showObjects('Instructor');
if($ins_info){
foreach ($ins_info as $obj) {
  # code...
echo "<tr>";
 echo "<td>" . $obj->getId(). "</td>";
  echo "<td>" . $obj->getName(). "</td>";
  echo "<td>" .$obj->getSalary(). "</td>";
  echo "<td>" . $obj->getWorkdate(). "</td>";
  echo "<td>" . $obj->getphone() . "</td>";
  echo "<td><img src='".$obj->getProfileImage()."'height='40px' width='50px'/></td>";
  echo "<td>  <a href='addeditinstructor.php?do=edit&id=".$obj->getId()."'class='btn btn-primary'><i class='fa fa-wrench' aria-hidden='true'></i>  Edit </a> 
         <a href='?do=delete&id=".$obj->getId()." 'class='btn btn-danger' onclick='return confirm(\"Are You Sure You Want To Delete This Instructor\")'><i class='fa fa-trash' aria-hidden='true'></i> Delete </a> 
   </td>";

echo"</tr>";

}
}
}

echo "</tbody>
 </table>";
 $admin=null;
}

//============================= request for supervisor table ======================================

elseif (isset($_GET['q']) && $_GET['type'] == 'super') {

$admin = new  Admin();
 echo '
<table class="table table-striped text-center">
<thead class="thead-inverse ">
<tr>
<th>ID</th>
<th>Name</th>
<th>Salary</th>
<th>Work Date</th>
<th>Phone</th>
<th>Image</th>
<th>Options</th>
</tr>
</thead>
<tbody>
 ';
if($_GET['q'] == 'sp'){
$key=$_GET['key'];
$super_info=$admin->search('Supervisor',$key);
if(!is_array($super_info)){
          if(!empty($super_info)){
          echo "<tr>";
           echo "<td>" . $super_info->getId(). "</td>";
            echo "<td>" . $super_info->getName(). "</td>";
            echo "<td>" .$super_info->getSalary(). "</td>";
            echo "<td>" . $super_info->getWorkdate(). "</td>";
            echo "<td>" . $super_info->getphone() . "</td>";
            echo "<td><img src='".$super_info->getProfileImage()."'height='40px' width='50px'/></td>";
            echo "<td>  <a href='addeditsuper.php?do=edit&id=".$super_info->getId()."'class='btn btn-primary'><i class='fa fa-wrench' aria-hidden='true'></i> Edit </a> 
                   <a href='?do=delete&id=".$super_info->getId()." 'class='btn btn-danger' onclick='return confirm(\"Are You Sure You Want To Delete This Instructor\")'><i class='fa fa-trash' aria-hidden='true'></i>
           Delete </a> 
             </td>";

          echo"</tr>";        

        }    
}
else{
if($super_info){
foreach ($super_info as $obj) {
 
  # code...
echo "<tr>";
 echo "<td>" . $obj->getId(). "</td>";
  echo "<td>" . $obj->getName(). "</td>";
  echo "<td>" .$obj->getSalary(). "</td>";
  echo "<td>" . $obj->getWorkdate(). "</td>";
  echo "<td>" . $obj->getphone() . "</td>";
  echo "<td><img src='".$obj->getProfileImage()."'height='40px' width='50px'/></td>";
  echo "<td>  <a href='addeditsuper.php?do=edit&id=".$obj->getId()."'class='btn btn-primary'><i class='fa fa-wrench' aria-hidden='true'></i> Edit </a> 
         <a href='?do=delete&id=".$obj->getId()." 'class='btn btn-danger' onclick='return confirm(\"Are You Sure You Want To Delete This Instructor\")'><i class='fa fa-trash' aria-hidden='true'></i>
 Delete </a> 
   </td>";

echo"</tr>";

}
}
}



}else{
$super_info=$admin->showObjects('Supervisor');
  if($super_info){
	foreach ($super_info as $obj) {
   # code...
echo "<tr>";
 echo "<td>" . $obj->getId(). "</td>";
  echo "<td>" . $obj->getName(). "</td>";
  echo "<td>" .$obj->getSalary(). "</td>";
  echo "<td>" . $obj->getWorkdate(). "</td>";
  echo "<td>" . $obj->getphone() . "</td>";
  echo "<td><img src='".$obj->getProfileImage()."'height='40px' width='50px'/></td>";
  echo "<td>  <a href='addeditsuper.php?do=edit&id=".$obj->getId()."'class='btn btn-primary'><i class='fa fa-wrench' aria-hidden='true'></i> Edit </a> 
         <a href='?do=delete&id=".$obj->getId()." 'class='btn btn-danger' onclick='return confirm(\"Are You Sure You Want To Delete This Instructor\")'><i class='fa fa-trash' aria-hidden='true'></i>
 Delete </a> 
   </td>";

echo"</tr>";

}
}
}
echo "</tbody>
 </table>";
 $admin=null;
}
//============================ request for client table ================================

elseif(isset($_GET['q']) && $_GET['type'] == 'client'){
$admin = new  Admin();
//$clients=$admin->showclientsdata();
echo '
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
';

if($_GET['q'] == 'sp'){
$key=$_GET['key'];
$clients=$admin->search('Client',$key);

if(!is_array($clients)){
          if(!empty($clients))
              echo "<tr>
                      <td> ". $clients->getId()."</td>
                      <td> ". $clients->getName()."</td>
                      <td> ". $clients->getPhone()."</td>
                      <td> ". $clients->getUsername()."</td>
                        <td> ". $clients->getEmail()."</td>
                      <td> ". $clients->getVerify()."</td>
                      <td> ". $clients->getRegistrationDate()."</td>
                      <td><img src='".$clients->getProfileImage()."'height='40px' width='50px'/></td>
                      <td> <a class='btn btn-primary' href='editclient.php?id=". $clients->getId()."'><i class='fa fa-wrench' aria-hidden='true'></i> Edit </a>
                           <a class='btn btn-danger delete' onclick='return confirm(\"Are You Sure You Want To Delete This Client\")' href='?box=delete&id=".$clients->getId()."'><i class='fa fa-trash' aria-hidden='true'></i> Delete </a>
                      </td>
                   </tr>"; 
      }

else{
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
                      <td><img src='".$client->getProfileImage()."'height='40px' width='50px'/></td>
                      <td> <a class='btn btn-primary' href='editclient.php?id=". $client->getId()."'><i class='fa fa-wrench' aria-hidden='true'></i> Edit </a>
                           <a class='btn btn-danger delete' onclick='return confirm(\"Are You Sure You Want To Delete This Client\")' href='?box=delete&id=".$client->getId()."'><i class='fa fa-trash' aria-hidden='true'></i> Delete </a>
                      </td>
                   </tr>"; 
}
  }

  }
          
          
}else{
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
                      <td><img src='".$client->getProfileImage()."'height='40px' width='50px'/></td>
                      <td> <a class='btn btn-primary' href='editclient.php?id=". $client->getId()."'><i class='fa fa-wrench' aria-hidden='true'></i> Edit </a>
                           <a class='btn btn-danger delete' onclick='return confirm(\"Are You Sure You Want To Delete This Client\")' href='?box=delete&id=".$client->getId()."'><i class='fa fa-trash' aria-hidden='true'></i> Delete </a>
                      </td>
                   </tr>";   
          }
}
}
echo "</tbody>
          </table>";
          $admin=null;
}
//===========================request for book table====================

elseif(isset($_GET['q']) && $_GET['type'] == 'book'){
$admin = new  Admin();

echo '
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

';
if($_GET['q'] == 'sp'){
$key=$_GET['key'];
$books=$admin->search('Book',$key);

if(!is_array($books)){
          if(!empty($books)){
             echo "<tr>
                      <td> ". $books->getId()."</td>                      
                      <td> ". $books->getName()."</td>
                      <td> ". $books->getPrice()."</td>
                      <td> ". $books->getCategory()."</td>
                      <td> ". $books->getEdition()."</td>
                      <td> ". $books->getCourseId()."</td>
                      <td><img src='".$books->getImg()."'height='40px' width='50px'/></td>
                      <td> <a class='btn btn-primary' href='addeditbook.php?do=edit&id=". $books->getId()."'><i class='fa fa-wrench' aria-hidden='true'></i> Edit </a>
                           <a class='btn btn-danger delete' onclick='return confirm(\"Are You Sure You Want To Delete This Client\")' href='?box=delete&id=".$books->getId()."'><i class='fa fa-trash' aria-hidden='true'></i> Delete </a>
                      </td>
                   </tr>";  
        }
    }
else{
for($i=0;$i<count($books);$i++){
              echo "<tr>
                      <td> ". $books[$i]->getId()."</td>                      
                      <td> ". $books[$i]->getName()."</td>
                      <td> ". $books[$i]->getPrice()."</td>
                      <td> ". $books[$i]->getCategory()."</td>
                      <td> ". $books[$i]->getEdition()."</td>
                      <td> ". $books[$i]->getCourseId()."</td>
                      <td><img src='".$books[$i]->getImg()."'height='40px' width='50px'/></td>
                      <td> <a class='btn btn-primary' href='addeditbook.php?do=edit&id=". $books[$i]->getId()."'><i class='fa fa-wrench' aria-hidden='true'></i> Edit </a>
                           <a class='btn btn-danger delete' onclick='return confirm(\"Are You Sure You Want To Delete This Client\")' href='?box=delete&id=".$books[$i]->getId()."'><i class='fa fa-trash' aria-hidden='true'></i> Delete </a>
                      </td>
                   </tr>";   
          }

}
 

}else{
$books=$admin->showObjects('Book');
for($i=0;$i<count($books);$i++){
              echo "<tr>
                      <td> ". $books[$i]->getId()."</td>                      
                      <td> ". $books[$i]->getName()."</td>
                      <td> ". $books[$i]->getPrice()."</td>
                      <td> ". $books[$i]->getCategory()."</td>
                      <td> ". $books[$i]->getEdition()."</td>
                      <td> ". $books[$i]->getCourseId()."</td>
                      <td><img src='".$books[$i]->getImg()."'height='40px' width='50px'/></td>
                      <td> <a class='btn btn-primary' href='addeditbook.php?do=edit&id=". $books[$i]->getId()."'><i class='fa fa-wrench' aria-hidden='true'></i> Edit </a>
                           <a class='btn btn-danger delete' onclick='return confirm(\"Are You Sure You Want To Delete This Client\")' href='?box=delete&id=".$books[$i]->getId()."'><i class='fa fa-trash' aria-hidden='true'></i> Delete </a>
                      </td>
                   </tr>";   
          }

}
echo "</tbody>
</table>";
$admin=null;
}
//================================== request for news table ===============================
elseif(isset($_GET['q']) && $_GET['type'] == 'news'){
$admin = new  Admin();
echo '
<table class="table table-striped text-center">
	    <thead class="thead-inverse ">
			<tr>
				<th>Header</th>
				<th>Creation Date</th>
				<th>Image</th>
				<th>Options</th>
			</tr>
			</thead>
		<tbody>
';
if($_GET['q'] == 'sp'){
$key=$_GET['key'];
$news=$admin->search('News',$key);
if(!is_array($news)){
          if(!empty($news)){
          echo "<tr>";
  echo "<td>".$news->getheader()."</td>";
    echo "<td>".$news->getcreationDate()."</td>";
    echo "<td><img src='".$news->getimage()."' width='60px' height='40px'/></td>";
  echo "<td><a href='addeditnews.php?do=edit&id=".$news->getnewsid()."' class='btn btn-primary'><i class='fa fa-wrench' aria-hidden='true'></i>  Edit</a> "; 
  echo "<a href='?do=delete&id=".$news->getnewsid()."' onclick='return confirm(\"Are You Sure You Want To Delete This Course\")' class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>";
  echo "</tr>";
          }
  }
 else{
  if($news){
foreach ($news as $obj) {
  echo "<tr>";
  echo "<td>".$obj->getheader()."</td>";
    echo "<td>".$obj->getcreationDate()."</td>";
    echo "<td><img src='".$obj->getimage()."' width='60px' height='40px'/></td>";
  echo "<td><a href='addeditnews.php?do=edit&id=".$obj->getnewsid()."' class='btn btn-primary'><i class='fa fa-wrench' aria-hidden='true'></i>  Edit</a> "; 
  echo "<a href='?do=delete&id=".$obj->getnewsid()."' onclick='return confirm(\"Are You Sure You Want To Delete This Course\")' class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>";
  echo "</tr>";
}
}
} 

}
else{
$news = $admin->showObjects('News');
if($news){
foreach ($news as $obj) {
	echo "<tr>";
	echo "<td>".$obj->getheader()."</td>";
		echo "<td>".$obj->getcreationDate()."</td>";
		echo "<td><img src='".$obj->getimage()."' width='60px' height='40px'/></td>";
	echo "<td><a href='addeditnews.php?do=edit&id=".$obj->getnewsid()."' class='btn btn-primary'><i class='fa fa-wrench' aria-hidden='true'></i>  Edit</a> ";	
	echo "<a href='?do=delete&id=".$obj->getnewsid()."' onclick='return confirm(\"Are You Sure You Want To Delete This Course\")' class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>";
	echo "</tr>";
}	
}
}
echo "</tbody>		 		
	</table>";
  $admin=null;
}
//===================================request for branches table ===========================
elseif(isset($_GET['q']) && $_GET['type'] == 'branch'){

$admin = new  Admin();

 echo '<table class="table table-striped text-center">
      <thead class="thead-inverse">
      <tr>
        <th>Location</th>
        <th>Description</th>
        <th>Phone</th>
        <th>Options</th>
      </tr>
      </thead>
    <tbody>
';
if($_GET['q'] == 'sp'){
$key=$_GET['key'];
$branches=$admin->search('Branch',$key);
if(is_array($branches)){
   if($branches){
foreach ($branches as $obj) {
  
  echo "<tr>";
  echo "<td>".$obj->getlocation()."</td>";
    echo "<td>".$obj->getdescription()."</td>";
    echo "<td>".$obj->getphone()."</td>";
  echo "<td><a href='objaddeditbranch.php?do=edit&id=".$obj->getbranchid()."' class='btn btn-primary'><i class='fa fa-wrench' aria-hidden='true'></i> Edit</a> ";  
  echo "<a href='?do=delete&id=".$obj->getbranchid()."' onclick='return confirm(\"Are You Sure You Want To Delete This Course\")' class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>";
  echo "</tr>";
}
}
}   
}
else{
$branches=$admin->showObjects('Branch');
if($branches){
foreach ($branches as $obj) {
  echo "<tr>";
  echo "<td>".$obj->getlocation()."</td>";
    echo "<td>".$obj->getdescription()."</td>";
    echo "<td>".$obj->getphone()."</td>";
  echo "<td><a href='addeditbranch.php?do=edit&id=".$obj->getbranchid()."' class='btn btn-primary'><i class='fa fa-wrench' aria-hidden='true'></i> Edit</a> ";  
  echo "<a href='?do=delete&id=".$obj->getbranchid()."' onclick='return confirm(\"Are You Sure You Want To Delete This Course\")' class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>";
  echo "</tr>";
}
}
}
echo "</tbody>        
  </table>";
  $admin=null;
}

?>