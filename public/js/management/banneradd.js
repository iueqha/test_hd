$(function(){
    //添加产品账号
    $('#submitButton').click(function () {
        var title   = $('#title').val();
        var place    = $('input[name="place"]:checked').val();
        var pic     = $('#pic1').val();
       
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
            url: "/Management/banner/doAdd",
            data: {
                title   : title,
                pic     : pic,
                place   : place
            },
            dataType: "json",
            success: function(data){
                if(data.code == 200){
                    alert('添加成功');
                    window.location.href='/Management/banner/list';
                }else {
                    alert('添加失败:'+data.msg);
                }
            }
        });
    });

});