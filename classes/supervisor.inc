<?php 
class Supervisor extends Worker {

public function sanitize($name,$username,$password,$email,$salary,$address,$phone,$id=''){
			$this->username=filter_var($username,FILTER_SANITIZE_STRING);
			if(!empty($id)) $this->id=filter_var($id,FILTER_SANITIZE_NUMBER_INT);
			//include 'connection.php';
			if(!empty($this->id)){
				$continue=' AND id !=?';
			}else{
				$continue='';
			}
			/*$stm=$con->prepare('SELECT username FROM clients WHERE username=:username');
			$stm->bindParam(':username',$this->username,PDO::PARAM_STR);
			$stm->execute();*/
			$db=Database::getinstance();
			$db->select('SELECT username FROM clients WHERE username=?',array($this->username),'',0);
			if($db->rowcount()>0){
				return false;
			}else{
				/*$stm=$con->prepare('SELECT username FROM supervisors WHERE username=:username');
				$stm->bindParam(':username',$this->username,PDO::PARAM_STR);
				$stm->execute();*/
				//$db=$db=Database::getinstance();
				$db->select('SELECT username FROM instructors WHERE username=?',array($this->username),'',0);
				if($db->rowcount()>0){
					return false;
				}else{
					/*$stm=$con->prepare('SELECT username FROM instructors WHERE username=:username'.$continue);
					$stm->bindParam(':username',$this->username,PDO::PARAM_STR);*/
					$attr=array();
					$attr[]=$this->username;
					if(!empty($this->id)){
						//$stm->bindParam(':id',$this->id,PDO::PARAM_INT);
						$attr[]=$this->id;
					}
					//$stm->execute();
					//$db=Database::getinstance();
					$db->select('SELECT username FROM supervisors WHERE username=?'.$continue,$attr,'',0);
					if($db->rowcount()>0){
						return false;
					}else{
						/*$stm=$con->prepare('SELECT username FROM admins WHERE username=:username');
						$stm->bindParam(':username',$this->username,PDO::PARAM_STR);
						$stm->execute();*/
						$db->select('SELECT username FROM admins WHERE username=?',array($this->username),'',0);
						if($db->rowcount()>0){
							return false;
						}else{
							$this->email=filter_var($email,FILTER_SANITIZE_EMAIL);
							if(!empty($password)){
								$this->password=sha1(filter_var($password,FILTER_SANITIZE_STRING));
							}
							$this->name=filter_var($name,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
							$this->phone=filter_var($phone,FILTER_SANITIZE_NUMBER_INT);
							$this->salary=filter_var($salary,FILTER_SANITIZE_NUMBER_INT);
							$this->address=filter_var($address,FILTER_SANITIZE_STRING);
							$db->close();
							return true;
						}
					}
				}
			}

	}//End function



//start edit




	public function edit(){
	//require 'connection.php';
	if(empty($this->password)){
		$passwordQuery='';
	}else{
		$passwordQuery=',password=?';
	}
	$sq="UPDATE supervisors SET username=?".$passwordQuery.",";
		if(!empty($this->profileImage)) $sq.="profileImage=?,";
		$sq.="workDate=CURRENT_DATE,phone=?,email=?,salary=?,name=? WHERE id=? ";
		$attr=array();
		$attr[]=$this->username;
		if(!empty($passwordQuery)){
		$attr[]=$this->password;
	}
		if(!empty($this->profileImage)) $attr[]=$this->profileImage;
		$attr[]=$this->phone;
		$attr[]=$this->email;
		$attr[]=$this->salary;
		$attr[]=$this->name;
		$attr[]=$this->id;

	$db=Database::getinstance();
	$db->update($sq,$attr);
    $db->close(); 
	 }
	 public function delete(){

	$db=Database::getinstance();
	$db->delete('DELETE FROM supervisors WHERE id=?',array($this->id));
    $db->close(); 
	 }



//start add
public function add(){

		$query='INSERT INTO supervisors (name,username,password,salary,email,phone,address,profileImage,workDate) 
		VALUES(?,?,?,?,?,?,?,?,CURRENT_DATE)';
		$attr=array(
		$this->name,	
        $this->username,
        $this->password,
        $this->salary,
        $this->email,
        $this->phone,
        $this->address,
       $this->profileImage 
		);
		$db=Database::getinstance();
		$db->insert($query,$attr);
		$db->close();
	}
public static function showAll(){
	/*require 'connection.php';
	$query='SELECT * FROM supervisors';
	$stmt =$con->query($query);
	$super_info=$stmt->fetchall(PDO::FETCH_CLASS,'supervisor');
	return $super_info;*/
	$db=Database::getinstance();
	$super_info=$db->selectAll('SELECT * FROM supervisors','','Supervisor',1);
	$db->close();
	return $super_info;
}
public function getOne(){

	$db=Database::getinstance();
	$super_info=$db->select('SELECT * FROM supervisors where id =?',array($this->id),'Supervisor',1);
	$db->close();
	return $super_info;
}
public static function getCount(){

	$db=Database::getinstance();
	$result=$db->select('SELECT COUNT(*) FROM supervisors ','','',0);
	$db->close();
	return $result;	
}
public static function search($key){
   // include 'connection.php';
if(is_numeric($key)){

$db=Database::getinstance();
$all=$db->select('SELECT * FROM supervisors WHERE id =?',array($key),'Supervisor',1);
$db->close();
return $all;
}else{

$db=Database::getinstance();
$all=$db->selectAll("SELECT * FROM supervisors WHERE name LIKE '%".$key."%'",'','Supervisor',1);
$db->close();
return $all;
}

}
public function showclientsdata(){
	return Client::showAll();	 
  }

public function showbooks()
  {
	  return Book::showAll();
  }

public function showcourses(){
	return	Course::showAll();

 }

public function insertclientcourse($client,$course)
 {
	 $attr=array();
	 $attr[]=$client->getId();
	 $attr[]=$course->getcourseid();
	$db=Database::getinstance();
	$db->insert('INSERT INTO client_course(clientid,courseid,registerdate) VALUES(?,?,CURRENT_DATE)',$attr);
	$db->update('UPDATE courses SET max=max-1 WHERE courseId=?',array($course->getcourseid()));
	$db->close();
 }
 public function insertclientbook($client,$book)
 {
	$attr=array();
	$attr[]=$client->getId();
	$attr[]=$book->getId();
   $db=Database::getinstance();
   $db->insert('INSERT INTO client_book(clientid,bookid,purchasedate,number) VALUES(?,?,CURRENT_DATE,1)',$attr);
   $db->update('UPDATE books SET number=number-1 WHERE bookId=?',array($book->getId()));
	$db->close();
 }
}