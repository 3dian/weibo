<?php
header('Content-type:application/json');
require_once('./class/chaohua.class.php');

$server = $_GET['server'];
$containerid = $_GET['containerid'];
$gsid = $_GET['gsid'];
$s = $_GET['s'];
$from = $_GET['from'];

$chaohua = new Chaohua($containerid, $gsid, $s, $from);
$res = $chaohua->sign_in();
if ($server && $res['code'] != 200) {
    get_url($server.'微博超话批量签到/'.$res['msg']);
}
echo json_encode($res);
?>