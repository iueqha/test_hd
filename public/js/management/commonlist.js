$(function(){
    //初始化编辑器
    CKEDITOR.replace('content');
    //添加选项卡
    $('#addButton').click(function () {
        var name   = $('#name').val();
        var key    = $('#key').val();
        if(name == '' || name == null){
            alert('名称不能为空');
            return false;
        }
        if(key == '' || key == null){
            alert('内容标识不能为空');
            return false;
        }
        $.ajax({
            type: "post",
            url: "/Management/common/doAdd",
            data: {
                name   : name,
                key    : key
            },
            dataType: "json",
            success: function(data){
                if(data.code == 200){
                    alert('添加成功');
                    window.location.reload();
                }else {
                    alert('添加失败:'+data.msg);
                }
            }
        });
    });

});