<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Inisiasi_klaster_model extends MY_Model
{
    public $table       = 'Inisiasi_klaster';
    public $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }
}

/* End of file 'Inisiasi_klaster_model.php' */
/* Location: ./application/models/Inisiasi_klaster_model.php */
