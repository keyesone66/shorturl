#功能简介
>index.php实现<br>
由短网址生成二维码，短网址的（短代码）和（原网址）入库。

>index2.php实现<br>
实现原网址生成短网址，原网址生成二维码，（短网址的短代码）和（原网址）入库。并且完成如下操作：<br>
删除admin下面的qrcode.php和phpqrcode.php文件；<br>
去掉admin/index.php<br> 
88行:

>		</a class='del' href=\"index.php?qrcode_id=".$u_id."\">生成二维码</a></td>\n";
>25~30行：

>	
	$qrcode_id = (int) @$_GET['qrcode_id'];
	//var_dump($qrcode_id);
	if ($qrcode_id > 0) {
    	header("Location:qrcode.php?qrcode_id=$qrcode_id");
   	exit();
	}

# 安装方式
将“shorturl.sql”导入数据库，并编辑“config.php”
  
>define('DB_HOSTNAME', 'localhost'); //数据库地址<br>
define('DB_USERNAME', ''); //数据库用户名<br>
define('DB_PASSWORD', ''); //数据库密码<br>
define('DB_NAME', ''); //数据库名<br>
define('DB_VERSION', '4');//数据库版本号，请勿修改<br>
define('DB_PREFIX', 'shorturl_'); //数据库前缀<br>
define('SITE_URL', 'https://demo.domain.org'); //你的网站地址，开头添加协议名，结尾不带“/”<br>
define('SITE_TITLE', 'ShortUrl'); //网页标题<br>
define('ADMIN_USERNAME', 'admin'); //管理员用户名<br>
define('ADMIN_PASSWORD', 'password'); //管理员密码<br>
define('URL_PROTOCOLS', 'http|https|ftp|ftps|mailto|news|mms|rtmp|rtmpt|ed2k'); //允许缩短的网址的协议<br>
define('SHORTURL_VERSION', '1.0.4');//版本号，请勿修改<br>
define('SHORTURL_NUMERICVERSION', '104');//版本号比对形式，请勿修改<br>
define('INDIRECTLYGO','0'); //开启跳转等待请将值更改为“1”，反之为“0”<br>
define('GOTIME','10');	//跳转等待的时间<br>


# 伪静态方式
Apache
		  
  
  	 RewriteEngine on
  	 RewriteOptions MaxRedirects=1
  	 RewriteBase /
   	 RewriteCond %{REQUEST_FILENAME} !-f
   	 RewriteCond %{REQUEST_FILENAME} !-d
  	 RewriteCond %{REQUEST_FILENAME} !-l
  	 RewriteRule ^([a-zA-Z0-9_-]+)$ redirect.php?alias=$1 [L]
  
```
Nginx
```  

	location / {
            rewrite ^/(.+)$ /redirect.php?alias=$1 last;
        }


# 注意
Nginx环境下访问后台需要在admin后面加上“/”才能登录。
如果无需SSL，请按以下程序操作：
 1. 编辑“index.php”, 注释第108行并取消注释第107行。
 2. 编辑“.htaccess”, 注释第9-10行。