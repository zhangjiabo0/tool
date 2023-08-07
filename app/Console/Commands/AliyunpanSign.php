<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\TaskNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AliyunpanSign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aliyunpan:sign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '阿里云盘 自动签到';

    private $users = [];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->users = config('sign.aliyunpan');
        $value = '';
        foreach ($this->users as $user){
            $value .= '尝试账号：'.$user['mobile'].PHP_EOL;
            $token_result = Http::post('https://auth.aliyundrive.com/v2/account/token', ['grant_type'=>'refresh_token','refresh_token'=>$user['refresh_token']]);
            $token_result = json_decode($token_result,true);
            if(!isset($token_result['access_token'])){
                $value .= 'refresh_token错误'.PHP_EOL;
                continue;
            }
            $access_token = $token_result['access_token'];
            $phone = $token_result["user_name"];
            $access_token2 = 'Bearer '.$access_token;
            $sign_result = Http::withHeaders(['Authorization'=>$access_token2])->post('https://member.aliyundrive.com/v1/activity/sign_in_list', ['_rx-s'=>'mobile']);
            $sign_result = json_decode($sign_result,true);
            if(!($sign_result['success'] ?? false)){
                $value .= 'sign签到失败'.PHP_EOL;
                continue;
            }
            $signin_count = $sign_result['result']['signInCount'];
            $value .= "账号：".$phone."-签到成功, 本月累计签到".$signin_count."天".PHP_EOL;
            sleep(2);

            $reward_result = Http::withHeaders(['Authorization'=>$access_token2])->post('https://member.aliyundrive.com/v1/activity/sign_in_reward?_rx-s=mobile', ['signInDay'=>$signin_count]);
            $reward_result = json_decode($reward_result,true);
            if(!($reward_result['success'] ?? false)){
                $value .= '领取奖励失败'.json_encode($reward_result).PHP_EOL;
                continue;
            }
            $value .= "本次签到获得：".$reward_result["result"]["name"] .",具体描述：".$reward_result["result"]["description"].PHP_EOL;
        }
        echo '时间：'.date('Y-m-d H:i:s').PHP_EOL.$value;
        $model_user = User::find(1);
        $model_user->subject = '阿里云盘签到'.date('Y-m-d#H:i:s');
        $model_user->text = $value;
        $model_user->notifyNow(new TaskNotification());
        return true;
    }
}
