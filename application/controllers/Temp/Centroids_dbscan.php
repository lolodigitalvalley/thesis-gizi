<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Centroids_dbscan extends CI_Controller
{

    protected $page_header = 'Cluster Centroid For DBSCAN';
    protected $module      = '';
    protected $url         = array();

    public function __construct()
    {
        parent::__construct();

        $this->module = 'centroids_dbscan/';
        $this->url    = array('view' => $this->module . 'view/',
            'generate_data'              => $this->module . 'generate_data/',
            'update'                     => $this->module . 'update/',
            'drop_data'                  => $this->module . 'drop_data/',
            'status'                     => $this->module . 'status/',
            'print'                      => $this->module . 'print/');

        $this->load->model('centroids_dbscan_model', 'centroids');
    }

    public function index()
    {
        $query = $this->centroids->get_all();

        set_table(false);

        $this->table->set_heading('Cluster', 'Lk', 'Pr', 'Umur', 'G001', 'G002', 'G003', 'G004', 'G005',
            'G006', 'G007', 'G008', 'G009', 'G010',
            'G011', 'G012', 'G013', 'G014', 'G015',
            'G016', 'G017', 'G018', 'G019', 'G020',
            'G021', 'G022', 'G023', 'G024', 'G025',
            'G026', 'G027', 'G028', 'G029', 'G030',
            'G031', 'G032', 'G033', 'G034', 'G035',
            'G036', 'G037', 'G038', 'G039', 'G040',
            'G041', 'G042', 'G043', 'G044', 'G045',
            'R001', 'R002', 'R003', 'R004', 'R005',
            'R006', 'R007', 'R008', 'R009', 'R010');

        if ($query) {
            foreach ($query as $row) {
                $this->table->add_row('C' . (int) $row->id, $row->lk, $row->pr, $row->umur, $row->g1, $row->g2, $row->g3, $row->g4, $row->g5,
                    $row->g6, $row->g7, $row->g8, $row->g9, $row->g10,
                    $row->g11, $row->g12, $row->g13, $row->g14, $row->g15,
                    $row->g16, $row->g17, $row->g18, $row->g19, $row->g20,
                    $row->g21, $row->g22, $row->g23, $row->g24, $row->g25,
                    $row->g26, $row->g27, $row->g28, $row->g29, $row->g30,
                    $row->g31, $row->g32, $row->g33, $row->g34, $row->g35,
                    $row->g36, $row->g37, $row->g38, $row->g39, $row->g40,
                    $row->g41, $row->g42, $row->g43, $row->g44, $row->g45,
                    $row->r1, $row->r2, $row->r3, $row->r4, $row->r5,
                    $row->r6, $row->r7, $row->r8, $row->r9, $row->r10);
            }
        }
        $data['table'] = $this->table->generate();

        $data['page_header']   = $this->page_header;
        $data['breadcrumb']    = $this->page_header;
        $data['panel_heading'] = '';
        $data['page']          = '';
        $this->frontend->view('centroid_v', $data);
    }
}

/* End of file centroid_som.php */
/* Location: ./application/controllers/centroid_som.php */
