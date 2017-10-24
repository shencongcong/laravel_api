<?php

namespace App\Api\Controllers\Tool;

use App\Http\Controllers\Controller;
use App\Jobs\SendReminderEmail;
use Log;

class QueueController extends Controller
{
    public function sendMail()
    {
        $receive = '1343948033@qq.com';
        $subject = '队列发送邮件测试';
        Log::info('Log1||'.$receive);
        $job = (new SendReminderEmail($receive,$subject));
        $this->dispatch($job);
        return 1;
    }
}