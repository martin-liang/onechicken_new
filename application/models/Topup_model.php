<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/17
 * Time: 19:06
 */
class Topup_model extends CI_Model
{
    public $table = 'tou_up';

    public function __construct()
    {
        parent::__construct();
    }

    public function writeMoney($money,$order_num,$ips_num)
    {
        $sql = "update top_up set `money` = $money ,`ips_num` = '".$ips_num."' where `order_num` = "."'".$order_num."'"." limit 1";
//        return $this->db->query("update top_up set money = ? where order_num = ? limit 1",[$money],$order_num);
        return $this->db->query($sql);
    }


    public function addExtract($sql)
    {
        return $this->db->query($sql);
    }

    public function querySql($sql)
    {
        return $this->db->query($sql)->result_array();
    }

    public function addLog($table,$data)
    {
        return $this->db->insert($table,$data);
    }


    public function tixian($id){
        $this->db->trans_begin();
        $data = $this->db->query("select * from extract where id = ? and status = 1 ",[$id])->row_array();
        if(!$data){
            throw  new Exception("已经处理过了");
        }

        $this->db->query("update chicken_wechat_user set tixian = tixian+".$data['money']." where id = ".$data['wu_id']);
        $this->db->query("update extract set status = 2 where id = ?",[$id]);
        $this->db->trans_commit();

        return true;
    }
}