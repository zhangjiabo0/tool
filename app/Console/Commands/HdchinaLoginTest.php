<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class HdchinaLoginTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hdchina:logintest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'hdchina 暴力破解密码';

    public function generateRandomIP(){
        $ip_1 = -1;
        $ip_2 = -1;
        $ip_3 = rand(0,255);
        $ip_4 = rand(0,255);
        $ipall = array(
            array(array(58,14),array(58,25)),
            array(array(58,30),array(58,63)),
            array(array(58,66),array(58,67)),
            array(array(60,200),array(60,204)),
            array(array(60,160),array(60,191)),
            array(array(60,208),array(60,223)),
            array(array(117,48),array(117,51)),
            array(array(117,57),array(117,57)),
            array(array(121,8),array(121,29)),
            array(array(121,192),array(121,199)),
            array(array(123,144),array(123,149)),
            array(array(124,112),array(124,119)),
            array(array(125,64),array(125,98)),
            array(array(222,128),array(222,143)),
            array(array(222,160),array(222,163)),
            array(array(220,248),array(220,252)),
            array(array(211,163),array(211,163)),
            array(array(210,21),array(210,22)),
            array(array(125,32),array(125,47))
        );
        $ip_p = rand(0,count($ipall)-1);#随机生成需要IP段
        $ip_1 = $ipall[$ip_p][0][0];
        if($ipall[$ip_p][0][1] == $ipall[$ip_p][1][1]){
            $ip_2 = $ipall[$ip_p][0][1];
        }else{
            $ip_2 = rand(intval($ipall[$ip_p][0][1]),intval($ipall[$ip_p][1][1]));
        }
        $member = null;
        $ipall  = null;
        return $ip_1.'.'.$ip_2.'.'.$ip_3.'.'.$ip_4;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        for($i = 0;$i<20;$i++){
            echo $i.' start:'.PHP_EOL;
            $ip = $this->generateRandomIP();
            $arr = [
                'X-Forwarded-For'=> $ip,
                'X-Originating-IP'=> $ip,
                'X-Remote-IP'=> $ip,
                'X-Remote-Addr'=> $ip,
                'X-Client-IP'=> $ip
            ];

            Http::withHeaders($arr)->connectTimeout(60)->get('https://www.hdchina.net/forum.php?mod=viewthread&tid=63256&fromuid=102897');
            echo $i.' end:'.PHP_EOL;
//            sleep(10);
        }
    }
}
