<?php
  include "inc.php";

  $cronPath = 'cron/'.$md5.'.cron';
  $indexPath = 'index/'.$md5;
  $index = file_get_contents($indexPath);
  $arr = json_decode($index,1);

  /* if($arr[type] == 1){
    echo '已经在转码了';
    exit;
  } */
  $arr['type'] = 0;
  $arr['stime'] = null;
  $arr['etime'] = null;
  file_put_contents($indexPath,json_encode($arr));
  file_put_contents($cronPath,"");
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
  die('重新添加到任务列表中了');

?>