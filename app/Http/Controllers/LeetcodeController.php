<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\TaskNotification;
use Illuminate\Support\Facades\Notification;

class LeetcodeController extends Controller
{
    //

    public function test(Request $request)
    {
        $s = 'MCMXCIV';

        $s = str_replace('IX','VIIII',$s);
        $s = str_replace('IV','IIII',$s);

        $s = str_replace('XC','LXXXX',$s);
        $s = str_replace('XL','XXXX',$s);

        $s = str_replace('CM','DCCCC',$s);
        $s = str_replace('CD','CCCC',$s);

        $l = strlen($s);

        $n = 0;
        for($i = 0;$i<$l;$i++){
            echo $s[$i].'<br>';
            if($s[$i] == 'I'){
                $n += 1;
            }else if($s[$i] == 'V'){
                $n += 5;
            }else if($s[$i] == 'X'){
                $n += 10;
            }else if($s[$i] == 'L'){
                $n += 50;
            }else if($s[$i] == 'C'){
                $n += 100;
            }else if($s[$i] == 'D'){
                $n += 500;
            }else if($s[$i] == 'M'){
                $n += 1000;
            }

        }

        echo $n;
    }

    public function test2(Request $request)
    {
        $num = 400;
        $r = $this->match_each($num);
        $r = str_replace('VIIII','IX',$r);
        $r = str_replace('IIII','IV',$r);

        $r = str_replace('LXXXX','XC',$r);
        $r = str_replace('XXXX','XL',$r);

        $r = str_replace('DCCCC','CM',$r);
        $r = str_replace('CCCC','CD',$r);

        echo $r;
    }

    function match_each($num){
        $m = floor($num/1000);
        if($m>=1){
            $b = $num-$m*1000;
            return str_repeat('M',$m).$this->match_each($b);
        }

        $d = floor($num/500);
        if($d>=1){
            $b = $num-$d*500;
            return str_repeat('D',$d).$this->match_each($b);
        }

        $c = floor($num/100);
        if($c>=1){
            $b = $num-$c*100;
            return str_repeat('C',$c).$this->match_each($b);
        }

        $l = floor($num/50);
        if($l>=1){
            $b = $num-$l*50;
            return str_repeat('L',$l).$this->match_each($b);
        }

        $x = floor($num/10);
        if($x>=1){
            $b = $num-$x*10;
            return str_repeat('X',$x).$this->match_each($b);
        }

        $v = floor($num/5);
        if($v>=1){
            $b = $num-$v*5;
            return str_repeat('V',$v).$this->match_each($b);
        }

        return str_repeat('I',$num);
    }

    public function test1(Request $request)
    {
        $user = new User();
        $user = User::find(1);
        $user->msg = 'v2free签到成功！';
//        var_dump($user);
        $invoice = 'aaaa';
        $user->notifyNow(new TaskNotification());
//        Notification::send($users, new InvoicePaid($invoice));
    }
}
