<?php
/**
 * Created by PhpStorm.
 * User: hemuhan
 * Date: 17/1/16
 * Time: 下午11:38
 */

class User_model extends CI_Model {
    public $userinfo;
    public $soils;
    public $recommand_list;

    public function userinfo($userid)
    {
        /**
         * 获取用户基本信息
         */
        $userinfo = $this->_userinfo($userid);
        $recommand_list = $this->recommands($userid);
        $soils = $this->soil($userid);
        $this->recommand_list = $recommand_list;
        $this->soils = $soils;
        $this->userinfo = $userinfo;
        $userinfo['soil_list'] = $soils;
        $userinfo['recommand_list'] = $recommand_list;
        return $userinfo;
    }

    /**
     * 获取用户帐户信息
     * @param $userid
     * @return mixed
     * @throws Exception
     */
    private function _userinfo($userid){
        $userinfo = $this->db->query("select wu.id,wu.nickname,wu.headimgurl,ua.eggs,ua.recommand_eggs,ua.total_eggs,ua.soils,ua.chickens,wu.tixian as money from chicken_wechat_user as wu inner join user_addition as ua on ua.user_id = wu.id where wu.id = ? limit 1",[$userid])->row_array();
        if(!$userinfo){
            throw new Exception("用户不存在");
        }
        $userinfo['today_eggs'] = $this->db->query("select sum(`eggs`) as c from eggs where user_id = ? and `date` = ?",[$userid,date("Y-m-d")])->row_array()['c'];
        if($userinfo['today_eggs'] == null){
            $userinfo['today_eggs'] = 0;
        }
//        $userinfo['money'] =  $this->db->query("select sum(`money`) m from extract where wu_id = ? and status = 2",$userinfo['id'])->row_array()['m'];
//        $userinfo['money'] || $userinfo['money']  = 0;
        $userinfo['total_eggs'] || $userinfo['total_eggs'] = 0;
        return $userinfo;
    }
    /**
     * 推荐成功的用户列表
     * @param $userid 用户ID
     * @return Array
     */
    public function recommands($userid){
        $result = $this->db->query("select cw.id,cw.nickname,cw.headimgurl from chicken_wechat_user as cw inner join user_addition as ua on ua.user_id = cw.id where ua.recommand = ? ",[$userid]);
        return $result->result_array();

    }

    /**
     * 获取土地信息,包括鸡的信息
     * @param $userid 用户ID
     */
    public function soil($userid){
        $result = $this->db->query("select * from soil where user_id = ?",[$userid])->result_array();
        foreach($result as &$item){
            if($item['enabled']){
                $chickens = $this->db->query("select * from chicken where soil_id = ? and user_id = ? and is_dead in (0,2) ",[$item['id'],$userid])->result_array();
                $item['chickens'] = $chickens;
            }
        }
        return $result;
    }



    /**
     * @param $userid 用户ID
     * @param $eggs   蛋的数量
     * 将钱转化为蛋
     */
    public function money2eggs($userid,$eggs){

    }


    /**
     * 推荐成功后调用的方法
     * @param $userid 当前用户
     * @param $recommand_id 被推荐者的用户ID
     */
    public function recommand_ok($userid,$recommand_id){

    }


    /**
     * 获取用户的消息
     * @param $userid 用户ID
     * @param bool $all_msg 是否发送所有消息,默认只发送未读消息
     * @return mixed
     */
    public function getmessage($userid,$all_msg=false){
        $query = "select message from user_messages where user_id = ?";
        if(!$all_msg){
            $query .= " and is_read = 0";
        }

        $result = $this->db->query($query,[$userid])->result_array();
        $this->db->query("update user_messages set is_read = 1 where user_id = ?",[$userid]);
        return $result;
    }


