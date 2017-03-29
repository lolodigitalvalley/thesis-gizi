<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Paramedis_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('penyakit_model' => 'penyakit', 'basis_kasus_model' => 'basis_kasus', 'users_model' => 'users', 'diagnosis_model' => 'diagnosis', 'gejala_model' => 'gejala'));
    }

    public function index()
    {
        $data['count_kasus']       = $this->basis_kasus->count_rows();
        $data['count_diagnosis']   = $this->diagnosis->count_rows();
        $data['count_penyakit']    = $this->penyakit->count_rows();
        $data['count_non_klaster'] = $this->basis_kasus->not_in_klaster()->num_rows();
        $data['count_users']       = $this->penyakit->count_rows();

        $this->frontend->view('dashboard_v', $data);
    }
}
