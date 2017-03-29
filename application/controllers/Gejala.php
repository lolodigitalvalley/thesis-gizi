<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class gejala extends Pakar_Controller {


 	protected $page_header = 'Data Gejala';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('gejala_model', 'gejala');
    }

    public function index()
    {       
        $data['page'] = '';
        $data['data_gejala'] = $this->generate_table();
        $data['page_header'] = $this->page_header;
        $data['breadcrumb']  = $this->page_header;
       	$this->frontend->view('gejala_v', $data);
    }

    private function generate_table()
    {
        set_table(false);
        $this->table->set_heading(array('data' => 'Action', 'width' => '55px'),
            array('data' => 'Kode Gejala'),
            array('data' => 'Nama Gejala'),
            array('data' => 'Bobot', 'class' => 'text-center')
        );

        $query = $this->gejala->with_bobot_gejala('fields:kode_penyakit, bobot')->get_all();
        if ($query > 0) {
            foreach ($query as $row) {
                $action = array('data' => button_action('update', array('onClick' => 'update_gejala(\'' . $row->kode_gejala . '\');')) . nbs(2) .
                    button_action('delete', array('onClick' => 'delete_gejala(\'' . $row->kode_gejala . '\');')),
                    'width'                => '125px',
                    'align'                => 'center',
                );
                $bobot = '';
                $i = 1;
                if(!empty($row->bobot_gejala)){
                    foreach ($row->bobot_gejala as $value) {
                        if($i == 4 ) {
                            $bobot .= '<br>';
                            $i = 1;
                        } 
                        $bobot .= $value->kode_penyakit.' = '.$value->bobot.'; ';
                        $i++;
                    }     
                }             

                $this->table->add_row($action,
                    $row->kode_gejala,
                    $row->nama_gejala,
                    array('data' => $bobot.br(1).anchor(site_url('bobot_gejala/generate_table/'. $row->kode_gejala), 'Tambah', array('class' => 'btn btn-warning btn-xs', 'title' => 'Tamb.')).nbs(4).
                                    anchor(site_url('bobot_gejala/delete_bobot/'. $row->kode_gejala), 'Hapus', array('class' => 'btn btn-warning btn-xs', 'title' => 'Hapus')),
                          'class' => 'text-center')
                );
            }
        }
        return $this->table->generate();
    }

    public function reload_table()
    {
        echo $this->generate_table();
    }

    public function add_gejala()
    {
        $form  = '<div class="row">
        <div class="col-lg-10">';
        $form .= form_open_multipart('', array('role' => 'form', 'id' => 'form-gejala')) .
        form_hidden('methode', 'add') .
        input_text('Kode Gejala', array('name' => 'kode_gejala', 'id' => 'kode_gejala', 'width' => 3)) .
        input_text('Nama Gejala', array('name' => 'nama_gejala', 'id' => 'nama_gejala', 'width' => 8)) .
        button(array('name' => 'submit', 'id' => 'submit', 'onClick' => 'save_gejala()', 'value' => 'Submit')) . nbs(4) .
        button(array('name' => 'reset', 'id' => 'reset', 'type' => 'reset', 'value' => 'Reset')) .
        form_close();
        $form .= '</div>
        </div>';

        echo $form;
    }
  
    public function update_gejala()
    {
        $kode_gejala = $this->input->post('kode_gejala');
        $query = $this->gejala->where('kode_gejala', $kode_gejala)->get();

        $form  = '<div class="row">
        <div class="col-lg-10">';
        $form .= form_open_multipart('', array('role' => 'form', 'id' => 'form-gejala')) .
        form_hidden('methode', 'update') .
        input_text('Kode gejala', array('name' => 'kode_gejala', 'id' => 'kode_gejala', 'value' => !empty($query->kode_gejala) ? $query->kode_gejala : '', 'width' => 3)) .
        input_text('Nama gejala', array('name' => 'nama_gejala', 'id' => 'nama_gejala', 'value' => !empty($query->nama_gejala) ? $query->nama_gejala : '', 'width' => 8)) .
        button(array('name' => 'submit', 'id' => 'submit', 'onClick' => 'save_gejala()', 'value' => 'Submit')) . nbs(4) .
        button(array('name' => 'reset', 'id' => 'reset', 'type' => 'reset', 'value' => 'Reset')) .
        form_close();
        $form .= '</div>
        </div>';

        echo $form;
    }

    public function save_gejala()
    {
        $error         = array('result' => 0);
        $kode_gejala = $this->input->post('kode_gejala');
        $nama_gejala = $this->input->post('nama_gejala');

        $methode  = $this->input->post('methode');
        if ($methode == 'add') {
            $row    = array('kode_gejala' => $kode_gejala, 'nama_gejala' => $nama_gejala);
            $result = $this->gejala->insert($row);
            echo json_encode(array('result' => 1));
            exit;
        } else if ($methode == 'update') {
            $result = $this->gejala->update(array('nama_gejala' => $nama_gejala), array('kode_gejala' => $kode_gejala));
            echo json_encode(array('result' => 2));
            exit;
        }
        
        echo json_encode(array('result' => 0));
    }

    public function delete_gejala()
    {
        $kode_gejala = $this->input->post('kode_gejala');

        $this->gejala->delete(array('kode_gejala' => $kode_gejala));
        echo json_encode(array("result" => 1));
    }
}
