 
<?php
require_once("IpsPay.Config.php");
require_once("lib/IpsPaySubmit.class.php");

/**
 * ************************请求参数*************************
 * $ipspay_config['Version']	 = 'v1.0.0';
//商戶號
$ipspay_config['MerCode']	 = '191942';
//交易賬戶號
$ipspay_config['Account']	 = '1919420016';
//商戶證書
$ipspay_config['MerCert']	 = 'jwGnnpqNyjH9ZARc1Yf5JQajo1NEqjT5AXuC5qkH776nfM60VGFTbPhhPAcnPATJq40rdjLYjmvymys9BpM45N3aLMjQjZJdwdBfcO9PThnwv65JnamdmC4ptExbO77Y';
//請求地址
$ipspay_config['PostUrl']	 = 'https://thumbpay.e-years.com/psfp-webscan/onlinePay.do';
//服务器S2S通知页面路径
$ipspay_config['S2Snotify_url'] = "http://h5.91marryu.com:8086/wechat/pay/wxonline-result.php";
//页面跳转同步通知页面路径
$ipspay_config['return_url'] = "http://h5.91marryu.com:8086/wechat/pay/wxonline-result-show.php";

$ipspay_config['MsgId'] = "";
 */
//  var_dump($_POST);
// 商户号
$MerCode = '191942';
//商户名称
$MerName = '京松商贸';
//商户账户号
$Account = '1919420016';
//商户订单号
$MerBillno = 'Mer'.date('ymdhis');
//订单金额金额
$OrdAmt = '0.02';
//订单时间
$OrdTime = date('Y-m-d H:i:s');
//商品名称
$GoodsName = '京松商贸';
//商品数量
$GoodsCount = 1;
//支付币种
$CurrencyType = 156;
//商户返回地址
$MerchantUrl = $_REQUEST['MerchantUrl'];
//商户S2S返回地址
$ServerUrl = $_REQUEST['ServerUrl'];
//超时时间
$BillExp = date('Y-m-d H:i:s',strtotime('+1 hour'));
//收货人地址
$ReachAddress = ' ';
//买家留言
$Attach = '金蛋';
//订单签名方式(156 md5)
$RetEncodeType = 156;
//收货人姓名
$ReachBy= '微信用户';

/************************************************************/

//构造要请求的参数数组
$parameter = array(
    "MerCode"	=> $MerCode,
    "MerName"	=> $MerName,
    "Account"	=> $Account,
    "MerBillno"	=> $MerBillno,
    "OrdAmt"   => $OrdAmt,
    "OrdTime"	=> $OrdTime,
    "ReqDate"	=> date("YmdHis"),
    "GoodsName"	=> $GoodsName,
    "GoodsCount"	=> $GoodsCount,
    "CurrencyType"	=> $CurrencyType,
    "MerchantUrl"	=> $MerchantUrl,
    "ServerUrl"	=> $ServerUrl,
    "BillExp"	=> $BillExp,
    "ReachAddress"	=> $ReachAddress,
    "RetEncodeType"	=> $RetEncodeType,
    "ReachBy"	=> $ReachBy,
    "Attach"	=> $Attach

);

// //建立请求
$ipspaySubmit = new IpsPaySubmit($ipspay_config);
$html_text = $ipspaySubmit->buildRequestForm($parameter);
echo $html_text;

?>
 