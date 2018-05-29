<?php
header("Content-type:text/html;charset=utf-8");
$links=mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD,DB_NAME) or db_die(__FILE__, __LINE__, mysqli_error());

    if (DB_VERSION > 4) {
         mysqli_set_charset($links,'UTF8') or db_die(__FILE__, __LINE__, mysqli_error());
    }


function get_last_number() {
    $db_result = mysqli_query("SELECT last_number FROM ".DB_PREFIX."settings") or db_die(__FILE__, __LINE__, mysqli_error());
    $db_row    = mysqli_fetch_row($db_result);

    return $db_row[0];
}

function increase_last_number() {
    //last-number+1操作
    mysqli_query("UPDATE ".DB_PREFIX."settings SET last_number = (last_number + 1)") or db_die(__FILE__, __LINE__, mysqli_error());

    return (mysqli_affected_rows() > 0) ? true : false;
}

function code_exists($code) {
     $links=mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD,DB_NAME);
    //判断短码是否存在
    $query = "SELECT COUNT(id) FROM ".DB_PREFIX."urls WHERE BINARY code = '$code'";
    $db_result = mysqli_query($links,$query);
    $db_row    = mysqli_fetch_row($db_result);
     //var_dump($row);die;
    return ($db_row[0] > 0) ? true : false;
}

function alias_exists($alias) {
    //判断alias是否存在
    $db_result = query("SELECT COUNT(id) FROM ".DB_PREFIX."urls WHERE BINARY alias = '$alias'") or db_die(__FILE__, __LINE__, mysqli_error());
    $db_row    = mysqli_fetch_row($db_result);

    return ($db_row[0] > 0) ? true : false;
}

//
function url_exists($url) {
    //查出id，和code
    $db_result = mysqli_query("SELECT id, code FROM ".DB_PREFIX."urls WHERE url LIKE '$url'") or db_die(__FILE__, __LINE__, mysqli_error());

    if (mysqli_num_rows($db_result) > 0) {
    //返回id ，code
        return mysqli_fetch_row($db_result);
    }

    return false;
}

function update_url($id, $alias) {
    //修改数据
    $links=mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD,DB_NAME);
    mysqli_query($links,"UPDATE ".DB_PREFIX."urls SET url = '$alias' WHERE id = '$id'") or db_die(__FILE__, __LINE__, mysqli_error());
}
/*
function update_url_st(){
    mysqli_query("INSERT INTO ").DB_PREFIX."urls SET st"
}
*/ 
function get_url($alias) {

    $db_result = mysqli_query("SELECT url FROM ".DB_PREFIX."urls WHERE BINARY code = '$alias' ") or db_die(__FILE__, __LINE__, mysqli_error());
    //mysqli_num_rows() 函数返回结果集中行的数目
    //mysqli_fetch_row() 函数从结果集中取得一行作为数字数组
    if (mysqli_num_rows($db_result) > 0) {
        $db_row = mysqli_fetch_row($db_result);
        return $db_row[0];
    }

    return false;
}

function get_code($qrcode_id) {

    $links=mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD,DB_NAME);

    $db_result = mysqli_query($links,"SELECT code FROM ".DB_PREFIX."urls WHERE id = '$qrcode_id' ") or db_die(__FILE__, __LINE__, mysqli_error());
    //mysqli_num_rows() 函数返回结果集中行的数目
    //mysqli_fetch_row() 函数从结果集中取得一行作为数字数组
    if (mysqli_num_rows($db_result) > 0) {
        $db_row = mysqli_fetch_row($db_result);
        return $db_row[0];
    }

    return false;

    
}











function db_die($filename, $line, $message) {
    die("文件: $filename<br />行: $line<br />信息: $message");
}

function generate_code($number) {
    //获取短码
    $out   = "";
    $codes = "abcdefghjkmnpqrstuvwxyz23456789ABCDEFGHJKMNPQRSTUVWXYZ";

    while ($number > 53) {
        $key    = $number % 54;
        $number = floor($number / 54) - 1;
        $out    = $codes{$key}.$out;
    }

    return $codes{$number}.$out;
}

function get_hostname() {
    //parse_url — 解析 URL，返回其组成部分
    $data = parse_url(SITE_URL);
    
    return $data['host'];
}


function get_domain() {
    $hostname = get_hostname();

    preg_match("/\.([^\/]+)/", $hostname, $domain);

    return $domain[1];
}

function print_errors() {
    global $_ERROR;

    if (count($_ERROR) > 0) {
        echo "<div class=\"error\">\n";

        foreach ($_ERROR as $key => $value) {
            echo "<p>$value</p>\n";
        }

        echo "</div>\n";
    }
}

function is_admin_login() {
    if (@$_SESSION['admin'] == 1) {
        return true;
    }

    return false;
    }


  
    