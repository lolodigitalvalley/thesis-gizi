<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Frontend
{
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
        //$this->ci->load->model(array('categories_model' => 'categories'));
    }

    public function view($pages = 'dashboard_v', $data = null)
    {
        $folder = 'frontend/';

        $data['content']     = $this->ci->load->view($folder . 'contents/' . $pages, $data, true);
        $data['navbar']      = $this->ci->load->view($folder . 'navbar', $data, true);
        $data['sidebar']     = $this->ci->load->view($folder . 'sidebar', $data, true);
        $data['ctrlsidebar'] = $this->ci->load->view($folder . 'ctrlsidebar', $data, true);

        $this->ci->load->view($folder . 'templates', $data);
    }

}

/* End of file frontend.php */
/* Location: ./application/libraries/frontend.php */
