<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Hdchina4K;
use mysql_xdevapi\Exception;

class HdchinaDownload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hdchina:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'hdchina 下载资源到数据库';

    //private $cc = 'c=KUxLezBZ-1677739185481-2abe8d2ac1dd11503262472; 7Kht_2132_connect_is_bind=1; 7Kht_2132_connect_uin=4BDB1085CEFD7A6EA736C6A14371292C; 7Kht_2132_nofavfid=1; 7Kht_2132_client_token=4BDB1085CEFD7A6EA736C6A14371292C; _fmdata=EdSRlcPL7r1n8mbQmZH3NweZ4no0RMzkGSErrpv4cKZ+eihM6bagelywiZtCCg4WIvFRcN8RkguoAQZbwkUGFA==; _xid=bEh4dsSHuHIcn4xhkWQWes0sez4h7ONBNBY/ec3Ui+o=; 7Kht_2132_editormode_e=1; 7Kht_2132_connect_login=1; 7Kht_2132_lastvisit=1680477223; 7Kht_2132_saltkey=TrS76x7R; 7Kht_2132_client_created=1680480843; 7Kht_2132_auth=f0e9jx04T/LZRZpYBjqscu/btd1CgBFQ7IkVnJ6C9XSEbqQ86KFvbMZlEUJzdr6pxWYWAXNyGzRkfCmK/MDPvzkMTUA; 7Kht_2132_visitedfid=51D66D52D48D57D62D53; PHPSESSID=760omffb7h16feb55977fq5su7; 7Kht_2132_secqaaqSdpE2tv=116.fa3a710f5b74e38b73; 7Kht_2132_secqaaqSYufM0Y=130.8541a95d740dc5e03f; 7Kht_2132_secqaaqSe8uNi8=157.228a9694892b57cc2c; 7Kht_2132_secqaaqSv9rH6Z=167.d7f42bbcba275379ea; 7Kht_2132_secqaaqSqCvWPO=400.c19b67bd17f8884556; 7Kht_2132_secqaaqSEodVlv=407.1f8a1959c41857a934; 7Kht_2132_secqaaqSY3D6Q3=409.ce100be36650e3dead; 7Kht_2132_secqaaqSYyS7Pw=464.2bc3c0793a9802d136; 7Kht_2132_secqaaqSjO3F1Y=552.ec68330fd524ae064b; 7Kht_2132_secqaaqSLQ29oK=667.5632d150e6b4b9ff0b; 7Kht_2132_secqaaqSn70I05=754.e2387250062bcf5bf2; 7Kht_2132_secqaaqSN44i44=764.13b5e662c837cfb54d; 7Kht_2132_secqaaqSUCrC49=773.7b9e50e18c2f07a419; 7Kht_2132_secqaaqSAto3j3=779.a109e56cd8ba353158; 7Kht_2132_secqaaqSRzfbMw=821.6ec93d686b4784a6ee; 7Kht_2132_secqaaqSBdOnY2=822.1728943e15546b9709; 7Kht_2132_ulastactivity=5e10/p8hvvtZFCK0LDY2FBsYRPqfilT0BTgx+FD30N5/GSYnLeEg; 7Kht_2132_secqaaqSqW98LL=11.892cb2b6762b1e7f03; 7Kht_2132_secqaaqSRbGzAP=18.32d922bebc30f3207f; 7Kht_2132_secqaaqSOkX8gA=37.0c504c0ed722c8bd50; 7Kht_2132_secqaaqSuyxeP2=39.980fbe16a24e8233a6; 7Kht_2132_secqaaqSG8PMT7=42.f710a7165269016d5d; 7Kht_2132_secqaaqSdocj1h=54.9118eb2edc4d6d95eb; 7Kht_2132_secqaaqSDZ869b=92.189a90f85bdf63316a; 7Kht_2132_secqaaqSbnni3t=96.9a203664f98b0e8894; 7Kht_2132_secqaaqSByZ9BP=195.c2618a43f16948b42b; 7Kht_2132_secqaaqSruhS85=215.9c4be46629fc9d769c; 7Kht_2132_secqaaqSIpnFOh=224.d97a33fce3c14e10a7; 7Kht_2132_noticeTitle=1; 7Kht_2132_secqaaqSH2B6cU=236.c023656b7a8635ecf4; 7Kht_2132_secqaaqSRzu2iE=253.c6759f77aabe626145; 7Kht_2132_secqaaqSQ98OAH=270.991984c68251cc16cc; 7Kht_2132_sid=e889Kb; 7Kht_2132_lip=60.12.2.25,1681265159; 7Kht_2132_st_p=102897|1681266176|a0d0df924a6967631970e16d6bcd024b; 7Kht_2132_viewid=tid_174312; 7Kht_2132_secqaaqSe889Kb=283.49f5b08b9cbb122bd0; 7Kht_2132_sendmail=1; 7Kht_2132_st_t=102897|1681266312|f493e73662fa7de9b847783f6ff55ee5; 7Kht_2132_forum_lastvisit=D_62_1680137900D_48_1680828054D_52_1680828089D_66_1680828136D_51_1681266312; 7Kht_2132_lastact=1681266313	misc.php	patch';

    private $cc = '_xid=CAFwU7CbkWm5tgn%5C8N4M4Ma2f3TK4pju9uq9TCHHqKbz8hEBIlPuPQnRUCbbOxsyXMb0966FfGwvnUx8itrGJ2iWW5WBZHXVgbj5y5VgjRRWS5n4qd6EWCqOblBXR2te; _fmdata=crGKYZiKfKqCEpyGyaSnf7ca2EqG6DANFJBA8aQ8DAzmVeoJ00JqYo6l%5CJ8vfDVlyPdT3nF5mlKNhL1eW5KSUp4MGC4UvVkzEhYbX5n2H8ivCAJxp8cwz6cPVEL1pm8y; c=M8ZMFAUc-1684198876729-b4e10aab3c16e-373139798; Hm_lvt_7026b7d3b024a55ad1c6f95bd754648e=1685098294,1685524035; PHPSESSID=5ulvkpkop97uslmb42qncv2pj4; 7Kht_2132_sid=RyrGEA; 7Kht_2132_noticeTitle=1; 7Kht_2132_saltkey=S9YNyNDy; 7Kht_2132_lastvisit=1685598476; 7Kht_2132_visitedfid=51; 7Kht_2132_viewid=tid_181530; 7Kht_2132_sendmail=1; 7Kht_2132_con_request_uri=https%3A%2F%2Fwww.hdchina.net%2Fconnect.php%3Fmod%3Dlogin%26op%3Dcallback%26referer%3Dhttps%253A%252F%252Fwww.hdchina.net%252Fthread-181530-1-6.html; 7Kht_2132_client_created=1685602108; 7Kht_2132_client_token=4BDB1085CEFD7A6EA736C6A14371292C; 7Kht_2132_ulastactivity=5b51EHvIvmI%2BeYqbdbZIVUDO3odWgp6clGV8cg4fF5dUTlbrZsp5; 7Kht_2132_auth=dd1d0%2BhjmdVe4prq%2BGQRbv9nvVoyZmxn7i2wqD%2BLV2fkBzKbs6tSF7U3daFZA3xWOx2Xuzen2L%2BDRJgXRfs6sseEIA0; 7Kht_2132_connect_login=1; 7Kht_2132_connect_is_bind=1; 7Kht_2132_connect_uin=4BDB1085CEFD7A6EA736C6A14371292C; 7Kht_2132_stats_qc_login=3; 7Kht_2132_checkpm=1; 7Kht_2132_st_p=102897%7C1685602111%7C165d66caad4aff9853701e02e7de4c1e; Hm_lpvt_7026b7d3b024a55ad1c6f95bd754648e=1685602112; 7Kht_2132_lastact=1685602112%09misc.php%09secqaa; 7Kht_2132_secqaaqSRyrGEA=696.e601b4ecbc18d36b08';

    private $cookies = [];

    public function getListByPage($type = '4k',$page = 1){
        echo '第'.$page.'页'.PHP_EOL;

        switch ($type){
            case '1080':
                $type_num = '53';
                break;
            case 'bluray':
                $type_num = '48';
                break;
            case '4k':
                $type_num = '51';
                break;
            default:
                $type_num = '51';
        }
        $url = 'https://www.hdchina.net/forum-'.$type_num.'-'.$page.'.html';
        $content = Http::withCookies($this->cookies,'www.hdchina.net')->retry(3, 5000)->get($url)->getBody()->getContents();

        preg_match_all('/<span title="共(.*?)页">(.*?)<\/span>/',$content,$pageArr);
        $pageNum = (int)trim($pageArr[1][0]);
        if($page > $pageNum) return 0;

        $num = preg_match_all('/<a href="thread(.*?)"(.*?)onclick="atarget\(this\)" (.*?)>(.*?)<\/a>/',$content,$titleArr);
        for($i = 0;$i<$num;$i++){
            $this->getDetail('https://www.hdchina.net/thread'.$titleArr[1][$i],$titleArr[4][$i]);
//            sleep(1);
        }
        return $pageNum;
    }

    public function getDetail($page_link,$page_name){
        $b = stripos($page_link,'-');
        $c = stripos($page_link,'-',31);
        $video_id = substr($page_link,$b+1,$c-$b-1);

        $page_name = mb_substr($page_name,0,250);
        $content = Http::withCookies($this->cookies,'www.hdchina.net')->connectTimeout(60)->retry(3, 5000)->get($page_link)->getBody()->getContents();

        preg_match_all('/◎标　　题　(.*?)(<br(.*?)\/>|<\/div>)/',$content,$title);
        $title = trim($title[1][0]??'');
        $title = mb_substr($title,0,250);

        preg_match_all('/◎译　　名　(.*?)(<br(.*?)\/>|<\/div>)/',$content,$trans_name);
        $trans_name = trim($trans_name[1][0]??'');
        $trans_name = mb_substr($trans_name,0,250);

        preg_match_all('/◎片　　名　(.*?)(<br(.*?)\/>|<\/div>)/',$content,$name);
        $name = trim($name[1][0]??'');
        $name = mb_substr($name,0,250);

        preg_match_all('/◎年　　代　(.*?)(<br(.*?)\/>|<\/div>|<\/font>)/',$content,$age);
        $age = trim($age[1][0]??'');
        $age = mb_substr($age,0,50);

        preg_match_all('/◎产　　地　(.*?)(<br(.*?)\/>|<\/div>)/',$content,$address);
        $address = trim($address[1][0]??'');
        $address = mb_substr($address,0,250);

        preg_match_all('/◎类　　别　(.*?)(<br(.*?)\/>|<\/div>)/',$content,$type);
        $type = trim($type[1][0]??'');
        $type = mb_substr($type,0,250);

        preg_match_all('/◎语　　言　(.*?)(<br(.*?)\/>|<\/div>)/',$content,$language);
        $language = trim($language[1][0]??'');
        $language = mb_substr($language,0,250);

        preg_match_all('/◎上映日期　(.*?)(<br(.*?)\/>|<\/div>)/',$content,$play_time);
        $play_time = trim($play_time[1][0]??'');
        $play_time = mb_substr($play_time,0,100);

        preg_match_all('/◎IMDb评分(.*?)\/10(.*?)(<br(.*?)\/>|<\/div>)/',$content,$imdb_point);
        $imdb_point = trim(html_entity_decode($imdb_point[1][0]??0));
        $imdb_point = $imdb_point?:0;
        $imdb_point = filter_var($imdb_point,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
        $imdb_point = $imdb_point ? $imdb_point : 0;
        $imdb_point = floatval($imdb_point);

        preg_match_all('/◎IMDb链接(.*?)(<br(.*?)\/>|<\/div>)/',$content,$imdb_link);
        $imdb_link = trim(html_entity_decode($imdb_link[1][0]??''));
        $imdb_link = filter_var($imdb_link,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
        $imdb_link = mb_substr($imdb_link,0,250);

        preg_match_all('/◎豆瓣评分　(.*?)\/10(.*?)(<br(.*?)\/>|<\/div>)/',$content,$douban_point);
        $douban_point = trim(html_entity_decode($douban_point[1][0]??0));
        $douban_point = $douban_point?:0;
        $douban_point = floatval($douban_point);

        preg_match_all('/◎豆瓣链接　(.*?)(<br(.*?)\/>|<\/div>)/',$content,$douban_link);
        $douban_link = trim(html_entity_decode($douban_link[1][0]??''));
        $douban_link = mb_substr($douban_link,0,250);

        preg_match_all('/◎片　　长(.*?)(<br(.*?)\/>|<\/div>)/',$content,$during);
        $during = trim($during[1][0]??'');
        $during = mb_substr($during,0,250);

        preg_match_all('/<a href="forum.php\?mod=attachment(.*?)" target="_blank">(.*?)<\/a>/',$content,$download_link);
        $download_link = 'https://www.hdchina.net/forum.php?mod=attachment'.html_entity_decode($download_link[1][0]??'');

//        echo "匹配结束，开始入库：".PHP_EOL;
        Hdchina4K::firstOrCreate([
            'video_id' => $video_id,
        ],[
            'page_link' => $page_link,
            'page_name' => $page_name,
            'video_id' => $video_id,
            'title' => $title,
            'trans_name' => $trans_name,
            'name' => $name,
            'age' => $age,
            'address' => $address,
            'type' => $type,
            'language' => $language,
            'play_time' => $play_time,
            'imdb_point' => $imdb_point,
            'imdb_link' => $imdb_link,
            'douban_point' => $douban_point,
            'douban_link' => $douban_link,
            'during' => $during,
            'download_link' => $download_link,
        ]);

        echo '网页名称: '.$page_name.' 网页链接：'.$page_link.PHP_EOL;
//        if($point >= 8){
//            preg_match_all('/<a href="forum.php\?mod=attachment(.*?)" target="_blank">(.*?)<\/a>/',$content,$linkArr);
//            $info =  '名称: '.$title.' 评分：'.trim($pointArr[1][0]??0).' 链接:'.'https://www.hdchina.net/forum.php?mod=attachment'.html_entity_decode($linkArr[1][0]).' 网页说明:'.$url.PHP_EOL;
//            echo $info;
//        }
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $c1 = explode(';',$this->cc);
        $cookies = [];
        foreach ($c1 as $c2){
            $c3 = explode('=',$c2);
            $cookies[trim($c3[0])] = $c3[1];
        }
        $this->cookies = $cookies;

        $page = 0;
        $type = '1080';//1080 bluray 4k
        do{
            $page++;
            $pageNum = $this->getListByPage($type,$page);
        }while($page<$pageNum);
    }
}
