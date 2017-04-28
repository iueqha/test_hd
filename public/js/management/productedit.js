$(function(){
    //初始化编辑器
    CKEDITOR.replace('content');
    //添加产品账号
    $('#submitButton').click(function () {
        var id      = $('#id').val();
        var title   = $('#title').val();
        var desc    = $('#desc').val();
        var pic     = $('#pic1').val();
        var content = CKEDITOR.instances.content.getData();
        if(id == '' || id == null || isNaN(id)){
            alert('当前不可编辑，请重试');
            history.back();
            return false;
        }
        if(title == '' || title == null){
            alert('名称不能为空');
            return false;
        }
        if(pic == '' || pic == null){
            alert('请上传图片');
            return false;
        }
        if(content == '' || content == null){
            alert('内容不能为空');
            return false;
        }
        $.ajax({
            type: "post",
            url: "/Management/product/doEdit",
            data: {
                id      : id,
                title   : title,
                desc    : desc,
                pic     : pic,
                content : content
            },
            dataType: "json",
            success: function(data){
                if(data.code == 200){
                    alert('提交成功');
                    window.location.reload();
                }else {
                    alert('提交失败:'+data.msg);
                }
            }
        });
    });

});