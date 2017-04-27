$(function(){
    var pageCount = 30;//'{#$pageCount#}';
    var nowPage   =  $('#nowPage').val();
    var pageContent = $('<ul></ul>');
    if(pageCount >1){
        if(nowPage == 1){
            var startP = $('<li class="disabled"><a href="#">首页</a></li><li class="active"><a href="?p=1">1</a></li>');
        }else{
            var startP = $('<li ><a href="?p=1">首页</a></li><li><a href="?p=1">1</a></li>');
        }
        pageContent.append(startP);
        if(pageCount <= 20){
            for(var i=2;i<20;i++){
                if(nowPage == i){
                    var pageLi = $('<li class="active"><a  href="?p='+i+'">'+i+'</a></li>');
                }else {
                    var pageLi = $('<li ><a href="?p='+i+'">'+i+'</a></li>');
                }
                pageContent.append(pageLi);
            }
        }else {
            if(nowPage <=10){
                for(var i=2;i<=15;i++){
                    if(nowPage == i){
                        var pageLi = $('<li class="active"><a href="?p='+i+'">'+i+'</a></li>');
                    }else {
                        var pageLi = $('<li ><a href="?p='+i+'">'+i+'</a></li>');
                    }

                    pageContent.append(pageLi);
                }
                var pageNote = $('<li class="disabled"><a href="#">...</a></li>');
                pageContent.append(pageNote);

                for(var i=pageCount-5;i<pageCount;i++){
                    var pageLi = $('<li ><a href="?p='+i+'">'+i+'</a></li>');
                    pageContent.append(pageLi);
                }
            }else{
                for(var i=2;i<=5;i++){
                    var pageLi = $('<li ><a href="?p='+i+'">'+i+'</a></li>');
                    pageContent.append(pageLi);
                }
                var pageNote = $('<li class="disabled"><a href="#">...</a></li>');
                pageContent.append(pageNote);
                if(pageCount - nowPage >5){
                    for(var i=nowPage-4;i<nowPage+4;i++){
                        console.log(111);
                        if(nowPage == i){
                            var pageLi = $('<li  class="active"><a   href="?p='+i+'">'+i+'</a></li>');
                        }else {
                            var pageLi = $('<li ><a href="?p='+i+'">'+i+'</a></li>');
                        }
                        pageContent.append(pageLi);
                    }

                    var pageNote = $('<li class="disabled"><a href="#">...</a></li>');
                    pageContent.append(pageNote);
                }else {
                    for(var i=nowPage-4;i<pageCount;i++){
                        if(nowPage == i){
                            var pageLi = $('<li class="active"><a  href="?p='+i+'">'+i+'</a></li>');
                        }else {
                            var pageLi = $('<li ><a href="?p='+i+'">'+i+'</a></li>');
                        }
                        pageContent.append(pageLi);
                    }
                }

            }
        }
        if(nowPage == pageCount){
            var endP = $('<li class="active"><a  href="?p='+pageCount+'">'+pageCount+'</a></li><li><a href="#" class="disabled">末页</a></li>');
        }else{
            var endP = $('<li><a  href="?p='+pageCount+'">'+pageCount+'</a></li><li><a href="?p='+pageCount+'">末页</a></li>');
        }
        pageContent.append(endP);

    }
    $('.pagination').append(pageContent);

});