<?php 
 interface payment{
	function payBook($bookid,$clientid,$number,$amount);
	 function payCourse($courseid,$clientid,$number,$amount);
}
?>