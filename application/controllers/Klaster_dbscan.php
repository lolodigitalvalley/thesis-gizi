<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Klaster_dbscan extends Pakar_Controller
{

    protected $page_header   = 'Klaster DBSCAN';
    protected $jenis_kelamin = array(1 => 'Laki-laki', 2 => 'Perempuan');
    protected $metode        = 'dbscan';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('gejala_model' => 'gejala', 'klaster_model' => 'klaster', 'basis_kasus_model' => 'basis_kasus', 'kasus_detail_model' => 'kasus_detail'));
    }

    public function index()
    {
        set_table(true);
        $this->table->set_heading(array('data' => 'Kode Kasus'),
            array('data' => 'Usia'),
            array('data' => 'Jenis Kelamin'),
            array('data' => 'Nama Penyakit'),
            array('data' => 'Gejala'),
            array('data' => 'Kluster'),
            array('data' => 'Created At', 'width' => '100px', 'class' => 'text-center')
        );

        $query = $this->basis_kasus
            ->with_penyakit('fields:nama_penyakit')
            ->with_kasus_detail('fields:kode_gejala')
            ->with_klaster('fields:klaster|where:metode = "' . $this->metode . '"')
            ->get_all();

        if (!empty($query)) {
            foreach ($query as $row) {
                $gejala = '';
                if (!empty($row->kasus_detail)) {
                    $i = 1;
                    foreach ($row->kasus_detail as $value) {
                        if ($i == 5) {
                            $gejala .= '<br>';
                            $i = 1;
                        }
                        $gejala .= $value->kode_gejala . ', ';
                        $i++;
                    }
                }

                $this->table->add_row($row->kode_kasus,
                    $row->usia,
                    $this->jenis_kelamin[$row->jk],
                    $row->kode_penyakit . br(1) .
                    $row->penyakit->nama_penyakit,
                    $gejala,
                    $row->klaster->klaster,
                    array('data' => $this->my_function->tgl_indo($row->created_at, 'd/m/Y'), 'class' => 'text-center')
                );
            }
        }

        $data['table'] = $this->table->generate();

        $data['page_header']   = $this->page_header;
        $data['breadcrumb']    = $this->page_header;
        $data['panel_heading'] = '';
        $data['page']          = '';
        $this->frontend->view('klaster_v', $data);
    }
}

/* End of file centroid_som.php */
/* Location: ./application/controllers/centroid_som.php */
