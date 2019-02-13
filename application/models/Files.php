<?php
namespace Models;

use Basic\BasicModel;

class Files extends BasicModel 
{
    protected $_targetTable = "i_files";
    
    /**
     * 初始化
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();
        $this->setTargetTable($this->_targetTable);
    }
    
    /**
     * 表字段属性(non-PHPdoc)
     * @see \Basic\BaseModel::attribute()
     * @create_time 2017年11月17日
     */
    public function attribute()
    {
        return [
            'id'   => 'ID',
            'name' => '文件名',
            'title' => '原图片名称',
            'file_type' => '文件类型',
            'path' => '路径',
            'realpath' => '绝对地址',
            'project' => '项目标识',
            'other' => '其他自定义标识',
            'size' => '文件大小',
            'deleted' => '删除状态 0正常 1删除',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
    
    public function add($data)
    {
        return $this->insertData($data);
    }
}