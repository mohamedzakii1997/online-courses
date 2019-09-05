<?php
class Course implements editable{
	private $name;
	private $courseId;
	private $description;
	private $content;
	private $hours;
	private $price;
	private $certifications;
	private $image;
	private $startDate;
	private $lectureTime;
	private $myinstructorid;
	private $category;
	private $state;
	private $max;
	private $resources;

	public function setResource($resource){
	$this->resources=$resource;
	}
	public function setCategory($category){
	$this->category=$category;
	}
	public function setState($state){
	$this->state=$state;
	}
	public function setMax($max){
	$this->max=$max;
	}
	public function setcourseid($id){
	$this->courseId=$id;
	}
	public function setname($name){
		$this->name=$name;
	}
	public function setdescription($des){
		$this->description=$des;
	}
	public function setcontent($content){
		$this->content=$content;
	}
	public function sethours($hours){
		$this->hours=$hours;
	}
	public function setprice($price){
		$this->price=$price;
	}
	public function setcertifications($cert){
		$this->certifications=$cert;
	}
	public function setimage($image){
		$this->image=$image;
	}															
	public function setstartDate($st_date){
		$this->startDate=$st_date;
	}
	public function setlectureTime($le_time){
		$this->lectureTime=$le_time;
	}
	public function setins_id($ins_id){
		$this->myinstructorid=$ins_id;
	}

	public function getname(){
		return $this->name;
	}	
	public function getcourseid(){
		return $this->courseId;
	}	
	public function getdescription(){
		return $this->description;
	}	
	public function getcontent(){
		return $this->content;
	}	
	public function gethours(){
		return $this->hours;
	}	
	public function getprice(){
		return $this->price;
	}
	public function getcertifications(){
		return $this->certifications;
	}
	public function getimage(){
		return $this->image;
	}
	public function getstartDate(){
		return $this->startDate;
	}		
	public function getlecturetime(){
		return $this->lectureTime;
	}
	public function getins_id(){
		return $this->myinstructorid;
	}
	public function getCategory(){
		return $this->category;
	}
	public function getState(){
		return $this->state;
	}
	public function getMax(){
		return $this->max;
	}
	public function getResource(){
		return $this->resources;
	}

	public function edit(){
		//require 'connection.php';
		$attr=array();
		$query="UPDATE courses SET name=?, description=?, content=?, hours=?, price=?, certifications=?, ";
		if(!empty($this->image)) $query.="image=?, ";
		 $query.="startDate=?, myinstructorid=?, lectureTime=? ,category=?,state=?,max=? WHERE courseid=?";
         $attr[]=$this->name;
         $attr[]=$this->description;
         $attr[]=$this->content;
         $attr[]=$this->hours;
         $attr[]=$this->price;
         $attr[]=$this->certifications;
         if(!empty($this->image)) $attr[]=$this->image;
         $attr[]=$this->startDate;
         $attr[]=$this->myinstructorid;
         $attr[]=$this->lectureTime;
         $attr[]=$this->category;
         $attr[]=$this->state;
         $attr[]=$this->max;
         $attr[]=$this->courseId; 

		$db=Database::getinstance();
		$db->update($query,$attr);
		$db->close();
	}	
	public function add(){
		//require 'connection.php';
		$query='INSERT INTO courses (name,description,content,hours,price,certifications,image,lectureTime,startDate,myinstructorid,category,state,max) 
		VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)';

		$attr=array($this->name,
$this->description,
$this->content,
$this->hours,
$this->price,
$this->certifications,
$this->image,
$this->lectureTime,
$this->startDate,
$this->myinstructorid,
$this->category,
$this->state,
$this->max
);

