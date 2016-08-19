<?php

/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 7/22/16
 * Time: 2:28 PM
 */
class Xero_model extends CI_Model
{
    public function __construct() {

        parent::__construct();
        $this->load->database();



    }

    public function add_xero_account($user_id, $cred) {

        $this->db->from('xero_credential');
        $this->db->where('user_id', $user_id);


        $query = $this->db->get()->row();

        if(empty($query)){
            $cred['user_id'] = $user_id;

            return $this->db->insert('xero_credential', $cred);
        }else{

            $return = array(
                'error' => 1,
                'message'=>"Xero Account is added"
            );

            return $return ;
        }



    }

    public function get_credential($user_id){

        $this->db->from('xero_credential');
        $this->db->where('user_id', $user_id);
        return $this->db->get()->row();

    }

    public function insertCode($data){

        $this->db->from('xero_account_code');
        $this->db->where('user_id', $_SESSION['id']);
        $this->db->where('account_id', $data['account_id']);
        $this->db->where('type', $data['type']);


        $query = $this->db->get()->row();

        if(empty($query)){
            $data['user_id'] = $_SESSION['id'];

            return $this->db->insert('xero_account_code', $data);
        }else{

            $return = array(
                'error' => 1,
                'message'=>"Xero Account is added"
            );

            return $return ;
        }

    }

    public function getAccount()
    {
        $this->db->from('xero_account_code');
        $this->db->where('user_id', $_SESSION['id']);
        $this->db->where('status', 1);

        return( $this->db->get()->result());

    }


    public function delete($id,$user_id)
    {

        $this->db->where('id', $id);
        $this->db->where('user_id', $user_id);
        $this->db->delete('xero_account_code');


    }




}