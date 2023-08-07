<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\TaskNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class V2freeSign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'v2free:sign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'v2free 自动签到';

    private $users = [];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->users = config('sign.v2free');
        $text = '';
        foreach ($this->users as $user){
            $login_result = Http::post('https://me.tofly.cyou/auth/login', $user);
            $result = json_decode($login_result,true);
            if($result['ret'] == 1){//登陆成功
                //获取cookie
                $uid = $login_result->cookies()->getCookieByName('uid')->getValue();
                $email = $login_result->cookies()->getCookieByName('email')->getValue();
                $expire_in = $login_result->cookies()->getCookieByName('expire_in')->getValue();
                $key = $login_result->cookies()->getCookieByName('key')->getValue();
                $cookies = [
                    'uid'=>$uid,
                    'email'=>$email,
                    'expire_in'=>$expire_in,
                    'key'=>$key
                ];
                $check_res = Http::withCookies($cookies,'me.tofly.cyou')->post('https://me.tofly.cyou/user/checkin');
                $check_res = json_decode($check_res,true);
                if($check_res['ret'] == 1){//签到成功
                    $text .= '账号：'.$user['email'].' 签到成功! '.PHP_EOL;
                }else{
                    $text .= '账号：'.$user['email'].' 签到失败! '.$check_res['msg'].PHP_EOL;
                }
            }else{
                $text .= '账号：'.$user['email'].' 登陆失败 '.$login_result.PHP_EOL;
            }
        }
        echo '时间：'.date('Y-m-d H:i:s').PHP_EOL.$text;
        $model_user = User::find(1);
        $model_user->subject = 'v2free签到'.date('Y-m-d#H:i:s');
        $model_user->text = $text;
        $model_user->notifyNow(new TaskNotification());
    }
}