		$db=Database::getinstance();
		$db->insert($query,$attr);
		$db->close();
	}
	public function delete(){
		/*require "connection.php";
		$query="DELETE FROM courses WHERE courseid = :id";
		$stmt=$con->prepare($query);
		$stmt->bindParam(':id',$this->courseId,PDO::PARAM_INT);
		$stmt->execute();*/
		$db=Database::getinstance();
		$db->delete('DELETE FROM courses WHERE courseid = ?',array($this->courseId));
		$db->close();
	}
	public function sanitize($name,$description,$content,$hours,$price,$certifications,$startDate,$lectureTime,$myinstructorid,$category,$max,$courseId=''){
		$this->name=filter_var($name,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$this->description=filter_var($description,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$this->content=filter_var($content,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$this->hours=filter_var($hours,FILTER_SANITIZE_NUMBER_INT);
		$this->price=filter_var($price,FILTER_SANITIZE_NUMBER_INT);
		$this->certifications=filter_var($certifications,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$this->startDate=filter_var($startDate,FILTER_SANITIZE_STRING);
		$this->lectureTime=filter_var($lectureTime,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$this->category=filter_var($category,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$this->myinstructorid=filter_var($myinstructorid,FILTER_SANITIZE_NUMBER_INT);
		$this->max=filter_var($max,FILTER_SANITIZE_NUMBER_INT);
		if(!empty($courseId)) $this->courseId=filter_var($courseId,FILTER_SANITIZE_NUMBER_INT);
	}
	public static function showAll(){

	 	$db=Database::getinstance();
	 	$all_courses=$db->selectAll('SELECT * FROM courses','','Course',1);
        $db->close();
        return $all_courses;   
	}
	public function getOne(){

		$db=Database::getinstance();
		$course=$db->select('SELECT * FROM courses where courseId =?',array($this->courseId),'Course',1);
        $db->close();
        return $course;
	}
	public static function getAllIds(){

		$db=Database::getinstance();
		$cid=$db->selectAll('SELECT courseId FROM courses','','',0);
		$db->close();
		return $cid;
	}
	public static function getRevenues(){

		$db=Database::getinstance();
		$result=$db->select('SELECT SUM(price) FROM client_course,courses WHERE client_course.courseid = courses.courseId','','',0);
	    $db->close();
	    return $result;
	}
	public static function getCount(){

		$db=Database::getinstance();
		$result=$db->select('SELECT COUNT(*) FROM courses','','',0);
	    $db->close();
	    return $result;
	}
	public static function getTransactions(){

		$db=Database::getinstance();
		$result=$db->selectAll('SELECT client_course.courseid,clientid,name,category,price,registerdate,image FROM client_course,courses WHERE client_course.courseid = courses.courseId ORDER BY client_course.courseid DESC limit 10','','',0);
		$db->close();
		return $result;
	}
	public static function getTop(){
		$db=Database::getinstance();
		$result=$db->selectAll('SELECT client_course.courseid,name,price,myinstructorid,image,COUNT(*) FROM client_course,courses WHERE client_course.courseid = courses.courseId 
			GROUP BY client_course.courseid
			ORDER BY COUNT(*)
			 limit 10','','',0);
		$db->close();
		return $result;
	}
	public static function search($key){

		
if(is_numeric($key)){

$db=Database::getinstance();
$all=$db->select('SELECT * FROM courses WHERE courseid =?',array($key),'Course',1);
$db->close();
return $all;
}else{

$db=Database::getinstance();
$all=$db->selectAll("SELECT * FROM courses WHERE name LIKE '%".$key."%'",'','Course',1);
$db->close();
return $all;
}
	}
	public static function getinscourses($id){
     $db=Database::getinstance();
     $courses=$db->selectAll('SELECT * FROM courses WHERE myinstructorid = ?',array($id),'',0);
     $db->close();
     return $courses;
	}
    public function uploadcourse_resources(){
    	$db=Database::getinstance();
    	$link=$db->select('SELECT resources from courses WHERE courseid = ?',array($this->courseId),'',0);
    	
    	if(!empty($link))
    	$link.=','.$this->resources;
        else $link=$this->resources;
    	$db->update('UPDATE courses SET resources = ? WHERE courseid = ?',array($link,$this->courseId)); 	
        $db->close();
    }
}