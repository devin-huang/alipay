<?php
/**
 * @Author: Devin
 * @Date:   2017-05-19 14:42:37
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-05-26 20:15:02
 */
require_once("AopSdk.php");
require_once("config.php");

//使用当前时间 + 6位随机数生成唯一购物订单ID
//(start)
function get_code($len){
    $CHAR_ARR = array('1','2','3','4','5','6','7','8','9','0');
    $CHAR_ARR_LEN = count($CHAR_ARR) - 1;
    $code = '';
    while(--$len > 0){ $code .= $CHAR_ARR[rand(0,$CHAR_ARR_LEN)]; }
    return $code;
}

$date = date('YmdHis');
$buyID=str_pad($date,19,get_code(6),STR_PAD_RIGHT);
//(end)

//定义参数
$subject      = 'Iphone6 16G';
$total_amount = '88.88';
$body         = 'Iphone6 16G';

//电脑端支付方法;
//(start)
$request = new AlipayTradePagePayRequest ();
$request->setReturnUrl('https://www.partsam.com/test/return_url.php');
$request->setNotifyUrl('https://www.partsam.com/test/notify_url.php');
$request->setBizContent('{"product_code":"FAST_INSTANT_TRADE_PAY","out_trade_no":'.$buyID.',"subject":"'. $subject .'","total_amount":"'. $total_amount .'","body":"'. $body  .'"}');
 
//请求
$result = $aop->pageExecute ($request); 
 
//输出
echo $result;
//(end)

?>

