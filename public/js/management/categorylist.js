$(function(){
    d = new dTree('d');

    d.add(0,-1,'全部分类',"javascript:clickCategory(0,'全部分类',0);");
    //循环写入树
    var list = [];
    $.ajax({
        url : '/Management/category/getList',
        type: 'post',
        data:{},
        success:function(data){
            if(data.code == 200){
                list = data.result;
                $.each(list, function (k,v) {
                    d.add(v.id,v.pid,v.title,'javascript:clickCategory('+v.id+',\''+v.title+'\','+v.pid+')');
                });
                document.getElementById("dtreeBox").innerHTML=d;
            }else{
                alert(data.msg);
            }
        }
    });

    document.getElementById("dtreeBox").innerHTML=d;
});
//点击类别
function clickCategory(category_id,title,pid) {
    if(category_id == 0){
        $('#categoryName').attr('disabled','disabled');
        $('#btn_update').hide();
        $('#btn_delete').hide();
    }else{
        $('#categoryName').removeAttr('disabled');
        $('#btn_update').show();
        $('#btn_delete').show();
    }

    $('#categoryName').val(title);
    $('#categoryId').val(category_id);
    document.documentElement.scrollTop = document.body.scrollTop =0;
}
//添加类别
function addCategory () {
    var title   = $('#newName').val();
    var pid    = $('#categoryId').val();
    if(title == ''){
        alert('类别名称不能为空');
        return false;
    }
    $.ajax({
        url : '/Management/category/doAdd',
        type: 'post',
        data:{
            title   : title,
            pid    : pid
        },
        success:function(data){
            if(data.code == 200){
                alert('操作成功');
                window.location.reload();
            }else{
                alert(data.msg);
            }
        }
    });
}
//修改类别
function updateCategory() {
    var title        = $('#categoryName').val();
    var category_id = $('#categoryId').val();
    if(title == ''){
        alert('类别名称不能为空');
        return false;
    }
    $.ajax({
        url : '/Management/category/doEdit',
        type: 'post',
        data:{
            title   : title,
            id     : category_id
        },
        success:function(data){
            if(data.code == 200){
                alert('操作成功');
                window.location.reload();
            }else{
                alert(data.msg);
            }
        }
    });
}
//删除类别
function delCategory() {
    var title        = $('#categoryName').val();
    var category_id = $('#categoryId').val();
    if(title == ''){
        alert('类别名称不能为空');
        return false;
    }
    if(confirm('确认删除类别【'+title+'】吗？')){

        $.ajax({
            url : '/Management/category/doDelete',
            type: 'post',
            data:{
                id     : category_id
            },
            success:function(data){
                console.log(data);
                if(data.code == 200){
                    alert('操作成功');
                    window.location.reload();
                }else{
                    alert(data.msg);
                }
            }
        });
    }

}