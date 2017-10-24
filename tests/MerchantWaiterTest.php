<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class MerchantWaiterTest
 * 可以一次性测试这个类，但是$id 需要自己配置下
 */
class MerchantWaiterTest extends TestCase
{
    protected $merchant_waiter_lists = 'api/waiter/index';
    protected $merchant_waiter_show = 'api/waiter/show';
    protected $merchant_waiter_lists_by_shop_id = 'api/waiter/waiterByShop';
    protected $merchant_waiter_del = 'api/waiter/destroy';

    protected $token;
    protected  $merchant_login = 'api/merchantAdmin/login';
    protected $id='151';//方便编辑 删除调试

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
     * @description:
     * @param:
     */
    public function merchant_waiter_lists()
    {
        $this->get($this->merchant_waiter_lists,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:get
     * @description:
     * @param:
     */
    public function merchant_waiter_show()
    {
        $this->get($this->merchant_waiter_show.'?id='.$this->id,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:post
     * @description:
     * @param:
     */
    public function merchant_waiter_lists_by_shop_id()
    {
        $this->post($this->merchant_waiter_lists_by_shop_id,$data=['shop_id'=>96],$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:delete
     * @description:
     * @param:
     */
    public function merchant_waiter_del()
    {
        $this->delete($this->merchant_waiter_del,$data=['id'=>$this->id],$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }
}
