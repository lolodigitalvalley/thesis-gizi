<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Users extends Admin_Controller
{

    protected $page_header = 'Users Account';
    protected $level       = array('administrator' => 'Administrator', 'pakar' => 'Pakar', 'paramedis' => 'Paramedis');
    protected $status      = array(0 => 'Blokir', 1 => 'Aktif');
    protected $module;
    protected $url = array();

    public function __construct()
    {
        parent::__construct();
        $this->module = 'users/';
        $this->url    = array('view' => $this->module . 'view/',
            'add'                        => $this->module . 'add/',
            'update'                     => $this->module . 'update/',
            'delete'                     => $this->module . 'delete/',
            'status'                     => $this->module . 'status/',
            'print'                      => $this->module . 'print/',
        );
        $this->load->model('users_model', 'users');
    }

    public function index()
    {
        $query = $this->users->get_all();

        set_table(true);

        $this->table->set_heading(array('data' => 'Action', 'width' => '140px', 'class' => 'text-center'), 'Username', 'Email', 'Level', 'Status');
        foreach ($query as $row) {
            $action = array('data' => button_circle('view', site_url($this->url['view'] . $row->id)) . '&nbsp; ' .
                button_circle('update', site_url($this->url['update'] . $row->id)) . '&nbsp; ' .
                button_circle('delete', site_url($this->url['delete'] . $row->id)),
                'width'                => '125px',
                'align'                => 'center');

            $this->table->add_row($action, $row->username, $row->email, $this->level[$row->level],
                array('data' => anchor(site_url($this->url['status'] . $row->id), $this->status[$row->status], array('class' => 'btn btn-warning btn-xs', 'title' => 'Status')),
                    'class'      => 'text-center')
            );
        }
        $data['table'] = $this->table->generate();
        
        $data['page']  = 'list'; 
        $data['page_header']   = $this->page_header;
        $data['panel_heading'] = button_square('add', site_url($this->url['add']), 'Add User').'&nbsp;';       
        $this->frontend->view('users_v', $data);  
    }

    public function view($id = null)
    {
        if ($id != null) {
            $query = $this->users->where('id', (int) $id)->get();
            if ($query) {
                $data['id']       = $query->id;
                $data['username'] = $query->username;
                $data['name']     = $query->name;
                $data['email']    = $query->email;
                $data['level']    = $this->level[$query->level];
                $data['status']   = $this->status[$query->status];

                $data['created_at'] = $this->my_function->tgl_indo($query->created_at);
                $data['updated_at'] = $this->my_function->tgl_indo($query->updated_at);
            }
        }

        $data['page']          = 'view';
        $data['page_header']   = $this->page_header;
        $data['panel_heading'] = anchor(site_url($this->module), 'Users Account') . ' / User View';

        $this->frontend->view('users_v', $data);
    }

    public function add()
    {
        if (isset($_POST['submit'])) {
            $rule = array(array('field' => 'username', 'label' => 'Username', 'rules' => 'alpha_numeric|required|min_length[5]|max_length[32]|is_unique[users.username]'),
                array('field' => 'password', 'label' => 'Password', 'rules' => 'alpha_numeric|required|min_length[5]'),
                array('field' => 'repassword', 'label' => 'Retype Password', 'rules' => 'alpha_numeric|required|matches[password]'),
                array('field' => 'email', 'label' => 'Email', 'rules' => 'required|max_length[50]|valid_email|is_unique[users.email]'),
                array('field' => 'name', 'label' => 'Name', 'rules' => 'trim|required|max_length[100]'));

            $this->form_validation->set_rules($rule);

            if ($this->form_validation->run() == true) {
                $row = array('username' => $this->input->post('username'),
                    'name'                  => $this->input->post('name'),
                    'password'              => $this->input->post('password'),
                    'email'                 => $this->input->post('email'),
                    'level'                 => $this->input->post('level'),
                    'status'                => (int) $this->input->post('status'));

                $this->users->insert($row);
                $this->session->set_flashdata('success', 'Succes Insert Data.');
                redirect(site_url($this->module));
            }
            $data = array('username' => $this->input->post('username'),
                'name'                   => $this->input->post('name'),
                'email'                  => $this->input->post('email'),
                'level'                  => $this->input->post('level'),
                'status'                 => (int) $this->input->post('status'));
        }
        $data['array_level']   = $this->level;
        $data['array_status']  = $this->status;
        $data['action']        = site_url($this->url['add']);
        $data['page']          = 'add';
        $data['page_header']   = $this->page_header;
        $data['panel_heading'] = anchor(site_url($this->module), 'Users Account') . ' / User Add';

        $this->frontend->view('users_v', $data);
    }

    public function update($id = null)
    {
        if (isset($_POST['submit'])) {
            $rule = array(array('field' => 'username', 'label' => 'Username', 'rules' => 'alpha_numeric|required|min_length[5]|max_length[32]'),
                array('field' => 'email', 'label' => 'Email', 'rules' => 'required|valid_email'),
                array('field' => 'name', 'label' => 'Name', 'rules' => 'trim|required|max_length[100]'));

            if (!empty($_POST['password'])) {
                $rule[] = array('field' => 'password', 'label' => 'Password', 'rules' => 'alpha_numeric');
                $rule[] = array('field' => 'repassword', 'label' => 'Retype Password', 'rules' => 'alpha_numeric|required|matches[password]');
            }

            $this->form_validation->set_rules($rule);

            if ($this->form_validation->run() == true) {
                $row = array('name' => $this->input->post('name'),
                    'email'             => $this->input->post('email'),
                    'level'             => $this->input->post('level'),
                    'status'            => (int) $this->input->post('status'));

                if (!empty($_POST['password'])) {
                    $row['password'] = $this->input->post('password');
                }
                $this->users->update_by('username', $this->input->post('username'), $row);
                $this->session->set_flashdata('success', 'Succes Update Data');
                redirect(site_url($this->module));
            }
        }

        if ($id != null) {
            $query = $this->users->where('id', (int) $id)->get();
            if ($query) {
                $data['username'] = $query->username;
                $data['name']     = $query->name;
                $data['email']    = $query->email;
                $data['level']    = $query->level;
                $data['status']   = $query->status;

                $data['array_level']  = $this->level;
                $data['array_status'] = $this->status;
            }
        }

        $data['action']        = site_url($this->url['update'] . $id);
        $data['page']          = 'update';
        $data['page_header']   = $this->page_header;
        $data['panel_heading'] = anchor(site_url($this->module), 'Users Account') . ' / User Update';

        $this->frontend->view('users_v', $data);
    }

    public function status($id = null)
    {
        if ($id != null) {
            $this->users->select('status');
            $query  = $this->users->get_by('id', (int) $id);
            $row    = ($query->status == '0') ? array('status' => '1') : array('status' => '0');
            $status = $this->users->update((int) $id, $row);
            if ($status) {
                redirect(site_url($this->module));
            }

        }
        $this->session->set_flashdata('error', 'Gagal Mengupdate Data');
        redirect(site_url($this->module));
    }

    public function delete($id = null)
    {
        if ($id != null) {
            $status = $this->users->delete((int) $id);
            if ($status) {
                redirect(site_url($this->module));
            }

        }
        $this->session->set_flashdata('error', 'Gagal Menghapus Data');
        redirect(site_url($this->module));
    }
}

/* End of file users.php */
/* Location: ./application/controllers/backend/administrator/users.php */
