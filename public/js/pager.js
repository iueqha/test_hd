$(function(){
    var pageCount = $('#pageCount').val();
    pageCount = parseInt(pageCount);
    var nowPage   =  $('#nowPage').val();
    nowPage = parseInt(nowPage);
    var pageContent = $('<ul></ul>');
    if(pageCount >1){
        if(nowPage == 1){
            var startP = $('<li class="disabled"><a href="#">首页</a></li><li class="active"><a href="javascript:changePage(1)">1</a></li>');
        }else{
            var startP = $('<li ><a href="javascript:changePage(1)">首页</a></li><li><a href="javascript:changePage(1)">1</a></li>');
        }
        pageContent.append(startP);
        if(pageCount <= 20){
            for(var i=2;i<20;i++){
                if(nowPage == i){
                    var pageLi = $('<li class="active"><a  href="javascript:changePage('+i+')">'+i+'</a></li>');
                }else {
                    var pageLi = $('<li ><a href="javascript:changePage('+i+')">'+i+'</a></li>');
                }
                pageContent.append(pageLi);
            }
        }else {
            if(nowPage <=10){
                for(var i=2;i<=15;i++){
                    if(nowPage == i){
                        var pageLi = $('<li class="active"><a href="javascript:changePage('+i+')">'+i+'</a></li>');
                    }else {
                        var pageLi = $('<li ><a href="javascript:changePage('+i+')">'+i+'</a></li>');
                    }

                    pageContent.append(pageLi);
                }
                var pageNote = $('<li class="disabled"><a href="#">...</a></li>');
                pageContent.append(pageNote);

                for(var i=pageCount-5;i<pageCount;i++){
                    var pageLi = $('<li ><a href="javascript:changePage('+i+')">'+i+'</a></li>');
                    pageContent.append(pageLi);
                }
            }else{
                for(var i=2;i<=6;i++){
                    var pageLi = $('<li ><a href="javascript:changePage('+i+')">'+i+'</a></li>');
                    pageContent.append(pageLi);
                }
                var pageNote = $('<li class="disabled"><a href="#">...</a></li>');
                pageContent.append(pageNote);
                if(pageCount - nowPage >10){
                    for(var i=nowPage-4;i<nowPage+4;i++){

                        if(nowPage == i){
                            var pageLi = $('<li  class="active"><a   href="javascript:changePage('+i+')">'+i+'</a></li>');
                        }else {
                            var pageLi = $('<li ><a href="javascript:changePage('+i+')">'+i+'</a></li>');
                        }
                        pageContent.append(pageLi);
                    }
                    var pageNote = $('<li class="disabled"><a href="#">...</a></li>');
                    pageContent.append(pageNote);
                }else {
                    for(var i=nowPage-5;i<pageCount;i++){
                        if(nowPage == i){
                            var pageLi = $('<li class="active"><a  href="javascript:changePage('+i+')">'+i+'</a></li>');
                        }else {
                            var pageLi = $('<li ><a href="javascript:changePage('+i+')">'+i+'</a></li>');
                        }
                        pageContent.append(pageLi);
                    }
                }

            }
        }
        if(nowPage == pageCount){
            var endP = $('<li class="active"><a  href="javascript:changePage('+pageCount+'">'+pageCount+'</a></li><li class="disabled"><a href="#" class="disabled">末页</a></li>');
        }else{
            var endP = $('<li><a  href="javascript:changePage('+pageCount+'">'+pageCount+'</a></li><li><a href="javascript:changePage('+pageCount+'">末页</a></li>');
        }
        pageContent.append(endP);

    }
    $('.pagination').append(pageContent);

});
function changePage(page) {
    var thisHref        = window.location.origin+window.location.pathname;
    var thisSearch      = window.location.search;
    thisSearch         += '&p='+page;
    window.location.href = thisHref+thisSearch;
}