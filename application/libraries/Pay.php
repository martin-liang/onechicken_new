<?php
/**
 * Created by PhpStorm.
 * User: hemuhan
 * Date: 17/1/17
 * Time: 下午4:52
 */

class Pay
{
    public function pays($MerchantUrl,$ServerUrl,$OrdAmt = '0.02',$orderNum)
    {
        require_once __DIR__ . '/pay/IpsPay.Config.php';
        require_once __DIR__ . '/pay/lib/IpsPaySubmit.class.php';

// 商户号
        $MerCode = '191942';
//商户名称
        $MerName = '京松商贸';
//商户账户号
        $Account = '1919420016';
//商户订单号
        if($orderNum)
            $MerBillno = $orderNum;
        else
        $MerBillno = 'Mer' . date('ymdhis').rand(1,99999);

//订单金额金额
        $OrdAmt = $OrdAmt;
//订单时间
        $OrdTime = date('Y-m-d H:i:s');
//商品名称
        $GoodsName = '京松商贸';
//商品数量
        $GoodsCount = 1;
//支付币种
        $CurrencyType = 156;
//商户返回地址
//        $MerchantUrl = 'http://www.a.com';//$_REQUEST['MerchantUrl'];
//商户S2S返回地址
//        $ServerUrl = 'http://www.3.com';// $_REQUEST['ServerUrl'];
//超时时间
        $BillExp = date('Y-m-d H:i:s', strtotime('+1 hour'));
//收货人地址
        $ReachAddress = '瞬时发货';
//买家留言
        $Attach = '瞬时发货';
//订单签名方式(156 md5)
        $RetEncodeType = 156;
//收货人姓名
        $ReachBy = '充值人员';

        /************************************************************/

//构造要请求的参数数组
        $parameter = array(
            "MerCode" => $MerCode,
            "MerName" => $MerName,
            "Account" => $Account,
            "MerBillno" => $MerBillno,
            "OrdAmt" => $OrdAmt,
            "OrdTime" => $OrdTime,
            "ReqDate" => date("YmdHis"),
            "GoodsName" => $GoodsName,
            "GoodsCount" => $GoodsCount,
            "CurrencyType" => $CurrencyType,
            "MerchantUrl" => $MerchantUrl,
            "ServerUrl" => $ServerUrl,
            "BillExp" => $BillExp,
            "ReachAddress" => $ReachAddress,
            "RetEncodeType" => $RetEncodeType,
            "ReachBy" => $ReachBy,
            "Attach" => $Attach

        );

// //建立请求
        $ipspaySubmit = new IpsPaySubmit($ipspay_config);
        $html_text = $ipspaySubmit->buildRequestForm($parameter);
        die("<html><body>".$html_text ."<script>document.forms['ipspaysubmit'].submit()</script>");
    }
}