<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Klaster_model extends MY_Model
{
    public $table       = 'klaster';
    public $primary_key = array('kode_kasus', 'klaster', 'teknik');

    public function __construct()
    {
        parent::__construct();

        $this->has_one['kode_kasus']  = array('Basis_kasus_model', 'kode_kasus', 'kode_kasus');

        //$this->has_many['kasus_detail'] = array('Kasus_detail_model', 'kode_kasus', 'kode_kasus');
    }

}

/* End of file 'Bobot_gejala_model.php' */
/* Location: ./application/models/Bobot_gejala_model.php */
