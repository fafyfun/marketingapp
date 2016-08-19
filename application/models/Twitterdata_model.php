<?php

/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 5/12/16
 * Time: 10:41 AM
 */
class Twitterdata_model extends CI_Model
{
    public function __construct() {

        parent::__construct();
        $this->load->database();

    }

    public function add_new_Twitter($user_id, $cred)
    {


        $this->db->from('twitter_account');
        $this->db->where('user_id', $user_id);
        $this->db->where('twitter_id', $cred['twitter_id']);

        $query = $this->db->get()->row();

        if(empty($query)){
            $cred['user_id'] = $user_id;
            return $this->db->insert('twitter_account', $cred);
        }else{

            $this->db->where('user_id', $user_id);
            $this->db->where('twitter_id', $cred['twitter_id']);


            return  $this->db->update('twitter_account', $cred);
        }



    }

    public function getTwitterAccount($userId)
    {
        $this->db->from('twitter_account');
        $this->db->where('user_id', $userId);
        $this->db->where('status', 1);
        return $this->db->get()->result();

    }

    public function add_temp_session($data){

        $this->deleteTemp($data['user_id']);

        return $this->db->insert('temp_twitter', $data);
    }

    public function get_temp_session($user_id)
    {
        $this->db->from('temp_twitter');
        $this->db->where('user_id', $user_id);
        return $this->db->get()->row();

    }

    public function deleteTemp($user_id)
    {
        $this->db->delete('temp_twitter', array('user_id' => $user_id));
    }

    public function getAccountList($user_id)
    {

        $this->db->select();
        $this->db->from('twitter_account');
        $this->db->where('user_id', $user_id);
        return $this->db->get()->result();


    }


    public function delete($id, $user_id){

        $this->db->where('twitter_id', $id);
        $this->db->where('user_id', $user_id);
        $this->db->delete('twitter_account');


    }



}