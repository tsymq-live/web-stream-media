<?php
//输出切片后缀
header('Content-Type:application/x-mpegURL');
header("Content-Disposition: attachment; filename=danran.m3u8");
$hz = '.ts';
$id = $_GET['id'] or die ('by danran');
if(!preg_match('/^[a-z0-9]{32}$/',$id)){
  exit('参数不合法!');
}
$m3u8Path = $id .'/playlist.m3u8';
if(is_file($m3u8Path)){
  if($hz == '.ts'){
      $m3u8 = file_get_contents($m3u8Path);
      //echo $m3u8 = ltrim($m3u8,"\XEF\XBB\XBF");
      echo preg_replace('#\n(\d{4})#',"\n./{$id}/$1",$m3u8);
  }else{
      
  }
}else{
    die('file does not exist');
}
?>