    /**
     * 拾取鸡蛋的功能
     * @param $userid  用户ID
     * @param $soil_id  土地ID
     * @param $chicken_id 鸡的ID
     * @return 未拾取的数量
     * @throws Exception 返回失败的提示消息
     */
    public function pickup_eggs($userid,$soil_id,$chicken_id){
        $this->db->trans_begin();
        $soil_info = $this->db->query("select * from soil where user_id = ? and enabled = 1 and id = ?",[$userid,$soil_id])->row_array();
        if(!$soil_info){
            throw  new Exception("此块地未开通");
        }
        $chicken_info = $this->db->query("select * from chicken where user_id = ? and soil_id = ? and id = ?",[$userid,$soil_id,$chicken_id])->row_array();
        if(!$chicken_info){
            throw new Exception("此鸡不存在");
        }
        if($chicken_info['is_dead'] == 1){
            throw new Exception("此鸡已经死亡");
        }
        if($chicken_info['no_get_eggs'] == 0){
            throw new Exception("此鸡今天已经没有蛋可拾取");
        }
        $this->db->query("update user_addition set total_eggs = total_eggs + ?  where user_id = ?",[$chicken_info['no_get_eggs'],$userid]);
        $this->db->insert("eggs",['date'=>date("Y-m-d"),'eggs'=>$chicken_info['no_get_eggs'],'user_id'=>$userid,'chicken_id'=>$chicken_info['id']]);
        $this->db->query("update chicken set no_get_eggs = 0 where id = ?",[$chicken_id]);
        if($chicken_info['is_dead'] == 2){
            $this->db->query("update chicken set is_dead = 1 where id = ?",[$chicken_id]);
            $this->db->query("update soil set henroost_".$chicken_info['soil_henroost']. ' = null where id = ?',[$soil_id]);
            $this->db->query("update user_addition set chickens = chickens - 1 where user_id = ? ",[$userid]);
        }
        $this->db->trans_commit();
        return $chicken_info['no_get_eggs'];

    }

    /**
     * 开地
     * @param $userid 用户ID
     * @param bool $soil_id 土地ID,不传则自动开启一块地
     * @throws Exception
     */

    public function enable_soil($userid,$soil_id = false){
        //计算是否有足够的钱来开地
        $userinfo = $this->_userinfo($userid);
        if ($userinfo['soils'] == 10 ){
            throw new Exception("你已永久拥有满10块养鸡的地，无法再兑换！");
        }

        if($userinfo['total_eggs'] < 10){
            throw new Exception("您的蛋不够兑换一块地");
        }
        $this->db->trans_begin();

        $no_soils = $this->db->query("select * from soil where user_id = ? and enabled = 0",[$userid])->result_array();
        if(count($no_soils) == 0){
            throw new Exception("你已永久拥有满10块养鸡的地，无法再兑换了！");
        }
        if(!$soil_id){
            $open_soil_id = $no_soils[0]['id'];
            $this->db->query("update soil set enabled = 1 where id = ? and user_id = ?",[$open_soil_id,$userid]);
        }else{
            $has_soil_id = false;
            foreach($no_soils as $item){
                if($item['id'] == $soil_id){
                    $has_soil_id = true;
                    break;
                }
            }
            if(!$has_soil_id){
                throw new Exception("你选择的地已经开过");
            }
            $open_soil_id = $soil_id;
            $this->db->query("update soil set enabled = 1 where id = ? and user_id = ?",[$soil_id,$userid]);
        }
        $this->db->query("update user_addition set total_eggs = total_eggs - 10, soils = soils + 1 where user_id = ?",[$userid]);

        $this->add_new_msg($userid,"恭喜你，你已永久拥有一块养鸡的地！");
        $this->db->trans_commit();
        return $open_soil_id;
    }

