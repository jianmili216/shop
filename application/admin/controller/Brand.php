<?php
namespace app\admin\controller;
use think\Controller;
class Brand extends Controller
{
    public function lst()
    {
        $brandres=db('brand')->order('id desc')->paginate(5);
        $this->assign('brandres',$brandres);
        return view();
    }
    public function add()
    {
        if(request()->isPost()){
            $data=input('post.');
            if($data['brand_url'] && stripos($data['brand_url'],'http://')===false){
                $data['brand_url']='http://'.$data['brand_url'];
            }
            //处理图片上传
            if($_FILES['brand_logo']['tmp_name']){
                $data['brand_logo']=$this->upload();
            }
            //添加验证数据
            $validate = validate('Brand');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }

            $add=db('brand')->insert($data);
            if($add){
                $this->success('添加品牌成功',url('brand/lst'));
            }else{
                $this->error('添加品牌失败，请返回修改',url('brand/add'));
            }
            return;
        }
        return view();
    }
    public function edit()
    {
        if(request()->isPost()){
            $data=input('post.');
            if($data['brand_url'] && stripos($data['brand_url'],'http://')===false){
                $data['brand_url']='http://'.$data['brand_url'];
            }
            //修改模块处理图片上传
            if($_FILES['brand_logo']['tmp_name']){
                $oldBrands=db('brand')->field('brand_logo')->find($data['id']);
                $oldBrangImg=IMG_UPLOADS.$oldBrands['brand_logo'];
                if(file_exists($oldBrangImg)){
                    @unlink($oldBrangImg);
                }

                 $data['brand_logo']=$this->upload();
//                dump($$data);die;
            }
            //添加验证数据
            $validate = validate('Brand');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }
            $save=db('brand')->update($data);
            if($save !==false){
                $this->success('修改品牌成功',url('brand/lst'));
            }else{
                $this->error('修改品牌失败，请返回修改',url('brand/add'));
            }
            return;
        }
        $id=input('id');
        $editres=db('brand')->find($id);
        //dump($res);die;
        $this->assign("editres",$editres);

        return view();
    }
    public function del()
    {
        $id=input('id');
        $del=db('brand')->delete($id);
        if($del){
            $this->success('删除数据成功','lst');
        }else{
            $this->error('删除数据失败');
        }
        return ;
    }
    //单独上传图片源码
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('brand_logo');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS .'static'. DS .'uploads');
            if($info){
                return  $info->getSaveName();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();  die;
            }
        }
    }
}
