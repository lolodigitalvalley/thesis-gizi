<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Access
{

    private $users;
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
        $auth     = $this->ci->config->item('auth');

        $this->ci->load->model('users_model', 'users');
        $this->users = &$this->ci->users;
    }

    public function login($username, $password)
    {
        $result = $this->users->where(array('username' => $username))->get();

        if ($result) {
            if ($password == $result->password) {
                session_start();
                $new_session = array(
                    'id'       => $result->id,
                    'username' => $result->username,
                    'name'     => $result->name,
                    'level'    => $result->level,
                );
                $this->ci->session->set_userdata($new_session);
                return true;
            }

        }
        //print_r($new_session);
        return false;
    }

    public function is_login()
    {
        return (($this->ci->session->userdata('username')) ? true : false);
    }

    public function is_admin()
    {
        return (($this->ci->session->userdata('level') === 'administrator') ? true : false);
    }

    public function is_pakar()
    {
        return (($this->ci->session->userdata('level') === 'pakar') ? true : false);
    }

    public function is_paramedis()
    {
        return (($this->ci->session->userdata('level') === 'paramedis') ? true : false);
    }

    public function logout()
    {
        $this->ci->session->unset_userdata('username');
        $this->ci->session->sess_destroy();
    }

}

/* End of file accses.php */
/* Location: ./application/libraries/access.php */
