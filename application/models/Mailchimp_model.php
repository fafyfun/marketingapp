<?php

/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 7/11/16
 * Time: 12:35 PM
 */

use \DrewM\MailChimp\MailChimp;

class Mailchimp_model extends CI_Model
{
    public function __construct() {

        parent::__construct();
        $this->load->database();

    }

    public function create_mailchimp_list($user_id, $cred) {

        $this->db->from('mailchimp');
        $this->db->where('user_id', $user_id);
        $this->db->where('api_key', $cred['api_key']);

        $query = $this->db->get()->row();

        if(empty($query)){
            $data = array(
                'user_id'   => $user_id,
                'api_key'      => $cred['api_key'],
                'status' =>$cred['status'],

            );

            $return = array(
                'error' => 0,
                'message'=>"Successfully Added",
                'response'=> $this->db->insert('mailchimp', $data)
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

    public function getList($user_id)
    {
        $this->db->select('*');
        $this->db->from('mailchimp');
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 1);
        return $this->db->get()->result();

    }

    public function getAPI($id)
    {
        $this->db->select('*');
        $this->db->from('mailchimp');
        $this->db->where('user_id', $id);
        return  $this->db->get()->row();

    }

    public function delete($id,$user_id){

        $this->db->where('id', $id);
        $this->db->where('user_id', $user_id);
        $this->db->delete('mailchimp');

    }

}