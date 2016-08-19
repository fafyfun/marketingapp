<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 *
 * @extends CI_Controller
 */
class User extends CI_Controller
{

    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model('user_model');

    }


    public function index()
    {


    }

    /**
     * register function.
     *
     * @access public
     * @return void
     */
    public function register()
    {

        // create the data object
        $data = new stdClass();

        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            redirect('/');
        }


        // set validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|min_length[6]|matches[password]');

        if ($this->form_validation->run() === false) {

            // validation not ok, send validation errors to the view
            $this->load->view('header');
            $this->load->view('user/register/register', $data);
            $this->load->view('footer');

        } else {

            // set variables from the form
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            if ($this->user_model->create_user($username, $email, $password)) {

                redirect('/');

            } else {

                // user creation failed, this should never happen
                $data->error = 'There was a problem creating your new account. Please try again.';

                // send error to the view
                $this->load->view('header');
                $this->load->view('user/register/register', $data);
                $this->load->view('footer');

            }

        }

    }

    /**
     * login function.
     *
     * @access public
     * @return void
     */
    public function login()
    {

        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            redirect('/');
        }

        // create the data object
        $data = new stdClass();

        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == false) {
            // validation not ok, send validation errors to the view
            $this->load->view('user/login/login');


        } else {

            // set variables from the form
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            if ($this->user_model->resolve_user_login($username, $password)) {

                $user_id = $this->user_model->get_user_id_from_username($username);
                $user = $this->user_model->get_user($user_id);

                // set session user datas
                $_SESSION['user_id'] = (int)$user->id;
                $_SESSION['username'] = (string)$user->username;
                $_SESSION['email'] = (string)$user->email;
                $_SESSION['logged_in'] = (bool)true;
                $_SESSION['is_confirmed'] = (bool)$user->is_confirmed;
                $_SESSION['is_user'] = (bool)$user->is_admin;

                // user login ok
                redirect("/");

            } else {

                // login failed
                $data->error = 'Wrong username or password.';

                // send error to the view
                $this->load->view('user/login/login', $data);

            }

        }

    }

    /**
     * logout function.
     *
     * @access public
     * @return void
     */
    public function logout()
    {

        // create the data object
        $data = new stdClass();

        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

            // remove session datas
            foreach ($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }

            // user logout ok
            $this->load->view('header_inner');
            $this->load->view('user/logout/logout_success', $data);
            $this->load->view('footer_inner');

        } else {

            // there user was not logged in, we cannot logged him out,
            // redirect him to site root
            redirect('/');

        }

    }

    public function profile()
    {

        $data = new stdClass();

        $customerId = $_SESSION['user_id'];


        if (empty($customerId) && $customerId == 0) {
            redirect('/user/login');
        }

        $user = $this->user_model->get_user($customerId);

        $data = array(
            'userDetails' => $user,
            'has_error' => false,
        );

        if ($this->input->post()) {

            // set validation rules
            $this->form_validation->set_rules('fName', 'First Name', 'required');
            $this->form_validation->set_rules('lName', 'Last Name', 'required');
            $this->form_validation->set_rules('add', 'Address', 'required');
            $this->form_validation->set_rules('city', 'City', 'required');
            $this->form_validation->set_rules('state', 'State', 'required');
            $this->form_validation->set_rules('country', 'Country', 'required');
            $this->form_validation->set_rules('pNumber', 'Phone Number', 'required');
            $this->form_validation->set_rules('emailAdd', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('title', 'Title', 'required|');
            $this->form_validation->set_rules('company', 'Company', 'required|');
            $this->form_validation->set_rules('comp_name', 'Upload Avatar', 'required');
            $this->form_validation->set_rules('comp_cv', 'Upload CV', 'required');

            if ($this->form_validation->run() == false) {
                $path = "uploads/profile/" . $_SESSION['user_id'];

                if (!is_dir($path)) //create the folder if it's not already exists
                {
                    mkdir($path, 0777, TRUE);
                    chmod($path, 0777);
                }

                $this->load->library('upload');


                $config = array(
                    'upload_path' => "./uploads/profile/" . $_SESSION['user_id'],
                    'allowed_types' => "jpg|png|jpeg",
                    'file_name' => $this->input->post('fName'),
                    'overwrite' => TRUE,
                    'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    'max_height' => "1024",
                    'max_width' => "1024"
                );

                $this->upload->initialize($config); // Important

                if ($this->upload->do_upload("com_name")) {
                    var_dump($this->upload->data());
                }

                $config1 = array(
                    'upload_path' => "./uploads/profile/" . $_SESSION['user_id'],
                    'allowed_types' => "pdf|doc|docx|txt",
                    'file_name' => $this->input->post('fName'),
                    'overwrite' => TRUE,
                    'max_size' => "10240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                );

                $this->upload->initialize($config1);

                if ($this->upload->do_upload("com_cv")) {
                    var_dump($this->upload->data());
                }


                $data = array(
                    'userDetails' => $user,
                    'has_error' => true,
                );


            }

        }


        $this->load->view('header');
        $this->load->view('user/profile/view_profile', $data);
        $this->load->view('footer');

    }

    public function forget_password()
    {
        // create the data object
        $data = new stdClass();

        // set validation rules
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == false) {
            $this->load->view('header_inner');
            $this->load->view('user/forgot/forgot_password', $data);
            $this->load->view('footer_inner');
        } else {

            $email = $this->input->post('email');

            if ($this->user->checkEmail($email)) {

                $this->load->helper('string');

                echo random_string('alnum', 16);


            } else {
                // login failed
                $data->error = 'Wrong email Id.';

                // send error to the view
                $this->load->view('header_inner');
                $this->load->view('user/forgot/forgot_password', $data);
                $this->load->view('footer_inner');
            }
        }


    }

    public function buildcv()
    {

        $data = new stdClass();

        $customerId = $_SESSION['user_id'];


        if (empty($customerId) && $customerId == 0) {
            redirect('/user/login');
        }

        if ($this->input->post()) {

            // set validation rules
            $this->form_validation->set_rules('summery', 'Career Objective / Summery', 'required');
            $this->form_validation->set_rules('proExperience', 'Professional Experience', 'required');
            $this->form_validation->set_rules('perStrengths', 'Personal Strengths', 'required');
            $this->form_validation->set_rules('acaQualification', 'Academic Qualification', 'required');
            $this->form_validation->set_rules('skills', 'Skills', 'required');
            $this->form_validation->set_rules('projExperience', 'Country', 'required');
            $this->form_validation->set_rules('extracurricular', 'Phone Number', 'required');
            $this->form_validation->set_rules('achievements', 'Email', 'required');

            if ($this->form_validation->run() == false) {

            } else {

                $summery = $this->input->post('summery');
                $proExperience = $this->input->post('proExperience');
                $perStrengths = $this->input->post('perStrengths');
                $acaQualification = $this->input->post('acaQualification');
                $skills = $this->input->post('skills');
                $projExperience = $this->input->post('projExperience');
                $extracurricular = $this->input->post('extracurricular');
                $achievements = $this->input->post('achievements');

                $insertData = array(
                    'userid'=> $_SESSION['user_id'],
                    'summery' => $summery,
                    'proExperience' => $proExperience,
                    'perStrengths' => $perStrengths,
                    'acaQualification' => $acaQualification,
                    'skills' => $skills,
                    'projExperience' => $projExperience,
                    'extracurricular' => $extracurricular,
                    'achievements' => $achievements,

                );

                if ($this->user_model->build_cv($insertData)) {

                    redirect('/');

                } else {
                    // user creation failed, this should never happen
                    $data->error = 'There was a problem creating your new account. Please try again.';

                }

            }

        }

        $this->load->view('header_inner');
        $this->load->view('user/buildcv/buildcv', $data);
        $this->load->view('footer_inner');
    }

}
