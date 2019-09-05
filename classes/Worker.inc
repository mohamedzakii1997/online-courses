<?php 
abstract class  Worker extends User implements addable,editable{
	protected $phone;
	protected $address;
	protected $salary;
	protected $workDate;

	 public function setPhone($phone){
            $this->phone=$phone;
        }


 public function setAddress($address){
            $this->address=$address;
        }

 public function setSalary($salary){
            $this->salary=$salary;
        }

 public function setWorkdate($workDate){
            $this->workDate=$workDate;
        }


public function getPhone(){
  return $this->phone;
} 
public function getAddress(){
  return $this->address;
}
 public function getSalary(){
  return $this->salary;
}
 public function getWorkdate(){
  return $this->workDate;
} 

		
}