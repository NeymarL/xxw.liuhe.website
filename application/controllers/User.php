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

    public function home($error = '')
    {
        $uid = $this->session->uid;
        $data = array('error' => $error);
        if ($uid) {
            $data['uid'] = $uid;
        }
        $this->load->view('main.html', $data);
    }

    public function account()
    {
        $this->load->view('services.html');
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
            $this->jumpto(/user/home, $res_error);
        }

        $this->session->uid = $uid;
        $this->jumpto(base_url('/user/home'));
    }

    /**
     * get user info
     * method : GET
     */
    public function info($uid)
    {
        if (!$uid || $uid == '') {
            $error = $this->lang->line('prompt_auth_out_date');
            $this->make_error_response($error, $error, HTTP_BAD_REQUEST);
        }

        $user = $this->users->get_user_info($uid);

        if (!$user) {
            $error = $this->lang->line('prompt_user_not_exist');
            $this->make_error_response($error, $error,
                HTTP_BAD_REQUEST);
        }

    }

    /**
     * update user name and gender
     * method : POST
     */
    public function update_user_info()
    {

        $this->validate_form('update_user');

        $token = $this->input->post('token');
        $name = $this->input->post('name');

        $uid = $this->get_uid_from_token($token);

        $update_fields = array(
            'name' => $name,
        );

        if (!$this->users->update_user($uid, $update_fields)) {
            $error = $this->lang->line('prompt_database_error');
            make_error_response($error, $error,
                HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * 更换头像
     * @return [type] [description]
     */
    public function change_head()
    {
        $token = $this->input->post('token');
        $uid = $this->get_uid_from_token($token);

        $config['upload_path'] = './resources/images/';
        $config['allowed_types'] = 'jpg|png|gif|jpeg';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('image')) {
            $error = $this->upload->display_errors();
            $this->make_error_response($error, $error, HTTP_BAD_REQUEST);
        } else {
            $filename = $this->upload->data('file_name');
            $url = base_url($filename);
            $update_array = array('head' => $filename);
            if (!$this->users->update_user($uid, $update_array)) {
                $error = $this->lang->line('prompt_database_error');
                $this->make_error_response($error, $error,
                    HTTP_INTERNAL_SERVER_ERROR);
            }
            $response = array(
                'code' => REQUEST_SUCCESS,
                'msg' => SUCCESS_MESSAGE,
                'data' => array(
                    'url' => $url,
                ),
            );
            api_output($response, HTTP_OK);
        }
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

    private function check_login()
    {
        $uid = $this->session->uid;
        if ($uid) {
            return true;
        }
        $this->jumpto(base_url('v1/admin/signin'));
    }

}
