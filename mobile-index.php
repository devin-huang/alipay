<?php
/**
 * @Author: anchen
 * @Date:   2017-05-26 14:38:36
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-05-26 20:12:14
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
$buyID='MD'.str_pad($date,20,get_code(6),STR_PAD_RIGHT);
//(end)

//定义参数
$arrBody      =  array('1.手机','2.衣服','3.家电');
$body         =  implode(";", $arrBody);
$subject      =  '大乐透';
$total_amount =  '9.00';

//移动端网站支付方法;
//(start)
$request = new AlipayTradeWapPayRequest ();
$request->setReturnUrl('https://www.partsam.com/return_url.php');  //必须是线上服务端URL
$request->setNotifyUrl('https://www.partsam.com/notify_url.php');  //必须是线上服务端URL
$request->setBizContent("{" .
"    \"body\":\"". $body ."\"," .
"    \"subject\":\"". $subject ."\"," .
"    \"out_trade_no\":\"". $buyID ."\"," .
"    \"timeout_express\":\"90m\"," .
"    \"total_amount\":". $total_amount ."," .
"    \"product_code\":\"QUICK_WAP_PAY\"" .
"  }");

$result = $aop->pageExecute ($request); 
echo $result;
//(end)