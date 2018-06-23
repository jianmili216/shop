<?php
namespace app\admin\validate;
use think\Validate;
class Brand extends Validate
{
    protected $rule = [
        'brand_name'  =>  'require|unique:brand',
        'brand_url' =>  'url',
        'brand_desc' =>  'min:6',
    ];

    protected $message = [
        'brand_name.require'  =>  '品牌名称必须填写',
        'brand_name.unique' =>  '品牌名称不能重复',
        'brand_url.url' =>  '网址名称不正确',
        'brand_desc.min' =>  '描述最少要写6个字符',
    ];
    protected $scene = [
        //'edit'  =>  ['name','age'],
    ];


    // 自定义验证规则
    protected function checkName($value,$rule,$data)
    {
        return $rule == $value ? true : '名称错误';
    }
}
