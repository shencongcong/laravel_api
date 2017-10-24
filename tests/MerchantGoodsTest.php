<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MerchantGoodsTest extends TestCase
{
    protected  $merchant_login = 'api/merchantAdmin/login';
    protected $merchant_goods_lists = 'api/goodsCate/index';
    protected $merchant_goods_parent_add = 'api/goodsCate/storeParent';
    protected $merchant_goods_parent_edit_show = 'api/goodsCate/editParent';
    protected $merchant_goods_parent_edit_post = 'api/goodsCate/updateParent';
    protected $merchant_goods_parent_del = 'api/goodsCate/destroyParent';
    protected $merchant_goods_child_add = 'api/goodsCate/storeChild';
    protected $merchant_goods_child_edit_show = 'api/goodsCate/editChild';
    protected $merchant_goods_child_edit_post = 'api/goodsCate/updateChild';
    protected $merchant_goods_child_del = 'api/goodsCate/destroyChild';

    protected $token;

    public function setUp()
    {
        parent::setUp();
        $admin_tel = 18817320310;
        $admin_password = 222222;
        $this->json('POST', $this->merchant_login, ['admin_tel'=>$admin_tel,'admin_password'=>$admin_password]);
        $content = $this->decodeResponseJson();
        $this->token = $content['data']['token'];
    }

    /** @test
     * @method:get
     * @description:商户管理产品展示
     * @param:
     */
    public function merchant_goods_lists()
    {
        $this->get($this->merchant_goods_lists,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:post
     * @description:商户产品父类添加
     * @param:
     */
    public function merchant_goods_parent_add()
    {
        $goods_name = ['美甲','美容'];
        $this->post($this->merchant_goods_parent_add,$data=['goods_name'=>$goods_name],$headers = ['authorization'=>'bearer'.$this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:get
     * @description:商户产品大类编辑
     * @param:
     */
    public function merchant_goods_parent_edit_show()
    {
        $this->get($this->merchant_goods_parent_edit_show.'?id=279',$headers = ['authorization'=>'bearer'.$this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:post
     * @description:商户产品大类编辑提交数据
     * @param:
     */
    public function merchant_goods_parent_edit_post()
    {
        $this->post($this->merchant_goods_parent_edit_post,$data=['id'=>279,'goods_name'=>'美容1'],$headers = ['authorization'=>'bearer'.$this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:delete
     * @description:商户产品父类删除
     * @param:
     */
    public function merchant_goods_parent_del()
    {
        $this->delete($this->merchant_goods_parent_del,$datas=['id'=>279],$headers = ['authorization'=>'bearer'.$this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    public function merchant_goods_child_add_data()
    {
        return [
/*            'test1'=>['278',[json_encode(['goods_name'=>'美甲1','price'=>30,'sever_time'=>1]),json_encode(['goods_name'=>'美甲2','price'=>50,'sever_time'=>2])]],*/
      /*      'test2'=>['278',[json_encode(['goods_name'=>'美甲1','price'=>'','sever_time'=>1]),json_encode(['goods_name'=>'美甲2','price'=>50,'sever_time'=>2])]],*/
            'test3'=>['278',[json_encode(['goods_name'=>'美甲1','price'=>10.0909,'sever_time'=>1]),json_encode(['goods_name'=>'美甲2','price'=>50,'sever_time'=>2])]],
        ];
    }

    /** @test
     * @dataProvider merchant_goods_child_add_data
     * @method:post
     * @description:产品子类添加
     * @param:
     */
    public function merchant_goods_child_add($pid,$goods_cate)
    {
        $this->post($this->merchant_goods_child_add,$datas=['pid'=>$pid,'goods_cate'=>$goods_cate],$headers = ['authorization'=>'bearer'.$this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:get
     * @description:子产品编辑页
     * @param:
     */
    public function merchant_goods_child_edit_show()
    {
        $this->get($this->merchant_goods_child_edit_show.'?id=293',$headers = ['authorization'=>'bearer'.$this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:post
     * @description:
     * @param:
     */
    public function merchant_goods_child_edit_post()
    {
        $this->post($this->merchant_goods_child_edit_post,$datas=['id'=>293,'goods_name'=>'养生护发','price'=>'444','sever_time'=>3],$headers = ['authorization'=>'bearer'.$this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:delete
     * @description:
     * @param:
     */
    public function merchant_goods_child_del()
    {
        $this->delete($this->merchant_goods_child_del,$datas=['id'=>293],$headers = ['authorization'=>'bearer'.$this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

}
