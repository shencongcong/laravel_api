<?php

namespace App\Api\Controllers\Tool;

use Mail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SendEmailController extends Controller
{
    /**
     * 发封电子邮件提醒给用户。
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function sendEmailReminder(Request $request)
    {
        Mail::raw('这是一封测试邮件', function ($message) {
            $to = '1343948033@qq.com';
            $message ->to($to)->subject('测试邮件');
        });
    }
}