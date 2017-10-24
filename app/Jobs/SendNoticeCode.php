<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Api\Controllers\Tool\SmsController;
use Log;
use Mail;

class SendNoticeCode extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;


    protected $sms;
    protected $tel;
    protected $tem;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tel,$tem)
    {
        $this->sms = new SmsController();
        $this->tel = $tel;
        $this->tem = $tem;
    }

    /**
     * 发送消息通知
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        Log::info('send_code_queue');
        $this->sms->noticeSendSms($this->tel,$this->tem);
    }

    /**
     * 处理一个失败的任务
     *
     * @return void
     */
    public function failed()
    {
        $title = '队列死掉，请速度重启';
        Mail::raw($title, function ($message) {
            $to = '1343948033@qq.com';
            $subject= '你的redis队列已经死掉了，请速度登录队列后台进行重启！队列名称:';
            $message ->to($to)->subject($subject);
        });
    }
}
