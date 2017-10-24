<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MerchantAdminTest extends TestCase
{
    protected  $merchant_login = 'api/merchantAdmin/login';
    protected  $mechant_logout = 'api/merchantAdmin/logout';
    protected  $forget_password_send_code = 'api/merchantAdmin/sendSms';
    protected  $forget_password_check_code = 'api/merchantAdmin/forgetPwd';
    protected  $update_password = 'api/merchantAdmin/pwdUpdate';
    protected  $merchant_admin_logout= 'api/merchantAdmin/logout';
    protected  $merchant_admin_info_show= 'api/merchantAdmin/show';
    protected  $merchant_admin_index_show= 'api/merchantAdmin/index';
    protected  $merchant_admin_info_update= 'api/merchantAdmin/update';



    protected  $token;

    public function setUp()
    {
        parent::setUp();
        $admin_tel = 18817320310;
        $admin_password = 222222;
        $this->json('POST', $this->merchant_login, ['admin_tel'=>$admin_tel,'admin_password'=>$admin_password]);
        $content = $this->decodeResponseJson();
        $this->token = $content['data']['token'];
    }

    /**
     *  模拟登录账号
     * */
    public function additionProvider()
    {
        return [
            'test1'=>[18817320310,111111],
            'test2'=>[18817320310,111121],
            'test3'=>[18817320311,''],
            'test4'=>['',111111],
        ];
    }

    /**@test
     * @dataProvider additionProvider
     * @method:post
     * @description: 商户管理员登录页
     * @param: admin_tel 账号 admin_password 密码
     * @ 200 407 407 407
     */
    public function Login($admin_tel,$admin_password)
    {
        $this->json('POST', $this->merchant_login, ['admin_tel'=>$admin_tel,'admin_password'=>$admin_password]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        var_dump($status_code);
    }

    /** @test
     * @dataProvider additionProvider
     * @method:@post
     * @description: 商户管理员忘记密码发送验证码验证码
     * @param: herder{ token } tel
     * 200 404(1min发送限制) 403(手机号不存在) 405(缺少必要参数)
     */
    public function merchant_admin_forget_password_send_code($tel)
    {
        $this->post($this->forget_password_send_code, $data = ['tel'=>$tel]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        var_dump($status_code);
    }

    /**
     * 商户验证码校验数据
     *
    */
    public function merchant_code_check_data()
    {
        return [
            'test1'=>[18817320310,1404], // code 需要先调用上面方法获取
            'test2'=>[18817320310,111121],
            'test3'=>[18817320311,111111],
        ];
    }

    /** @test
     * @dataProvider merchant_code_check_data
     * @method:post
     * @description:商户管理员忘记密码校验验证码是否正确
     * @param: tel code
     * 正确  ||  验证码错误 || 手机号（账号）不存在
     * 200(输出的结果有问题：可能是缓存没有起作用) 407 404
     * res:fail
     */
    public function merchant_admin_forget_password_check_code($tel,$code)
    {
        $this->post($this->forget_password_check_code, $data = ['tel'=>$tel,'code'=>$code]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        var_dump($status_code);
    }

    public function merchant_admin_update_password_data()
    {
        return [
            'test1'=>[18817320310,111111,222222],
            'test2'=>[18817320311,2222222,222222],
            'test3'=>[18817320310,222222,111111],
        ];
    }
    /** @test
     *  @dataProvider merchant_admin_update_password_data
     * @method:post
     * @description:商户管理员密码修改s
     * @param:admin_tel(账号) old_password(旧秘密) new_password(新密码)
     * 200 407 407
     * res:ok
     */
    public function merchant_admin_update_password($tel, $old_password, $new_password)
    {
        $this->post($this->update_password, $data = ['admin_tel'=>$tel,'old_password'=>$old_password,'new_password'=>$new_password],$headers = ['authorization'=>'bearer'.$this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        var_dump($status_code);
    }

    /** @test
     * @method:get
     * @description:商户管理员退出登录
     * @param:
     * 200
     * ok
     */
    public function merchant_admin_logout()
    {
        $this->get($this->merchant_admin_logout,$headers = ['authorization'=>'bearer'.$this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     * ok
     */
    public function merchant_admin_info_show()
    {
        $this->get($this->merchant_admin_info_show,$headers = ['authorization'=>'bearer'.$this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }

    /** @test
     * @method:
     * @description:
     * @param:
     */
    public function merchant_admin_index_show()
    {
        $this->get($this->merchant_admin_index_show,$headers = ['authorization'=>'bearer'.$this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }


    public function merchant_admin_info_update_data()
    {
        return [
            'test1'=>['丛丛','https://image.weerun.com/wr2/2017-08-08b23fa5be05099b5d1146a25580940486.png'],
        ];
    }
    /** @test
     * @dataProvider merchant_admin_info_update_data
     * @method:post
     * @description:商户端管理员信息修改
     * @param: nickname img
     */
    public function merchant_admin_info_update($nickname,$img)
    {
        $this->post($this->merchant_admin_info_update, $data = ['nickname'=>$nickname,'img'=>$img],$headers = ['authorization'=>'bearer'.$this->token]);
        $content = $this->decodeResponseJson();
        $status_code = $content['status_code'];
        $this->assertEquals(200,$status_code);
    }
    
}
