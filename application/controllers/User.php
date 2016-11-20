<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->log_type = LOG_TYPE_USER;

        $this->load->model('user_model', 'users');
        $this->load->model('timeline_model', 'timeline');
    }

    public function home()
    {
        $uid = $this->session->uid;
        $posts = $this->timeline->get_newest(100, 0);
        for ($i = 0; $i < count($posts); $i++) {
            $user_i = $this->users->get_user_info($posts[$i]['user_id']);
            $posts[$i]['head'] = $user_i['head'];
        }
        $data = array(
            'posts' => $posts,
        );
        if ($uid) {
            $data['uid'] = $uid;
            $user = $this->users->get_user_info($uid);
            $data['head'] = $user['head'];
        }
        $this->load->view('main.html', $data);
    }

    public function post()
    {
        if (!$this->check_login()) {
            return;
        }
        $this->load->view('send.html');
    }

    public function account()
    {
        $this->check_login();
        $uid = $this->session->uid;
        $posts = $this->timeline->get_ones_post($uid);
        $user = $this->users->get_user_info($uid);
        $data = array(
            'posts' => $posts,
            'head' => base_url($user['head']),
        );
        $this->load->view('services.html', $data);
    }

    /**
     * register interface
     * method : POST
     * @param  username, password, gender
     */
    public function register()
    {
        $this->validate_form('register');
        $username = $this->input->post('username');
        $password = encrypt_passwd($this->input->post('password'));
        $gender = $this->input->post('gender');

        // register
        if ($this->username_exist($username)) {
            $error = $this->lang->line('prompt_account_has_exist');
            $this->make_error_response($error, $error,
                HTTP_BAD_REQUEST);
        }

        $uid = $this->users->insert_user($username, $password, $gender);

        if (!$uid) {
            $errors = $this->lang->line('prompt_database_error');
            $this->make_error_response($errors, $errors,
                HTTP_INTERNAL_SERVER_ERROR);
        }

        $this->session->uid = $uid;
        $this->jumpto(base_url('/user/home'));
    }

    /**
     * user login
     * method : POST
     * @param  username, password
     */
    public function login()
    {
        $this->validate_form('login');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $res = $this->users->get_hash_from($username);
        $uid = $res['user_id'];
        $hash = $res['password'];

        if (!validate_passwd($password, $hash)) {
            $res_error = $this->lang->line('prompt_passwd_error');
            $this->long_jumpto('/user/home', $res_error);
        }

        $this->session->uid = $uid;
        $this->jumpto(base_url('/user/home'));
    }

    public function new_post()
    {
        $this->check_login();
        $this->validate_form('post');
        $image = $this->upload_image();
        $describe = $this->input->post('describe');
        $uid = $this->session->uid;
        $this->timeline->new_post($uid, $image, $describe);
        $this->jumpto('/user/account');
    }

    private function upload_image()
    {
        $config['upload_path'] = './resources/images/';
        $config['allowed_types'] = 'jpg|png|gif|jpeg';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);
        $url = '';

        if (!$this->upload->do_upload('image')) {
            $error = $this->upload->display_errors();
            // $this->make_error_response($error, $error, HTTP_BAD_REQUEST);
            $this->long_jumpto('/user/post', $error);
        } else {
            $filename = $this->upload->data('file_name');
            $url = $filename;
        }
        return $url;
    }

    private function validate_form($rules)
    {
        $rules = $this->config->item($rules, 'form_rules');
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == false) {
            $error = validation_errors();
            $this->make_error_response($error, $error, HTTP_BAD_REQUEST);
        }
    }

    /**
     * 检查手机号是否被注册
     * @param  [type] $name [description]
     * @return [type]        [description]
     */
    private function username_exist($name)
    {
        return $this->users->is_exist($name);
    }

    private function jumpto($url)
    {
        $data = array('url' => $url);
        $this->load->view('jump.html', $data);
    }

    private function long_jumpto($url, $error)
    {
        $data = array('url' => $url, 'error' => $error);
        $this->load->view('errors/html/error_general.php', $data);
    }

    private function check_login()
    {
        $uid = $this->session->uid;
        if ($uid) {
            return true;
        }
        $this->long_jumpto(base_url('home'), '发皂片要先登录哦');
        return false;
    }

}
