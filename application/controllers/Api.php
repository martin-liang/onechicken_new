<?php
/**
 * Created by PhpStorm.
 * User: hemuhan
 * Date: 17/1/16
 * Time: 上午10:48
 * @property $user_model user_model
 */


class Api extends MY_Controller {

    private $_message = "获取信息成功";
    public function __construct()
    {
        parent::__construct();
        $this->load->model("user_model");
    }

    /**
     * 获取用户信息
     */
    public function info(){
        try{
            $userinfo = $this->user_model->userinfo($this->get_userid());

            $this->send_data(true,$userinfo,$this->_message);
        }catch (Exception $e){
            $this->send_data(false,null,$e->getMessage());
        }

    }

    /**
     * 获取最新的提示消息
     */
    public function messages(){
        $userid = $this->get_userid();
        try{
            $this->send_data(true,$this->user_model->getmessage($userid),null);
        }catch(Exception $e){
            $this->send_data(false,null,$e->getMessage());
        }
    }

    /**
     * 拾取鸡蛋
     */
    public function pickup_eggs(){
        $user_id =  $this->get_userid();
        $soil_id =  isset($_POST['soil_id']) ? $_POST['soil_id']: false;
        $chicken_id = isset($_POST['chicken_id']) ? $_POST['chicken_id'] : false;
        if(!$soil_id){
            $this->send_data(false,null,'参数错误,没有传递土地的ID');
            die;
        }
        if(!$chicken_id){
            $this->send_data(false,null,'参数错误,没有传递鸡的ID');
            die;
        }
        try{
            $pickup_nums = $this->user_model->pickup_eggs($user_id,$soil_id,$chicken_id);
            $this->send_data(true,$pickup_nums,null);
        }catch (Exception $e){
            $this->send_data(false,null,$e->getMessage());
        }
    }

    /**
     * 蛋兑换成鸡
     */
    public function egg2chicken(){
        $user_id = $this->get_userid();
        try{
            $soil_id = $this->user_model->egg2chicken($user_id);
            $this->send_data(true,$soil_id);
        }catch (Exception $e){
            $this->send_data(false,null,$e->getMessage());
        }
    }

    /**
     * 开地
     */

    public function enable_soil(){
        $user_id = $this->get_userid();
        $soil_id = isset($_POST['soil_id']) ? $_POST['soil_id'] : false;
        try{
            $soil_id = $this->user_model->enable_soil($user_id,$soil_id);
            $this->send_data(true,$soil_id);
        }catch (Exception $e){
            $this->send_data(false,null,$e->getMessage());
        }
    }

    public function pay(){
        $this->load->model('topup_model');
        $this->load->model('token_model');
        $this->load->library("pay");
        /*金额*/
        $money = $_REQUEST['money']?$_REQUEST['money']:'0.02';
        /*订单号*/
        $data['order_num'] = $order= 'Mer' . date('Ymdhis').rand(1,99999);
        /*微信用户id*/
        $data['wu_id'] = $wu_id = $_REQUEST['userid'];
        $data['create_time'] = time();
        
        /*用户地址*/
        $memLink = "http://www.sqweichao.com/wechat/game#qian=".$money;
        /*服务器通知地址*/
        $serLink = "http://www.sqweichao.com/api/payCall";
        

        /*写入支付记录*/
        $this->db->insert('top_up',$data);

        $this->pay->pays($memLink,$serLink,$money,$order);
    }

    public function payCall()
    {

        /*记录充值log*/
        $paymentResult['log'] = $_REQUEST['paymentResult'];

        $this->load->model('topup_model');
        $this->topup_model->addLog('log',$paymentResult);
        //todo:反写换鸡蛋
        $data = $this->_addTopUp();
        $this->load->model('token_model');
        if($data && $data['message'])
        {
            $this->load->model('topup_model');

//            $data['money']=1;
//            $data['order_num']=1;
            /*反写*/
            $sq = "select * from top_up WHERE `ips_num` = "."'".$data['ips_num']."'";
            $sqInfo = $this->topup_model->querySql($sq);
            $sqInfo = $sqInfo[0];
            if($sqInfo)
                return;

            $sql1 = "select * from top_up WHERE order_num = "."'".$data['order_num']."'";
            $orderInfo = $this->topup_model->querySql($sql1);
            $orderInfo = $orderInfo[0];
            $info = $this->topup_model->writeMoney($data['money'],$data['order_num'],$data['ips_num']);
            if($info){
                $money = $data['money'];
                $sql = "update chicken_wechat_user set top_up = top_up+$money WHERE id = ".$orderInfo['wu_id'];
                $sql2 = "update user_addition set total_eggs = total_eggs+$money WHERE id = ".$orderInfo['wu_id'];
                $this->topup_model->addExtract($sql);
                $this->topup_model->addExtract($sql2);
            }
        }
    }

