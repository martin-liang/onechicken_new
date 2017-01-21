<?php
/**
 * Created by PhpStorm.
 * User: hemuhan
 * Date: 17/1/16
 * Time: 下午4:15
 * @property array $userinfo 用户信息
 */

class MY_Controller extends CI_Controller {
    protected $userinfo;


    protected function get_userid(){
        if(ENVIRONMENT == 'test'){
            return 1;
        }else{
            return $_POST['userid'];
        }

    }

    /**
     * 发送给前端的数据信息
     * @param $status
     * @param $data
     * @param $msg
     * @return string
     */
    protected function send_data($status,$data,$msg=false){
        header("Content-type: application/json");
        $result = json_encode([
            "status"=>$status,
            "data"=>$data,
            "msg"=>$msg
        ]);
        die($result);
    }


}