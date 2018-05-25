<?php
define('SHORTURL', true);
//ini_set — 为一个配置选项设置值
ini_set('display_errors', 0);
//字首这里应该是请求头的意思
$prefix[0] = '';
?>
<?php
require_once("config.php");
require_once("functions.php");
require_once("phpqrcode.php");

db_connect();



if (count($_GET) > 0) {
    //mysql_real_escape_string() 函数转义 SQL 语句中使用的字符串中的特殊字符
    //trim — 去除字符串首尾处的空白字符（或者其他字符）
    $url   = mysql_real_escape_string(trim($_GET['url']));
    /*$alias = mysql_real_escape_string(trim($_GET['alias']));*/
    //var_dump($alias);die;
    //preg_match — 执行匹配正则表达式
    //define('URL_PROTOCOLS', 'http|https|ftp|ftps|mailto|news|mms|rtmp|rtmpt|ed2k'); //允许缩短的网址的协议
    if (!preg_match("/^(".URL_PROTOCOLS.")\:\/\//i", $url)) {
    //explode:把字符串打散为数组
 	$prefix = explode(":", $url);
 	if ($prefix[0] == 'mailto') {
 		$url = $url;
       // print_r($url);die;
 	} else {
        $url = "http://".$url;
 	}
    }
    //strlen长度
    //最后一个字母
    $last = $url[strlen($url) - 1];

    if ($last == "/") {
    //substr — 返回字符串的子串
    //下面为去掉最后一个
        $url = substr($url, 0, -1);
    }

    //parse_url — 解析 URL，返回其组成部分
    $data = @parse_url($url);
   
	//print_r($data);
		if ($prefix[0] == 'mailto') {
			$data['scheme'] = 'mailto';
			$data['host'] = 'none';
		}
    if (strlen($url) == 0) {
        $_ERROR[] = "<p class=error>请输入一个真实链接.</p>";
    }
    else if (empty($data['scheme']) || empty($data['host'])) {
        $_ERROR[] = "<p class=error>请输入一个有效的链接.</p>";
    }
    else {
        //返回$data['host']  www.ccc.cn
        $hostname = get_hostname();
        $domain   = get_domain();
        //返回ccc.cn
        //print_r($domain);die;
    }

        $code =substr($data[path], 1);

        $url=$_GET['yurl'];
        //var_dump($code);
        if (code_exists($code)) {
            echo '短网址已经生产二维码';
        }
        $id = insert_url($url, $code);
   
        //$short_url = SITE_URL."/".$code; 
        $value =  $url; //二维码内容     
        $errorCorrectionLevel = 'L'; //容错级别     
        $matrixPointSize = 6; //生成图片大小  
  
        // 生成二维码图片     
        QRcode::png($value, 'qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);  
        // 输出二维码图片  
        $_GET['url']   = "";
        $_GET['yurl'] = "";
        //$info = "<p class=info>短地址创建成功！新地址：<strong><a href=\"http://".htmlentities($short_url) ."\" target=\"_blank\">".htmlentities($short_url)."</a></strong> </p>";
        //<a href=\"" . htmlentities($u_url) . "\" target=\"_blank\">" . htmlentities($u_code) . "</a>
        //htmlentities — 将字符转换为 HTML 转义字符
        //$info = "<p class=info>短地址+二维码：<strong><a href=\"".htmlentities($short_url) ."\" target=\"_blank\">".htmlentities($short_url)."</a></strong><img src='qrcode.png'></p>";
        $info = "<p class=info>二维码：<br><img src='qrcode.png'></p>";
        
        require_once("html/index.php");
        exit();
    }

require_once("html/index.php");