    private function verifyReturn(){
        try {
            if(empty($_REQUEST)) {
                return false;
            }
            else {
                $paymentResult = $_REQUEST['paymentResult'];
                $xmlResult = new SimpleXMLElement($paymentResult);
                $rspCode = $xmlResult->WxPayRsp->head->RspCode;
                if($rspCode == "000000")
                {
                    return true;
                }

            }
        } catch (Exception $e) {

        }
        return false;
    }

    public function subStrXml($begin,$end,$str)
    {
        $b= (strpos($str,$begin));
        $c= (strpos($str,$end));

        return substr($str,$b,$c-$b + 7);

    }
    public function md5Verify($prestr, $sign,$merCode, $key)
    {
        $prestr = $prestr .$merCode. $key;
        $mysgin = md5($prestr);

        if($mysgin == $sign) {
            return true;
        }
        else {
            return false;
        }
    }

    private function _addTopUp()
    {
        $verify_result = $this->verifyReturn();
        if ($verify_result) { // 验证成功
            $paymentResult = $_REQUEST['paymentResult'];
            $data = $this->xml_to_array($paymentResult);
            $return =  $data['WxPayRsp']['body'];
            $return['message'] = $data['WxPayRsp']['head']['RspCode'];
            $return['order_num'] = $return['MerBillno'];
            $return['money'] = $return['OrdAmt'];
            $return['ips_num'] = $return['IpsBillNo'];

            return $return;

        }
    }

    function xml_to_array($xml)
    {
        $array = (array)(simplexml_load_string($xml));
        foreach ($array as $key=>$item){
            $array[$key]  =  $this->struct_to_array((array)$item);
        }
        return $array;
    }
    function struct_to_array($item) {
        if(!is_string($item)) {
            $item = (array)$item;
            foreach ($item as $key=>$val){
                $item[$key]  =  $this->struct_to_array($val);
            }
        }
        return $item;
    }
    /**
     * 微信分享接口 所需access_token && signature
     */
    public function share()
    {
        $this->load->model('token_model');
//        $this->token_model->getWeChatSignature();
        //$data = $this->token_model->setToken();
        $this->send_data(true,[],$this->_message);
        /*getWeChatSignature*/
    }



    public function tixian()
    {
        /*银行卡号brank_num 姓名name 提现金额money wu_id create_time*/
        $this->load->model('topup_model');
        $name = "'".$_POST['name']."'";
        $brank_num = $_POST['brank_num'];
        $money = $_POST['money'];
        $wu_id = $_POST['userid'];
        $phone = $_POST['phone'];


        if($wu_id) {
            $totalEggs = $this->db->query('select * from user_addition WHERE user_id = ?', $_POST['userid'])->row_array();
            if($totalEggs['total_eggs'] < $money)
                $this->send_data(false,[],'失败');
        }
        
        $create_time = time();
        $sql = " INSERT INTO extract (`name`,`brank_num`,`money`,`wu_id`,`create_time`,`phone`) VALUES ( $name,$brank_num,$money,$wu_id,$create_time,$phone)";
        $info = $this->topup_model->addExtract($sql);
        $sql1 = "update user_addition set total_eggs = total_eggs-".$money." where user_id = ".$wu_id;
        $this->topup_model->addExtract($sql1);
        if($info)
            $this->send_data(true);

        $this->send_data(false,[],'失败');
    }

    /**
     * 每天0.00运行的任务
     */
    public function dayjob(){
	ignore_user_abort(true);
        set_time_limit(0);
        $this->user_model->product_eggs();
    }



    public function user()
    {
        $this->load->model('token_model');
        $arr = [
            'a'=>1,
            'b'=>12,
            'c'=>13,
            'd'=>14,
        ];
        var_dump($_REQUEST);die;
        $a = $this->token_model->getToken();
        var_dump($a);die;
        $a = $this->token_model->getWeChatSignature();
        var_dump($a);
    }

}