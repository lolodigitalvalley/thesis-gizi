<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bobot_gejala extends Pakar_Controller {


 	protected $page_header = 'Data Bobot Gejala';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('penyakit_model' => 'penyakit', 'bobot_gejala_model' => 'bobot_gejala',  'gejala_model' => 'gejala'));
    }

    public function index()
    {       
        $data['page'] = '';
        $data['data_kasus']  = $this->generate_table();
        $data['page_header'] = $this->page_header;
        $data['breadcrumb']  = $this->page_header;
       	$this->frontend->view('basis_kasus_v', $data);
    }

    public function generate_table($kode_gejala)
    {
        $data['bobot_gejala'] = $this->bobot_gejala->where('kode_gejala', $kode_gejala)->get_all();

        $data['penyakit'] = $this->penyakit->get_all();
        $data['kode_gejala'] = $kode_gejala;
        $data['page_header'] = $this->page_header;
        $this->frontend->view('bobot_gejala_v', $data);
    }

    public function save_bobot()
    {
        $kode_gejala = $this->input->post('kode_gejala');
        $bobot = $this->input->post('bobot');

        $this->bobot_gejala->delete(array('kode_gejala' => $kode_gejala));

        $insert_many = array();
        foreach ($bobot as $key => $value) {
            $insert_many[] = array('kode_gejala' => $kode_gejala, 'kode_penyakit' => $key, 'bobot' => $value); 
        }

        $this->bobot_gejala->insert($insert_many);
        redirect(site_url('gejala'));
    }

    public function delete_bobot($kode_gejala)
    {
        $this->bobot_gejala->delete(array('kode_gejala' => $kode_gejala));

        redirect(site_url('gejala'));
    }


}
