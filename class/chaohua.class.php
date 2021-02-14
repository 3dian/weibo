<?php
class chaohua {
    public $host = 'https://api.weibo.cn';
    public $c = 'iphone';
    public $containerid;
    public $gsid;
    public $s;
    public $from;
    
    public function __construct($containerid, $gsid, $s, $from) {
        $this->containerid = $containerid;
        $this->gsid = $gsid;
        $this->s = $s;
        $this->from = $from;
    }
    
    public function sign_in() {
        if ($this->get_chaohua()['code'] == 200) {
            $chaohua = $this->get_chaohua()['data'];
            for ($i = 0; $i < count($chaohua); $i++) {
                $title = $chaohua[$i]['title_sub'];
                preg_match('/(?<=containerid=)[A-Za-z0-9]+/', $chaohua[$i]['scheme'], $pageid);
                $request_url = 'http://i.huati.weibo.com/mobile/super/active_checkin?pageid='.$pageid[0];
                $sign_info = json_decode(get_url($this->host.'/2/page/button?c='.$this->c.'&request_url='.$request_url.'&gsid='.$this->gsid.'&s='.$this->s.'&from='.$this->from), true);
                if ($sign_info['result'] == 402004 && $scheme == null) {
                    $msg = $sign_info['msg'];
                    $scheme = $sign_info['scheme'];
                    break;
                } else {
                    $result[] = $title.'：'.$sign_info['msg'];
                }
            }
            $res = $scheme ? array(
                'code' => 200,
                'msg' => $msg,
                'scheme' => $scheme
            ) : array(
                'code' => 200,
                'data' => $result,
                'msg' => '批量签到完成'
            );
        } else {
            $res = $this->get_chaohua();
        }
        return $res;
    }
    
    // 获取关注的超话
    private function get_chaohua(){
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            require_once('/Applications/phpstudy/WWW/weibo/curl.php');
        } else {
            require_once('/www/wwwroot/'.$_SERVER['SERVER_NAME'].'/curl.php');
        }
        $chaohua_info = json_decode(get_url($this->host.'/2/cardlist?c='.$this->c.'&containerid='.$this->containerid.'&gsid='.$this->gsid.'&s='.$this->s.'&from='.$this->from), true);
        $chaohua = $chaohua_info['cards'][0]['card_group'];
        if (is_array($chaohua)) {
            $res = array(
                'code' => 200,
                'data' => array_slice($chaohua, 1, -1),
                'msg' => '获取超话成功'
            );
        } else {
            $res = array(
                'code' => 202,
                'msg' => '查询接口错误，请及时处理'
            );
        }
        return $res;
    }
}
?>