<?php
include "inc.php";

$title = $_POST['title'] or die('title');
if(empty($title)){
    die('名称不能为空');
}
$indexPath = 'index/'.$md5;
if(is_file($indexPath)){
    $index = file_get_contents($indexPath);
    $arr = json_decode($index,true);
    $arr['title'] = htmlspecialchars($title);
    if(file_put_contents($indexPath,json_encode($arr))){
        die('修改成功');
    }else{
        die('修改失败');
    }
}else{
     die('视频文件索引不存在');
}
?>