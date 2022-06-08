<?php
    error_reporting(1);
	date_default_timezone_set('PRC');
	$path = 'index/*';
	$files = glob($path);
	$arr = array();
	foreach ($files as $k=>$v) {
		$file = file_get_contents($v);
		$tmp = json_decode($file,1);
		if($tmp['type']==0){
			$tmp['type'] = '待转码';
		}elseif ($tmp['type']==1) {
			$tmp['type'] = '转码中';
		}elseif ($tmp['type']==3) {
			$tmp['type'] = '转码完成';
		}elseif ($tmp['type']==4) {
			$tmp['type'] = '文件异常';
		}
        
        //上传时间
        $tmp['utime'] = date('Y-m-d H:i',$tmp['utime']);
        //任务开始时间
        $tmp['stime'] = $tmp['stime'] ? date('Y-m-d H:i',$tmp['stime']) : '转码未开始！！';
        //任务完成时间
        $tmp['etime'] = $tmp['etime'] ? date('Y-m-d H:i',$tmp['etime']) : '';
        
        
		$tmp['thumb'] = 'thumb/'.$tmp['md5'].'.jpg';
        if(isset($tmp['duration'])){
            $tmp['duration'] = number_format($tmp['duration']/60, 1);
        }else{
            $tmp['duration'] = 0;
        }
        $_k = filectime($v) . $k;
		$arr[$_k] = $tmp;
	}
	krsort($arr);
?>
<!DOCTYPE html>
<html lang="zh">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>视频列表</title>
	<link rel="stylesheet" href="webuploader/css/up.css" />
</head>
<body>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/layer/layer.css"></script>
	<script src="js/clipboard.min.js"/></script>
    <script src="js/list.js"></script>
<div class="hyright">
<div class="container mt10 yh">
    <div class="shipin_tit mb20" id="addvideo">
      <h2>
        <ul>
          <li class=""><a href="index.html">上传视频包</a></li>
          <li class="selected">视频管理</li>
        </ul>
        <div class="clear"></div>
      </h2>
    </div>
	<table>
		<tr>
			<th>Date</th>
			<th width="200">视频名称</th>
			<th>时长</th>
			<th>状态</th>
			<th>视频ID</th>
			<th>操作</th>
		</tr>
		<?php
			foreach ($arr as $k => $v) {
		?>
		<tr data-id="<?=$v['md5']?>">
			<td><?php echo date('m-d',$k); ?></td>
			<td class="title" data-src="<?=$v['thumb']?>"><?=$v['title']?></td>
			<td><?=$v['duration']?>分钟</td>
			<td><a href="javascript:;" data-tisp="任务开始时间<?=$v['stime']?><br/>任务结束时间<?=$v['etime']?>"><?=$v['type']?></a></td>
			<td contenteditable="true" data-clipboard-text="<?=$v['md5']?>"><?=$v['md5']?></td>
			<td>
			<a data-preview="hls/player.html?api.php?id=<?=$v['md5']?>" href="javascript:;">预览</a> | <a href="javascript:;" data-click="Rename">重命名</a> |<a href="javascript:;" data-click="Revcode">重新转码</a> | <a href="javascript:;" data-click="Delete">删除</a></td>
		</tr>
		<?php
			}
		?>
	</table>
	<div class="preview"></div>
</div>	

</body>
</html>