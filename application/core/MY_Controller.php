<?php

defined('BASEPATH') or exit('No direct script access allowed');

// 导入HTTP状态码列表
require_once APPPATH . 'config/http_code.php';
// 导入数据库中表的常量名
require_once APPPATH . 'config/database_const.php';
// 导入日志类型列表
require_once APPPATH . 'config/log_type.php';

class MY_Controller extends CI_Controller
{

    private $_log_body;
    protected $log_type;

    public function __construct()
    {
        parent::__construct();

        $this->config->load('form_rules', true);
        $this->form_validation->set_error_delimiters('', '');

        //$this->config->load('upload_rules', true);

        $this->lang->load('prompt', 'chinese');

        // 记录表单数据，方便做日志统计
        $this->_log_body = $this->_make_log_body();
    }

    private function _make_log_body()
    {
        $method = $this->input->method(true);
        $body = array();
        switch ($method) {
            case 'POST':
                $body = $_POST;
                break;
            case 'GET':
                $body = $_GET;
                break;
            default:
                $body = $this->input->input_stream();
                break;
        }
        $body['user_ip'] = $this->input->ip_address();
        return my_array_to_str($body);
    }

    protected function make_error_response($log_errors, $res_errors, $res_code)
    {
        $response = array();
        // 记录错误的原因，以及当前表单数据，方便后期数据统计，分析。
        log_message_info($this->log_type, $log_errors . $this->_log_body);
        // 响应内容
        $response['code'] = REQUEST_FAILED;
        $response['msg'] = $res_errors;
        api_output($response, $res_code);
    }

    protected function make_lack_param_response()
    {
        $errors = $this->lang->line('prompt_lack_request_param');
        $this->make_error_response($errors, $errors, HTTP_BAD_REQUEST);
    }

    protected function make_unlegal_req_type_response()
    {
        $errors = $this->lang->line('prompt_unlegal_request_type');
        $this->make_error_response($errors, $errors, HTTP_BAD_REQUEST);
    }

}
