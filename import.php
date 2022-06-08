<?php
//导入本地文件
$dir = "./import/*";

if(!file_exists('./import/')){
    mkdir('./import/');
}
$files = glob($dir);


if($_POST){
    $path = $_POST['path'];
    if(empty($path)){
        exit;
    }
    foreach ($path as $v){
        $v = toGbk($v);
        if(!file_exists("./import/$v")){
            continue;
        }
        $md5 = md5_file("./import/$v");
        $indexPath = 'index/'.$md5;
        $savePath = 'save/'.$md5.'.'.getExt($v);
        $cronPath = 'cron/'.$md5.'.cron';

        rename("./import/$v", $savePath);
        //添加文件索引
        file_put_contents($indexPath,json_encode(
            array('md5'=>$md5,'title'=>htmlspecialchars($v),'save'=>$savePath,'type'=>0,'duration'=>'','utime'=>time(),'stime'=>'','etime'=>''))
        );
        //添加到任务列表
        file_put_contents($cronPath,'0');
    }
}


function getExt($path){
    $arr = explode(".",$path);
    return array_pop($arr);
}
function toUtf8($str){
    if(PATH_SEPARATOR == ':'){
        return $str;
    }
    $encode = mb_detect_encoding($str, array("gb2312",'UTF-8')); 
    return $str= mb_convert_encoding($str, 'UTF-8', $encode);
}
function toGbk($str){
    if(PATH_SEPARATOR == ':'){
        return $str;
    }
    $encode = mb_detect_encoding($str, array("gb2312",'UTF-8')); 
    return $str= mb_convert_encoding($str, "gb2312", $encode);
}
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>一键导入服务器视频，将文件放到import目录下然后导入</title>
    <script src="js/jquery-1.11.2.min.js"></script>
    <style>
        *{padding: 0;margin: 0;}
        html,body{
        }
        .c{
            width: 1200px;
            margin: 10px auto;
        }
    </style>
</head>
<body>
    <div class="c">
        <form method="post" action="?">
        <div><label for="ids"><input id="ids" type="checkbox">全选</label></div>
        <?php foreach($files as $k=>$v){  ?>
            <?php



            ?>
            <div><label for="id<?=$k?>"><input name="path[]" value="<?=toUtf8(basename($v))?>" id="id<?=$k?>" type="checkbox"><?=toUtf8($v)?></label></div>
        <?php } ?>
        <input type="submit" value="一键导入"/>
        </form>
    </div>
    <script>
        $('#ids').change(function(){
            if($(this).is(':checked')){
                $('input').prop('checked',true);
            } else {
                $('input').prop('checked',false);
            }
        })
    </script>
</body>
</html>