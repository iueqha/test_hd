$(function(){

    SearchKey = {
        'searchId'    : $('#searchId').val(),
        'searchTitle' : $('#searchTitle').val(),
        'nowPage'      : $('#nowPage').val(),
    };
    //搜索
     $('#searchButton').click(function () {
         SearchKey.searchId    = $('#searchId').val();
         SearchKey.searchTitle = $('#searchTitle').val();
         var thisHref             = window.location.origin+window.location.pathname;
         thisHref                 += '?p=1&searchId='+SearchKey.searchId+'&searchTitle='+SearchKey.searchTitle;
         window.location.href = thisHref;
     });
    //删除
    $('.delButton').click(function () {
        var thisId = $(this).parents('tr').children('td').eq(0).text();
        var thisT  = $(this).parents('tr').children('td').eq(1).text();
        var r      = confirm('确认删除【'+thisT+'】吗？');
        if(r){
            $.ajax({
                type: "post",
                url: "/Management/banner/doDelete",
                data: {
                    id   : thisId
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
        
    });

});