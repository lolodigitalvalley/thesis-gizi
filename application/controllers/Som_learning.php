<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Som_learning extends Pakar_Controller
{

    protected $page_header = 'Self Organizing Map';
    protected $metode      = 'som';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('gejala_model' => 'gejala', 'bobot_gejala_model' => 'bobot_gejala', 'basis_kasus_model' => 'basis_kasus', 'kasus_detail_model' => 'kasus_detail', 'klaster_model' => 'klaster', 'pusat_klaster_model' => 'pusat_klaster', 'inisiasi_klaster_model' => 'inisiasi_klaster', 'centroids_som_model' => 'centroid'));
        $this->load->library('cluster_lib');
    }

    public function index()
    {
        $data['page_header']   = $this->page_header;
        $data['breadcrumb']    = $this->page_header;
        $data['panel_heading'] = 'Inisiasi SOM';
        $data['page']          = 'index';
        $this->frontend->view('som_v', $data);
    }

    public function training()
    {
        $learningRate   = $this->input->post('learningRate');
        $toLearningRate = $this->input->post('toLearningRate');
        $numCluster     = $this->input->post('numCluster');
        $maxIterasi     = $this->input->post('maxIterasi');
        /*
        $weights         = $this->input->post('weights');
        $weights         = json_decode($weights);

        if(empty($weights)){
        $this->session->set_flashdata('error', 'You must generate weights');
        redirect(site_url('som_learning'), 'refresh');
        }

        if(empty($learningRate)) $learningRate = 0.5;
        if(empty($toLearningRate)) $toLearningRate = 0.6;
        if(empty($numCluster)) $numCluster = 10;
        if(empty($maxIterasi)) $maxIterasi = 10;
         */

        switch ($numCluster) {
            case 3:
                $weights = array(0 => array(0 => 0.2148, 1 => 0.0286, 2 => 0, 3 => 0, 4 => 0.0286, 5 => 0.0029, 6 => 0, 7 => 0.0114, 8 => 0.0517, 9 => 0.1143, 10 => 0.02, 11 => 0.1514, 12 => 0.0571, 13 => 0.4829, 14 => 0.0743, 15 => 0.0343, 16 => 0.0171, 17 => 0.1114, 18 => 0.0457, 19 => 0.1714, 20 => 0, 21 => 1),
                    1                  => array(0 => 0.4265, 1 => 0.0294, 2 => 0.2353, 3 => 0.0588, 4 => 0.0588, 5 => 0.0824, 6 => 0.0353, 7 => 0, 8 => 0.0294, 9 => 0.1647, 10 => 0, 11 => 0.1765, 12 => 0, 13 => 0, 14 => 0.0471, 15 => 0.0176, 16 => 0.1235, 17 => 0.0353, 18 => 0.0235, 19 => 1, 20 => 0, 21 => 1),
                    2                  => array(0 => 0.3972, 1 => 0.3111, 2 => 0.0667, 3 => 0.0889, 4 => 0.1556, 5 => 0.2667, 6 => 0.05, 7 => 0.0222, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0, 13 => 0, 14 => 0, 15 => 0, 16 => 0.0833, 17 => 0.0111, 18 => 0.0778, 19 => 0.9444, 20 => 1, 21 => 0));
                break;
                
            case 4:
                $weights = array(0 => array(0 => 0.2148, 1 => 0.0286, 2 => 0, 3 => 0, 4 => 0.0286, 5 => 0.0029, 6 => 0, 7 => 0.0114, 8 => 0.0517, 9 => 0.1143, 10 => 0.02, 11 => 0.1514, 12 => 0.0571, 13 => 0.4829, 14 => 0.0743, 15 => 0.0343, 16 => 0.0171, 17 => 0.1114, 18 => 0.0457, 19 => 0.1714, 20 => 0, 21 => 1),
                    1                  => array(0 => 0.4265, 1 => 0.0294, 2 => 0.2353, 3 => 0.0588, 4 => 0.0588, 5 => 0.0824, 6 => 0.0353, 7 => 0, 8 => 0.0294, 9 => 0.1647, 10 => 0, 11 => 0.1765, 12 => 0, 13 => 0, 14 => 0.0471, 15 => 0.0176, 16 => 0.1235, 17 => 0.0353, 18 => 0.0235, 19 => 1, 20 => 0, 21 => 1),
                    2                  => array(0 => 0.2861, 1 => 0, 2 => 0.1, 3 => 0.2667, 4 => 0.1167, 5 => 0.4, 6 => 0.05, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0, 13 => 0, 14 => 0, 15 => 0, 16 => 0.15, 17 => 0, 18 => 0, 19 => 0.8333, 20 => 1, 21 => 0),
                    3                  => array(0 => 0.4528, 1 => 0.4667, 2 => 0.05, 3 => 0, 4 => 0.175, 5 => 0.2, 6 => 0.05, 7 => 0.0333, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0, 13 => 0, 14 => 0, 15 => 0, 16 => 0.05, 17 => 0.0167, 18 => 0.1167, 19 => 1, 20 => 1, 21 => 0)); 
                break;

            case 5:
                $weights = array(0 => array(0 => 0.2904, 1 => 0.0192, 2 => 0, 3 => 0.0385, 4 => 0.0577, 5 => 0.0308, 6 => 0, 7 => 0.0154, 8 => 0.0769, 9 => 0.1462, 10 => 0, 11 => 0.1615, 12 => 0.0231, 13 => 0.4115, 14 => 0.0577, 15 => 0.0231, 16 => 0.0154, 17 => 0, 18 => 0.0385, 19 => 0.3462, 20 => 0, 21 => 1),
                    1                  => array(0 => 0.3967, 1 => 0.08, 2 => 0.28, 3 => 0, 4 => 0.0333, 5 => 0.1, 6 => 0.08, 7 => 0, 8 => 0, 9 => 0.0933, 10 => 0, 11 => 0.1667, 12 => 0, 13 => 0, 14 => 0.04, 15 => 0, 16 => 0.22, 17 => 0, 18 => 0.0133, 19 => 0.9333, 20 => 0.2667, 21 => 0.7333),
                    2                  => array(0 => 0.2778, 1 => 0, 2 => 0, 3 => 0.5333, 4 => 0.2333, 5 => 0.5333, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0, 13 => 0, 14 => 0, 15 => 0, 16 => 0, 17 => 0, 18 => 0, 19 => 1, 20 => 1, 21 => 0),
                    3                  => array(0 => 0.4561, 1 => 0.4455, 2 => 0, 3 => 0, 4 => 0.1909, 5 => 0.2182, 6 => 0.0273, 7 => 0.0364, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0, 13 => 0, 14 => 0, 15 => 0, 16 => 0.0273, 17 => 0.0182, 18 => 0.1273, 19 => 1, 20 => 1, 21 => 0),
                    4                  => array(0 => 0.1711, 1 => 0.0333, 2 => 0.0667, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0.0333, 9 => 0.1067, 10 => 0.0467, 11 => 0.1067, 12 => 0.0933, 13 => 0.4133, 14 => 0.0867, 15 => 0.06, 16 => 0.0133, 17 => 0.3, 18 => 0.0533, 19 => 0.2, 20 => 0, 21 => 1));
                break;
            case 7:
                $weights = array(0 => array(0 => 0.2378, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0.0067, 6 => 0, 7 => 0, 8 => 0.0333, 9 => 0.2667, 10 => 0.0467, 11 => 0.2667, 12 => 0.0467, 13 => 0.5133, 14 => 0.04, 15 => 0, 16 => 0.04, 17 => 0.04, 18 => 0.04, 19 => 0, 20 => 0, 21 => 1),
                    1                  => array(0 => 0.35, 1 => 0.14, 2 => 0.24, 3 => 0, 4 => 0, 5 => 0.16, 6 => 0.12, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0, 13 => 0, 14 => 0, 15 => 0, 16 => 0.3, 17 => 0, 18 => 0.04, 19 => 0.8, 20 => 1, 21 => 0),
                    2                  => array(0 => 0.2778, 1 => 0, 2 => 0, 3 => 0.5333, 4 => 0.2333, 5 => 0.5333, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0, 13 => 0, 14 => 0, 15 => 0, 16 => 0, 17 => 0, 18 => 0, 19 => 1, 20 => 1, 21 => 0),
                    3                  => array(0 => 0.4567, 1 => 0.49, 2 => 0, 3 => 0, 4 => 0.21, 5 => 0.24, 6 => 0.03, 7 => 0.04, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0, 13 => 0, 14 => 0, 15 => 0, 16 => 0, 17 => 0.02, 18 => 0.12, 19 => 1, 20 => 1, 21 => 0),
                    4                  => array(0 => 0.1, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0.1111, 9 => 0, 10 => 0, 11 => 0.0889, 12 => 0.0778, 13 => 0.6222, 14 => 0.0333, 15 => 0.1333, 16 => 0, 17 => 0.2667, 18 => 0.0444, 19 => 0, 20 => 0, 21 => 1),
                    5                  => array(0 => 0.1733, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0, 13 => 0, 14 => 0.3, 15 => 0, 16 => 0, 17 => 0.12, 18 => 0.12, 19 => 0, 20 => 0, 21 => 1),
                    6                  => array(0 => 0.4101, 1 => 0.0652, 2 => 0.1739, 3 => 0.0435, 4 => 0.087, 5 => 0.0609, 6 => 0.0261, 7 => 0.0174, 8 => 0.0435, 9 => 0.1217, 10 => 0, 11 => 0.1522, 12 => 0.0261, 13 => 0.1565, 14 => 0.0435, 15 => 0.013, 16 => 0.0913, 17 => 0.0391, 18 => 0.0174, 19 => 1, 20 => 0, 21 => 1));
                break;
        }

        $newWeights = $weights;
        $lRate      = $learningRate;

        $gejala = $this->gejala->fields('kode_gejala')->get_all();

        $query        = $this->bobot_gejala->get_all();
        $bobot_gejala = array();
        foreach ($query as $row) {
            $bobot_gejala[$row->kode_gejala][$row->kode_penyakit] = $row->bobot;
        }

        $query = $this->basis_kasus->with_kasus_detail('fields:kode_gejala')->get_all();

        $records = array();
        $primary = array();
        $i       = 0;
        foreach ($query as $row) {
            $primary[$i]    = $row->kode_kasus;
            $records[$i][0] = $this->norm_usia($row->usia);

            $kasus_detail = array();
            if (!empty($row->kasus_detail)) {
                foreach ($row->kasus_detail as $value) {
                    $kasus_detail[] = $value->kode_gejala;
                }
            }

            $j = 1;
            foreach ($gejala as $value) {
                $records[$i][$j++] = (in_array($value->kode_gejala, $kasus_detail)) ? $bobot_gejala[$value->kode_gejala][$row->kode_penyakit] : 0;
            }

            $i++;
        }

        $this->benchmark->mark('code_start');
        for ($iterasi = 1; $iterasi <= $maxIterasi; $iterasi++) {
            $som = new SOM($primary, $records, $newWeights, $numCluster, $learningRate);

            $newWeights = array();
            $tmpWeights = array();
            $clusters   = array();

            $newWeights = $som->getNewWeight();

            if ($newWeights == $tmpWeights) {
                break;
            } else {
                $tmpWeights = $newWeights;
            }

            $learningRate = $learningRate * $toLearningRate;
        }

        $clusters               = $som->getClusters();
        $silhoutteIndex         = new Silhoutte_index();
        $data['silhoutteIndex'] = $silhoutteIndex->getValue($som->getClustersValue());

        $this->benchmark->mark('code_end');

        $data['page_header']    = $this->page_header;
        $data['panel_heading']  = 'Training dengan ' . $maxIterasi . ' Iterasi, ' . $numCluster . ' Cluster, Learning rate ' . $lRate . ' to ' . $toLearningRate . ' dan Silhoutte index ' . $data['silhoutteIndex'];
        $data['table']          = $this->lihat_hasil_som($newWeights, $numCluster);
        $data['clusters']       = $clusters;
        $data['centroids']      = $newWeights;
        $data['weights']        = $weights;
        $data['gejala']         = $gejala;
        $data['maxIterasi']     = $maxIterasi;
        $data['learningRate']   = $lRate;
        $data['toLearningRate'] = $toLearningRate;

        $data['elapsed_time'] = $this->benchmark->elapsed_time('code_start', 'code_end');

        $data['page'] = 'training';

        $this->frontend->view('som_v', $data);
    }

    public function save_training()
    {
        $clusters   = unserialize($this->input->post('clusters'));
        $centroids  = unserialize($this->input->post('centroids'));
        $weights    = unserialize($this->input->post('weights'));
        $gejala     = unserialize($this->input->post('gejala'));
        $maxIterasi = unserialize($this->input->post('maxIterasi'));

        $learningRate   = unserialize($this->input->post('learningRate'));
        $toLearningRate = unserialize($this->input->post('toLearningRate'));
        $silhoutteIndex = unserialize($this->input->post('silhoutteIndex'));

        $n = count($clusters);

        $query = $this->klaster->delete(array('metode' => $this->metode));

        $query = $this->pusat_klaster->delete(array('metode' => $this->metode));

        for ($i = 0; $i < $n; $i++) {
            $rows = array();
            foreach ($clusters[$i] as $value) {
                $rows[] = array('kode_kasus' => $value, 'metode' => $this->metode, 'klaster' => ($i + 1));
            }

            $this->klaster->insert($rows);

            $rows    = array();
            $rows[0] = array('klaster' => ($i + 1), 'no' => 1, 'metode' => $this->metode, 'atribut' => 'usia', 'bobot' => $centroids[$i][0]);
            $j       = 1;
            foreach ($gejala as $value) {
                $rows[$j] = array('klaster' => ($i + 1), 'no' => $j + 1, 'metode' => $this->metode, 'atribut' => $value->kode_gejala, 'bobot' => $centroids[$i][$j++]);
            }

            $this->pusat_klaster->insert($rows);
        }

        $this->inisiasi_klaster->update(array('jumlah_klaster' => count($clusters), 'max_iterasi' => $maxIterasi, 'learning_rate' => $learningRate, 'to_learning_rate' => $toLearningRate, 'silhoutte_index' => $silhoutteIndex), array('metode' => $this->metode));

        /*
        for ($i = 0, $row = array(); $i < count($centroids); $i++) {
        $row[$i]['id']   = $i + 1;
        $row[$i]['usia'] = $centroids[$i][0];
        $row[$i]['g1']   = $centroids[$i][1];
        $row[$i]['g2']   = $centroids[$i][2];
        $row[$i]['g3']   = $centroids[$i][3];
        $row[$i]['g4']   = $centroids[$i][4];
        $row[$i]['g5']   = $centroids[$i][5];
        $row[$i]['g6']   = $centroids[$i][6];
        $row[$i]['g7']   = $centroids[$i][7];
        $row[$i]['g8']   = $centroids[$i][8];
        $row[$i]['g9']   = $centroids[$i][9];
        $row[$i]['g10']  = $centroids[$i][10];
        $row[$i]['g11']  = $centroids[$i][11];
        $row[$i]['g12']  = $centroids[$i][12];
        $row[$i]['g13']  = $centroids[$i][13];
        $row[$i]['g14']  = $centroids[$i][14];
        $row[$i]['g15']  = $centroids[$i][15];
        $row[$i]['g16']  = $centroids[$i][16];
        $row[$i]['g17']  = $centroids[$i][17];
        $row[$i]['g18']  = $centroids[$i][18];
        $row[$i]['g19']  = $centroids[$i][19];
        $row[$i]['g20']  = $centroids[$i][20];
        $row[$i]['g21']  = $centroids[$i][21];
        }

        $this->centroid->drop_data();
        $this->centroid->insert($row);
        */
        echo array("status" => true);
    }

    public function lihat_hasil_som($centroids, $numCluster)
    {
        $gejala = $this->gejala->fields('kode_gejala')->get_all();

        if (count($centroids) <= 0) {
            return false;
        }

        $table = '<table class="table table-striped table-bordered table-hover"><tr><th>Klaster</th><th>Usia</th>';
        foreach ($gejala as $value) {
            $table .= '<th>' . $value->kode_gejala . '</th>';
        }
        $table .= '</tr>';

        for ($a = 0; $a < $numCluster; $a++) {
            $table .= '<tr><td width="7px"><b>C ' . ($a + 1) . '</b></td>';
            for ($b = 0; $b < count($centroids[0]); $b++) {
                $table .= '<td>' . round($centroids[$a][$b], 5) . '</td>';
            }

            $table .= '</tr>';
        }
        $table .= '</table>';

        return $table;
    }

    private function norm_usia($usia)
    {
        $max_usia    = $this->basis_kasus->get_max()->max_usia;
        $min_usia    = $this->basis_kasus->get_min()->min_usia;

        return ($usia - $min_usia) / ($max_usia - $min_usia);
    }
}
