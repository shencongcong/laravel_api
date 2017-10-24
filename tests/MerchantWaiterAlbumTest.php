<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class MerchantWaiterAlbumTest
 * 可以一次性测试这个类，但是$id 需要自己配置下
 */
class MerchantWaiterAlbumTest extends TestCase
{
    protected  $merchant_waiter_album_lists = 'api/waiterAlbum/index';
    protected  $merchant_waiter_album_show = 'api/waiterAlbum/show';
    protected  $merchant_waiter_album_del = 'api/waiterAlbum/destroy';


    protected $token;
    protected  $merchant_login = 'api/merchantAdmin/login';
    protected $id='17';//方便编辑 删除调试

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
     * @method:
     * @description:
     * @param:
     */
    public function merchant_waiter_album_lists()
    {
        $this->get($this->merchant_waiter_album_lists,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function merchant_waiter_album_show()
    {
        $this->get($this->merchant_waiter_album_show.'?id='.$this->id,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:delete
     * @description:
     * @param:
     */
    public function merchant_waiter_album_del()
    {
        $this->delete($this->merchant_waiter_album_del,$data=['id'=>$this->id],$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

}