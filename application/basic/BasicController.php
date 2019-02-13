<?php
namespace Basic;

use Phalcon\Mvc\Controller;
use Phalcon\DI;

class BasicController extends Controller
{
    
    /**
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @param int $code
     * @param string $msg
     * @param String $type AJAX返回数据格式
     */
    protected function ajaxReturn($code, $msg, $data = null, $other=null, $type='json')
    {
        $returnMsg = ['code'=>$code, 'msg'=>$msg];
        if($data)$returnMsg['data'] 	= $data;
        $data = $returnMsg;
        
        if($other && is_array($other)){
            foreach ($other as $key => $val){
                $returnMsg[$key] = $val;
            }
        }
    
        switch (strtoupper($type)){
            case 'JSON' :
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode($data,JSON_UNESCAPED_UNICODE) ); // php 5.11
        }
    }
    
    protected static function get($name=null, $filters=null, $defaultValue=null)
    {   
        return DI::getDefault()->get('request')->getQuery($name, $filters, $defaultValue);
    }
    
    protected static function post($name=null, $filters=null, $defaultValue=null)
    {
        return DI::getDefault()->get('request')->getPost($name, $filters, $defaultValue);
    }
    
}