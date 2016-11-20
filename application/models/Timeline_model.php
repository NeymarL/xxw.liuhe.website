<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Timeline_model extends MY_Model
{
/*
CREATE TABLE `timeline` (
`timeline_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
`user_id` char(32) NOT NULL COMMENT '发布人',
`image` char(50) NOT NULL COMMENT '发布的图片',
`describe` char(200) NOT NULL COMMENT '说的话',
`num_likes` int(11) NOT NULL COMMENT '喜欢的人数',
`time` int(11) NOT NULL COMMENT '发布时间',
FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
)
 */

    public function __construct()
    {
        parent::__construct();
        $this->set_table_name(TABLE_TIMELINE);
    }

    public function new_post($user_id, $image, $describe)
    {
        $tid = create_primary_key();
        $data = array(
            'timeline_id' => $tid,
            'user_id' => $user_id,
            'image' => $image,
            'describe' => $describe,
            'num_likes' => 0,
            'time' => time(),
        );
        return $this->db->insert($this->table_name, $data) ? $tid : false;
    }

    public function get_newest($num, $skip)
    {
        $result = $this->db
            ->select('timeline_id, user_id, image, describe, num_likes, time')
            ->from($this->table_name)
            ->order_by('time', 'DESC')
            ->get()
            ->result_array();
        return count($result) > 0 ? $result : array();
    }

    public function get_hotest($num, $skip)
    {
        $result = $this->db
            ->select('timeline_id, user_id, image, describe, num_likes, time')
            ->from($this->table_name)
            ->order_by('num_likes', 'DESC')
            ->limit($skip, $num)
            ->get()
            ->result_array();
        return count($result) > 0 ? $result : false;
    }

    public function get_ones_post($user_id)
    {
        $result = $this->db
            ->select('timeline_id, user_id, image, describe, num_likes, time')
            ->from($this->table_name)
            ->where('user_id', $user_id)
            ->order_by('time', 'DESC')
            ->get()
            ->result_array();
        return count($result) > 0 ? $result : array();
    }

}
