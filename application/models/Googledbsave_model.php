<?php

/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 4/7/16
 * Time: 4:59 PM
 */
class Googledbsave_model extends CI_Model
{
    public function __construct() {

        parent::__construct();
        $this->load->database();

    }


    public function create_google_cred($user_id, $cred) {

        $data = array(
            'user_id'   => $user_id,
            'access_token'      => $cred['access_token'],
            'token_type'   => $cred['token_type'],
            'expires_in' => $cred['expires_in'],
            'refresh_token' =>$cred['refresh_token'],
            'created' => $cred['created']
        );

        return $this->db->insert('google_credential', $data);

    }

    public function get_google_cred($user_id) {

        $this->db->from('google_credential');
        $this->db->where('user_id', $user_id);
        return $this->db->get()->row();

    }

    public function update_google_cred($user_id,$data) {

        $this->db->where('user_id', $user_id);
        return  $this->db->update('google_credential', $data);


    }

    public function create_google_prof($user_id, $cred) {

        $this->db->from('google_profile');
        $this->db->where('user_id', $user_id);
        $this->db->where('web_id', $cred['web_id']);


        $query = $this->db->get()->row();



        if(empty($query)){
            $data = array(
                'user_id'   => $user_id,
                'account_id'      => $cred['account_id'],
                'prop_id'   => $cred['account_id'],
                'web_id' => $cred['web_id'],
                'namePro' => $cred['namePro'],
                'status' =>$cred['status'],

            );



            $return = array(
                'error' => 0,
                'message'=>"Successfully Added",
                'response'=>$this->db->insert('google_profile', $data)
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

    public function remove_access($id)
    {
        $this->db->delete('google_profile', array('user_id' => $id));
        $this->db->delete('google_credential', array('user_id' => $id));

    }


    public function getProfile($user_id)
    {
        $this->db->select('web_id,namePro');
        $this->db->from('google_profile');
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 1);
        return $this->db->get()->result();

    }

    public function getProfileList($user_id)
    {

        $this->db->select();
        $this->db->from('google_profile');
        $this->db->where('user_id', $user_id);
        return $this->db->get()->result();


    }

    public function delete($id, $user_id){

        $this->db->where('web_id', $id);
        $this->db->where('user_id', $user_id);
        $this->db->delete('google_profile');


    }

    public function getProfileData($profileId,$user_id)
    {
        $this->db->from('google_profile');
        $this->db->where('web_id', $profileId);
        $this->db->where('user_id', $user_id);
        return $this->db->get()->row();

    }


}