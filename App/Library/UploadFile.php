<?php
namespace App\Library;
class UploadFile{
	public function storeFile($fileKey){
		$mediaId = '';
		if($_FILES[$fileKey]["error"] == 0){
			//后缀
			$ext      = explode('.',$_FILES[$fileKey]["name"]);
			$fileName = date('YmdHis').mt_rand(10000,99999).'.'.$ext[1];
			move_uploaded_file($_FILES[$fileKey]["tmp_name"],ROOT_PATH.'upfiles/'.$fileName);
			$mediaId  = 'upfiles/'. $fileName;
		}
		return $mediaId;
	}
	public  function getUrl($mediaId = ''){
		return  $this->domain.$mediaId;
	}
}

?>