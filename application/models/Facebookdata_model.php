<?php

/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 4/12/16
 * Time: 3:10 PM
 */
class Facebookdata_model extends CI_Model
{

    public function __construct() {

        parent::__construct();
        $this->load->database();

    }

    public function create_facebook_page($user_id, $cred) {

        $this->db->from('facebook_pages');
        $this->db->where('user_id', $user_id);
        $this->db->where('page_id', $cred['page_id']);


        $query = $this->db->get()->row();

        if(empty($query)){
            $cred['user_id'] = $user_id;


            $return = array(
                'error' => 0,
                'message'=>"Successfully Added",
                'response'=>$this->db->insert('facebook_pages', $cred)
            );

            return $return ;

        }else{

            $return = array(
                'error' => 1,
                'message'=>"Profile Already Added"
            );



            return $return ;
        }



    }

    public function create_facebook_access($user_id, $cred) {

        $data = array(
            'user_id'   => $user_id,
            'accessToken' => $cred,
            'status'=> 1

        );

        return $this->db->insert('facebook_access', $data);

    }

    public function getFBAccessCode($userid)
    {
        $this->db->from('facebook_access');
        $this->db->where('user_id', $userid);
        $this->db->where('status', 1);
        return $this->db->get()->row();

    }

    public function getfacebookpage($userid)
    {
        $this->db->from('facebook_pages');
        $this->db->where('user_id', $userid);
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }

    public function getfacebookpagelist($userid)
    {
        $this->db->from('facebook_pages');
        $this->db->where('user_id', $userid);
        return $this->db->get()->result();
    }

    public function getacessCode($profileid,$userid)
    {
        $this->db->from('facebook_pages');
        $this->db->where('user_id', $userid);
        $this->db->where('page_id', $profileid);
        $this->db->where('status', 1);
        return $this->db->get()->row();
    }

    public function delete($id, $user_id){

        $this->db->where('page_id', $id);
        $this->db->where('user_id', $user_id);
        $this->db->delete('facebook_pages');
    }

    public function remove_access($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('facebook_pages');


        $this->db->where('user_id', $user_id);
        $this->db->delete('facebook_access');

    }


}