    /**
     * 蛋兑换成鸡
     * @param $userid 用户ID
     * @return 返回鸡所在的地的ID
     */
    public function egg2chicken($userid){
        $userinfo = $this->_userinfo($userid);
        if($userinfo['total_eggs'] < 100){
            throw new Exception("没有足够的蛋兑换");
        }
        if($userinfo['chickens'] > $userinfo['soils']*2){
            if($userinfo['soils'] < 10){
                throw new Exception("您的地不足,请先兑换一块地");
            }else{
                throw new Exception("你已拥有20只超生产力的母鸡，无法再兑换！");
            }

        }
        $this->db->trans_begin();

        $soil_arr = $this->soil($userid);
        $selected_soil = false;
        $selected_soil_henroost = false;
        foreach($soil_arr as $soil){
            if($soil['enabled'] == 1){
                if($soil['henroost_a'] == null){
                    $selected_soil = $soil['id'];
                    $selected_soil_henroost = 'a';
                    break;
                }
                if($soil['henroost_b'] == null){
                    $selected_soil = $soil['id'];
                    $selected_soil_henroost = 'b';
                    break;
                }
            }
        }
        if(!$selected_soil_henroost || !$selected_soil){
            throw new Exception("系统出现问题,请联系管理员解决");
        }
        //添加到鸡
        $this->db->insert('chicken',['soil_id'=>$selected_soil,'user_id'=>$userid,'soil_henroost'=>$selected_soil_henroost]);
        $chicken_id = $this->db->insert_id();
        if($selected_soil_henroost == 'a'){
            $update_soil_sql = "update soil set henroost_a = ?  where user_id = ? and id = ?";
        }else{
            $update_soil_sql = "update soil set henroost_b = ?  where user_id = ? and id = ?";
        }
        $this->db->query($update_soil_sql,[$chicken_id,$userid,$selected_soil]);
        $this->db->query("update user_addition set total_eggs = total_eggs - 100 , chickens = chickens + 1 where user_id = ? ",[$userid]);
        $this->add_new_msg($userid,"恭喜你，你已拥有一只超生产力的母鸡！");
        $this->db->trans_commit();
        return $selected_soil;
    }

    /**
     * 添加新的消息
     * @param $userid
     * @param $message
     */
    public function add_new_msg($userid,$message){
        $this->db->query("insert into user_messages (`user_id`,`message`) values(?,?)",[$userid,$message]);
    }


    /**
     * 每天生蛋任务
     * 流程
     * 将用户所有未死亡的鸡的蛋+5,总产蛋数+5
     * 更新推荐人的蛋为昨天拾取的蛋的总数*0.1
     */
    public function product_eggs(){
        $this->load->driver('cache');
        $cache_key = "crontab_eggs";
        $cacheinfo = $this->cache->file->get($cache_key);
        if($cacheinfo == date("Y-m-d")){
            die('今天已经运行过生蛋任务');
        }
        $this->db->trans_begin();
        $this->db->query("update chicken set no_get_eggs = no_get_eggs + 5 , total_eggs = total_eggs + 5 where is_dead = 0 and total_eggs < 150  and no_get_eggs = 0 ");
        $this->db->query("update chicken set is_dead = 2 where is_dead = 0 and total_eggs >= 150");

        //先更新所有今天获取推荐的蛋的数量为0,将昨天获取推荐的蛋的数量+到总数上
        $this->db->query("update user_addition set  recommand_eggs = 0");
        //更新昨天拾取蛋的10% 到推荐者帐户中
        $lastday_eggs = $this->db->query("select sum(e.eggs)*0.1 as eggs ,u.recommand from eggs as e inner join user_addition as u on u.user_id = e.user_id where e.`date` = ? group by u.recommand",[date("Y-m-d",strtotime("-1 day"))])->result_array();
        foreach ($lastday_eggs as $egg){
            $this->db->query("update user_addition set recommand_eggs = ?, recommand_total_eggs = recommand_total_eggs + recommand_eggs, total_eggs = total_eggs + ? where user_id = ?",[$egg['eggs'],$egg['eggs'],$egg['recommand']]);
            $this->add_new_msg($egg['recommand'],'恭喜你，通过你的小伙伴分享，你已获得了'.$egg['eggs'].'个蛋。');
        }
        $this->db->trans_commit();
        $this->cache->file->save($cache_key,date("Y-m-d"),864000);
    }
}
