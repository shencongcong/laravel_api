<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    /*
     * 工具类接口
     * */
    $api->group(['namespace' => 'App\Api\Controllers\Tool'], function ($api) {
        $api->post('imgUpload','ImgUploadController@index');
        $api->get('sendSms', 'SmsController@sendSms');
        $api->get('qrCodes', 'QrCodesController@create');
        // 服务师注册网页授权
        $api->get('oauth/waiterRegisterIndex', 'OauthController@waiterRegisterIndex');
        $api->get('oauth/waiterRegisterBack', 'OauthController@waiterRegisterBack');
        // 服务师登录网页授权
        $api->get('oauth/loginIndex', 'OauthController@loginIndex');
        $api->get('oauth/loginBack', 'OauthController@loginBack');
        $api->get('templates/send', 'TemplatesController@send');
        // js sdk
        $api->get('jsSdk/getLocation', 'jsSdkController@getLocation');

        // 发送邮件
        $api->get('sendEmail/send', 'SendEmailController@sendEmailReminder');

        // 队列测试
        $api->get('queue/sendMail', 'QueueController@sendMail');
    });
    $api->get('test', 'App\Api\Controllers\TestController@index');
    /*
     * 商户端
     * */
    $api->group(['namespace' => 'App\Api\Controllers\Merchant'], function ($api) {
        // 商户登录
        $api->post('merchantAdmin/login', 'MerchantAdminController@login');
        //商户管理员忘记密码---发送短信验证码
        $api->post('merchantAdmin/sendSms','MerchantAdminController@sendSms');
        //商户管理员忘记密码
        $api->post('merchantAdmin/forgetPwd','MerchantAdminController@forgetPwd');

        /*
         * 开发接口
         * */
        //检查服务师是否已经注册
        $api->post('open/checkRegister','OpenController@checkWaiterRegister');
        //服务师扫码注册
        $api->post('waiter/register','OpenController@waiterRegister');
        //获取店铺信息
        $api->get('open/shopIndex','OpenController@shopIndex');
        //获取职位信息
        $api->get('open/levelIndex','OpenController@levelIndex');
        //服务项目信息
        $api->get('open/goodsIndex','OpenController@goodsIndex');
        // 商户推广二维码(用户扫码注册)
        $api->get('spread/code','SpreadController@code');
        

        /*
         * 商户注册
         * */
        //商户注册验证手机号码是否已经注册
        $api->post('open/checkTel','OpenController@merchantRegisterCheckTel');
        //商户注册发送手机验证码
        $api->post('open/registerSendMsg','OpenController@merchantRegisterSendMsg');
        //商户注册检测验证码
        $api->post('open/checkCode','OpenController@checkMsgCode');
        //商户注册检测验证码
        $api->post('open/merchantRegister','OpenController@merchantRegister');


        $api->group(['middleware'=>'jwt.auth'],function ($api){

            /*
             * 商户信息
             * */
            //商户推广二维码
            $api->get('merchant/merchantQrCode', 'MerchantController@merchantQrCode');

            $api->get('merchant/getAllMerchant', 'MerchantController@getAllMerchant');
            /*
             * 商户管理端----管理员相关路由
             * */
            //商户管理员退出
            $api->get('merchantAdmin/logout',['as' => 'merchantAdmin.logout', 'uses' => 'MerchantAdminController@logout']);
            //商户管理端首页信息
            $api->get('merchantAdmin/index','MerchantAdminController@index');
            //商户管理员信息
            $api->get('merchantAdmin/show','MerchantAdminController@show');
            //商户管理员的信息修改
            $api->post('merchantAdmin/update','MerchantAdminController@update');
            //商户管理员密码修改
            $api->post('merchantAdmin/pwdUpdate','MerchantAdminController@pwdUpdate');
            //商户管理员展示登录账号
            $api->get('merchantAdmin/showName','MerchantAdminController@showName');
            //商户管理员忘记密码---修改密码
            $api->post('merchantAdmin/forgetPwdUpdatePwd','MerchantAdminController@forgetPwdUpdatePwd');

            /*
             * 商户管理端----店铺管理
             * */
            //商户店铺展示
            $api->get('shop/index','ShopController@index');
            //商户店铺添加
            $api->post('shop/store','ShopController@store');
            //商户店铺信息更新
            $api->post('shop/update','ShopController@update');
            //单个店铺信息展示
            $api->get('shop/show','ShopController@show');
            //商户门店删除
            $api->delete('shop/destroy','ShopController@destroy');
            //获取商户还能添加的门店数量
            $api->get('shop/getShopNum','ShopController@getShopNum');
            //获取门店名称列表
            $api->get('shop/getShopList','ShopController@getShopList');
            /*
             * 商户管理端----人员管理
             * */
            //  职位管理
            //--所有职位展示
            $api->get('waiterLevel/index','WaiterLevelController@index');
            //--职位添加
            $api->post('waiterLevel/store','WaiterLevelController@store');
            //--职位修改
            $api->post('waiterLevel/update','WaiterLevelController@update');
            //--职位删除
            $api->delete('waiterLevel/destroy','WaiterLevelController@destroy');
            //  职位编辑
            $api->get('waiterLevel/edit','WaiterLevelController@edit');

            //  服务师管理
            //所有服务师展示
            $api->get('waiter/index','WaiterController@index');
            //单个服务师的信息展示参数服务师的id
            $api->get('waiter/show','WaiterController@show');
            //服务师删除  参数服务师的id
            $api->delete('waiter/destroy','WaiterController@destroy');
            //根据店铺id 展示门店下的所有服务师
            $api->post('waiter/waiterByShop','WaiterController@waiterByShop');

            //服务师生成注册二维码
            $api->get('waiter/build','WaiterRegisterQrCodeController@buildQrCode');
            
            /*
             * 商户管理端----产品管理
             * */
            //所有产品展示
            $api->get('goodsCate/index','GoodsCateController@index');
            //大类产品添加
            $api->post('goodsCate/storeParent','GoodsCateController@storeParent');
            //大类编辑
            $api->get('goodsCate/editParent','GoodsCateController@editParent');
            //大类编辑数据提交
            $api->post('goodsCate/updateParent','GoodsCateController@updateParent');
            //大类删除
            $api->delete('goodsCate/destroyParent','GoodsCateController@destroyParent');
            //子类产品添加
            $api->post('goodsCate/storeChild','GoodsCateController@storeChild');
            //子类编辑
            $api->get('goodsCate/editChild','GoodsCateController@editChild');
            //子类编辑数据提交
            $api->post('goodsCate/updateChild','GoodsCateController@updateChild');
            //子类删除
            $api->delete('goodsCate/destroyChild','GoodsCateController@destroyChild');
            
            /*
             * 商户管理端----服务师作品管理
             * */
            //所有作品展示
            $api->get('waiterAlbum/index','WaiterAlbumController@index');
            //单作品展示
            $api->get('waiterAlbum/show','WaiterAlbumController@show');
            //单作品展示
            $api->delete('waiterAlbum/destroy','WaiterAlbumController@destroy');

            /*
            * 商户管理端----预约统计
            * */
            //预约统计首页
            $api->get('appointRank/index','AppointRankController@index');
            //预约统计首页（根据门店id筛选）
            $api->get('appointRank/indexByShop','AppointRankController@indexByShopId');
            //根据时间区间 ,门店id   服务师预约排行
            $api->post('appointRank/waiterRankByShop','AppointRankController@WaiterRankIndexByShop');

            /*
            * 商户管理端----实时预约
            * */
            //首页 全部门店 实时预约
            $api->post('appoint/index','AppointController@index');
            //显示店铺的--实时预约
            $api->post('appoint/shop','AppointController@byShopAppoint');

            /*
             * 客户列表
             * */
            //客户列表展示
            $api->get('member/index','MemberController@index');

            /*
             * 门店排行
             * */
            $api->get('shopRank/index','ShopRankController@index');

            /*
             * 产品排行
             * */
            //产品排行首页
            $api->post('GoodsRank/index','GoodsRankController@index');
            //获取产品所有的大类
            $api->get('GoodsRank/goodsParent','GoodsRankController@allGoodsParent');

            /*
             * 商户服务师的评价
             * */
            //获取服务的评价标签数量
            $api->post('comment/waiterComment','CommentController@waiterComment');

            /*
             * 商户注册初始化
             * */
            //门店初始化
            $api->get('initialization/int','InitializationController@int');
            /*//产品初始化
            $api->get('initialization/goods','InitializationController@goods');
            //职位初始化
            $api->get('initialization/level','InitializationController@level');*/

            /*
             * 商户地址
             * */
            //新增
            $api->post('address/store','AddressController@store');
        });

    });

    /*
     * 服务师端
     * */
    $api->group(['namespace'=>'App\Api\Controllers\Waiter','prefix'=>'waiter'],function($api){

        //单个商户服务师登录（手机号码登录）
        //$api->post('waiter/login','WaiterController@login');
        //多商户登录获取商户信息
        //$api->post('waiter/merchantList','WaiterController@merchantList');
        //多商户服务师登录
        //$api->post('waiter/moreLogin','WaiterController@moreMerchantLogin');

        //单个商户服务师微信登录
        $api->post('waiter/wxLogin','WaiterController@wxLogin');
        //多商户 （微信）登录获取商户信息
        $api->post('waiter/wxMerchantList','WaiterController@wxMerchantList');
        //多商户服务师（微信）登录
        $api->post('waiter/wxMoreLogin','WaiterController@wxMoreMerchantLogin');
        
        //登录发送短信
        //$api->post('waiter/sendSms','WaiterController@sendSms');

        $api->group(['middleware'=>'jwt.waiter_auth'],function ($api){
            /*
             * 服务师
             * */
            //服务师退出
            $api->get('waiter/logout','WaiterController@logout');
            //服务师端首页
            $api->get('waiter/index','WaiterController@index');
            //服务师端首页
            $api->get('waiter/edit','WaiterController@edit');
            //服务师端首页
            $api->post('waiter/update','WaiterController@update');
            //获取所有的门店
            $api->get('waiter/allShop','WaiterController@allShopByMerchant');
            //根据 服务师id 获取所在的门店
            $api->get('waiter/shopByWaiter','WaiterController@shopByWaiterId');
            //获取所有的职位
            $api->get('waiter/allLevel','WaiterController@allLevelByMerchant');
            //获取所有服务产品
            $api->get('waiter/allGoods','WaiterController@allGoodsByMerchant');

            /*
             * 服务师作品
             * */
            //作品首页
            $api->get('album/index','AlbumController@index');
            //单个作品显示
            $api->get('album/show','AlbumController@show');
            //作品删除
            $api->delete('album/destroy','AlbumController@destroy');
            //作品新增
            $api->post('album/store','AlbumController@store');
            //作品编辑显示
            $api->get('album/edit','AlbumController@edit');
            //作品编辑显示
            $api->post('album/update','AlbumController@update');

            /*
             * 预约管理
             * */
            //首页
            $api->get('appoint/index',['uses' => 'AppointController@index','as' => 'waiter.appoint.index']);
            //取消预约
            $api->post('appoint/cancel','AppointController@cancelAppoint');
            //确认到店
            $api->post('appoint/confirm','AppointController@confirmShop');
            //预约删除
            $api->delete('appoint/destroy','AppointController@destroy');
            
            /*
             * 服务师调休
             * */
            //服务师调休首页
            $api->get('waiterRest/index','WaiterRestController@index');
            //调休编辑提交
            $api->post('waiterRest/update','WaiterRestController@update');
            //(该时间存在预约)调休编辑提交
            $api->post('waiterRest/haveAppoint','WaiterRestController@updateHaveAppoint');

            //调休删除
            $api->delete('waiterRest/destroy','WaiterRestController@destroy');
            //服务师是否开启预约
            $api->post('waiterRest/openAppoint','WaiterRestController@openAppoint');
            //调休删除
            $api->get('waiterRest/status','WaiterRestController@openAppointStatus');

            /*
             * 预约统计
             * */
            //预约统计首页
            $api->get('appointRank/index','AppointRankController@index');
            //预约统计首页（根据门店id筛选）
            $api->post('appointRank/indexByShop','AppointRankController@indexByShopId');

            /*
             * 评价列表
             * */
            $api->post('comment/index','CommentController@index');

        });
    });

    /*
     * 会员端
     * */
    $api->group(['namespace'=>'App\Api\Controllers\Member','prefix'=>'member'],function($api){
        
        //客户登录发送手机短信验证码
        //$api->post('member/sendSms','MemberController@sendSms');
        //根据手机号码获取商户信息
        //$api->post('member/merchantByTel','MemberController@merchantByTel');

        //单商户单门店直接登录
        $api->post('member/chooseMerchantLogin','MemberController@chooseMerchantLogin');

        //多店铺---选择店铺登录
        $api->post('member/chooseShopLogin','MemberController@chooseShopLogin');


        //商户列表展示
        $api->post('member/merchantList','MemberController@merchantList');
        //客户手机登录 多商户登录
        //$api->post('member/moreLogin','MemberController@moreMerchantLogin');
        
        //删除商户会员关系
        $api->post('member/delMerchantRelation','MemberController@delMerchantRelation');

        //店铺列表
        $api->post('shop/shopList','ShopController@shopList');
        /*3333*/
        $api->post('shop/lgh','ShopController@lgh');
        //微信登录
        $api->post('member/wxLogin','MemberController@wxLogin');
        //客户微信登录 多商户列表展示
        $api->post('member/wxMerchantList','MemberController@wxMerchantList');
        //客户微信登录 多商户登录
        //$api->post('member/wxMoreLogin','MemberController@wxMoreMerchantLogin');
        // jssdk 生成分享链接接口
        $api->get('share/getShareLink','ShareController@getShareLink');

        $api->group(['middleware'=>'jwt.member_auth'],function ($api){

            /*
             * 登陆之后绑定手机号码
             * */
            //检查手机号码是否存在
            $api->get('member/checkTel','MemberController@checkTelByToken');
            //发送短信验证码
            $api->post('member/bindTelSendMsg','MemberController@bindTelSendMsg');
            //发验证手机验证码，完成手机号码绑定
            $api->post('member/bindTel','MemberController@bindTel');
            /*
             * 店铺信息
             * */

            //店铺首页
            //$api->get('shop/shopIndex','ShopController@shopIndex');
            //店铺详情
            $api->get('shop/shopShow','ShopController@shopShow');
            
            /*
             * 我的
             * */
            //首页展示
            $api->get('member/index','MemberController@index');
            //编辑展示
            $api->get('member/edit','MemberController@edit');
            //编辑提交
            $api->post('member/update','MemberController@update');
            //退出
            $api->get('member/logout','MemberController@logout');

            //我的预约
            $api->get('myAppoint/index',['uses' => 'MyAppointController@index','as' => 'member.myAppoint.index']);
            //我的预约  取消预约
            $api->post('myAppoint/cancel','MyAppointController@cancelAppoint');
            //我的预约  预约删除
            $api->delete('myAppoint/destroy','MyAppointController@destroy');

            /*
             * 服务师信息
             * */
            //服务师 首页
            $api->get('waiter/waiterList','WaiterController@waiterList');
            //服务师所有的职位
            $api->get('waiter/allLevel','WaiterController@allLevel');
            //根据职位显示服务师信息
            $api->post('waiter/waiterListByLevel','WaiterController@waiterListByLevel');
            //服务师详情
            $api->get('waiter/waiterShow','WaiterController@waiterShow');
            //根据产品筛选服务师
            $api->get('waiter/waiterListByGoods','WaiterController@waiterListByGoods');

            /*
             * 服务师作品
             * */
            //服务师全部作品
            $api->get('waiterAlbum/allAlbum','WaiterAlbumController@allAlbum');
            //服务师作品详情
            $api->get('waiterAlbum/albumShow','WaiterAlbumController@albumShow');

            /*
             * 服务产品
             * */
            //获取产品-大类
            $api->get('goodsCate/allParent','GoodsCateController@allParent');
            //获取所有产品-子类
            $api->get('goodsCate/allChild','GoodsCateController@allChild');
            //根据大类id获取子类
            $api->get('goodsCate/goodsCateByPid','GoodsCateController@goodsCateByPid');
            //预约项目 
            $api->get('goodsCate/goodsCateById','GoodsCateController@goodsCateById');
            //根据服务师id获取 产品大类
            $api->post('goodsCate/parentByWaiterId','GoodsCateController@parentByWaiterId');
            //根据服务师id获取 产品子类
            $api->post('goodsCate/goodsByWaiterId','GoodsCateController@goodsCateByWaiterId');
            //根据服务师id,产品pid 获取产品子类
            $api->post('goodsCate/goodsByWaiterIdByPid','GoodsCateController@goodsCateByWaiterIdByPid');

            /*
             * 预约
             * */
            //获取产品-大类
            $api->post('appoint/getAppointTime','AppointController@getAppointTime');
            //产品预约
            $api->post('appoint/appointStore','AppointController@appointStore');
            //获取预约的服务师，产品信息
            $api->post('appoint/appointEdit','AppointController@appointEdit');

            /*
             * 评价
             * */
            //获取所有的标签
            $api->get('comment/allTag','CommentController@allCommentTag');
            //添加评论
            $api->post('comment/store','CommentController@store');
            //服务师的评论
            $api->post('comment/waiterComment','CommentController@waiterComment');
            
            // jssdk 获取分享信息
            $api->get('share/getShareInfo','ShareController@getShareInfo');
        });
    });
});