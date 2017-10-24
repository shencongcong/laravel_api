<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WaiterAlbumTest extends TestCase
{
    protected $token;
    protected $waiter_login = 'api/waiter/waiter/login';
    protected $id =22;

    protected $waiter_album_index = 'api/waiter/album/index';
    protected $waiter_album_show = 'api/waiter/album/show';
    protected $waiter_album_add = 'api/waiter/album/store';
    protected $waiter_album_del = 'api/waiter/album/destroy';
    protected $waiter_album_edit_show = 'api/waiter/album/edit';
    protected $waiter_album_edit_post = 'api/waiter/album/update';

    public function setUp()
    {
        // 先做单商户处理 测试的时候验证码校验暂时在代码里面注销掉
        parent::setUp();
        $tel = 18817320310;
        $code = 222222;
        $this->json('POST', $this->waiter_login, ['tel'=>$tel,'code'=>$code]);
        $content = $this->decodeResponseJson();
        //var_dump($content);
        $this->token = $content['data']['token'];
    }

    /** @test
     * @method:get
     * @description:
     * @param:
     */
    public function waiter_album_index()
    {
        $this->get($this->waiter_album_index,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function waiter_album_show()
    {
        $this->get($this->waiter_album_index.'?id='.$this->id,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function waiter_album_add()
    {
        $post_data = [
            'introduce' => '发放所多付多多多多多',
             'name' => '短发美丽',
            'img' =>json_encode(['https://image.weerun.com/wr2/2017-08-08b23fa5be05099b5d1146a25580940486.png','https://image.weerun.com/wr2/2017-08-08b23fa5be05099b5d1146a25580940486.png'])
        ];
        $this->post($this->waiter_album_add,$data=$post_data,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }



    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function waiter_album_edit_show()
    {
        $this->get($this->waiter_album_edit_show.'?id='.$this->id,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function waiter_album_edit_post()
    {
        $post_data = [
            'id' => $this->id,
            'name' => 'test_name',
            'introduce' => 'test_introduce',
            'img' => json_encode(['img1'=>'http://image.weerun.com/wr2/2017-08-08b23fa5be05099b5d1146a25580940486.png','img2'=>'https://image.weerun.com/wr2/2017-08-08b23fa5be05099b5d1146a25580940486.png'])
        ];
        $this->post($this->waiter_album_edit_post,$data=$post_data,$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function waiter_album_del()
    {
        $this->delete($this->waiter_album_del,$data=['id'=>$this->id],$headers = ['authorization'=>'bearer'.$this->token] );
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }
}
