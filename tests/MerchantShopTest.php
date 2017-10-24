<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

class MerchantShopTest extends TestCase
{
    //use WithoutMiddleware;
    protected  $shop_list= '/api/shop/index';
    protected  $merchant_login = 'api/merchantAdmin/login';
    protected  $shop_show= '/api/shop/show';
    protected $merchant_get_shop_lists = '/api/shop/getShopList';
    protected $merchant_shop_add = '/api/shop/store';
    protected $merchant_shop_del = '/api/shop/destroy';
    protected $merchant_shop_update= '/api/shop/update';
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
     * 获取所有门店的信息
     */
    public function merchant_get_shops()
    {
        $this->get($this->shop_list,$headers =['authorization'=>'bearer'.$this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    public function merchant_get_shop_data()
    {
        return [
            'test1' => ['96']
        ];
    }
    /** @test
     * @dataProvider merchant_get_shop_data
     */
    public function merchant_get_shop($id)
    {
        $this->get($this->shop_show . '?id=' . $id, $headers = ['authorization' => 'bearer' . $this->token]);
        //$this->get($this->shop_show,$headers =['authorization'=>'bearer'.$this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:get
     * @description:获取门店列表
     * @param:
     */
    public function merchant_get_shop_lists()
    {
        $this->get($this->merchant_get_shop_lists, $headers = ['authorization' => 'bearer' . $this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200, $status_code);
    }

    /** @test
     * @method:post
     * @description:商户端门店添加
     * @param:shop_name address tel open_time introduce longitude latitude img
     */
    public function merchant_shop_add()
    {
        $datas = [
            'shop_name' => '乔韵国际', 'address' => '虹梅南路11号', 'tel' => '11111111111', 'open_time' => '07:10 - 23:59', 'longitude' => '120', 'latitude' => '30', 'introduce' => 'haha'
        ];
        $this->post($this->merchant_shop_add, $data = $datas, $headers = ['authorization' => 'bearer' . $this->token]);
        $content = $this->decodeResponseJson();
        dd($content);
        $status_code = $content['status_code'];

        $this->assertEquals(200, $status_code);
    }

    /** @test
     * @method:delete
     * @description:商户门店删除
     * @param:
     */
    public function merchant_shop_del()
    {

        $this->delete($this->merchant_shop_del,$data=['id'=>126], $headers = ['authorization' => 'bearer'. $this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200, $status_code);
    }

    /** @test
     * @method: post
     * @description:商户门店信息修改
     * @param:
     */
    public function merchant_shop_update()
    {
        $datas = [
            'id'=>127,'shop_name' => '乔韵国际1', 'address' => '虹梅南路11号1', 'tel' => '111111111111', 'open_time' => '07:10 - 23:59', 'longitude' => '121', 'latitude' => '301', 'introduce' => 'haha', 'img' => json_encode(['img0' => 'https://image.weerun.com/wr2/2017-08-157bf5567e7aaa0d136093040ba1b70774.jpeg', 'img1' => 'https://image.weerun.com/wr2/2017-08-232bd9bea102b4d8361a4d4ba328ead4de.jpg'])
        ];
        $this->post($this->merchant_shop_update,$data=$datas, $headers = ['authorization' => 'bearer'. $this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200, $status_code);
    }
}
