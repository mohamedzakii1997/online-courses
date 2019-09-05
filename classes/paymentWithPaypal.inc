<?php 
	class paymentWithPaypal implements payment{
		private $email;
		function __construct($email){
			$this->email=$email;
		}
		public function payBook($bookid,$clientid,$number,$amount){
			$db=Database::getinstance();
			$query='INSERT INTO client_book(clientid,bookid,purchasedate,number) VALUES (?,?,CURRENT_DATE,?)';
			$attr=array($clientid,$bookid,$number);
			$db->insert($query,$attr);

			$query='UPDATE books SET number=number-1 WHERE bookId=?';
			$attr=array($bookid);
			$db->update($query,$attr);

			$query='INSERT INTO paypal(clientid,email,amount,paydate) VALUES(?,?,?,CURRENT_DATE)';
			$attr=array($clientid,$this->email,$amount*$number);
			$db->insert($query,$attr);
			$db->close();
		}
		public function payCourse($courseid,$clientid,$number,$amount){
			$db=Database::getinstance();
			$query='INSERT INTO client_course(clientid,courseid,registerdate) VALUES (?,?,CURRENT_DATE)';
			$attr=array($clientid,$courseid);
			$db->insert($query,$attr);

			$query='UPDATE courses SET max=max-1 WHERE courseId=?';
			$attr=array($courseid);
			$db->update($query,$attr);

			$query='INSERT INTO paypal(clientid,email,amount,paydate) VALUES(?,?,?,CURRENT_DATE)';
			$attr=array($clientid,$this->email,$amount*$number);
			$db->insert($query,$attr);
			$db->close();
		}
	}
?>