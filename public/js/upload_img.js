$(function(){
	//上传
	$('input[type="file"]').change(function () {
		var thisid = $(this).attr('id');
		var index  = thisid[6];
		var file = document.querySelector('#upFile'+index);
		if(!file.files.length) {
			alert('请选择文件！');
			return false;
		}
		/*var limit_s = $(this).attr('limit_s');
		if(file.files[0].size > 1024*limit_s){
			alert('图片太大，最大不能超过'+limit_s+'K！');
			return false;
		}*/
		var params = new FormData();
		params.append('upload_file', file.files[0]);
		//限制宽高
		/*var limit_h = $(this).attr('limit_h');
		var limit_w = $(this).attr('limit_w');
		params.append('limit_height', limit_h);
		params.append('limit_width', limit_w);*/
		var module = /\w+/.exec(window.location.pathname)[0];
		localStorage.setItem(module+'file',file.value);
		var xhr = new XMLHttpRequest();
		xhr.open("post", "/upload/indexUpPicture" , true);
		xhr.send(params);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4) {
				var ret = eval("(" + xhr.responseText + ")");
				console.log(ret);
				/*if(ret.code == 200){
					var picPath = ret.result.picPath;
					var mediaId = ret.result.mediaId;
					//放入文本框
					$('#pic'+index).val(mediaId);
					$('#showPic'+index).html('<img src="'+picPath+'" height="100"/>');
				}else{
					alert(ret.msg);
				}*/
			}
		}
	});
})