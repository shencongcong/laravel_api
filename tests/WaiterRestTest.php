<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WaiterRestTest extends TestCase
{
    protected $token;
    protected $waiter_login = 'api/waiter/waiter/login';

    protected $waiter_rest_edit_post = 'api/waiter/waiterRest/update';
    protected $waiter_rest_edit_show = 'api/waiter/waiterRest/edit';

    public function setUp()
    {
        // 先做单商户处理 测试的时候验证码校验暂时在代码里面注销掉
        parent::setUp();
        $tel = 18817320310;
        $code = 222222;
        $this->json('POST', $this->waiter_login, ['tel' => $tel, 'code' => $code]);
        $content = $this->decodeResponseJson();
        $this->token = $content['data']['token'];
    }

    /** @test
     * @method:post
     * @description:
     * @param:
     */
    public function waiter_rest_edit_post()
    {
        $post_data =
            ['time' =>
                 [
                     '1533081600',
                     '1533168000',
                     '1504137600',
                     '1504137600'
                 ]
            ];
        $this->post($this->waiter_rest_edit_post, $data = $post_data, $headers = ['authorization' => 'bearer' . $this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200, $status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function waiter_rest_edit_show()
    {
        $this->get($this->waiter_rest_edit_show, $headers = ['authorization' => 'bearer' . $this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200, $status_code);
    }
}
