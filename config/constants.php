<?php

return [

    //登录类型
    'MERCHANT_LOGIN' => 1,  //管理员登录 
    'WAITER_LOGIN'   => 2,  //服务师登录
    'MEMBER_LOGIN'   => 3,  //客户登录

    // 缓存时间 (单位 min)
    'ONE_MINUTE' => 1,
    'THREE_MINUTE' => 3,
    'FIVE_MINUTE' => 5,
    'TEN_MINUTE' => 10,
    'ONE_DAT'=>24*60,
     'ONE_YEAR' => 365*24*60,
    //手机验证码过期时间,以's'为单位
    'TIME_EXPIRES'  =>3000,

    'WEB_SITE' => 'https://wr2.weerun.com',// 网站域名
    'WAITER_REGISTER' => 'https://merchant.weerun.com/#/haitoken',//服务师注册授权页
    'MEMBER_REGISTER' =>'https://wr2.weerun.com/api/spread/code',//用户注册
    'MEMBER_SHARE' =>'https://member.weerun.com/#/share/',//用户分享页面
    //生成签名的字符串
    'SIGNATURES_KEY' =>'Km8gAuc4jCQKsAxXC6CmYna7fUk8iX3Y',

    // 公众号模板消息

    'APPID'=>[
        // 约美甲
        'wx456828ef5e9900e7'=>[
            'NOTICE_MEMBER_OK' => '80JjHqskN60riAkfZHL82zf2KWd1Nv06CS2IhxJ09tQ' ,// 通知会员预约成功
            'NOTICE_HAIR_OK' =>'q6A-ZeSs2Vnh2F0vMkrMoS5nHiRMW34zGK4F9fJKAB4',//通知服务师预约成功
            'NOTICE_CANCEL' =>'DAOpBiMuLq33rtrawKULNE6Bz8UfrHCinsA65bELWMg',//预约取消
            'ADVANCE_NOTICE' =>'0BdMqXn1l0bDxwbTnJRBotZ0TfSAKfPJUWCidSPrnLQ',//服务到期提前通知
            'BALANCE_NOTICE' =>'VaOg204EAvEfq_MXDsAV6922hbwliC8qMeFn6YWMenA',// 余额变更通知
        ],
        // 爱丽真
        'wxc3c47e69c7e71c65'=>[
            'NOTICE_MEMBER_OK' => 'kOZfi3562T1vECYYCJrkfvUro4xrGj4krGdxV1_Jeec' ,// 通知会员预约成功
            'NOTICE_HAIR_OK' =>'LjR954pLkhpCvkZPHq8llnGqjBmP4oaMlCQXJCz459I',//通知服务师预约成功
            'NOTICE_CANCEL' =>'2UplKr0H7-_U_ZPV-xN2wdUDXgOqR6bbsN5aTvY-AI4',//预约取消
            'ADVANCE_NOTICE' =>'bBMGFHR5E_Vjt_HgllQnZGkT5svCDFxZ0WnWzpqj92A',//服务到期提前通知
            'BALANCE_NOTICE' =>'yKjXfTor3LW1eElv92sALi1dLl0WrkpD8veI8lbXHkg',// 余额变更通知
        ],
        // 约美发
        // 约理疗

        // 蕾娜发型格沙龙
        'wxe07ccd9b6b7c7626'=>[
            'NOTICE_MEMBER_OK' => 'nHc6AobQk01s7kPdZON9Sg3hF5b2h2dtV9qW9ZRr6ug' ,// 通知会员预约成功
            'NOTICE_HAIR_OK' =>'Br--594pHXC29Im7kf2KOVHu_EWRgIkKBn7a2X1qZpE',//通知服务师预约成功
            'NOTICE_CANCEL' =>'jIuKyT8Xz8t_NdrPlS0ZwQSOYs1401_9Q6eYKSfUbTQ',//预约取消
            'ADVANCE_NOTICE' =>'K54DLERCZ4ILvEIYaKdsxa347-9gxZ7iHnnEm9WP7bw',//服务到期提前通知
            'BALANCE_NOTICE' =>'bS9rOlcQJrpgjiAch_SuWwgVfyd7H7zbzfx0Hnz9opg',// 余额变更通知
        ]

    ],

    //商户角色标志
    'BASE_ROLE' =>6,
    'HIGH_ROLE' =>8,
    //商户默认的到期时间（年）
    'MERCHANT_EXPIRE_TIME'=> 2,
    //一天可预约次数
    'CAN_APPOINT_NUM' =>5,

    // app应用端授权域名
    'APP_DOMAIN' =>[
        'member.weerun.com',
        'waiter.weerun.com',
        'merchant.weerun.com'
    ]
];