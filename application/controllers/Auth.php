<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
                          
    public function __construct()
    {
        parent::__construct();
        $this->load->library('access');
    }
    
	public function index()
	{
        $this->login();
	}
    
    public function login()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');

        $rule = array(array('field' => 'username', 'label' => 'Username', 'rules' => 'trim|required|strip_tags'),
                      array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|required|strip_tags'));
        
        $this->form_validation->set_rules($rule);
        $this->form_validation->set_rules('token', 'token', 'callback_check_login');
        if ($this->form_validation->run() == TRUE)
        {
            redirect(site_url('dashboard'));
            
        }
        $this->load->view('auth_v');
    }
    
    public function logout()
    {
        $this->access->logout();
        redirect(site_url('login')); 
    }
    
    public function check_login()
    {
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE); 
        
        $login = $this->access->login($username, $password);
        if ($login)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('check_login', 'Username atau Password Salah');
            return FALSE;
        }
    }
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */