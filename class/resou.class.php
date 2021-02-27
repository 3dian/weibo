<?php
class resou {
    public $host = 'https://api.weibo.cn/2/guest/page?skin=default&c=iphone&lang=zh_CN&did=28702ff365175bb6ec73bdae54e983b6&sflag=1&s=05255a73&ua=iPhone12,3__weibo__10.3.2__iphone__os13.3.1&aid=01A60TsNDLJjHThSBRYl3stFkRvAJVswLxyxIuyR3_42GI-kI.&wm=3333_2001&sensors_device_id=56ADFCCB-9F4A-4E98-84DE-11029AF0EAAA&sensors_is_first_day=false&v_f=1&sensors_mark=0&ft=1&uid=1014452611945&v_p=82&gsid=_2AkMqh0bzf8NhqwJRmfwRyWnkbYx-zg3EieKc27coJRM3HRl-wT9jql0_tRV6AQdoHM8DSWqdK4Z63hMK72vKbWKfXkxW&from=10A3293010&networktype=wifi&checktoken=da33e09bb260669c0c46ac5ae1f841ad&b=0&page_interrupt_enable=0&extparam=pos%253D0_0%2526mi_cid%253D100103%2526cate%253D10103%2526filter_type%253Drealtimehot%2526c_type%253D30%2526display_time%253D1585013533&orifid=231619&count=20&luicode=10000512&containerid=106003type%3D25%26t%3D3%26disable_hot%3D1%26filter_type%3Drealtimehot&featurecode=10000512&uicode=10000011&fid=106003type%3D25%26t%3D3%26disable_hot%3D1%26filter_type%3Drealtimehot&st_bottom_bar_new_style_enable=0&need_new_pop=1&page=1&client_key=4654bde8da914bb619fd60a5c1e8cc5d&lfid=231619&moduleID=pagecard&oriuicode=10000512&launchid=10000365--x';
    
    public function __construct() {
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            require_once('/Applications/phpstudy/WWW/weibo/MySql.php');
        } else {
            require_once('/www/wwwroot/'.$_SERVER['SERVER_NAME'].'/MySql.php');
        }
        
        $this->conn = new mysqli($servername, $username, $password, $dbname);
    }
    
    public function mactchResou($kw, $server) {
        if ($kw) {
            if ($this->getResou()['code'] == 200) {
                $kw_arr = explode(',', $kw);
                for ($i = 0; $i < count($kw_arr); $i++) {
                    $sql = "select `desc`, updateTime from weibo_resou where server = '$server'";
                    $results = $this->conn->query($sql);
                    while($row = $results->fetch_assoc()) {
                        $pushed[date('Ymd', strtotime($row['updateTime']))][] = $row['desc'];
                    }
                }
                $total = 0;
                $resou = $this->getResou()['data'];
                $today = $pushed[date('Ymd')] ? $pushed[date('Ymd')] : [];
                
                for ($i = 0; $i < count($resou); $i++) {
                    $desc = $resou[$i]['desc'];
                    $scheme = $resou[$i]['scheme'];
                    $pic = $resou[$i]['pic'];
                    preg_match('/(?<=search_).+(?=.png)/', $pic, $no);
                    for ($j = 0; $j < count($kw_arr); $j++) {
                        if (strstr($desc, $kw_arr[$j]) && !in_array($desc, $today)) {
                            $sql = "insert into weibo_resou set server = '$server', kw = '$kw_arr[$j]', `desc` = '$desc'";
                            $this->conn->query($sql);
                            $total = $total + 1;
                            $result[$kw_arr[$j]][] = array(
                                'no' => $no[0],
                                'desc' => $desc,
                                'scheme' => $scheme,
                                'pic' => $pic
                            );
                        }
                    }
                }
                $res = array(
                    'code' => 200,
                    'data' => array(
                        'total' => $total,
                        'result' => $result
                    ),
                    'msg' => '匹配热搜成功'
                );
            } else {
                $res = $this->getResou();
            }
        } else {
            $res = array(
                'code' => 201,
                'msg' => '缺少kw参数'
            );
        }
        return $res;
    }
    
    // 获取热搜
    private function getResou(){
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            require_once('/Applications/phpstudy/WWW/weibo/curl.php');
        } else {
            require_once('/www/wwwroot/'.$_SERVER['SERVER_NAME'].'/curl.php');
        }
        $resou_info = json_decode(get_url($this->host), true);
        $resou = $resou_info['cards'][0]['card_group'];
        if (is_array($resou)) {
            $res = array(
                'code' => 200,
                'data' => array_slice($resou, 1),
                'msg' => '获取热搜成功'
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