<?php
require_once("config.php");
require_once("functions.php");

//初始化数据库连接
db_connect();
//header("Content-Type:text/html;charset=utf-8");
//mysql_real_escape_string() 函数转义 SQL 语句中使用的字符串中的特殊字符
//trim — 去除字符串首尾处的空白字符（或者其他字符）
$alias = trim(mysql_real_escape_string($_GET['alias']));
//var_dump($alias);die;
get_st($alias);

if (!preg_match("/^[a-zA-Z0-9_-]+$/", $alias)) {
 header("Location: ".SITE_URL);
  exit();
 }
if(INDIRECTLYGO==1){
	if (($url = get_url($alias))) {
        
        header("refresh:".GOTIME.";url=".$url."");
	       //include './ad.php';  //需要加载的页面地址
        echo "<br><a href=\"".$url."\">点击直接进入</a>";
        exit();
        
        }

}else{
  if (($url = get_url($alias))) {
      header("Location: $url");
      exit();
  }
}
echo "<script>document.location = '".SITE_URL."';</script>";
//header("Location: ".SITE_URL, true, 301);