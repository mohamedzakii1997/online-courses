<?php 
class Testimonials implements addable{
private $id;
private $client_id;
	private $description;

public function setid($id){
	$this->id=$id;
}
public function setdescription($des){
	$this->description=$des;
}

public function setclientid($id){
	$this->client_id=$id;
}

public function getclientid(){
	return $this->client_id;
}

public function getid(){
	return $this->id;
}
public function getdescription(){
	return $this->description;
}

public function delete(){
	/*require 'connection.php';
$stmt=$con->prepare('DELETE FROM testimonials WHERE id=:id');
$stmt->bindParam(':id',$this->id,PDO::PARAM_INT);
$stmt->execute();*/
$db=Database::getinstance();
$db->delete('DELETE FROM testimonials WHERE id=?',array($this->id));
$db->close();
}
public function add(){
	$db=Database::getinstance();
		$db->insert('INSERT INTO testimonials(client_id,description) VALUES(?,?)',array($this->getclientid(),$this->getdescription()));
		$db->close();
}
public static function showAll(){
	/*require 'connection.php';
	$stmt=$con->query('SELECT * FROM testimonials');
	$all_test=$stmt->fetchAll(PDO::FETCH_CLASS,'Testimonials');
	$con=null;*/
	$db=Database::getinstance();
	$all_test=$db->selectAll('SELECT * FROM testimonials','','Testimonials',1);
	$db->close();
	return $all_test;
}
}