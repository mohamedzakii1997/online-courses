<?php 
spl_autoload_register(function ($class){
             require 'classes/'.$class.'.inc';
        });

	$client= new Client();
	$client->setId('3');
  	$client->payment=new paymentWithPaypal('gmgg@gmail.com');
  		$client->payment->payCourse('5',$client->getId(),'5','500');