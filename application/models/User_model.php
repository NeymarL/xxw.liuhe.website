<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends MY_Model
{
/*
对应数据表结构
CREATE TABLE `user` (
`user_id` char(32) NOT NULL PRIMARY KEY,
`head` varchar(100) NOT NULL COMMENT '用户头像路径',
`gender` char(1) NOT NULL COMMENT '0 -> male, 1 -> female, 2 -> unknown',
`password` varchar(60) NOT NULL,
`username` varchar(30) NOT NULL COMMENT '用户昵称',
`time` int(11) NOT NULL COMMENT '用户注册时间',
)
 */
    public function __construct()
    {
        parent::__construct();
        $this->set_table_name(TABLE_USER);
    }

    /**
     * 新增用户
     */
    public function insert_user($username, $password, $gender)
    {
        $uid = create_primary_key();
        $data = array(
            'user_id' => $uid,
            'head' => $this->config->item('head', 'default'),
            'username' => $username,
            'password' => $password,
            'gender' => $gender,
            'time' => time(),
        );
        return $this->db->insert($this->table_name, $data) ? $uid : false;
    }

    /**
     * update user field
     * @param  string $uid          user id
     * @param  array  $update_field
     * @return bool   true on success, false on failure
     */
    public function update_user($uid, $update_field)
    {
        $this->db->where('user_id', $uid);
        return $this->db->update($this->table_name, $update_field);
    }

    /**
     * get user infomation
     * @param  string $uid user id
     * @return mixed  information(array) on success, false(bool) on failure
     */
    public function get_user_info($uid)
    {
        $this->db->select('user_id, username, head, gender, time, password');
        $this->db->from($this->table_name);
        $this->db->where('user_id', $uid);
        $result = $this->db->get()->result_array();
        return count($result) > 0 ? $result[0] : false;
    }

    public function get_user_num()
    {
        return $this->db->count_all_results($this->table_name);
    }

    public function remove($user_id)
    {
        $find_field = array('user_id' => $user_id);
        return $this->db->delete($this->table_name, $find_field);
    }

    /**
     * get password hash from database
     * @param  [type] $uid [description]
     * @return [type]      [description]
     */
    public function get_hash_from($username = '', $uid = '')
    {
        $this->db->select('user_id, password');
        $this->db->from($this->table_name);
        if ($username != '') {
            $this->db->where('username', $username);
        } else if ($uid != '') {
            $this->db->where('user_id', $uid);
        } else {
            $this->db->get();
            return false;
        }
        $result = $this->db->get()->result_array();
        return count($result) > 0 ? $result[0] : false;
    }

    /**
     * check username is already exist
     * @param  str    username
     * @return boolean    true on exist, false on not exists
     */
    public function is_exist($username)
    {
        $result = $this->db->select()
            ->from($this->table_name)
            ->where('username', $username)
            ->get()->result_array();
        return !empty($result);
    }

    /**
     * get user id from username
     * @param  string $username
     * @return string user id
     */
    public function get_uid($username)
    {
        $result = $this->db->select('user_id')
            ->from($this->table_name)
            ->where('username', $username)
            ->get()->result_array();
        return count($result) > 0 ? $result[0]['user_id'] : false;
    }

}
