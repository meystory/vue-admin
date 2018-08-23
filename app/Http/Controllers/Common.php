<?php

namespace App\Http\Controllers;
/**
 * 公共方法
 */
class Common
{
    /**
     * 生成无限级树
     * @param array $list
     * @param string $primary_key 字段名
     * @param string $parent_key 字段名
     * @return array
     */
    public static function buildTree($list=[], $primary_key, $parent_key='parent_id')
    {
        $map = $tree = [];

        foreach($list as &$item){
            $map[$item[$primary_key]] = &$item;
        }

        foreach($list as &$val){
            $parent = &$map[$val[$parent_key]];
            if($parent){
                $parent['child'][] = &$val;
            }else{
                $tree[] = &$val;
            }
            if(!isset($val['child'])){
                $val['child'] = [];
            }
        }   
        return $tree;
    }
}