$(function(){
    //初始化编辑器
    CKEDITOR.replace('content');
    //添加产品账号
    $('#addButton').click(function () {
        var title   = $('#title').val();
        var desc    = $('#desc').val();
        var pic     = $('#pic1').val();
        var content = CKEDITOR.instances.content.getData();
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
            url: "/Management/product/doAdd",
            data: {
                title   : title,
                desc    : desc,
                pic     : pic,
                content : content
            },
            dataType: "json",
            success: function(data){
                if(data.code == 200){
                    alert('添加成功');
                    window.location.href='/Management/product/list';
                }else {
                    alert('添加失败:'+data.msg);
                }
            }
        });
    });

});