<?php

defined('BASEPATH') or exit('No direct script access allowed');

$config = array(
    // 注册
    'register' => array(
        array(
            'field' => 'username',
            'label' => '用户名',
            'rules' => 'trim|required|max_length[30]',
            'errors' => array(
                'required' => '请填写昵称',
                'max_length' => '昵称长度应小于{param}位',
            ),
        ),
        array(
            'field' => 'password',
            'label' => '密码',
            'rules' => 'trim|required|max_length[60]',
            'errors' => array(
                'required' => '请填写密码',
                'max_length' => '密码长度应小于{param}位',
            ),
        ),
        array(
            'field' => 'gender',
            'label' => '性别',
            'rules' => 'trim|required|integer',
            'errors' => array(
                'required' => '请填写性别',
                'integer' => '非法的性别',
            ),
        ),
    ),
    // 登陆
    'login' => array(
        array(
            'field' => 'username',
            'label' => '用户名',
            'rules' => 'trim|required|max_length[30]',
            'errors' => array(
                'required' => '请填写昵称',
                'max_length' => '昵称长度应小于{param}位',
            ),
        ),
        array(
            'field' => 'password',
            'label' => '密码',
            'rules' => 'trim|required|max_length[60]',
            'errors' => array(
                'required' => '请填写密码',
                'max_length' => '密码长度应小于{param}位',
            ),
        ),
    ),
    // 修改密码
    'passwd' => array(
        array(
            'field' => 'token',
            'label' => '令牌',
            'rules' => 'trim|required|max_length[32]',
            'errors' => array(
                'max_length' => 'token应少于{param}位',
                'required' => '请填写token',
            ),
        ),
        array(
            'field' => 'old',
            'label' => '旧密码',
            'rules' => 'trim|required|max_length[60]',
            'errors' => array(
                'max_length' => '旧密码长度应小于{param}位',
                'required' => '请填写旧密码',
            ),
        ),
        array(
            'field' => 'new',
            'label' => '新密码',
            'rules' => 'trim|required|max_length[60]',
            'errors' => array(
                'max_length' => '新密码长度应小于{param}位',
                'required' => '请填写新密码',
            ),
        ),
    ),
    // 忘记密码
    'forget' => array(
        array(
            'field' => 'phone',
            'label' => '手机号',
            'rules' => 'trim|required|max_length[14]|integer',
            'errors' => array(
                'max_length' => '自定义内容不能超过{param}字',
                'required' => '请填写手机号',
                'integer' => '手机号只能包含数字',

            ),
        ),
        array(
            'field' => 'password',
            'label' => '密码',
            'rules' => 'trim|required|max_length[60]',
            'errors' => array(
                'max_length' => '密码长度应小于{param}位',
                'required' => '请填写新密码',
            ),
        ),
        array(
            'field' => 'SMScode',
            'label' => '验证码',
            'rules' => 'trim|required|max_length[7]|integer',
            'errors' => array(
                'required' => '请填写验证码',
                'integer' => '非法的验证码',
            ),
        ),
    ),
    // 更新用户信息
    'update_user' => array(
        array(
            'field' => 'token',
            'label' => '令牌',
            'rules' => 'trim|required|max_length[32]',
            'errors' => array(
                'max_length' => 'token应少于{param}位',
                'required' => '请填写token',
            ),
        ),
        array(
            'field' => 'name',
            'label' => '昵称',
            'rules' => 'trim|required|max_length[30]',
            'errors' => array(
                'required' => '请填写自己的姓名',
                'max_length' => '昵称应少于{param}位',
            ),
        ),
    ),
    'pace' => array(
        array(
            'field' => 'token',
            'label' => '令牌',
            'rules' => 'trim|required|max_length[32]',
            'errors' => array(
                'max_length' => 'token应少于{param}位',
                'required' => '请填写token',
            ),
        ),
        array(
            'field' => 'pace_num',
            'label' => '步数',
            'rules' => 'trim|required|integer',
            'errors' => array(
                'required' => '请填写步数',
            ),
        ),
        array(
            'field' => 'money',
            'label' => '金币数',
            'rules' => 'trim|required|integer',
            'errors' => array(
                'required' => '请填写金币数',
            ),
        ),
    ),
    'use' => array(
        array(
            'field' => 'token',
            'label' => '令牌',
            'rules' => 'trim|required|max_length[32]',
            'errors' => array(
                'max_length' => 'token应少于{param}位',
                'required' => '请填写token',
            ),
        ),
        array(
            'field' => 'com_id',
            'label' => '商品ID',
            'rules' => 'trim|required|max_length[32]',
            'errors' => array(
                'max_length' => '商品ID应少于{param}位',
            ),
        ),
    ),
    'rest' => array(
        array(
            'field' => 'token',
            'label' => '令牌',
            'rules' => 'trim|required|max_length[32]',
            'errors' => array(
                'max_length' => 'token应少于{param}位',
                'required' => '请填写token',
            ),
        ),
        array(
            'field' => 'option',
            'label' => '选项',
            'rules' => 'trim|required|integer|in_list[0,1]',
            'errors' => array(
                'in_list' => 'option只能选0或1',
            ),
        ),
    ),
    // 反馈
    'feedback' => array(
        array(
            'field' => 'token',
            'label' => '令牌',
            'rules' => 'trim|required|max_length[32]',
            'errors' => array(
                'max_length' => 'token应少于{param}位',
                'required' => '请填写token',
            ),
        ),
        array(
            'field' => 'information',
            'label' => '联系方式',
            'rules' => 'trim|required|max_length[40]',
            'errors' => array(
                'max_length' => '联系方式应少于40字符。',
                'required' => '请填写联系方式哦',
            ),
        ),
        array(
            'field' => 'message',
            'label' => '反馈内容',
            'rules' => 'trim|required|max_length[400]',
            'errors' => array(
                'max_length' => '反馈内容应少于400字符',
                'required' => '请填写正文',
            ),
        ),
    ),
    // 管理员登陆
    'admin_login' => array(
        array(
            'field' => 'username',
            'label' => '用户名',
            'rules' => 'trim|required|max_length[14]|integer',
            'errors' => array(
                'required' => '请填写用户名',
                'max_length' => '用户名长度应小于{param}位',
                'integer' => '用户名只能包含数字',
            ),
        ),
        array(
            'field' => 'password',
            'label' => '密码',
            'rules' => 'trim|required|max_length[60]',
            'errors' => array(
                'required' => '请填写密码',
                'max_length' => '密码长度应小于{param}位',
            ),
        ),
    ),
    'commodity' => array(
        array(
            'field' => 'name',
            'label' => '名称',
            'rules' => 'trim|required|max_length[30]',
            'errors' => array(
                'required' => '请填写名称',
                'max_length' => '名称应小于{param}个字符',
            ),
        ),
        array(
            'field' => 'describe',
            'label' => '描述',
            'rules' => 'trim|required|max_length[100]',
            'errors' => array(
                'required' => '请填写描述',
                'max_length' => '描述应小于{param}个字符',
            ),
        ),
        array(
            'field' => 'price',
            'label' => '价格',
            'rules' => 'trim|required|max_length[11]|integer',
            'errors' => array(
                'required' => '请填写价格',
                'max_length' => '价格应小于{param}个字符',
            ),
        ),
        array(
            'field' => 'HP',
            'label' => '生命值',
            'rules' => 'trim|required|max_length[11]|integer',
            'errors' => array(
                'required' => '请填写生命值',
                'max_length' => '生命值应小于{param}个字符',
            ),
        ),
        array(
            'field' => 'hungry_point',
            'label' => '饱腹值',
            'rules' => 'trim|required|max_length[11]|integer',
            'errors' => array(
                'required' => '请填写饱腹值',
                'max_length' => '饱腹值应小于{param}个字符',
            ),
        ),
        array(
            'field' => 'lang',
            'label' => '随机话',
            'rules' => 'trim|max_length[500]',
            'errors' => array(
                'max_length' => '随机话应小于{param}个字符',
            ),
        ),
    ),
);
