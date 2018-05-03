<?php
namespace Configs;
/**
 * Class Config
 * @desc 获取配置信息
 * @package Configs
 */
class Config
{
    protected $Datas;
    public function __construct($arr)
    {
        $this->Datas = $arr;
    }

    /**
     * 获取配置
     * @param bool|false $flag
     * @param bool|false $sub
     * @return array
     */
    public function get($flag=false,$sub=false)
    {
        if($flag && $sub){
            if(!isset($this->Datas[$flag][$sub])){
                throw new \Exception('配置不存在',120001);
            }
            return $this->Datas[$flag][$sub];
        }
        if($flag){
            if(!isset($this->Datas[$flag])){
                throw new \Exception('配置不存在',120002);
            }
            return $this->Datas[$flag];
        }
        throw new \Exception('配置不存在',120003);
    }
}