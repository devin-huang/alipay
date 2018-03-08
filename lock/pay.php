<?php
/**
 * @Author: anchen
 * @Date:   2017-05-22 09:55:08
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-05-22 14:07:16
 */
function get_code($len){

    $CHAR_ARR = array('1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','X','Y','Z','W','S','R','T');
    $CHAR_ARR_LEN = count($CHAR_ARR) - 1;
    $code = '';
    while(--$len > 0){ $code .= $CHAR_ARR[rand(0,$CHAR_ARR_LEN)]; }
    return $code;

}

$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='jootop';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='huang12345';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";

$pdo = new PDO($dsn, $user, $pass);
$fp = fopen('lock.txt','r');
//通过排他锁 锁定该过程
if(flock($fp,LOCK_EX)){

    //查询当前时间已发放验证码数量
    $code_num_rs = $pdo->query("SELECT COUNT(*) as sum FROM text");
    $code_num_arr = $code_num_rs->fetch(PDO::FETCH_ASSOC);
    $code_num = $code_num_arr['sum'];
    if($code_num < 1){
    sleep(2);
    $code = get_code(6);
    $pdo->query("INSERT INTO text (name,time) VALUES ('$code',".time().")");
    }
    flock($fp,LOCK_UN);
    fclose($fp);

}
