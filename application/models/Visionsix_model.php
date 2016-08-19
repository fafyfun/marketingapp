<?php

/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 5/26/16
 * Time: 4:46 PM
 */
class Visionsix_model extends CI_Model
{
    public function __construct() {

        parent::__construct();
        $this->load->database();

    }

    public function create_vision6_list($user_id, $cred) {

        $this->db->from('vision6');
        $this->db->where('user_id', $user_id);
        $this->db->where('list_id', $cred['list_id']);


        $query = $this->db->get()->row();

        if(empty($query)){
            $data = array(
                'user_id'   => $user_id,
                'api_key'      => $cred['api_key'],
                'list_id'   => $cred['list_id'],
                'list_name' => $cred['list_name'],
                'folder_name' => $cred['folder_name'],
                'status' =>$cred['status'],

            );

            $return = array(
                'error' => 0,
                'message'=>"Successfully Added",
                'response'=> $this->db->insert('vision6', $data)
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
        $this->db->from('vision6');
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 1);
        return $this->db->get()->result();

    }

    public function delete($id, $user_id){

        $this->db->from('vision6');
        $this->db->where('user_id', $user_id);
        $this->db->where('list_id', $id);

        $query = $this->db->get()->row();


        if(!empty($query->api_key)){

            $api_key = $query->api_key;

            $this->db->where('list_id', $id);
            $this->db->where('user_id', $user_id);
            $this->db->delete('vision6');

            $this->db->from('vision6');
            $this->db->where('user_id', $user_id);

            $query = $this->db->get()->row();

            $data = array(
                'api_key' => $api_key,
            );

            $this->db->where('id', $query->id);
            $this->db->update('vision6', $data);

        }else{

            $this->db->where('list_id', $id);
            $this->db->where('user_id', $user_id);
            $this->db->delete('vision6');
        }






    }



}