<?php
class Ta {
    public $conn;
    
    public function __construct() {
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            require_once('/Applications/phpstudy/WWW/weibo/MySql.php');
        } else {
            require_once('/www/wwwroot/'.$_SERVER['SERVER_NAME'].'/MySql.php');
        }
        
        $this->conn = new mysqli($servername, $username, $password, $dbname);
    }
    
    public function get_ta_info($wb) {
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            require_once('/Applications/phpstudy/WWW/weibo/curl.php');
        } else {
            require_once('/www/wwwroot/'.$_SERVER['SERVER_NAME'].'/curl.php');
        }
        preg_match('/[a-zA-z]+:\/\/[^\s]*/', $wb, $url);
        if (preg_match('/weibo.com/', $url[0]) == 1) {
            preg_match('/[0-9]+/', $wb, $uid);
            if ($uid) {
                $user_info = json_decode(get_url('https://api.weibo.cn/2/users/show?uid='.$uid[0]), true);
                $uid = $user_info['id']; // uid
                $name = $user_info['name']; // 名字
                $location = $user_info['location']; // 地点
                $description = $user_info['description']; // 描述
                $avatar = $user_info['avatar_hd']; // 描述
                $gender = $user_info['gender']; // 性别
                $followers_count = $user_info['followers_count']; // 粉丝数
                $friends_count = $user_info['friends_count']; // 关注数
                $statuses_count = $user_info['statuses_count']; // 微博数
                $created_at = $user_info['created_at']; // 注册时间
                $vid = $user_info['status']['id']; // 微博ID
                
                $description_encode = $this->emoji_encode($description);
                $created_at = date("Y-m-d H:i:s", strtotime($created_at));
                $gender = $gender == '男' ? 1 : 2;
                
                $sql = "select followers_count, friends_count, statuses_count, vid from weibo_ta where uid = '$uid'";
                $result = $this->conn->query($sql);
                
                if ($result->num_rows == 1) {
                    $res = $result->fetch_assoc();
                    $followers = $followers_count - $res['followers_count'];
                    $friends = $friends_count - $res['friends_count'];
                    $statuses = $statuses_count - $res['statuses_count'];
                    $is_vid = $vid == $res['vid'] ? false : true;
        
                    $sql = "update weibo_ta set name = '$name', location = '$location', description = '$description_encode', avatar = '$avatar', gender = $gender, followers_count = $followers_count, friends_count = $friends_count, statuses_count = $statuses_count, created_at = '$created_at', vid = '$vid' where uid = $uid";
                    $result = $this->conn->query($sql);
                    $res_followers = $followers == 0 ? null : $name.($followers > 0 ? '新增了' : '掉了').abs($followers).'个粉丝';
                    $res_friends = $friends == 0 ? null : $name.($friends > 0 ? '新关注了' : '取消关注了').abs($friends).'个人';
                    $res_statuses = $statuses == 0 ? null : $name.($statuses > 0 ? '新发布了' : '删除了').abs($statuses).'条微博';
                    $res_vid = $is_vid ? $vid : null;
                    
                    $res = array(
                        'code' => 200,
                        'data' => array(
                            'uid' => $uid,
                            'name' => $name,
                            'location' => $location,
                            'description' => $description,
                            'avatar' => $avatar,
                            'gender' => $gender,
                            'count' => array(
                                'followers_count' => $followers_count,
                                'friends_count' => $friends_count,
                                'statuses_count' => $statuses_count
                            ),
                            'created_at' => $created_at,
                            'change' => array(
                                'followers' => $res_followers,
                                'friends' => $res_friends,
                                'statuses' => $res_statuses,
                                'vid' => $res_vid
                            )
                        ),
                        'msg' => '查询成功'
                    );
                    
                } else {
                    $sql = "insert into weibo_ta set uid = '$uid', name = '$name', location = '$location', description = '$description_encode', avatar = '$avatar', gender = $gender, followers_count = $followers_count, friends_count = $friends_count, statuses_count = $statuses_count, created_at = '$created_at', vid = '$vid'";
                    $this->conn->query($sql);
                    $res = array(
                        'code' => 200,
                        'data' => array(
                            'uid' => $uid,
                            'name' => $name,
                            'location' => $location,
                            'description' => $description,
                            'avatar' => $avatar,
                            'gender' => $gender,
                            'count' => array(
                                'followers_count' => $followers_count,
                                'friends_count' => $friends_count,
                                'statuses_count' => $statuses_count
                            ),
                            'created_at' => $created_at
                        ),
                        'msg' => '关注成功'
                    );
                }
            } else {
                $res = array(
                    'code' => 201,
                    'msg' => '请输入正确的微博作者主页链接'
                );
            }
        } else {
            $res = array(
                'code' => 201,
                'msg' => '缺少wb参数'
            );
        }
        return $res;
    }
    
    //对emoji表情转义
    private function emoji_encode($str){
        $strEncode = '';
     
        $length = mb_strlen($str,'utf-8');
     
        for ($i=0; $i < $length; $i++) {
            $_tmpStr = mb_substr($str,$i,1,'utf-8');    
            if(strlen($_tmpStr) >= 4){
                $strEncode .= '[[EMOJI:'.rawurlencode($_tmpStr).']]';
            }else{
                $strEncode .= $_tmpStr;
            }
        }
     
        return $strEncode;
    }
    
    //对emoji表情转反义
    private function emoji_decode($str){
        $strDecode = preg_replace_callback('|\[\[EMOJI:(.*?)\]\]|', function($matches){  
            return rawurldecode($matches[1]);
        }, $str);
     
        return $strDecode;
    }
}
?>