﻿<?php
session_start();
require_once("../config.php");
require_once("../functions.php");

if (!is_admin_login()) {
    header("Location: login.php");
    exit();
}

require_once("header.php");


$delete_id = (int) @$_GET['delete_id'];

if ($delete_id > 0) {
    mysqli_query($links,"DELETE FROM ".DB_PREFIX."urls WHERE id = '$delete_id'") or db_die(__FILE__, __LINE__, mysqli_error());
}

if (@$_GET['new_url'] <> "" and @$_GET['old_url'] <> "") {
    update_url($_GET['old_url'],$_GET['new_url']);
}

$qrcode_id = (int) @$_GET['qrcode_id'];
//var_dump($qrcode_id);
if ($qrcode_id > 0) {
    header("Location:qrcode.php?qrcode_id=$qrcode_id");
   exit();
}

$page = (int) @$_GET['page'];

if ($page < 1) {
    $page = 1;
}

$db_query = "1 AND ";

$search_alias = mysqli_real_escape_string($links,@$_GET['search_alias']);
$search_url   = mysqli_real_escape_string($links,@$_GET['search_url']);

if (!empty($search_alias)) {
    $db_query .= "(code = '$search_alias' ) AND ";
}

if (!empty($search_url)) {
    $db_query .= "url LIKE '%$search_url%' AND ";
}

$db_query  = substr($db_query, 0, -5);

$db_result = mysqli_query($links,"SELECT COUNT(id) FROM ".DB_PREFIX."urls WHERE $db_query") or db_die(__FILE__, __LINE__, mysqli_error());
$db_row    = mysqli_fetch_row($db_result);
$db_count  = (int) $db_row[0];

$db_start  = ($page - 1) * 25;
$db_pages  = ceil($db_count / 25);

$db_result = mysqli_query($links,"SELECT * FROM ".DB_PREFIX."urls WHERE $db_query ORDER BY date_added DESC LIMIT $db_start, 25") or db_die(__FILE__, __LINE__, mysqli_error());

echo "<table  border=\"0\" cellpadding=\"0\" cellspacing=\"0\" id=\"url_list\">\n"."<thead>";
    echo "<tr>\n".
         "<th style=\"border-radius: 4px 0 0 0;\">ID</th>\n".
         "<th>短代码</th>\n".
         /*"<th>别名</th>\n".*/
         "<th>原网址</th>\n".
         "<th>添加日期</th>\n".
        /* "<th>次数</th>\n".*/
         "<th style=\"border-radius: 0 4px 0 0;\">操作</th>\n".
	  "</tr>\n";
echo "</thead>";
while ($db_row = mysqli_fetch_assoc($db_result)) {
    $db_row = array_filter($db_row, "stripslashes");

    extract($db_row, EXTR_OVERWRITE|EXTR_PREFIX_ALL, "u");

   
//
    echo 
	  "<tr>\n".
	  "<td>$u_id</td>\n".
         "<td><a href=\"" . htmlentities($u_url) . "\" target=\"_blank\">" . htmlentities($u_code) . "</a></td>\n".
        /* "<td><a href=\"" . htmlentities($u_url) . "\" target=\"_blank\">" . htmlentities($u_alias) . "</a></td>\n".*/
         "<td><a href=\"" . htmlentities($u_url) . "\" target=\"_blank\">". htmlentities($u_url)."</a></td>\n".
         "<td>$u_date_added</td>\n".
         /*"<td>".$st."</td>\n".*/
         "<td><a class='del' href=\"javascript:delete_url($u_id);\">删除</a><a class =\"update\" href=\"index.php?old_id=".$u_id."\">修改</a><a class='del' href=\"index.php?qrcode_id=".$u_id."\">生成二维码</a></td>\n".
         "</tr>\n";
unset($u_id, $u_code, $u_url, $u_date_added);
}

echo "</table>\n";

if ($db_count > 25) {
    echo "<p>\n";

    if ($page > 1) {
        echo "<a href=\"index.php?page=".($page - 1)."\">&laquo; 上一页</a> ";
    }

    if ($page < $db_pages) {
        echo "<a href=\"index.php?page=".($page + 1)."\">下一页 &raquo;</a>";
    }

    echo "</p>\n";
}

require_once("footer.php");

