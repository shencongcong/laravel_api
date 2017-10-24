<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MerchantAppointTest extends TestCase
{
    protected $merchant_appoint_now = 'api/appoint/index';
    protected $merchant_appoint_now_by_shop_id = 'api/appoint/shop';
    protected $merchant_shop_appoint_order = 'api/appointRank/index';
    protected $merchant_shop_appoint_order_by_time = 'api/appointRank/shopRank';
    protected $merchant_waiter_appoint_order = 'api/appointRank/waiterIndex';
    protected $merchant_waiter_appoint_order_by_time = 'api/appointRank/waiterRank';

    protected $token;
    protected  $merchant_login = 'api/merchantAdmin/login';
    protected $id='31';//方便编辑 删除调试

    public function setUp()
    {
        parent::setUp();
        $admin_tel = 18817320310;
        $admin_password = 222222;
        $this->json('POST', $this->merchant_login, ['admin_tel'=>$admin_tel,'admin_password'=>$admin_password]);
        $content = $this->decodeResponseJson();
        $this->token = $content['data']['token'];
    }

    public function merchant_appoint_now_data()
    {
        return ['test1'=>1,'test2'=>2];
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function merchant_appoint_now()
    {
        $status = mt_rand(1,2);
        $this->post($this->merchant_appoint_now,$data=['status'=>$status],$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function merchant_appoint_now_by_shop_id()
    {
        $this->post($this->merchant_appoint_now_by_shop_id,$data=['status'=>1,'shop_id'=>97],$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        //var_dump($content);
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function merchant_shop_appoint_order()
    {
        $this->get($this->merchant_shop_appoint_order,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function merchant_shop_appoint_order_by_time()
    {
        $type = mt_rand(1,3);
        $this->post($this->merchant_shop_appoint_order_by_time,$data=['time_logo'=>$type],$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function merchant_waiter_appoint_order()
    {
        $this->get($this->merchant_waiter_appoint_order,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function merchant_waiter_appoint_order_by_time()
    {
        $type = mt_rand(1,3);
        $this->post($this->merchant_waiter_appoint_order_by_time,$data=['time_logo'=>$type],$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }
}
