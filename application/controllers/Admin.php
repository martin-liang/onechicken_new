<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin extends CI_Controller {


    private $_cookieName = 'aid';
    private $_cookieUserName = 'email';
    private $_cookieTime = 8640000;

    private $_pageNum = 20;
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function index()
    {
        if($_POST)
        {

            $this->load->model("admin_model");
            $userInfo = $this->admin_model->getUsers($_POST['email']);
            if(md5($_POST['password']) == $userInfo['pwd'])
            {
                setcookie($this->_cookieName,$userInfo['id'],time()+$this->_cookieTime);
                setcookie($this->_cookieUserName,$userInfo['email'],time()+$this->_cookieTime);
                header('location:http://www.sqweichao.com/index.php/admin/show');
                exit;
            }
        }

        $this->load->view('admin_login');
    }

    public function show()
    {
//        error_reporting(0);
        $this->load->library('pagination');
        $this->load->model('topup_model');

        $config['base_url'] = 'http://www.sqweichao.com/index.php/admin/show/page/';
        $countSql = " SELECT count(*) from chicken_wechat_user wu LEFT JOIN user_addition ua ON wu.id=ua.user_id";
        $count= $this->topup_model->querySql($countSql);

        $config['total_rows'] = $count['count(*)'];
        $config['per_page'] = $this->_pageNum;
        $config['enable_query_strings'] = true;

        $this->pagination->initialize($config);

        $data['page'] =  $this->pagination->create_links();
        $page = intval($_GET['page']);
        $sql = " SELECT wu.*,ua.total_eggs total_eggs,ua.soils,ua.chickens from chicken_wechat_user wu LEFT JOIN user_addition ua ON wu.id=ua.user_id   limit $page, $this->_pageNum";
        $list= $this->topup_model->querySql($sql);
        foreach ($list as $key=>$value)
        {
            if($value['create_time'])
            {
                $list[$key]['create_time'] = date('Y-m-d H:i',$value['create_time']);
            }
            if($value['sex'] == 2)
            {
                $list[$key]['sex'] = '女';
            }else{
                $list[$key]['sex'] = '男';
            }
        }
        $data['list'] = $list;
        $this->load->view('admin_user',$data);
//        $this->load->view('admin_login');
    }


    public function tixian()
    {
        error_reporting(0);
        $this->load->library('pagination');
        $this->load->model('topup_model');

        $countSql = "select count(*) from extract ";
        $count  = $this->topup_model->querySql($countSql);

        $config['base_url'] = 'http://www.sqweichao.com/index.php/admin/tixian/page/';
        $config['total_rows'] = $count['count(*)'];
        $config['per_page'] = $this->_pageNum;
        $config['enable_query_strings'] = true;



        $this->pagination->initialize($config);

        $data['page'] =  $this->pagination->create_links();
        $page = intval($_GET['page']);
        $sql = "select * from extract limit $page, $this->_pageNum";
        $list = $this->topup_model->querySql($sql);

        foreach ($list as $key=>$value)
        {
            $id = $value['id'];
            if($value['create_time'])
            {
                $list[$key]['create_time'] = date('Y-m-d H:i');
            }

            if($value['status'] == 1)
            {
                $link = "http://www.sqweichao.com/index.php/admin/ok?id=$id";
                $list[$key]['status'] = "<a href=$link>未处理</a>";
            }
            else
            {
                $list[$key]['status'] = '已处理';
            }
        }

        $data['list'] = $list;

        $this->load->view('tixian',$data);
    }

    public function logout()
    {
        setcookie($this->_cookieUserName,'',-1);
        setcookie($this->_cookieName,'',-1);
        header('location:http://www.sqweichao.com/index.php/admin/index');
        exit;

    }

    public function ok()
    {
        $id = $_GET['id'];
        $this->load->model('topup_model');

        try{
            $this->topup_model->tixian($id);
            $this->load->view('success');
        }catch (Exception $e){
            header('location:http://www.sqweichao.com/index.php/admin/tixian');
            exit;
        }

    }
}
