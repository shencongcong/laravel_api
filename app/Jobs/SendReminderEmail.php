<?php

namespace App\Jobs;

use App\User;
use App\Jobs\Job;
use Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class SendReminderEmail extends Job implements  ShouldQueue
{

    use InteractsWithQueue, SerializesModels;

    protected $to;
    protected $title;
    protected $subject;

    public function __construct($to,$title,$subject)
    {
        $this->to = $to;
        $this->title = $title;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::raw($this->title, function ($message) {
            $message ->to($this->to)->subject($this->subject);
        });
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