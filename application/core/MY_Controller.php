<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Paramedis_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('access');
        if (!$this->access->is_login()) {
            redirect(site_url('login'));
        }
    }
}

class Pakar_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('access');
        if (!$this->access->is_login() || (!$this->access->is_pakar() && !$this->access->is_admin())) {
            redirect(site_url('login'));
        }
    }
}

class Admin_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('access');
        if (!$this->access->is_login() || !$this->access->is_admin()) {
            redirect(site_url('login'));
        }
    }
}

class MY_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
}
/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
