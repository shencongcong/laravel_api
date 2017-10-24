<?php

namespace App\Providers;

use Queue;
use Illuminate\Queue\Events\JobFailed;
use Mail;
use Illuminate\Support\ServiceProvider;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 队列执行失败邮件通知我们通知
        //admin-sidebar
        Queue::failing(function (JobFailed $event) {
            Log::info('Queue::failing');
            $title = '队列死掉，请速度重启';
            Mail::raw($title, function ($message)use($event) {
                $to = '1343948033@qq.com';
                $subject= '你的redis队列已经死掉了，请速度登录队列后台进行重启！队列名称:'.$event->job;
                $message ->to($to)->subject($subject);
            });
        });
        view()->composer('admin.layouts.sidebar','App\Http\ViewComposers\AdminMenuComposer');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);
    }
}
