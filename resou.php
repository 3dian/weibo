<?php
header('Content-type:application/json');
require_once('./class/resou.class.php');

$server = $_GET['server'];
$kw = $_GET['kw'];

$resou = new Resou();
$res = $resou->mactchResou($kw, $server);

if ($server && $res['data']['result'] != null) {
    $result = $res['data']['result'];
    $kw_match = array_keys($result);
    for ($i = 0; $i < count($kw_match); $i++) {
        $resou = $result[$kw_match[$i]];
        for ($j = 0; $j < count($resou); $j++) {
            $desc[] = $resou[$j]['no'].'：'.$resou[$j]['desc'];
        }
    }
    
    $keys = implode('、', $kw_match);
    $values = implode('；', $desc);
    get_url($server.'你关注的 '.$keys.' 有了新的热搜/'.$values.'?url=sinaweibo://discover');
}

echo json_encode($res);
?>