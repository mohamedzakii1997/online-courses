 <?php

 class Database{

private static $instance = null;
private $conn;
private $count;

private function __construct(){	
//$this->conn = new PDO ("mysql:host=localhost;dbname=center","root","");
  try{
$this->conn= new PDO ("mysql:host=localhost;dbname=center","root","aymon");
$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo  "Faild to Connect to the Database";
    die();
}
  
}
public static function getinstance(){
if(self::$instance == null){self::$instance=new Database();}
return self::$instance;
}

public function insert($query,$attr){
	$stmt=$this->conn->prepare($query);
    $stmt->execute($attr);
}
public function selectAll($query,$attr,$classname,$option){
	$stmt=$this->conn->prepare($query);
	if($option==1){
	if(empty($attr))    $stmt->execute();
else
    $stmt->execute($attr);
    if($stmt->rowCount()>0){
    $this->count=$stmt->rowCount();
    return $stmt->fetchAll(PDO::FETCH_CLASS,$classname);}
    else return 0;}
 elseif($option==0){

    if(empty($attr))
    $stmt->execute();
    else $stmt->execute($attr);
    
    if($stmt->rowCount()>0){
     $this->count=$stmt->rowCount();
     return $stmt->fetchAll();}
     else return 0;
     } 
     
}
public function select($query,$attr,$classname,$option){
    $stmt2=$this->conn->prepare($query);
    if($option==1){
        $stmt2->execute($attr);
        if($stmt2->rowCount()>0){
            $this->count=$stmt2->rowCount();
            return $stmt2->fetchObject($classname);}
        else return 0;
    }
    else{
        if(empty($attr))
        $stmt2->execute();
       else   $stmt2->execute($attr);
       $this->count=$stmt2->rowCount();
        return $stmt2->fetchColumn();
    }
}


public function update($query,$attr){
	$stmt=$this->conn->prepare($query);
	if(empty($attr)) $stmt->execute();
	else {
        $stmt->execute($attr);
    }
}
public function close(){
    Database::$instance=null;
    $this->conn=null;
}
public function delete($query,$attr){	
$stmt=$this->conn->prepare($query);
$stmt->execute($attr);
}
public function rowcount(){
    return $this->count;
}
public function backup(){
$db2= new DBBackup($this->conn);
$ar=$db2->backup();
 if($ar['error']==false){
 $ar['msg'];
//echo  $ar['msg'];

  $fp = fopen('backup2.sql' ,'w+');
     fwrite($fp, $ar['msg']);
    
    fclose($fp); return true;}
    else return false;
}
}
?>