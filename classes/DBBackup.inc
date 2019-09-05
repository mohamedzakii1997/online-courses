<?php
Class DBBackup { 
   

    /** 
     * 
     * Array with the tables of the database 
     * @var Array 
     */ 
    private $tables = array(); 

    /** 
     * 
     * Hold the connection 
     * @var ObjectConnection 
     */ 
    private $handler; 
    /** 
     * 
     * Array to hold the errors 
     * @var Array 
     */ 
    private $error = array(); 

    /** 
     * 
     * The result string. String with all queries 
     * @var String 
     */ 
    private $final; 

    /** 
     * 
     * The main function 
     * @method DBBackup 
     * @uses Constructor 
     * @param Array $args{host, driver, user, password, database} 
     * @example $db = new DBBackup(array('host'=>'my_host', 'driver'=>'bd_type(mysql)', 'user'=>'db_user', 'password'=>'db_password', 'database'=>'db_name')); 
     */ 
    public function DBBackup($con){ 
 $this->handler=$con;
    } 

    /** 
     * 
     * Call this function to get the database backup 
     * @example DBBackup::backup(); 
     */ 
    public function backup(){ 
        $this->getTables(); 
        $this->generate(); 
        if(count($this->error)>0){ 
            return array('error'=>true, 'msg'=>$this->error); 
        } 
        return array('error'=>false, 'msg'=>$this->final); 
    } 

    /** 
     * 
     * Generate backup string 
     * @uses Private use 
     */ 
    private function generate(){ 
        foreach ($this->tables as $tbl) { 
            $this->final .= '--CREATING TABLE '.$tbl['name']."\n"; 
            $this->final .= $tbl['create'] . ";\n\n"; 
            $this->final .= '--INSERTING DATA INTO '.$tbl['name']."\n"; 
            $this->final .= $tbl['data']."\n\n\n"; 
        } 
        $this->final .= '-- THE END'."\n\n"; 
    } 

    /** 
     * 
     * Connect to a database 
     * @uses Private use 
     */ 

    /** 
     * 
     * Get the list of tables 
     * @uses Private use 
     */ 
    private function getTables(){ 
        try { 
            $stmt = $this->handler->query('SHOW TABLES'); 
            $tbs = $stmt->fetchAll(); 
            $i=0; 
            foreach($tbs as $table){ 
                $this->tables[$i]['name'] = $table[0]; 
                $this->tables[$i]['create'] = $this->getColumns($table[0]); 
                $this->tables[$i]['data'] = $this->getData($table[0]); 
                $i++; 
            } 
            unset($stmt); 
            unset($tbs); 
            unset($i); 

            return true; 
        } catch (PDOException $e) { 
            $this->handler = null; 
            $this->error[] = $e->getMessage(); 
            return false; 
        } 
    } 

    /** 
     * 
     * Get the list of Columns 
     * @uses Private use 
     */ 
    private function getColumns($tableName){ 
        try { 
            $stmt = $this->handler->query('SHOW CREATE TABLE '.$tableName); 
            $q = $stmt->fetchAll(); 
            $q[0][1] = preg_replace("/AUTO_INCREMENT=[\w]*./", '', $q[0][1]); 
            return $q[0][1]; 
        } catch (PDOException $e){ 
            $this->handler = null; 
            $this->error[] = $e->getMessage(); 
            return false; 
        } 
    } 

    /** 
     * 
     * Get the insert data of tables 
     * @uses Private use 
     */ 
    private function getData($tableName){ 
        try { 
            $stmt = $this->handler->query('SELECT * FROM '.$tableName); 
            $q = $stmt->fetchAll(PDO::FETCH_NUM); 
            $data = ''; 
            foreach ($q as $pieces){ 
                foreach($pieces as &$value){ 
                    $value = htmlentities(addslashes($value)); 
                } 
                $data .= 'INSERT INTO '. $tableName .' VALUES (\'' . implode('\',\'', $pieces) . '\');'."\n"; 
            } 
            return $data; 
        } catch (PDOException $e){ 
            $this->handler = null; 
            $this->error[] = $e->getMessage(); 
            return false; 
        } 
    } 
} 
?>