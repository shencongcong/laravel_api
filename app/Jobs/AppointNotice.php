<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Api\Controllers\Tool\TemplatesController;
use Log;
use Mail;

class AppointNotice extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $send;
    protected $merchant_id;
    protected $wx_open_id;
    protected $template_type;
    protected $data;
    protected $url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($merchant_id, $wx_open_id, $template_type, $data, $url='')
    {
        $this->send = new TemplatesController();
        $this->merchant_id = $merchant_id;
        $this->wx_open_id = $wx_open_id;
        $this->template_type = $template_type;
        $this->data = $data;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('send_template_queue');
        $this->send->send($this->merchant_id, $this->wx_open_id, $this->template_type, $this->data, $this->url);
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
