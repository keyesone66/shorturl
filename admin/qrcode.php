<?php
session_start();
require_once("../config.php");
require_once("../functions.php");


if (!is_admin_login()) {
    header("Location: login.php");
    exit();
}

require_once("header.php");


require_once("phpqrcode.php");

$qrcode_id=$_GET['qrcode_id'];

$code= get_code($qrcode_id);

//var_dump($code);die;
$url = SITE_URL."/".$code; 
$value =  $url; //二维码内容     
$errorCorrectionLevel = 'L'; //容错级别     
$matrixPointSize = 6; //生成图片大小  
  
  // 生成二维码图片     
QRcode::png($value, 'qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);  

echo "<p class=info>二维码：<br><img src='qrcode.png'></p>";