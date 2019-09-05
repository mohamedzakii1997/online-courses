<?php 
class News implements editable{
	private $image;
	private $header;
	private $description;
	private $creationDate;
	private $newsId;

public function setimage($image){
	$this->image=$image;
}

public function setheader($header){
	$this->header=$header;
}

public function setdescription($desc){
	$this->description=$desc;
}

public function setnewsid($newsid){
	$this->newsId=$newsid;
}

public function getimage(){
	return $this->image;
}

public function getheader(){
	return $this->header;
}

public function getdescription(){
	return $this->description;
}

public function getcreationDate(){
	return $this->creationDate;
}

public function getnewsid(){
	return $this->newsId;
}
//get all news from DB
public static function showAll(){
	/*require 'connection.php';
$stmt=$con->query('SELECT * FROM news');
$all_news=$stmt->fetchAll(PDO::FETCH_CLASS,'News');
$con=null;
return $all_news;*/ 
$db=Database::getinstance();
$all_news=$db->selectAll('SELECT * FROM news','','News',1);
$db->close();
return $all_news;
}

//get news from DB
public function getOne(){
/*require 'connection.php';
$stmt=$con->prepare('SELECT * FROM news WHERE newsId =:id');
$stmt->bindParam(':id',$this->newsId,PDO::PARAM_INT);
$stmt->execute();
$row=$stmt->fetchObject('News');
return $row;*/
$db=Database::getinstance();
$row=$db->select('SELECT * FROM news WHERE newsId =?',array($this->newsId),'News',1);
$db->close();
return $row;
}

//update news
public function edit(){
//require 'connection.php';
$query='UPDATE news SET ';
if(!empty($this->image)) $query.= 'image = ?, ';
	$query.='header = ?, description = ? WHERE newsId =?';
//$stmt=$con->prepare($query);
	$attr=array();
if(!empty($this->image)) $attr[]=$this->image;
$attr[]=$this->header;
$attr[]=$this->description;
$attr[]=$this->newsId;
/* $stmt->bindParam(':img',$this->image,PDO::PARAM_STR);
/*$stmt->bindParam(':head',$this->header,PDO::PARAM_STR);
$stmt->bindParam(':des',$this->description,PDO::PARAM_STR);
$stmt->bindParam(':id',$this->newsId,PDO::PARAM_INT);
$stmt->execute();*/
$db=Database::getinstance();
$db->update($query,$attr);
$db->close;
}
//add news
public function add(){
/*require 'connection.php';
$stmt=$con->prepare('INSERT INTO news (image,header,description,creationDate) VALUES (:img, :head, :des, CURRENT_DATE)');
$stmt->bindParam(':img',$this->image,PDO::PARAM_STR);
$stmt->bindParam(':head',$this->header,PDO::PARAM_STR);
$stmt->bindParam(':des',$this->description,PDO::PARAM_STR);
$stmt->execute();*/
$attr=array($this->image,$this->header,$this->description);
$db=Database::getinstance();
$db->insert('INSERT INTO news (image,header,description,creationDate) VALUES (?, ?, ?, CURRENT_DATE)',$attr);
$db->close();
}

public function delete(){
/*require 'connection.php';
$stmt=$con->prepare('DELETE FROM news WHERE newsId=:id');
$stmt->bindParam(':id',$this->newsId,PDO::PARAM_INT);
$stmt->execute();*/
$db=Database::getinstance();
$db->delete('DELETE FROM news WHERE newsId=?',array($this->newsId));
$db->close();
}

//filtter inputs
public function sanitize($header,$desc,$id=''){
$this->header=filter_var($header,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$this->description=filter_var($desc,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if(!empty($id))$this->newsId=filter_var($id,FILTER_SANITIZE_NUMBER_INT);
}
public static function getCount(){
	/*require 'connection.php';
		$stmt= $con->query('SELECT COUNT(*) FROM news');
		$result=$stmt->fetchColumn();
		$con=null;
		return $result;*/
		$db=Database::getinstance();
		$result=$db->select('SELECT COUNT(*) FROM news','','',0);
		$db->close();
		return $result;
}
public static function get_ordered_news(){
/*require 'connection.php';
$query= 'SELECT * FROM news ORDER BY newsId DESC';
        $stmt=$con->query($query);
         $all=$stmt->fetchAll();	
    return $all;*/
    $db=Database::getinstance();
   $all= $db->selectAll('SELECT * FROM news ORDER BY newsId DESC','','',0);
   $db->close();
   return $all;
}
public static function search($key){
	//include 'connection.php';
if(is_numeric($key)){
/*$query='SELECT * FROM news WHERE newsId =:id';
$stmt=$con->prepare($query);
$stmt->bindParam(':id',$key,PDO::PARAM_INT);
$stmt->execute();
$all =$stmt->fetchObject('News');
return $all;*/
$db=Database::getinstance();
$all=$db->select('SELECT * FROM news WHERE newsId =?',array($key),'News',1);
$db->close();
return $all;
}else{
	/*$query="SELECT * FROM news WHERE header LIKE '%".$key."%'";
$stm=$con->prepare($query);
$stm->execute();
$all =$stm->fetchAll(PDO::FETCH_CLASS, 'News');
return $all;*/
$db=Database::getinstance();
$all=$db->selectAll("SELECT * FROM news WHERE header LIKE '%".$key."%'",'','News',1);
$db->close();
return $all;
}
}

}