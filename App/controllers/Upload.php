<?php
use App\Library\InterfaceCode;
class UploadController extends \App\Library\ControllerAbstract
{
    public function indexFileAction(){
        $this->_setJsonHeader();
        $path = $_POST['upload_path'];
        $type = $_POST['upload_content_type'];
        $name = $_POST['upload_name'];
        $size = $_POST['upload_size'];
        try {
            if(!in_array(pathinfo($name, PATHINFO_EXTENSION),array('csv'))){
                throw new Exception('error file:'.$name);
            }
            $_FILES['upload_file'] = array(
                'name'     => $name,
                'type'     => $type,
                'tmp_name' => $path,
                'size'      => $size,
                'error'    => 0
            );
            $mediaId   = $this->storeFile('upload_file');

            if(empty($mediaId)) {
                throw new Exception("upload file failed");
            }
            //返回https://的地址
            $picPath = $this->getUrl($mediaId);

            echo $this->_echoJson(InterfaceCode::OK, ['path'=>$picPath,'mediaId'=>$mediaId]);


        } catch (FileException $e) {
            echo $this->_echoJson(InterfaceCode::ILLEGAL_PARAMETER, [], '请上传符合要求的文件');
        }
    }

    //上传图片到图片服务器
    public function indexUpPictureAction(){
        $this->_setJsonHeader();
        $path = $_FILES['upload_file']['tmp_name'];

        //判断图片限制宽高
        if(isset($_POST['limit_width']) && isset($_POST['limit_height'])){
            $limit_w = $_POST['limit_width'];
            $limit_h = $_POST['limit_height'];
            $imgData = getimagesize($path);
            $this_w  = $imgData[0];
            $this_h  = $imgData[1];
            if($this_w != $limit_w || $this_h != $limit_h){
                echo $this->_echoJson(InterfaceCode::ILLEGAL_PARAMETER, [], '图片宽高必须是：'.$limit_w.'*'.$limit_h);
                exit;
            }
        }
        try {
            $mediaId   = $this->storeFile('upload_file');

            if(empty($mediaId)) {
                throw new Exception("upload file failed");
            }
            //返回https://的地址
            $picPath = $this->getUrl($mediaId);

            echo $this->_echoJson(InterfaceCode::OK, ['picPath'=>$picPath,'mediaId'=>$mediaId]);


        } catch (FileException $e) {
            echo $this->_echoJson(InterfaceCode::ILLEGAL_PARAMETER, [], '请上传符合要求的文件');
        }
    }

    protected function storeFile($fileKey){
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
    protected function getUrl($mediaId = ''){
        return  'http://'.$_SERVER['HTTP_HOST'].$mediaId;
    }


}
