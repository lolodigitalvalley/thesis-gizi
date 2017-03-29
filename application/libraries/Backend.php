<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Backend
{
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->library('ion_auth');
    }

    public function view($pages = 'dashboard_v', $data = null)
    {
        $folder = 'backend/administrator/';
        //if($this->ci->ion_auth->is_admin()) $folder = 'backend/administrator/';
        //else if ($this->ci->ion_auth->in_group('members')) $folder = 'backend/members/';

        $data['content']     = $this->ci->load->view($folder . 'contents/' . $pages, $data, true);
        $data['navbar']      = $this->ci->load->view($folder . 'navbar', $data, true);
        $data['sidebar']     = $this->ci->load->view($folder . 'sidebar', $data, true);
        $data['ctrlsidebar'] = $this->ci->load->view($folder . 'ctrlsidebar', $data, true);

        $this->ci->load->view($folder . 'templates', $data);
    }

}

/* End of file backend.php */
/* Location: ./application/libraries/backend.php */
