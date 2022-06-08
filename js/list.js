$(function(){
    //重新转码
    $('[data-click="Revcode"]').click(function(){
        var tr = $(this).parents("tr");
        var id = tr.data("id");
        tr.addClass('pos');
        layer.confirm('确定要重新转码吗？',{
            btn: ['确定','取消'],
            formType: 0,
            end: function(){
                tr.removeClass('pos');
            }
        }, function(i){
            $.ajax({
                url:'revcode.php',
                type:'POST',
                data:{'md5':id},
                success:function(e){
                    layer.alert(e,function(){
                        location.href = location.href;
                    })
                },
                error:function(){
                    
                }
            })
        });
    })

    //删除
    $('[data-click="Delete"]').click(function(){
        var tr = $(this).parents("tr");
        var id = tr.data("id");
        tr.addClass('pos');
        layer.confirm('确定要删除该条数据吗？',{
            btn: ['确定','取消'],
            formType: 0,
            end: function(){
                tr.removeClass('pos');
            }
        }, function(i){
            $.ajax({
                url:'delete.php',
                type:'POST',
                data:{'md5':id},
                success:function(e){
                    layer.alert(e,function(){
                        location.href = location.href;
                    })
                },
                error:function(){
                    
                }
            })
        });
    })
    //重命名
    $('[data-click="Rename"]').click(function(){
        var tr = $(this).parents("tr");
        var id = tr.data("id");
        tr.addClass('pos');
        layer.prompt({
            title: '请输入新的视频名称',
            formType: 0,
            end: function(){
                tr.removeClass('pos');
            }
        }, function(i){
            $.ajax({
                url:'rename.php',
                type:'POST',
                data:{'md5':id,'title':i},
                success:function(e){
                    layer.alert(e,function(){
                        location.href = location.href;
                    })
                },
                error:function(){
                    
                }
            })
        });
    })

    $('[data-preview]').click(function(){
        var url = $(this).data('preview');
        layer.open({
            type: 2,
            title: '在线预览',
            shadeClose: true,
            shade: 0.8,
            area: ['63%', '63%'],
            content: url
        }); 
    })

    //显示缩略图
    $('.title').hover(function(e) {
        var top = $(this).position().top-112;
        var thumb = $(this).data('src');
        $('.preview').css({
            top: top,
            background:'url("'+thumb+'") center/cover'
        });
        $('.preview').show();
    }, function() {
        $('.preview').hide();
    });
    //显示转码时间
    $('[data-tisp]').click(function(){
        var title = $(this).data('tisp');
        layer.tips(title, $(this),{tips: [1, '#3595CC']});
    })

    var clipboard = new ClipboardJS('[data-clipboard-text]');
    clipboard.on('success', function(e) {
        layer.msg('复制成功');
    })
    
    console.info("%c 淡然 Email:  tsymq@live.com", "background: linear-gradient(87deg, rgba(0,0,0,1) 0%, rgba(91,91,91,1) 31%, rgba(128,127,127,1) 87%, rgba(55,55,55,1) 100%);font-family: helvetica; font-size: 20px;color:#fff;");
    console.info("%c 淡然 Email:  tsymq@live.com", "background: linear-gradient(87deg, rgba(0,0,0,1) 0%, rgba(91,91,91,1) 31%, rgba(128,127,127,1) 87%, rgba(55,55,55,1) 100%);font-family: helvetica; font-size: 20px;color:#fff;");
    
});
