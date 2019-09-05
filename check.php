<?php
spl_autoload_register(function ($class){
             require 'classes/'.$class.'.inc';
        });
session_start();
        if(isset($_COOKIE['clientcookie'])){
    $user=unserialize($_COOKIE['clientcookie']);
     $_SESSION['CLIENT']=$user;

}
  $req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) {
  if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
    $value = urlencode(stripslashes($value));
  } else {
    $value = urlencode($value);
  }
  $req .= "&$key=$value";
}
$ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
if ( !($res = curl_exec($ch)) ) {
  curl_close($ch);
  exit;
}
curl_close($ch);
if (strcmp ($result, "VERIFIED") == 0) {
  $item_name = $_POST['item_name'];
  $item_number = $_POST['item_number'];
  $payment_status = $_POST['payment_status'];
  $payment_amount = $_POST['mc_gross'];
  $payment_quantity = $_POST['quantity'];
  $payment_currency = $_POST['mc_currency'];
  $receiver_email = $_POST['receiver_email'];
  $payer_email = $_POST['payer_email'];
  if(isset($_GET['check'])){
    if($_GET['check']=='book'){
      $book=new Book();
      $book->setId($item_number);
      $book=$book->getOne();
      if($payment_status=='Completed'&&$payment_currency=='USD'&&$payment_amount==$book->getPrice()&&$receiver_email=='center@gmail.com'&&$item_name==$book->getName()){
      	if(isset($_SESSION['CLIENT'])){
      		$client=$_SESSION['CLIENT'];
      		$client->payment=new paymentWithPaypal($payer_email);
      		$client->payment->payBook($book->getId(),$client->getId(),$payment_quantity,$payment_amount);
        }
      }
    }elseif($_GET['check']=='course'){
      $course=new Course();
      $course->setcourseid($item_number);
      $course=$course->getOne();
      if($payment_status=='Completed'&&$payment_currency=='USD'&&$payment_amount==$course->getprice()&&$receiver_email=='center@gmail.com'&&$item_name==$course->getname()){
        if(isset($_SESSION['CLIENT'])){
          $client=$_SESSION['CLIENT'];
          $client->payment=new paymentWithPaypal($payer_email);
          $client->payment->payCourse($course->getcourseid(),$client->getId(),$payment_quantity,$payment_amount);
        }
      }
    }
  }
}