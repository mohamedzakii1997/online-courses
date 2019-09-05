<?php
class Contact_Us implements addable{
	private $id;
	private $message;
	private $clientId;

	public function setId($id){
		$this->id=$id;
	}	
	public function setMessage($message){
		$this->message=$message;
	}
	public function setClientId($clientId){
		$this->clientId=$clientId;
	}
	public function getId(){
		return $this->id;
	}
	public function getMessage(){
		return $this->message;
	}
	public function getClientId(){
		return $this->clientId;
	}
	public function delete(){

		$db=Database::getinstance();
		$db->delete('DELETE FROM contact_us WHERE id=?',array($this->id));
        $db->close();
		}
	public static function showAll(){

		$db=Database::getinstance();
		$all_test=$db->selectAll('SELECT * FROM contact_us','','Contact_Us',1);
		$db->close();
		return $all_test;
	}
	public function add(){
		$db=Database::getinstance();
		$db->insert('INSERT INTO contact_us(clientId,message) VALUES(?,?)',array($this->getClientId(),$this->getMessage()));
		$db->close();
	}
}