<?php
class Branch implements editable{
	private $branchId;
	private $location;
	private $phone;
	private $description;
public function setbranchid($id){
$this->branchId=$id;
}

public function setlocation($loc){

$this->location=$loc;
}

public function setphone($phone){
$this->phone=$phone;
}
public function setdescription($desc){
$this->description=$desc;
}

public function getbranchid(){
	return $this->branchId;
}


public function getlocation(){
	return $this->location;
}


public function getphone(){
	return $this->phone;
}


public function getdescription(){
	return $this->description;
}
public static function getCount(){

}

//get all branches
public static function showAll(){
$db=Database::getinstance();
$all_branches=$db->selectAll('SELECT * FROM branches','','Branch',1);
$db->close();
return $all_branches;
}

//get specific branch
public function getOne(){
$db=Database::getinstance();
$row=$db->select('SELECT * FROM branches WHERE branchId =?',array($this->branchId),'Branch',1);
$db->close();
return $row;
}

//update branch 
public function edit(){

$attr=array($this->location,$this->description,$this->phone,$this->branchId);
$db=Database::getinstance();
$db->update('UPDATE branches SET  location = ?, description = ?, phone = ? WHERE branchId =?',$attr);
$db->close();
}

//add branch
public function add(){

$attr=array($this->location,
$this->description,
$this->phone);
$db=Database::getinstance();
$db->insert('INSERT INTO branches (location,description,phone) VALUES (?, ?, ?)',$attr);
$db->close();
}

//delete branch 
public function delete(){
$db=Database::getinstance();
$db->delete('DELETE FROM branches WHERE branchId=?',array($this->branchId));
$db->close();
}

//filter inputs
public function sanitize($loc,$desc,$phone,$id){
$this->location=filter_var($loc,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$this->description=filter_var($desc,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$this->phone=filter_var($phone,FILTER_SANITIZE_NUMBER_INT);
if(!empty($id))$this->branchId=filter_var($id,FILTER_SANITIZE_NUMBER_INT);
}
public static function search($key){
	//include 'connection.php';
if(is_numeric($key)){
$db=Database::getinstance();
$all=$db->select('SELECT * FROM branches WHERE branchId =?',array($key),'Branch',1);
$db->close();
return $all;
}else{

$db=Database::getinstance();
$all=$db->selectAll("SELECT * FROM branches WHERE location LIKE '%".$key."%'",'','Branch',1);
$db->close();
return $all;
}
}
}