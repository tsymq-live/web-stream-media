<?php
error_reporting(0);
date_default_timezone_set('PRC');
header("charset:utf-8");
$md5 = $_POST['md5'] or die('md5');
if(!preg_match('/^[a-z0-9]{32}$/',$md5)){
  exit('参数不合法!');
}
