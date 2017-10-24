<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WaiterAppointTest extends TestCase
{

    protected $token;
    protected $waiter_login = 'api/waiter/waiter/login';
    protected $id =2;

    protected $waiter_appoint_index = 'api/waiter/appoint/index';
    protected $waiter_appoint_cancel = 'api/waiter/appoint/cancel';
    protected $waiter_appoint_confirm = 'api/waiter/appoint/confirm';
    protected $waiter_appoint_del = 'api/waiter/appoint/destroy';

    public function setUp()
    {
        // 先做单商户处理 测试的时候验证码校验暂时在代码里面注销掉
        parent::setUp();
        $tel = 18817320310;
        $code = 222222;
        $this->json('POST', $this->waiter_login, ['tel'=>$tel,'code'=>$code]);
        $content = $this->decodeResponseJson();
        $this->token = $content['data']['token'];
    }
    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function waiter_appoint_index()
    {
        $status = mt_rand(1,2);
        $this->get($this->waiter_appoint_index.'?status='.$status,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:post
     * @description:
     * @param:
     */
    public function waiter_appoint_cancel()
    {
        $this->post($this->waiter_appoint_cancel,$data=['id'=>2,'reason'=>1],$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function waiter_appoint_confirm()
    {
        $this->post($this->waiter_appoint_confirm,$data=['id'=>1,'status'=>2],$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:delete
     * @description:
     * @param:
     */
    public function waiter_appoint_del()
    {
        $this->delete($this->waiter_appoint_del,$data=['id'=>1],$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }
}
