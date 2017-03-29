<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Admin_Controller { 

    protected $page_header = 'Users Account';
    protected $status      = array (0 => 'Not Active', 1 => 'Active');
    protected $module      = '';
    protected $url         = array ();

    function __construct()
    {
        parent::__construct();
        $this->module  = 'adminweb/users/';
        $this->url     = array ('view'   => $this->module.'view/',
                                'add'    => $this->module.'add/',
                                'update' => $this->module.'update/',
                                'delete' => $this->module.'delete/',
                                'status' => $this->module.'status/',
                                'print'  => $this->module.'print/',
                                'import'  => $this->module.'import/'
        );

        $this->has_read();      
    }
    
    public function index()
	{       
        $query = $this->ion_auth->order_by('created_on', 'DESC')->users()->result();   
        
        set_table(true);        

        $this->table->set_heading(array ('data' => 'Action', 'width' => '140px','class'=>'text-center'), 'Username', 'Email', 'Groups', 'Status');
        foreach($query as $row)
        {
            $action = array ('data'=> button_circle('view', site_url($this->url['view'].$row->id)).'&nbsp; '.
                                      button_circle('update', site_url($this->url['update'].$row->id)).'&nbsp; '.
                                      button_circle('delete', site_url($this->url['delete'].$row->id)),
                             'width'=>'125px',
                             'align'=>'center');

            $groups = $this->ion_auth->get_users_groups($row->id)->result();
            $group_name = '';
            foreach ($groups as $group) {
               $group_name .= $group->name.br(1);
            }
            
            $this->table->add_row($action, $row->username, $row->email, $group_name,                                   
                                array ('data' => anchor(site_url($this->url['status'].$row->id), $this->status[$row->active], array ('class'=>'btn btn-warning btn-xs', 'title'=>'Status')), 
                                       'class' => 'text-center')
            );                          
        }
        $data['table'] = $this->table->generate();
        
        $data['page']  = 'list'; 
        $data['page_header']   = $this->page_header;
        $data['panel_heading'] = button_square('add', site_url($this->url['add']), 'Add User').'&nbsp; '.button_square('import', site_url($this->url['import']));       
        $this->backend->view('users_v', $data);     
	}
    
    public function view($id = NULL)
    {         
        $query = $this->ion_auth->user((int)$id)->row();
        if($query)
        {
            $groups = $this->ion_auth->get_users_groups($query->id)->result();
            $group_name = '';
            foreach ($groups as $group) {
               $group_name .= '<p>'.$group->name.'</p>';
            }

            $data['id']       = $query->id; 
            $data['username'] = $query->username;
            $data['name']     = $query->name; 
            $data['email']    = $query->email;
            $data['company']  = $query->company;
            $data['phone']    = $query->phone;
            $data['last_login'] = $query->last_login;
            $data['group_name'] = $group_name;
            $data['active']   = $this->status[$query->active];
            $data['created_on'] = $query->created_on;
        }

        $data['page']          = 'view';
        $data['page_header']   = $this->page_header;
        $data['panel_heading'] = anchor(site_url($this->module), 'Users Account').' / User View';
       
        $this->backend->view('users_v', $data); 
    }

    public function add()
    {        
        if (isset($_POST['submit']))
        {
            $rule = array (array ('field' => 'username', 'label' => 'Username', 'rules' => 'alpha_numeric|required|min_length[5]|max_length[20]'),
                           array ('field' => 'password', 'label' => 'Password', 'rules' => 'alpha_numeric|required'),
                           array ('field' => 'repassword', 'label' => 'Retype Password', 'rules' => 'alpha_numeric|required|matches[password]'),
                           array ('field' => 'email', 'label' => 'Email', 'rules' => 'required|valid_email'));
                            
            $this->form_validation->set_rules($rule);
            
            if ($this->form_validation->run() == TRUE) 
            {                
                $identity_column = $this->config->item('identity','ion_auth');

                $email    = strtolower($this->input->post('email'));
                $identity = ($identity_column==='email') ? $email : $this->input->post('username');
                $password = $this->input->post('password');
                $groups   = $this->input->post('groups');
                //$group    = is_array($group) ? $group : array($group);

                $additional_data = array(
                    'name' => $this->input->post('name'),
                    'company'    => $this->input->post('company'),
                    'phone'      => $this->input->post('phone'),
                    'active'      => $this->input->post('active')
                );
                
                $result = $this->ion_auth_model->register($identity, $password, $email, $additional_data, $groups);
                if($result)
                {
                    $this->session->set_flashdata('success', 'Success Insert Data');
                    redirect(site_url($this->module));
                }
            }
            else
            {
                $data['username'] = $this->input->post('username');
                $data['name']     = $this->input->post('name'); 
                $data['email']    = $this->input->post('email');
                $data['company']  = $this->input->post('company');
                $data['phone']    = $this->input->post('phone');
                $data['group']    = $this->input->post('group');
                $data['active']   = $this->input->post('active');
            }
          
        }

        $query = $this->ion_auth->groups()->result();
        $data['groups'] = array();
        foreach ($query as $row) {
            $data['groups'][$row->id] = $row->name;
        }
        $data['actives'] = $this->status;
        $data['action']  = site_url($this->url['add']); 
        $data['page']    = 'add';
        $data['page_header']   = $this->page_header;
        $data['panel_heading'] = anchor(site_url($this->module), 'Users Account').' / User Add';

        $this->backend->view('users_v', $data); 
    }
    
    public function update($id = NULL)
    {        
        if (isset($_POST['submit']))
        {
            $rule = array (array ('field' => 'username', 'label' => 'Username', 'rules' => 'alpha_numeric|required|min_length[5]|max_length[20]'),
                           array ('field' => 'email', 'label' => 'Email', 'rules' => 'required|valid_email'));
                          
            if ( ! empty($_POST['password']))
            {
                  $rule[]['field'] = 'password';
                  $rule[]['label'] = 'Password';
                  $rule[]['rules'] = 'alpha_numeric|required';
                  
                  $rule[]['field'] = 'repassword';
                  $rule[]['label'] = 'Retype Password';
                  $rule[]['rules'] = 'alpha_numeric|required|matches[password]';
            }
                            
            $this->form_validation->set_rules($rule);
            
            if ($this->form_validation->run() == TRUE) 
            {                
                /*
                $email    = strtolower($this->input->post('email'));
                $identity = ($identity_column==='email') ? $email : $this->input->post('username');
                */
                $row = array(
                    'name' => $this->input->post('name'),
                    'company'    => $this->input->post('company'),
                    'phone'      => $this->input->post('phone'),
                    'active'      => $this->input->post('active')
                );
                
                if ( ! empty($_POST['password'])){
                    $row['password'] = $this->input->post('password');  
                }
                
                // Only allow updating groups if user is admin
                if ($this->ion_auth->is_admin())
                {
                    //Update the groups user belongs to
                    $groups    = $this->input->post('groups');

                    if (isset($groups) && !empty($groups)) {

                        $this->ion_auth->remove_from_group('', $id);

                        foreach ($groups as $group) {
                            $this->ion_auth->add_to_group($group, $id);
                        }

                    }
                }

                $result = $this->ion_auth->update($id, $row);
                if($result)
                {
                    $this->session->set_flashdata('success', 'Success Update Data');
                    redirect(site_url($this->module));
                }
            }           
        }
        
        $query = $this->ion_auth->groups()->result();
        $data['groups'] = array();
        foreach ($query as $row) {
            $data['groups'][$row->id] = $row->name;
        }

        $query = $this->ion_auth->user((int)$id)->row();

        if($query)
        {
            $grps = $this->ion_auth->get_users_groups($query->id)->result();
            $groups = array();
            foreach ($grps as $grp) {
                $groups[] = $grp->id;
            }

            $data['id']       = $query->id; 
            $data['username'] = $query->username;
            $data['name']     = $query->name; 
            $data['email']    = $query->email;
            $data['company']  = $query->company;
            $data['phone']    = $query->phone;
            $data['group']    = $groups;
            $data['active']   = $query->active;
        }
        $data['actives'] = $this->status;

        $data['action'] = site_url($this->url['update'].$id); 
        $data['page']   = 'update';
        $data['page_header']   = $this->page_header;
        $data['panel_heading'] = anchor(site_url($this->module), 'Users Account').' / User Update';

        $this->backend->view('users_v', $data); 
    }
    
    public function status($id = NULL)
    {
        if ($id != NULL)
        {            
            $query  = $this->ion_auth->select('active')->user((int)$id)->row(); 
            $row    = ($query->active == 0) ? array('active' => 1) : array('active' => 0);
            $result = $this->ion_auth->update((int)$id, $row);                         
            if($result) 
            {                
                $this->session->set_flashdata('success','Success Update Data'); 
                redirect(site_url($this->module));
            }
        }
        $this->session->set_flashdata('error','Error Update Data'); 
        redirect(site_url($this->module));
    }

    private function has_read()
    {
        $id = $this->uri->segment(4);
        if($id != null) $this->ion_auth->update($id, array('has_read' => 1));                 
    }

    public function delete($id = NULL)
    {
        $result = $this->ion_auth->delete_user($id);             
        if($result) 
        {
            $this->session->set_flashdata('success','Success Delete Data');
            redirect(site_url($this->module));
        } 
        $this->session->set_flashdata('error','Error Delete Data');
        redirect(site_url($this->module));
    }

    public function import()
    {
        if( ! empty($_FILES['userfile']['tmp_name']))
        {
            $config['upload_path']   = FCPATH.'uploads/';
            $config['allowed_types'] = 'xls';
            $config['max_size']      = '1000';
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload())
            {
                $this->form_validation->set_message('Error upload', $this->upload->display_errors());
                return FALSE;
            }
            else
            {
                $upload_data   = $this->upload->data();

                $primary_value = array ();
                $insert     = array ();
                $additional = array ();
                $update     = array ();

                $this->load->library('excel_reader');
                $this->excel_reader->setOutputEncoding('230787');
                $file =  $upload_data['full_path'];
                $this->excel_reader->read($file);

                $data = $this->excel_reader->sheets[0] ;
                $rows =  $data['numRows'];
                $cols =  $data['numCols'];

                for($r = 2; $r<=$rows; $r++)
                {
                    if(!empty($data['cells'][$r][1]))
                    {
                        if ($this->ion_auth->username_check($data['cells'][$r][1]))
                        {
                            $additional = array('name'=>$data['cells'][$r][4], 'company'=>$data['cells'][$r][5], 'phone'=>$data['cells'][$r][6]);
                            $this->db->where('username', $data['cells'][$r][1])
                                     ->update('users', $additional);
                        }
                        else
                        {
                            $password   = !empty($data['cells'][$r][2]) ? $data['cells'][$r][2] : $data['cells'][$r][1];
                            $additional = array('name'=>$data['cells'][$r][4], 'company'=>$data['cells'][$r][5], 'phone'=>$data['cells'][$r][6], 'active' => 1);
                            $this->ion_auth_model->register($data['cells'][$r][1], $password, $data['cells'][$r][3], $additional, array(2));
                        
                        }
                    }
                }
                unlink($upload_data['full_path']);
                redirect(site_url($this->module));

            }
        }

        $data['page_header']   = $this->page_header;
        $data['panel_heading'] = anchor(site_url($this->module), ' Users').' / Import Users';
        $data['page']          = 'import';
        $this->backend->view('users_v', $data);
    }     
}

/* End of file users.php */
/* Location: ./application/controllers/backend/administrator/users.php */