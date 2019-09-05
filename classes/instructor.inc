<?php 
class Instructor extends Worker implements observer{
	private $description;
	private $career;
	private $rate;
    private $unseen_notific;
	
	public function setDescription($description){
  $this->description=$description;
}
public function setCarrer($career){
  $this->career=$career;
}
public function setRate($rate){
  $this->rate=$rate;
}

public function getDescription(){
  return $this->description;
}
public function getRate(){
  return $this->rate;
} 
public function getCarrer(){
  return $this->career;
}
 
 public function sanitize($name,$username,$password,$email,$salary,$address,$phone,$description,$career,$id=''){
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

				$db->select('SELECT username FROM supervisors WHERE username=?',array($this->username),'',0);
				if($db->rowcount()>0){
					return false;
				}else{

					$attr=array();
					$attr[]=$this->username;
					if(!empty($this->id)){
						//$stm->bindParam(':id',$this->id,PDO::PARAM_INT);
						$attr[]=$this->id;
					}
					//$stm->execute();
					//$db=Database::getinstance();
					$db->select('SELECT username FROM instructors WHERE username=?'.$continue,$attr,'',0);
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
							$this->description=filter_var($description,FILTER_SANITIZE_STRING);
							$this->career=filter_var($career,FILTER_SANITIZE_STRING);
							$db->close();
							return true;
						}
					}
				}
			}

	}//End function

	public function edit(){
	//require 'connection.php';
	if(empty($this->password)){
		$passwordQuery='';
	}else{
		$passwordQuery=',password=?';
	}
	$sq="UPDATE instructors SET username=?".$passwordQuery.",career=?,address=?,description=?,";
		if(!empty($this->profileImage)) $sq.="profileImage=?,";
		$sq.="salary=?,workDate=CURRENT_DATE,phone=?,email=?,name=? WHERE id=? ";
		$attr=array();
		$attr[]=$this->username;
	/*$stat=$con->prepare($sq);
	$stat->bindParam(':username',$this->username,PDO::PARAM_STR);*/
	if(!empty($passwordQuery)){
		//$stat->bindParam(':password',$this->password,PDO::PARAM_STR);
        $attr[]=$this->password;
	}
	$attr[]=$this->career;
	$attr[]=$this->address;
	$attr[]=$this->description;
	if(!empty($this->profileImage)) $attr[]=$this->profileImage;
	$attr[]=$this->salary;
	$attr[]=$this->phone;
	$attr[]=$this->email;
	$attr[]=$this->name;
	$attr[]=$this->id;

	$db=Database::getinstance();
	$db->update($sq,$attr);
	$db->close();
	 }
	 public function add(){
		//require 'connection.php';
		$query='INSERT INTO instructors (name,username,password,email,description,phone,salary,career,address,profileImage,rate,workDate) 
		VALUES(?,?,?,?,?,?,?,?,?,?,0,CURRENT_DATE)';
		$attr=array($this->name,
         $this->username,
         $this->password,
         $this->email,
         $this->description,
         $this->phone,
         $this->salary,
         $this->career,
         $this->address,
         $this->profileImage);
		$db=Database::getinstance();
		$db->insert($query,$attr);
		$db->close();
	}
	public function delete(){

		$db=Database::getinstance();
		$db->delete('DELETE FROM instructors WHERE id=?',array($this->id));
		$db->close();
	}
	public static function showAll(){

		$db=Database::getinstance();
		$ins_info=$db->selectAll('SELECT * FROM instructors','','Instructor',1);
        $db->close();
        return $ins_info; 
	}
	public static function getAllIds(){

		$db=Database::getinstance();
		$myins=$db->selectAll('SELECT id FROM instructors','','',0);
        $db->close();
        return $myins;
	}
	public function getOne(){

		$db=Database::getinstance();
		$instructor_info=$db->select('SELECT * FROM instructors where id =?',array($this->id),'Instructor',1);
		$db->close();
		return $instructor_info;

	}
	public static function getCount(){

		$db=Database::getinstance();
		$result=$db->select('SELECT COUNT(*) FROM instructors','','',0);
		$db->close();
		return $result;
	}
	public static function getTop(){
		$db=Database::getinstance();
		$result=$db->selectAll('SELECT id,name,salary,rate FROM instructors ORDER BY rate DESC LIMIT 10','','',0);
		$db->close();
		return $result;
	}
	public static function search($key){

		//include 'connection.php';
		if(is_numeric($key)){

		$db=Database::getinstance();
		$all=$db->select('SELECT * FROM instructors WHERE id =?',array($key),'Instructor',1);
		$db->close();
		return $all;
		}else{

		$db=Database::getinstance();
		$all=$db->selectAll("SELECT * FROM instructors WHERE name LIKE '%".$key."%'",'','Instructor',1);
        $db->close();
        return $all; 
        }
	}
	public function getmycourses(){
	return	Course::getinscourses($this->id);
	}
	public function upload_myresource($resource,$c_id){
$course= new Course();
$course->setResource(filter_var($resource,FILTER_SANITIZE_STRING));
$course->setcourseid($c_id);
$course->uploadcourse_resources();
	}
   public function showmystudents($courseid){
     $query ='SELECT name,email FROM clients WHERE id in(SELECT clientid FROM client_course WHERE courseid =?)';
  $db=Database::getinstance();
$result=$db->selectAll($query,array($courseid),'',0);

  if($db->rowcount()>0){
  $db->close();
return $result;}

else {  $db->close();  return 0;}


   }
//============notification for instructor===================
 public function update(){
		$db=Database::getinstance();
		$db->update('UPDATE instructors SET unseen_notific = unseen_notific + 1 WHERE id = ?',array($this->id));
		$db->close();
    }
    public function update_unseen($id){

		$db=Database::getinstance();
		$db->update('UPDATE instructors SET unseen_notific = ? WHERE id= ?',array(0,$id));
		$db->close();
    }

    public function getnotify($id){
	    //include 'connection.php';
        $all=array();
        $all[]=News::get_ordered_news();	

        $db=Database::getinstance();
      $all[]= $db->select('SELECT unseen_notific FROM instructors WHERE id= ?',array($id),'',0);
      $db->close();

return $all;
}


}