<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use \Illuminate\Support\Facades\Cache;

class WaiterInfoTest extends TestCase
{
    protected $token;
    protected $waiter_login = 'api/waiter/waiter/login';
    protected $waiter_get_merchant_lists = 'api/waiter/waiter/merchantList';
    protected $waiter_index_info = 'api/waiter/waiter/index';
    protected $waiter_info_edit_show = 'api/waiter/waiter/edit';
    protected $waiter_get_all_shops_lists = 'api/waiter/waiter/allShop';
    protected $waiter_get_all_level_lists = 'api/waiter/waiter/allLevel';
    protected $waiter_get_all_goods_lists = 'api/waiter/waiter/allGoods';
    protected $waiter_info_edit_post = 'api/waiter/waiter/update';

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
     * @method:post
     * @description:
     * @param:tel
     */
    public function waiter_get_merchant_lists()
    {
        $this->post($this->waiter_get_merchant_lists,$data=['tel'=>18817320310] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function waiter_index_info()
    {
        $this->get($this->waiter_index_info,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function waiter_info_edit_show()
    {
        $this->get($this->waiter_info_edit_show,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function waiter_info_edit_post()
    {
        $post_arr = [
            'nickname'=>'贺兰丛丛1',
            'img'=>'https://image.weerun.com/wr2/2017-08-08b23fa5be05099b5d1146a25580940486.png',
            'sex'=>2,
            'level'=>27,
            'work_length'=>4,
            'brief'=>'大头鬼是个大头，小头鬼是个小头，大头小头一起',
            'shop_id' =>['96','97'],
            'goods_id'=>['230','231']
        ];
        $this->post($this->waiter_info_edit_post,$data=$post_arr,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function waiter_get_all_shops_lists()
    {
        $this->get($this->waiter_get_all_shops_lists,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:get
     * @description:
     * @param:
     */
    public function waiter_get_all_level_lists()
    {
        $this->get($this->waiter_get_all_level_lists,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function waiter_get_all_goods_lists()
    {

    }
}

