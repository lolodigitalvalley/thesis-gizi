<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Basis_kasus_model extends MY_Model
{
    public $table       = 'basis_kasus';
    public $primary_key = 'kode_kasus';

    public function __construct()
    {
        parent::__construct();

        $this->has_one['penyakit']  = array('Penyakit_model', 'kode_penyakit', 'kode_penyakit');

        $this->has_many['kasus_detail'] = array('Kasus_detail_model', 'kode_kasus', 'kode_kasus');
        $this->has_one['klaster'] = array('Klaster_model', 'kode_kasus', 'kode_kasus');
    }

    public function get_max_id()
    {
        $this->db->select_max('kode_kasus', 'max_id');
        $query = $this->db->get($this->table);

        return $query->row()->max_id;
    }

    public function get_max()
    {
        $this->db->select_max('usia', 'max_usia');
        $query = $this->db->get($this->table);

        return $query->row();
    }

    public function get_min()
    {
        $this->db->select_min('usia', 'min_usia');
        $query = $this->db->get($this->table);

        return $query->row();
    }

    public function not_in_klaster(){
        //$query = $this->db->query("SELECT kode_kasus FROM basis_kasus where kode_kasus NOT IN (SELECT DISTINCT kode_kasus FROM klaster)");      
        //return $query;

        $query = $this->db->distinct()->select('kode_kasus')->get('klaster'); 
        $kode_kasus = array();
        foreach ($query->result() as $row) $kode_kasus[] =  $row->kode_kasus;
        
        $query = $this->db->where_not_in('kode_kasus', $kode_kasus)->get('basis_kasus');

        return $query;
    }

}

/* End of file 'Basis_kasus_model.php' */
/* Location: ./application/models/Basis_kasus_model.php */
