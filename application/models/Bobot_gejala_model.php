<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Bobot_gejala_model extends MY_Model
{
    public $table       = 'bobot_gejala';
    public $primary_key = array('kode_gejala', 'kode_penyakit');

    public function __construct()
    {
        parent::__construct();

        //$this->has_one['penyakit']  = array('Penyakit_model', 'kode_penyakit', 'kode_penyakit');

        //$this->has_many['kasus_detail'] = array('Kasus_detail_model', 'kode_kasus', 'kode_kasus');
    }

}

/* End of file 'Bobot_gejala_model.php' */
/* Location: ./application/models/Bobot_gejala_model.php */
