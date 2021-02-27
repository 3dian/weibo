<?php
header('Content-type:application/json');
require_once('./class/ta.class.php');

$wb = $_GET['wb'];
$server = $_GET['server'];
$fs = $_GET['fs'];
$gz = $_GET['gz'];
$zp = $_GET['zp'];
$new = $_GET['new'];

$ta = new Ta();
$res = $ta->getTaInfo($wb);
if ($server) {
    $server = substr($server, -1) == '/' ? $server : $server.'/';
    $uid = $res['data']['uid'];
    $name = $res['data']['name'];
    $description = $res['data']['description'];
    $change = $res['data']['change'];
    if ($change) {
        $followers = $change['followers'];
        $friends = $change['friends'];
        $statuses = $change['statuses'];
        $vid = $change['vid'];
        if ($followers && $fs != '0') {
            get_url($server.'你关注的微博用户有了新动态'.'/'.$followers.'?url=https://weibo.com/u/'.$uid);
            sleep(0.5);
        }
        if ($friends && $gz != '0') {
            get_url($server.'你关注的微博用户有了新动态'.'/'.$friends.'?url=https://weibo.com/u/'.$uid);
            sleep(0.5);
        }
        if ($statuses && $zp != '0') {
            get_url($server.'你关注的微博用户有了新动态'.'/'.$statuses.'?url=https://weibo.com/u/'.$uid);
            sleep(0.5);
        }
        if ($vid && $new != '0') {
            get_url($server.'你关注的微博用户有了新动态'.'/点击查看'.$name.'的最新一条微博'.'?url=https://m.weibo.cn/'.$uid.'/'.$vid);
            sleep(0.5);
        }
    } else {
        if ($description) {
            get_url($server.'关注微博用户 '.$name.' 成功/'.str_replace(PHP_EOL, ' ', $description).'?url=https://weibo.com/u/'.$uid);
        } else {
            get_url($server.'关注微博用户 '.$name.' 成功/'.$name.'未设置签名?url=https://weibo.com/u/'.$uid);
        }
    }
}
echo json_encode($res);
?>