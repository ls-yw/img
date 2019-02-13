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
        
        if(!in_array($project, ['ypy', 'blog'])){
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
            $insertData['realpath']  = $path;
            $insertData['project']   = $project;
            $insertData['other']     = $other;
            $insertData['size']      = $data['size'];
            $id = (new Files())->add($insertData);
            if(!$id)Log::write('img', '上传记录保存失败，data：'.json_encode($insertData, JSON_UNESCAPED_UNICODE));
            
            return $this->ajaxReturn(0, '成功', $data);
        }catch (\Exception $e){
            Log::write('img', $e->getMessage());
            return $this->ajaxReturn(1, $e->getMessage());
        }
        
    }
}