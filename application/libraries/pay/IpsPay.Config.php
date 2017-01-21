<?php
$ipspay_config['Version']	 = 'v1.0.0';
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

?>