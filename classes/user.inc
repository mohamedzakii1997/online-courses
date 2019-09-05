<?php
class User{
    protected $id;
    protected $name;
    protected $password;
    protected $username;
    protected $email;
    protected $profileImage;

    public function setId($id){
        $this->id=$id;
    }
    public function setUsername($username){
        $this->username=$username;
    }
    public function setPassword($password){
        $this->password=$password;
    }
    public function setEmail($email){
        $this->email=$email;
    }
    public function setName($name){
        $this->name=$name;
    }
    public function setProfileImage($image){
        $this->profileImage=$image;
    }
    public function getUsername(){
        return $this->username;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getName(){
        return $this->name;
    }
    public function getId(){
        return $this->id;
    }
    public function getProfileImage(){
        return $this->profileImage;
    }
    public function login(){
        //include 'connection.php';
        $hash=sha1($this->password);
        /*$stmt=$con -> prepare("SELECT * FROM clients WHERE username=:name AND password = :pass");
        $stmt->bindParam(":name",$this->username,PDO::PARAM_STR);
        $stmt->bindParam(":pass",$hash,PDO::PARAM_STR);
        $stmt->execute();*/
        $db=Database::getinstance();
        $client=$db->select('SELECT * FROM clients WHERE username=? AND password = ?',array($this->username,$hash),'Client',1);
        if ($db->rowcount()>0){
            //$client= $stmt->fetchObject('Client');
            //$con=null;
            $db->close();
            return $client;
                  }else{
                    /*$stmt=$con -> prepare("SELECT * FROM instructors WHERE username=:name AND password = :pass");
                    $stmt->bindParam(":name",$this->username,PDO::PARAM_STR);
                    $stmt->bindParam(":pass",$hash,PDO::PARAM_STR);
                    $stmt->execute();*/
            $instructor=$db->select('SELECT * FROM instructors WHERE username=? AND password = ?',array($this->username,$hash),'Instructor',1);
                    if ($db->rowcount()>0){
                        //$instructor= $stmt->fetchObject('Instructor');
                        //$con=null;
                        $db->close();
                        return $instructor;
                    }else{
                        /*$stmt=$con -> prepare("SELECT * FROM supervisors WHERE username=:name AND password = :pass");
                        $stmt->bindParam(":name",$this->username,PDO::PARAM_STR);
                        $stmt->bindParam(":pass",$hash,PDO::PARAM_STR);
                        $stmt->execute();*/
                        $supervisor=$db->select('SELECT * FROM supervisors WHERE username=? AND password = ?',array($this->username,$hash),'Supervisor',1);
                        if ($db->rowcount()>0){
                            //$supervisor= $stmt->fetchObject('Supervisor');
                            //$con=null;
                            $db->close();
                            return $supervisor; 
                    }else{
                        /*$stmt=$con -> prepare("SELECT * FROM admins WHERE username=:name AND password = :pass");
                        $stmt->bindParam(":name",$this->username,PDO::PARAM_STR);
                        $hash=sha1($this->password);
                        $stmt->bindParam(":pass",$hash,PDO::PARAM_STR);
                        $stmt->execute();*/
                        $admin=$db->select('SELECT * FROM admins WHERE username=? AND password = ?',array($this->username,$hash),'Admin',1);
                        if ($db->rowcount()>0){
                            //$admin= $stmt->fetchObject('Admin');
                            //$con=null;
                            $db->close();
                            return $admin;
                        }else return null;

                    }
                  }
              }
        
    }// End function 
    public function  logout(){
        session_unset();
        session_destroy();
        if(isset($_COOKIE['clientcookie'])){
            
        setcookie("clientcookie","",time()-60*60*7,"/");

        }elseif(isset($_COOKIE['SUPERVISORcookie'])){
            
        setcookie("SUPERVISORcookie","",time()-60*60*7,"/");


        }elseif (isset($_COOKIE['Admincookie'])){
            
        setcookie("Admincookie","",time()-60*60*7,"/");


        }elseif (isset($_COOKIE['INSTRUCTORcookie'])){
            
        setcookie("INSTRUCTORcookie","",time()-60*60*7,"/");


        }
    }
    public function changePassword($password,$table){
        $this->password=sha1(filter_var($password,FILTER_SANITIZE_STRING));
        $db=Database::getinstance();
        $db->update("UPDATE ".$table." SET password=? WHERE id=".$this->id,array($this->password));
        $db->close();
    }
    public function resetLost($tablename){
        $db=Database::getinstance();
        $db->update("UPDATE ".$tablename." SET lost=NULL WHERE id=".$this->id,array());
        $db->close();
    }
    public function editProfile(){
        if ($this instanceof Admin){
            $sql='UPDATE admins SET name=?,email=?';
            if(!empty($this->profileImage))$sql.=',profileImage=?';
            $sql.=' WHERE id ='.$this->id;
            $attr=array();
            $attr[]=$this->name;
            $attr[]=$this->email;
            if(!empty($this->profileImage)) $attr[]=$this->profileImage;
            $db=Database::getinstance();
            $db->update($sql,$attr);
            $db->close();
        }elseif($this instanceof Client){
            $sql='UPDATE clients SET name=?,email=?,phone=?';
            if(!empty($this->profileImage))$sql.=',profileImage=?';
            $sql.=' WHERE id =?';
            $attr=array();
            $attr[]=$this->name;
            $attr[]=$this->email;
            $attr[]=$this->getPhone();
            if(!empty($this->profileImage)) $attr[]=$this->profileImage;
            $attr[]=$this->id;
            $db=Database::getinstance();
            $db->update($sql,$attr);
            $db->close();

        }elseif($this instanceof Instructor){
            $sql='UPDATE instructors SET name=?,email=?,phone=?,description=?,address=?';
            if(!empty($this->profileImage))$sql.=',profileImage=?';
            $sql.=' WHERE id ='.$this->id;
            $attr=array();
            $attr[]=$this->name;
            $attr[]=$this->email;
            $attr[]=$this->getPhone();
            $attr[]=$this->getDescription();
            $attr[]=$this->getAddress();
            if(!empty($this->profileImage)) $attr[]=$this->profileImage;
            $db=Database::getinstance();
            $db->update($sql,$attr);
            $db->close();

        }elseif($this instanceof Supervisor){
            $sql='UPDATE supervisors SET name=?,email=?,phone=?,address=?';
            if(!empty($this->profileImage))$sql.=',profileImage=>';
            $sql.=' WHERE id ='.$this->id;
            $attr=array();
            $attr[]=$this->name;
            $attr[]=$this->email;
            $attr[]=$this->getPhone();
            $attr[]=$this->getAddress();
            if(!empty($this->profileImage)) $attr[]=$this->profileImage;
            $db=Database::getinstance();
            $db->update($sql,$attr);
            $db->close();

        }
    }
}// End class