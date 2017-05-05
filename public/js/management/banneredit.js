$(function(){
    //添加产品账号
    $('#submitButton').click(function () {
        var id      = $('#id').val();
        var title   = $('#title').val();
        var place    = $('input[name="place"]:checked').val();
        var pic     = $('#pic1').val();
        if(id == '' || id == null || isNaN(id)){
            alert('当前不可编辑，请重试');
            history.back();
            return false;
        }
        if(title == '' || title == null){
            alert('名称不能为空');
            return false;
        }
        if(place == '' || place == null){
            alert('请选择位置');
            return false;
        }
        if(pic == '' || pic == null){
            alert('请上传图片');
            return false;
        }
        $.ajax({
            type: "post",
            url: "/Management/banner/doEdit",
            data: {
                id      : id,
                title   : title,
                pic     : pic,
                place   : place
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