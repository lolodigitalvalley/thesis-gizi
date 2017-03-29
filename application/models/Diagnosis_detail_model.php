<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Diagnosis_detail_model extends MY_Model
{
    public $table       = 'diagnosis_detail';
    public $primary_key = array('kode_kasus', 'kode_gejala');

    public function __construct()
    {
        parent::__construct();

        $this->has_one['diagnosis']  = array('Diagnosis_model', 'kode_kasus', 'kode_kasus');

        $this->has_many['gejala'] = array('Gejala_model', 'kode_gejala', 'kode_gejala');
    }

}

/* End of file 'Diagnosis_detail_model.php' */
/* Location: ./application/models/Diagnosis_detail_model.php */
