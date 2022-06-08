<?php
//by danran 2016.06.16
//大文件上传分片处理，文件秒传
//修复秒传
//修复分片秒传
//修复单片合并出错问题
header("charset:utf-8");
error_reporting(1);
include "pclzip.php";
set_time_limit(10*60);
ignore_user_abort(true);
//允许上传的文件后缀，修改这里同时也要修改upload.js
$ext_arr = ['mp4','wmv','rmvb','avi','flv','mkv','rm'];
$md5 = isset($_POST['md5'])?$_POST['md5']:'';
$ext = isset($_POST['ext'])?strtolower($_POST['ext']):'';

$status = isset($_POST['status'])?$_POST['status']:'';
if(!preg_match('/^[a-z0-9]{32}$/',$md5)){
    exit('参数不合法!');
}


$savePath = 'save/'.$md5.'.'.$ext;
$cronPath = 'cron/'.$md5.'.cron';
$indexPath = 'index/'.$md5;

if($status == 'md5Check'){  //文件md5校验 0不存在
    if(is_file($savePath)){
        die(json_encode(array('ifExist'=>1,'md5'=>$md5)));
    }else{
        die('{"ifExist":0}');
    }
}

if($status == 'chunkCheck'){    //分片文件校验
    $chunkIndex = $_POST['chunkIndex'];
    $chunkFilePath = 'uploads/'.$md5.'_'.$chunkIndex.'.part';
    if(is_file($chunkFilePath)){
        die('{"ifExist":1}');
    }else{
        die('{"ifExist":0}');
    }
}

if($status == 'chunksMerge'){   //文件合并
    $chunks = $_POST['chunks'];
    if(!in_array($ext,$ext_arr)){
        exit("不允许上传的文件");
    }
    $fileoldname = htmlspecialchars($_POST['fileoldname']);
    if(is_file($savePath)){      //文件存在，秒传了不合并
        if(!is_file($indexPath)){
            //添加文件索引
            file_put_contents($indexPath,json_encode(
                array('md5'=>$md5,'title'=>$fileoldname,'save'=>$savePath,'type'=>0,'duration'=>'','utime'=>time(),'stime'=>'','etime'=>''))
            );
            //添加到任务列表
            file_put_contents($cronPath,'0');            
        }
        die(json_encode(array('md5'=>$md5,'title'=>$fileoldname)));
    }else{
        $out = fopen($savePath,'wb');
        for($index=0;$index<$chunks;$index++){
            if(flock($out,LOCK_EX)){
                if(!$in = fopen('uploads/'.$md5.'_'.$index.'.part','rb')){
                    break;
                }
                if(empty($in)){
                    exit('chunksMerge err [empty]');
                }
                while($buff = fread($in, 4096)){
                    fwrite($out, $buff);
                }
                @fclose($in);
                @unlink('uploads/'.$md5.'_'.$index.'.part');
                flock($out,LOCK_UN);
            }
        }
        fclose($out);
        
        if($ext=='zip'){        //解压视频包（废弃功能）
/*             $archive = new PclZip($savePath);
            $archive->extract(PCLZIP_OPT_PATH, './hls/'.$md5.'/');
            $f = file_get_contents('./hls/'.$md5.'/'.'playlist.m3u8');
            $f = str_replace('.ts','.js',$f);
            file_put_contents('./hls/'.$md5.'/'.'playlist.m3u8',$f);
            die(json_encode(array('md5'=>$md5,'title'=>$fileoldname))); */
        }else{
            //添加文件索引
            file_put_contents($indexPath,json_encode(
                array('md5'=>$md5,'title'=>$fileoldname,'save'=>$savePath,'type'=>0,'duration'=>'','utime'=>time(),'stime'=>'','etime'=>''))
            );
            //添加到任务列表
            file_put_contents($cronPath,'0');
            die(json_encode(array('md5'=>$md5,'title'=>$fileoldname)));
        }
    }
}

if(empty($status)){     //文件上传
    $uniqueFileName = $_POST['md5'];                            //唯一文件名
    $chunk = $_POST['chunk']  ? $_POST['chunk'] : '0';          //当前分片ID
    if($_FILES){
        if($_FILES['file']['tmp_name']){
            move_uploaded_file($_FILES['file']['tmp_name'],'uploads/'.$uniqueFileName.'_'.$chunk.'.part');
        }
    }
}

?>