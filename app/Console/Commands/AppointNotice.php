<?php

namespace App\Console\Commands;

use App\models\Appoint;
use App\models\Member;
use App\models\Shop;
use App\models\Waiter;
use Illuminate\Console\Command;
use DB;
use Log;
use App\Api\Controllers\Tool\TemplatesController;

class AppointNotice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointNotice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '预约到期通知定时任务';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $template_type = 'ADVANCE_NOTICE';
        // 提前10min通知服务师
        $time = time() + 600;
        $appoint_obj = Appoint::where('is_notice_waiter', 0)
            ->where('status', 1)
            ->where('reason', '=', 0)
            ->where('time_str', '<=', $time)
            ->get();
        if (count($appoint_obj) !== 0) {
            $appoint_arr = $appoint_obj->toArray();
            foreach ($appoint_arr as $k => $v) {
                $time_date = $v['time_date'];
                $time_hour_text = date('H:i', $v['time_str']);
                $merchant_id = $v['merchant_id'];
                $merchant_num = DB::table('wr_merchant')
                    ->where('id',$merchant_id)
                    ->count();
                if($merchant_num>0){
                    $hair_arr = (array)DB::table('wr_waiter')
                        ->where('id', $v['waiter_id'])
                        ->select('open_id', 'nickname')
                        ->first();
                    if ($hair_arr) {
                        $member_arr = (array)DB::table('wr_member')
                            ->where('id', $v['member_id'])
                            ->select('tel', 'member_name')
                            ->first();
                        if ($member_arr) {
                            $member_tel = $member_arr['tel'];
                            $member_name = $member_arr['member_name'];
                        } else {
                            $member_tel = '';
                            $member_name = '';
                            Log::info('客户不存在');
                            DB::table('wr_appoint')->where('id', $v['id'])->update(array('is_notice_waiter' => 1));
                        }
                        $wx_waiter_open_id = $hair_arr['open_id'];
                        $hair_name = $hair_arr['nickname'];
                        $data = appoint_ok_notice_hair_again($member_name, $time_date, $time_hour_text, $member_tel, $hair_name);
                        $url = 'http://waiter.weerun.com/#/Appointment';
                        $send = new TemplatesController();
                        $send->send($merchant_id, $wx_waiter_open_id, $template_type, $data, $url);
                        // 将提示服务师状态改掉
                        DB::table('wr_appoint')->where('id', $v['id'])->update(array('is_notice_waiter' => 1));
                    } else {
                        Log::info('服务师不存在');
                        DB::table('wr_appoint')->where('id', $v['id'])->update(array('is_notice_waiter' => 1));
                    }
                }

            }
        }

        // 提前30min通知客户
        $time_member = time() + 1800;
        $appoint_obj_member = Appoint::where('is_notice_member', 0)
            ->where('status', 1)
            ->where('reason', '=', 0)
            ->where('time_str', '<=', $time_member)
            ->get();
        if (count($appoint_obj_member) !== 0) {
            $appoint_arr_member = $appoint_obj_member->toArray();
            foreach ($appoint_arr_member as $k1 => $v1) {
                $merchant_id = $v1['merchant_id'];
                $merchant_num = DB::table('wr_merchant')
                    ->where('id',$merchant_id)
                    ->count();
                if($merchant_num>0){
                    $time_date = $v1['time_date'];
                    $time_hour_text = date('H:i', $v1['time_str']);
                    $shop_obj = Shop::where('id', $v1['shop_id'])
                        ->select('shop_name', 'tel')
                        ->first();
                    if ($shop_obj) {
                        $shop_arr = $shop_obj->toArray();
                        $shop_tel = $shop_arr['tel'];
                        $shop_name = $shop_arr['shop_name'];
                        $member_obj = Member::where('id', $v1['member_id'])
                            ->select('member_name', 'open_id')
                            ->first();
                        if ($member_obj) {
                            $member_arr = $member_obj->toArray();
                            $member_name = $member_arr['member_name'];
                            $wx_member_open_id = $member_arr['open_id'];
                            $hair_name = Waiter::where('id', $v1['waiter_id'])
                                ->value('nickname');
                            if (!$hair_name) {
                                $hair_name = '';
                                Log::info('服务师不存在');
                            }
                            $data1 = appoint_ok_notice_member_again($member_name, $time_date, $time_hour_text, $shop_tel, $hair_name, $shop_name);
                            //会员我的预约首页
                            $url1 = 'http://member.weerun.com/#/Userappointgoing';
                            $send = new TemplatesController();
                            $send->send($merchant_id, $wx_member_open_id, $template_type, $data1, $url1);
                            // 将提示客户状态改掉
                            DB::table('wr_appoint')->where('id', $v1['id'])->update(array('is_notice_member' => 1));
                        } else {
                            Log::info('客户不存在');
                            DB::table('wr_appoint')->where('id', $v1['id'])->update(array('is_notice_member' => 1));
                        }
                    } else {
                        Log::info('门店不存在');
                        DB::table('wr_appoint')->where('id', $v1['id'])->update(array('is_notice_member' => 1));
                    }
                }
            }
        }

    }
}
