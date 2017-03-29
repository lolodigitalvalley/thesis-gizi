<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Diagnosis_model extends MY_Model
{
    public $table       = 'diagnosis';
    public $primary_key = 'kode_kasus';

    public function __construct()
    {
        parent::__construct();

        $this->has_one['penyakit']  = array('Penyakit_model', 'kode_penyakit', 'kode_penyakit');

        $this->has_many['diagnosis_detail'] = array('Diagnosis_detail_model', 'kode_kasus', 'kode_kasus');
    }

    public function get_max_id()
    {
        $this->db->select_max('kode_kasus', 'max_id');
        $query = $this->db->get($this->table);

        return $query->row()->max_id;
    }

}

/* End of file 'Basis_kasus_model.php' */
/* Location: ./application/models/Basis_kasus_model.php */
