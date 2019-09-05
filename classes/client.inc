<?php 
spl_autoload_register(function ($class){
    require $class.'.inc';
});
class Client extends User implements editable,observer{
	private $phone;
	private $verify;
	private $registrationDate;
	private $unseen_notific;
	public $payment;

	public function setPhone($phone){
		$this->phone=$phone;
	}
	public function setRegistrationDate($date){
		$this->registrationDate=$date;
	}
	public function setVerify($verify){
		$this->verify=$verify;
	}
	public function getRegistrationDate(){
		return $this->registrationDate;
	}
	public function getVerify(){
		return $this->verify;
	}
	public function getPhone(){
		return $this->phone;
	}
	public function sanitize($username,$password,$email,$name,$phone,$id=''){
			$this->username=filter_var($username,FILTER_SANITIZE_STRING);
			if(!empty($id)) $this->id=filter_var($id,FILTER_SANITIZE_NUMBER_INT);
			if(!empty($this->id)){
				$continue=' AND id !=?';
			}else{
				$continue='';
			}

			$attr=array();
			$attr[]=$this->username;
			if(!empty($this->id)){
				//$stm->bindParam(':id',$id,PDO::PARAM_INT);
				$attr[]=$id;
			}
			//$stm->execute();
			$db=Database::getinstance();
			$db->select('SELECT username FROM clients WHERE username=?'.$continue,$attr,'',0);
			if($db->rowcount()>0){
				return false;
			}else{
				/*$stm=$con->prepare('SELECT username FROM supervisors WHERE username=:username');
				$stm->bindParam(':username',$this->username,PDO::PARAM_STR);
				$stm->execute();*/
				$db->select('SELECT username FROM supervisors WHERE username=?',array($this->username),'',0);
				if($db->rowcount()>0){
					return false;
				}else{
					/*$stm=$con->prepare('SELECT username FROM instructors WHERE username=:username');
					$stm->bindParam(':username',$this->username,PDO::PARAM_STR);
					$stm->execute();*/
					$db->select('SELECT username FROM instructors WHERE username=?',array($this->username),'',0);
					if($db->rowCount()>0){
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
							$db->close();
							return true;
						}
					}
				}
			}

	}//End function

	public function add(){

		$db=Database::getinstance();
		$arr=array($this->username,$this->name,$this->password,$this->email,$this->phone);

          $db->insert('INSERT INTO clients (username,name,password,email,phone,profileImage,unseen_notific,verify,registrationDate) 
							VALUES (?, ?, ?, ?, ?,"",0,0,CURRENT_DATE)',$arr);	
          $db->close();
	}//End The Function
	public function edit(){
		//require 'connection.php';
		$attr=array();
		if(empty($this->password)){
			$passwordQuery='';
		}else{
			$passwordQuery=',password=?';
		}
		$sq="UPDATE clients SET username=?".$passwordQuery.",phone=?,";
		if(!empty($this->profileImage)) $sq.="profileImage=?,";
		$sq.="verify=?,email=?,name=? WHERE id=?";

//		$stat=$con->prepare($sq);
//		$stat->bindParam(':username',$this->username,PDO::PARAM_STR);
		$attr[]=$this->username;
		if(!empty($passwordQuery)){
   			//$stat->bindParam(':password',$this->password,PDO::PARAM_STR);
            $attr[]=$this->password;
		}

		$attr[]=$this->phone;
		if(!empty($this->profileImage)) $attr[]=$this->profileImage;
		 $attr[]=$this->verify;
		$attr[]=$this->email;
		$attr[]=$this->name;
		$attr[]=$this->id;
		$db=Database::getinstance();
		$ar=$db->update($sq,$attr);
		$db->close();
	}
	public function delete(){

		$db=Database::getinstance(); 
		$db->delete('DELETE FROM clients WHERE id=?',array($this->id));
		return $db;
		$db->close();
	}
	public static function showAll(){

		$db = Database::getinstance();
		$clients = $db->selectAll('SELECT * FROM clients ORDER BY id','','Client',1);
        $db->close();
        return $clients; 
	}
	public function getOne(){

	  $db=Database::getinstance();
       $client = $db->select('SELECT * FROM clients WHERE id=?',array($this->id),'Client',1);
       $db->close();
        return $client;       
	}  
	public static function getCount(){

		$db=Database::getinstance();
		$result=$db->select('SELECT COUNT(*) FROM clients','','',2);
		$db->close();
		return $result;
	}
	public static function getRegistrations(){

		$db=Database::getinstance();
		 $result=$db->selectAll('SELECT id,name,username,email,registrationDate,profileImage FROM clients ORDER BY id DESC LIMIT 10'
			,'','',0);
          $db->close();
          return  $result;
	}
	public function checkCourseRegistration($courseid){
		$db=Database::getinstance();
		$count=$db->select('SELECT COUNT(*) FROM client_course WHERE clientid='.$this->getId().' AND courseid='.$courseid,'','',2);
		if($count>0)return true;
		else return false;

	}
		//=================notification==============
	public function update(){

		$db=Database::getinstance();
		$db->update('UPDATE clients SET unseen_notific = unseen_notific + 1 WHERE id = ?',array($this->id));
		$db->close();
    }
    public function update_unseen($id){

		$db=Database::getinstance();
		$db->update('UPDATE clients SET unseen_notific = ? WHERE id= ?',array(0,$id));
		$db->close();
    }
    public function getnotify($id){
	    //include 'connection.php';
        $all=array();
        $all[]=News::get_ordered_news();	

//$stmt2=$con->prepare('SELECT unseen_notific FROM clients WHERE id= ?');
        $db=Database::getinstance();
      $all[]= $db->select('SELECT unseen_notific FROM clients WHERE id= ?',array($id),'',0);
      $db->close();
//$stmt2->execute(array($id));
//$all[]=$stmt2->fetch();
return $all;
}
public static function getv_unv_clients($flag){
        //require 'connection.php'; 
        if($flag == 1){

            $db=Database::getinstance();
            $all=$db->selectAll('SELECT * FROM clients WHERE verify = ?',array(1),'Client',1);
            $db=$db->close();
            return $all;
        }else{

            $db=Database::getinstance();
            $all=$db->selectAll('SELECT * FROM clients WHERE verify = ?',array(0),'Client',1);
            $db=$db->close();
            return $all;
        }

	}
	public static function search($key){
//include 'connection.php';
if(is_numeric($key)){

$db=Database::getinstance();
$all=$db->select('SELECT * FROM clients WHERE id =?',array($key),'Client',1);
$db->close();
return $all;
}else{

$db=Database::getinstance();
$all=$db->selectAll("SELECT * FROM clients WHERE name LIKE '%".$key."%'",'','Client',1);
$db->close();
return $all;
}
}
public function sendObject(addable $obj){
	$obj->add();
}
public function rateInstructor($instructor)
{$attr=array();
	$db=Database::getinstance();
	$attr[]=$instructor->getRate();
	$attr[]=$instructor->getId();
	$attr[]=$this->getId();
	  $db->insert(' INSERT INTO rates(value,instructorid,clientid) VALUES (?,?,?)',$attr);	
	  $db->close();
}

public function updateinsrate($instructor)
{
	$attr=array();
	$db=Database::getinstance();
	$attr[]=$instructor->getId();
	$number=$db->select('SELECT COUNT(*) FROM rates where instructorid=?',$attr,'',0);
	$sumofrates=$db->select('SELECT SUM(value) FROM rates where instructorid=?',$attr,'',0);
	$totalrate=$sumofrates/$number;
	$db->update('UPDATE instructors SET rate='.$totalrate.' where id=?',$attr);
	$db->close();
}
public function verifyrate(){
	$attr=array();
	$attr[]=$this->id;
$db=Database::getinstance();
$db->select('SELECT clientid FROM rates WHERE clientid = ?',$attr,'',0);
if($db->rowcount()>0){
	$db->close();
return 1;}
else {
	$db->close();
	return 0;}
}

public function verifyins ($instructor)
{
	$attr=array();
	$attr[]=$instructor->getId();
	$attr[]=$this->id;
$db=Database::getinstance();
$db->select('SELECT courseId FROM courses WHERE  myinstructorid=? AND courseId IN(SELECT courseid from client_course WHERE clientid=?)',$attr,'',0);
if($db->rowcount()>0){
	$db->close();
return true;}
else {
	$db->close();
	return false;}

}
	public function showmycourses(){
		
$query='SELECT name,hours,content,startDate,lectureTime,state,registerdate,courses.courseId,clientid FROM `courses`,client_course WHERE client_course.courseid = courses.courseId';

    $db =Database::getinstance();
$result=$db->selectAll($query,'','',0);
$db->close();
return $result;


	}

 

 public function showmybooks(){
 	

$query='SELECT name,description,price,edition,category,client_book.number,purchasedate,clientid FROM `books`,client_book WHERE client_book.bookid = books.bookId';
 $db =Database::getinstance();
$result=$db->selectAll($query,'','',0);
$db->close();
return $result;
 }
public function showdownloads($courseid){
$db=Database::getinstance();
$result=$db->select('SELECT resources from courses WHERE courseId = ?',array($courseid),'',0);
$db->close();
return $result;
}
public function checkTestimonial(){
			$db=Database::getinstance();
		$count=$db->select('SELECT COUNT(*) FROM testimonials WHERE client_id=?',array($this->id),'',2);
		$db->close();
		if($count>0)return true;
		else return false;
}
public function getUnRegisteredCourses(){
	$db= Database::getinstance();
	$courses=$db->selectAll('SELECT courses.courseId,name from courses WHERE courseId NOT IN(SELECT courseid FROM client_course where clientid =?)',array($this->id),'',0);
	$db->close();
	return $courses;
}
}