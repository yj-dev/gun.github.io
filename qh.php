<?php
show_source(__FILE__);

$appId = 'wxdcaf112d8cbd8eb8'; //对应自己的appId
$appSecret = '85804fe0e8ae361be244df6f53594108'; //对应自己的appSecret
$wxgzhurl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appId . "&secret=" . $appSecret;
$access_token_Arr = https_request($wxgzhurl);
$access_token = json_decode($access_token_Arr, true);
$ACCESS_TOKEN = $access_token['access_token']; //ACCESS_TOKEN



$lovestart = strtotime('2021-01-01');
$end = time();
$love = ceil(($end - $lovestart) / 86400);


$birthdaystart = strtotime('2022-11-17');
$end = time();
$birthday = ceil(($end - $birthdaystart) / 86400);

$tianqiurl = 'https://www.yiketianqi.com/free/day?appid=69215429&appsecret=XFv2Y4rX&unescape=1&city=邵阳'; //修改为自己的
$tianqiapi = https_request($tianqiurl);
$tianqi = json_decode($tianqiapi, true);

$qinghuaqiurl = 'https://v2.alapi.cn/api/qinghua?token=LwExDtUWhF3rH5ib'; //修改为自己的
$qinghuaapi = https_request($qinghuaqiurl);
$qinghua = json_decode($qinghuaapi, true);


// 你自己的一句话
$yjh = ''; 

$touser = 'oqoML67cGBkVhspnKcQYwAGOtxCg';  
$data = array(
    'touser' => $touser,
    'template_id' => "tMG3f5oCi-1hA3pbH6GE2Gc_q-TQcNvu7XS74jCV0w8", //改成自己的模板id，在微信后台模板消息里查看
    'data' => array(
        'first' => array(
            'value' => "$yjh",
            'color' => "#000"
        ),
        'keyword1' => array(
            'value' => $tianqi['wea'],
            'color' => "#000"
        ),
        'keyword2' => array(
            'value' => $tianqi['tem_day'],
            'color' => "#000"
        ),
        'keyword3' => array(
            'value' => $love . '天',
            'color' => "#000"
        ),
        'keyword4' => array(
            'value' => $birthday . '天',
            'color' => "#000"
        ),
        'remark' => array(
            'value' => $qinghua['data']['content'],
            'color' => "#FF0000"
        ),
        'keyword5' => array(
            'value' => $tianqi['date'],
            'color' => "#000"
        ),
    )
);

// 下面这些就不需要动了————————————————————————————————————————————————————————————————————————————————————————————
$json_data = json_encode($data);
$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $ACCESS_TOKEN;
$res = https_request($url, urldecode($json_data));
$res = json_decode($res, true);

if ($res['errcode'] == 0 && $res['errcode'] == "ok") {
    echo "发送成功！";
}
function https_request($url, $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

