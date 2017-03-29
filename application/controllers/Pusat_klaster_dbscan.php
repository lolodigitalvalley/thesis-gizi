<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pusat_klaster_dbscan extends Pakar_Controller
{

    protected $page_header = 'Pusat Klaster DBSCAN';
    protected $metode      = 'dbscan';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('gejala_model' => 'gejala', 'pusat_klaster_model' => 'pusat_klaster', 'inisiasi_klaster_model' => 'inisiasi_klaster'));
    }

    public function index()
    {
        $nCluster = $this->pusat_klaster->group_by('klaster')->count_rows('metode', $this->metode);
        $gejala   = $this->gejala->fields('kode_gejala')->get_all();

        set_table(false);
        $heading = array('Klaster', 'Usia');
        foreach ($gejala as $value) {
            $heading[] = $value->kode_gejala;
        }

        $this->table->set_heading($heading);
        for ($i = 0; $i <= $nCluster; $i++) {
            $query = $this->pusat_klaster->where(array('metode' => $this->metode, 'klaster' => $i))->order_by('no')->get_all();
            if ($query) {
                $bobot = array($i);
                foreach ($query as $row) {
                    $bobot[] = $row->bobot;
                }

                $this->table->add_row($bobot);
            }
        }

        $data['table'] = $this->table->generate();

        $query =  $this->inisiasi_klaster->where(array('metode' => $this->metode))->get();

        $data['page_header']   = $this->page_header;
        $data['breadcrumb']    = $this->page_header;
        $data['panel_heading'] = 'Klaster menggunakan '.$this->metode.' dengan epsilon '. $query->epsilon. ', minimum points '.$query->min_points.' dan nilai silhoutte index '.$query->silhoutte_index;
        $data['page']          = '';
        $this->frontend->view('centroid_v', $data);
    }
}

/* End of file centroid_som.php */
/* Location: ./application/controllers/centroid_som.php */
