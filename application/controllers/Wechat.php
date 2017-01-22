<?php
/**
 * 微信授权页面
 *
 *
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/16
 * Time: 13:56
 */
class wechat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('token_model');
    }

    public function getCode()
    {
        session_start();
        if($_SESSION['user_id'])
        {
            header("Location:http://www.sqweichao.com/index.php/wechat/game?user_id=".$_SESSION['user_id']);
            exit;
        }

        $recommand_code = $_GET['recommand_code'];
        $userid = $_GET['userid'];
        $parent_id = 0;
        if($_GET['code'] && $_GET['state'] == '123')
        {
            if($_GET['recommand_code'])
                $recommand_code = $_GET['recommand_code'];

            if($recommand_code && $userid)
            {
                $ex = $this->db->query('select * from chicken_wechat_user where recommand_code = ?',[$recommand_code])->row_array();
                if($ex['id'] == $_GET['userid'])
                {
                    header("Location:http://www.sqweichao.com/wechat/game?user_id=".$_GET['userid']);
                    exit;
                }

            }

            $data = $this->token_model->getWeChatOpenId($_GET['code'],$recommand_code,$parent_id);
            if($_COOKIE['user_id'])
            {
                header("Location:http://www.sqweichao.com/index.php/wechat/game?user_id=" . $_COOKIE['user_id']);
                exit;
            }

            if($data) {
                $userinfo= $this->token_model->getWuId($data['wechat_id']);
                setcookie('user_id',$userinfo['id']);
                $_SESSION['user_id'] = $userinfo['id'];
                header("Location:http://www.sqweichao.com/index.php/wechat/game?user_id=".$userinfo['id']);
                exit;
            }
        }

        if($recommand_code && $userid)
        {
            $link = "http://www.sqweichao.com/index.php/wechat/getcode?recommand_code=$recommand_code&userid=$userid";
        }else{
            $link = "http://www.sqweichao.com/index.php/wechat/getcode";
        }
        $this->token_model->_getCode($link);
    }


   public function game()
    {
        if($_GET['user_id'])
            setcookie('user_id',$_GET['user_id']);

        if($_GET['user_id']){
            $userId = $_GET['user_id'];
        }elseif ($_COOKIE['user_id']){
            $userId = $_COOKIE['user_id'];
        }elseif ($_SESSION['user_id'])
        {
            $userId = $_SESSION['user_id'];
        }else{
            header("Location:http://www.sqweichao.com/index.php/wechat/getcode");
            exit;
        }
        $this->load->model('token_model');
        $this->load->model('topup_model');
        $wuinfo = $this->topup_model->querySql("select * from chicken_wechat_user WHERE id = ".$userId);


//        echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//
//        echo "<br>";
//
//        echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
//
//
//        die;
//        $this->token_model->getWeChatSignature();
//        $data = $this->token_model->getWeChatSignature('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
        $data = $this->token_model->getWeChatSignature('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
//        $data['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//        var_dump($data);die;
        $user = $wuinfo[0];
        unset($data['id']);
        unset($user['create_time']);
        $info = array_merge($user,$data);
        $info['link'] = "http://www.sqweichao.com/wechat/getcode?recommand_code=".$info['recommand_code']."&userid=".$userId;
        $info['appId'] = "wx193e672203c8c855";
        $this->load->view('chicken',$info);
    }


    public function test()
    {
        var_dump('http://' . $_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI']);
        var_dump($_SERVER);die;
    }


}