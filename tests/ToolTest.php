<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ToolTest extends TestCase
{
    protected $waiter_login_send_code = 'api/waiter/waiter/sendSms';

    /** @test
     * @method:post
     * @description: 服务师登录发送验证码
     * @param:
     */
    public function waiter_login_send_code()
    {
        $this->post($this->waiter_login_send_code,$data=['tel'=>'18817320310'] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }
}
