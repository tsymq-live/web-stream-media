## 简单的服务端转码服务

### 0x0
 1.如何安装，和使用php程序一样，新建站点把代码丢上去就完了
 2.启动转码任务，运行根目录下的start
 3.windows用户启动start.exe
 4.linux用户运行start
#### linux下快速部署
你需要新建一个php站点，我这里的站点路径是 /www/123.com 你只需要替换该路径为自己网站路径即可
```
cd /www/123.com
git clone https://github.com/tsymq-live/web-stream-media.git
chmod 755 -R ./
cd web-stream-media
nohup ./start &


```

### 0x1
 1.声明：本软件完全免费，仅供学习交流使用，勿用于违法用途！！
 2.简介：这是我2017年写的流媒体工具，大概功能就是能够将你上传的视频自动转码切片
 3.说明：比较简陋，前端用php写的，你可以自行修改，如果有bug可以给我反馈下面有我的邮箱
 4.说明：前端你可以进行二次开发，转码端最早是用nodejs写的，最近翻出来用Go重写了
 5.技巧：可以用php和nginx配合实现token加密，达到文件有效期控制，以此来实现防盗链
 6.技巧：还可以用nginx将ts文件伪装成jpg可以用cloudflare达到加速效果
 7.技巧：如果你服务器有显卡(土豪)，可以开启gpu加速编码达到高速转码效果
 8.注意：conf.ini不要瞎配置
 9.暂时没有了，想到再补充
 10.更新直接覆盖即可

 Ps.播放器本来写了一个web-p2p加速插件，基于webrtc技术。
 但是对移动端不友好，因为国产移动端浏览器基本上不支持webrtc
 所以本次放出的版本被我阉割了。

### 0x3
#### /cron/          存放转码任务列表
 /hls/           存放切片文件
 /index/         存放视频信息索引
 /js/            前端静态资源
 /save/          存放上传视频
 /thumb/         存放视频截图文件
 /uploads/       存放上传分片文件
 /webuploader/   前端上传插件（来自百度）

### 0x4
 上传不了，多半是nginx上传限制到2m，修改nginx配置中的client_max_body_size改为4m即可
    
[详细文档](https://www.kancloud.cn/tsymq/easyvod/2732252)
	
### 界面预览
![](https://s1.ax1x.com/2022/04/17/LULSzV.gif)

:-: 联系作者：tsymq@live.com


> 云转码，流媒体，视频点播