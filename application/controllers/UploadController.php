<?php
namespace Controllers;

use Basic\BasicController;
use woodlsy\upload\Upload;
use Library\Log;
use Models\Files;

class UploadController extends BasicController 
{
    public function imgAction() {
        $project = self::get('project', 'string', '');
        $other   = self::get('other', 'string', '');
        
        if(!in_array($project, ['ypy', 'blog', 'novel'])){
            return $this->ajaxReturn(2, '错误项目');
        }
        
        try {
            $relativePath = $project.'/'.date('Ymd');
            $path = '/data/html/upload/'.$relativePath;
            $data = (new Upload())->setMaxSize('2M')->setUploadPath($path)->upload();
            $data['url'] = $relativePath.'/'.$data['name'];
            
            $insertData = [];
            $insertData['name']      = $data['name'];
            $insertData['title']     = $data['title'];
            $insertData['file_type'] = $data['type'];
            $insertData['path']      = $data['url'];
            $insertData['realpath']  = $path.'/'.$data['name'];
            $insertData['project']   = $project;
            $insertData['other']     = $other;
            $insertData['size']      = $data['size'];
            $id = (new Files())->add($insertData);
            if(!$id)Log::write('img', '上传记录保存失败，data：'.json_encode($insertData, JSON_UNESCAPED_UNICODE));
            
            return $this->ajaxReturn(0, '成功', null,$data);
        }catch (\Exception $e){
            Log::write('img', $e->getMessage());
            return $this->ajaxReturn(1, $e->getMessage());
        }
    }

    /**
     * 上传网络图片
     *
     * @author yls
     */
    public function urlImgAction() {
        $project = self::get('project', 'string', '');
        $other   = self::get('other', 'string', '');
        $urlImg  = self::get('url', 'string', '');

        if(!in_array($project, ['ypy', 'blog', 'novel'])){
            return $this->ajaxReturn(2, '错误项目');
        }

        try {
            $relativePath = $project.'/'.date('Ymd');
            $path = '/data/html/upload/'.$relativePath;
            Upload::directory($path);

            $imgData = file_get_contents($urlImg);
            $splitUrl = explode('/', $urlImg);
            $fileName = end($splitUrl);
            $splitName = explode('?', $fileName);
            $fileName = current($splitName);
            $fileTmpPath = '/tmp/'.$fileName;
            $fp = @fopen($fileTmpPath, 'w');
            @fwrite($fp, $imgData);
            fclose($fp);

            $newFileName = time().$fileName;
            if(!copy($fileTmpPath, $path.'/'.$newFileName)){
                throw new \Exception('文件上传失败');
            }
            unlink($fileTmpPath);

            $data['url'] = $relativePath.'/'.$newFileName;

            $insertData = [];
            $insertData['name']      = $newFileName;
            $insertData['title']     = $fileName;
            $insertData['file_type'] = filetype($path.'/'.$newFileName);
            $insertData['path']      = $data['url'];
            $insertData['realpath']  = $path.'/'.$newFileName;
            $insertData['project']   = $project;
            $insertData['other']     = $other;
            $insertData['size']      = filesize($path.'/'.$newFileName);
            $id = (new Files())->add($insertData);
            if(!$id)Log::write('img', '上传记录保存失败，data：'.json_encode($insertData, JSON_UNESCAPED_UNICODE));

            return $this->ajaxReturn(0, '成功', null,$data);
        }catch (\Exception $e){
            Log::write('img', $e->getMessage());
            return $this->ajaxReturn(1, $e->getMessage());
        }
    }
}