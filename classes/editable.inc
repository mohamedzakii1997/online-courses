<?php 
	 interface editable extends addable{
		public function edit();
		public function getOne();
		public static function search($key);
		public static function getCount();
	}
?>