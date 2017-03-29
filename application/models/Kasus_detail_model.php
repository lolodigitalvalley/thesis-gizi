<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Kasus_detail_model extends MY_Model
{
    public $table       = 'kasus_detail';
    public $primary_key = array('kode_kasus', 'kode_gejala');

    public function __construct()
    {
        parent::__construct();

        $this->has_one['kasus']  = array('Basis_kasus_model', 'kode_kasus', 'kode_kasus');

        $this->has_many['gejala'] = array('Gejala_model', 'kode_gejala', 'kode_gejala');
    }

}

/* End of file 'Basis_kasus_model.php' */
/* Location: ./application/models/Basis_kasus_model.php */
