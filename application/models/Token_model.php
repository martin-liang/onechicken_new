<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/16
 * Time: 13:09
 */
class token_model extends CI_Model
{
    private $table_token = 'chicken_wechat_token';

    private $_url = 'http://www.sqweichao.com/api/share';



    CONST appId = "wxf691fb1f4059c9f3";
    CONST secret = "bb4063f79f23fd2459a4b9064ef4c997";
    CONST redirect = "http://www.7gz.com";

    CONST accessTokenLink = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s";
    CONST signatureLink = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=jsapi";

    /*appid=wx193e672203c8c855&redirect_uri=http://h5.91marryu.com*/
    /*微信基础验证 （仅获取openID）*/
    CONST oAuthBase = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
    /*用户验证*/
    CONST oAuthInfo = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";


    /*获取微信验证token*/
    CONST getWebToken = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code";
    CONST getWeUserInfo = "https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=zh_CN";

    /*
     * http://h5.91marryu.com/m/index.html?code=013nmP7S14rFF81VqX9S1FuP7S1nmP7t&state=123
     *
     * */

    public  function getWeChatOpenId($code = '',$recommand_code= '',$parent_id = 0)
    {

        $weChatJsonInfo = curlGet(sprintf(self::getWebToken,self::appId,self::secret,$code));
        $weChatInfo = json_decode($weChatJsonInfo,true);
        $userJsonInfo = curlGet(sprintf(self::getWeUserInfo,$weChatInfo['access_token'],$weChatInfo['openid']));
        $userInfo = json_decode($userJsonInfo,true);
        $saveData = [
            'wechat_id'=>$userInfo['openid'],
            'create_time'=>time(),
            'headimgurl'=>$userInfo['headimgurl'],
            'nickname'=>$userInfo['nickname'],
            'province'=>$userInfo['province'],
            'city'=>$userInfo['city'],
            'sex'=>$userInfo['sex'],
            'recommand_code'=>md5($userInfo['openid']),
            'parent_code'=>$recommand_code,
            'parent_id'=>$parent_id,
        ];

				$info = $this->db->query("select * from chicken_wechat_user where wechat_id = ?",[$userInfo['openid']])->row_array();
        if($info)
            return $info;


        $this->db->insert('chicken_wechat_user',$saveData);

        usleep(50000);

        $info = $this->db->query("select * from chicken_wechat_user where wechat_id = ?",[$userInfo['openid']])->row_array();
        
        $parentInfo = $this->db->query("select * from chicken_wechat_user where id = ?",[$info['id']])->row_array();

        $this->writeResult($parentInfo['id'],$parentInfo['parent_id'],$parentInfo['recommand_code']);






        return $saveData;

        //获取code
        //2.获取access_token
        //返回数据
        /*{
    "access_token": "Nw_5y7UpaGN9mD_CZhuMC1AoSRzr-7iUqcawQVe6ZbQLAEiI288dKt93_hmicKMx9sTVAP7KUVJywx3WDND7pj3DD6BvuoNfkKzFJeqOmLY",
    "expires_in": 7200,
    "refresh_token": "gsG0v4M1YlRBbuZMmI1wGBDG_eWjZ4XpbF9uTc5FgfLM2tH-K9BWfeQw-gQ20X8Q3V1tiG4QxYk4mjkBeGG7Q52zWMsPoveZoEZ4zR52k3s",
    "openid": "o0TY9sw1z2MTMJ0DdOjJUW20LXmw",
    "scope": "snsapi_userinfo"
}
         * */
    }

    public function writeResult($userId,$parentId = 0,$recommand_code = '')
    {
        $save['user_id'] = $userId;
        $save1['enabled'] = 1;
        $save1['user_id'] = $userId;
        $this->db->insert('soil',$save1);

        $saveS = [
            $save,
            $save,
            $save,
            $save,
            $save,
            $save,
            $save,
            $save,
            $save,
        ];
        $this->db->insert_batch('soil',$saveS);
        $save['recommand'] = $parentId;
        $save['recommand_code'] = $recommand_code;
        $save['soils'] = 1;
        $this->db->insert('user_addition',$save);
    }
    public function getWuId($wechat_id)
    {
        return $this->db->query("select * from chicken_wechat_user WHERE wechat_id = ? order by create_time DESC limit 1  ",[$wechat_id])->row_array();
    }

    public function getid($recommand_code)
    {
        return $this->db->query("select * from chicken_wechat_user WHERE recommand_code = ?  order by create_time DESC limit 1",[$recommand_code])->row_array();
    }

    public function insertLog($table,$data)
    {
        return $this->db->insert($table,$data);
    }

    public function _getCode($link = "")
    {
        if($link) {
            $target = (sprintf(self::oAuthInfo, self::appId, $link));
            header("Location:$target");
        }


        return '跳转链接未传入';

    }
    
    

    /**
     * 调取微信分享token
     * @return mixed
     */
    public function getToken()
    {


        return $this->db->query("select * from chicken_wechat_token WHERE valid_time > ".time()." ORDER BY id DESC ")->row_array();
    }

    /**
     * 设置微信分享token
     */
    public function setToken()
    {
        if($this->getToken())
        {
            return $this->getToken();
        }
       return $this->getWeChatSignature();
    }

    /**
     * 微信 access_token 数据
     * 有效时间 2两小时
     * 分享全部调用
     */

    public function getWeChatSignature($url = '')
    {
        if($url)
            $this->_url = $url;

        $time = time();
        $result = curlGet(sprintf(self::accessTokenLink,self::appId,self::secret));

        $token = (json_decode($result, true));
        $link2 = sprintf(self::signatureLink, $token['access_token']);
        $result1 = curlGet($link2);
        $token1 = (json_decode($result1, true));
        $ticket = $token1['ticket'];
        $string1 = "jsapi_ticket=$ticket&noncestr=bitch&timestamp=$time&url=$this->_url";
        $signature = sha1($string1);
        $data['create_time'] = $time;
        $data['valid_time'] = $time + 7100;
        $data['access_token'] = $token['access_token'];
        $data['signature'] = $signature;
        $this->saveData($this->setData($data));
        $data['ticket'] = $ticket;
        return $data;
    }
    
    
    
    
    
    
    /**/

    public function __construct()
    {
        parent::__construct();
        $this->load->database($this->table_token);

    }

    public function getData()
    {


        return $this->db->where('valid_time > ',time())->get($this->table_token)->result_array();
    }


    
    public function saveData($obj)
    {
        return $this->db->set($obj)->insert($this->table_token);
    }

    public function setData($arr)
    {
        $obj = new stdClass();
        foreach ($arr as $key=>$value)
        {
            $obj-> $key= $value;
        }

        return $obj;
    }
}
