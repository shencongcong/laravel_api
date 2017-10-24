<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class MerchantWaiterLevelTest
 * 可以一次性测试这个类，但是$id
 */
class MerchantWaiterLevelTest extends TestCase
{
    protected $merchant_waiter_level_show = 'api/waiterLevel/index';
    protected $merchant_waiter_level_add = 'api/waiterLevel/store';
    protected $merchant_waiter_level_edit_show = 'api/waiterLevel/edit';
    protected $merchant_waiter_level_edit_post = 'api/waiterLevel/update';
    protected $merchant_waiter_level_del = 'api/waiterLevel/destroy';

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

    /** @test
     * @method:get
     * @description:
     * @param:
     */
    public function merchant_waiter_level_show()
    {
        $this->get($this->merchant_waiter_level_show,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:post
     * @description:
     * @param:
     */
    public function merchant_waiter_level_add()
    {
        $this->post($this->merchant_waiter_level_add,$datas=['name'=>['test1','test2']],$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:get
     * @description:
     * @param:
     */
    public function merchant_waiter_level_edit_show()
    {
        $this->get($this->merchant_waiter_level_edit_show.'?id='.$this->id,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:post
     * @description:
     * @param:
     */
    public function merchant_waiter_level_edit_post()
    {
        $this->post($this->merchant_waiter_level_edit_post,$datas=['id'=>$this->id,'name'=>'test32'],$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:delete
     * @description:
     * @param:
     */
    public function merchant_waiter_level_del()
    {
        $this->delete($this->merchant_waiter_level_del,$data=['id'=>$this->id],$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }
}
