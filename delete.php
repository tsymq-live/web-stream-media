<?php
include "inc.php";

$indexPath = 'index/'.$md5;
if(is_file($indexPath)){
    if(unlink($indexPath)){
        echo "删除索引成功<br/>";
    }
}else{
     echo '视频文件索引不存在<br/>';
}
$hlsPath = 'hls/'.$md5;
if(deldir($hlsPath)){
    echo "删除切片成功<br/>";
}
$thumb = "thumb/{$md5}.jpg";
if(unlink($thumb)){
  echo "删除缩略图成功<br/>";
}
function deldir($dir) {
  //先删除目录下的文件：
  $dh=opendir($dir);
  while ($file=readdir($dh)) {
    if($file!="." && $file!="..") {
      $fullpath=$dir."/".$file;
      if(!is_dir($fullpath)) {
          unlink($fullpath);
      } else {
          deldir($fullpath);
      }
    }
  }
 
  closedir($dh);
  //删除当前文件夹：
  if(rmdir($dir)) {
    return true;
  } else {
    return false;
  }
}
?>