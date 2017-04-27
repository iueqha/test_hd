$(function(){
    //添加管理员账号
    $('#addButton').click(function () {
        var account = $('#account').val();
        var password = $('#password').val();
        if(account == '' || account == null){
            alert('管理员账号不能为空');
            return false;
        }
        if(password == '' || password == null){
            alert('管理员密码不能为空');
            return false;
        }
        $.ajax({
            type: "post",
            url: "/Management/manager/doAdd",
            data: {
                account : account,
                password : password
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
    //重置密码
    $('.resetPassword').click(function () {
        var id = $(this).parents('tr').children('td').eq(0).text();
        var account = $(this).parents('tr').children('td').eq(1).text();

        var r = confirm('确定重置管理员【'+account+'】的密码吗？');
        if(r){
            $.ajax({
                type: "post",
                url: "/Management/manager/resetPassword",
                data: {
                    id : id
                },
                dataType: "json",
                success: function(data){
                    if(data.code == 200){
                        alert('已成功重置密码，新的密码是'+data.result.password);
                        window.location.reload();
                    }else {
                        alert('重置失败:'+data.msg);
                    }
                }
            });
        }
    })
    //删除管理员
    $('.delManager').click(function () {
        var id = $(this).parents('tr').children('td').eq(0).text();
        var account = $(this).parents('tr').children('td').eq(1).text();

        var r = confirm('确定删除管理员【'+account+'】吗？');
        if(r){
            $.ajax({
                type: "post",
                url: "/Management/manager/delManager",
                data: {
                    id : id
                },
                dataType: "json",
                success: function(data){
                    if(data.code == 200){
                        alert('删除成功');
                        window.location.reload();
                    }else {
                        alert('删除失败:'+data.msg);
                    }
                }
            });
        }
    })
});