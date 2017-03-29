<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reasoning extends CI_Controller {


 	protected $page_header = 'Reasoning';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('data_som_model' => 'data_som', 'data_dbscan_model' => 'data_dbscan', 'centroid_som_model' => 'centroid_som', 'centroid_dbscan_model' => 'centroid_dbscan', 'gejala_model' => 'gejala'));
        $this->load->library('cluster_lib');
    }

    public function index()
    {  	
        $data['page_header']   = $this->page_header;
       	$data['panel_heading'] = 'Input New Case';
       	$data['page']          = 'index';
        $data['centroids_som']    = $this->get_centroids_som();
        $data['centroids_dbscan'] = $this->get_centroids_dbscan();
        $data['gejala']        = $this->gejala->get_all();
       	$this->frontend->view('reasoning_v', $data);
    }

    public function retrive()
    {          
        $indexing  = $this->input->post('indexing');
        if($indexing !='non-indexing'){
            $centroids = ($indexing == 'som') ? unserialize($this->input->post('centroids_som')) : unserialize($this->input->post('centroids_dbscan'));
        }        
        
        $sex       = ($this->input->post('sex') == 'L') ? 0 : 1;
        $new_case  = array ('kode_kasus'  => $this->input->post('kode_kasus'),
                            'nama_pasien' => $this->input->post('nama_pasien'),
                            'sex' => $sex,
                            'age' => $this->input->post('age'));

        $age       = $this->norm_age($this->input->post('age'));
        $gejala    = $this->input->post('gejala');

        for ($i=1, $index = array(); $i <= count($gejala) ; $i++) { 
            $index[$i] = (int)substr($gejala[$i-1], 2);
        }

        $rows = $this->gejala->fields('kode_gejala, p1, p2, p3')->where('kode_gejala', $gejala)->get_all();

        $newCase = array();
        $newCase[1][0] = $age;
        $newCase[2][0] = $age;
        $newCase[3][0] = $age;

        for ($i=1, $j = 0; $i < 22 ; $i++) { 
            if(in_array($i, $index)){
                $newCase[1][$i] = $rows[$j]->p1;
                $newCase[2][$i] = $rows[$j]->p2;
                $newCase[3][$i] = $rows[$j]->p3;
                $j++;
            }
            else{
                $newCase[1][$i] = 0;
                $newCase[2][$i] = 0;
                $newCase[3][$i] = 0;
            }
        }

        /*
        for ($i=1; $i < 4; $i++) { 
            $knn = new knn($centroids, $newCase[$i], 1);
            $d[$i]['cluster'] = $knn->get_nn() + 1;               
            $d[$i]['distance'] = $knn->get_distance();
        }
        print_r($d);
        exit;
        */

        $knn = new knn($centroids, $newCase[1], 1);            
        $nearestCluster  = $knn->get_nn() + 1;
        $nearestDistance = $knn->get_distance();
        $disease = 1;
        for ($i=2; $i < 4; $i++) { 
            $knn = new knn($centroids, $newCase[$i], 1);               
            if($knn->get_distance() < $nearestDistance){
                $nearestCluster  = $knn->get_nn() + 1;
                $nearestDistance = $knn->get_distance();
                $disease = $i;
            }
        }



        $fields = 'kode_kasus, kode_penyakit, umur, g1, g2, g3, g4, g5, g6, g7, g8, g9, g10, g11, g12, g13, g14, g15, g16, g17, g18, g19, g20, g21';
        $query  = ($indexing == 'som') ? $this->data_som->fields($fields)->where('cluster', $nearestCluster)->get_all() : $this->data_dbscan->fields($fields)->where('cluster', $nearestCluster)->get_all();
        
        $i = 0;
        foreach ($query as $row) {
            $oldCase[$i][0] = $row->umur;
            $oldCase[$i][1] = $row->g1;
            $oldCase[$i][2] = $row->g2;
            $oldCase[$i][3] = $row->g3;
            $oldCase[$i][4] = $row->g4;
            $oldCase[$i][5] = $row->g5;
            $oldCase[$i][6] = $row->g6;
            $oldCase[$i][7] = $row->g7;
            $oldCase[$i][8] = $row->g8;
            $oldCase[$i][9] = $row->g9;
            $oldCase[$i][10] = $row->g10;
            $oldCase[$i][11] = $row->g11;
            $oldCase[$i][12] = $row->g12;
            $oldCase[$i][13] = $row->g13;
            $oldCase[$i][14] = $row->g14;
            $oldCase[$i][15] = $row->g15;
            $oldCase[$i][16] = $row->g16;
            $oldCase[$i][17] = $row->g17;
            $oldCase[$i][18] = $row->g18;
            $oldCase[$i][19] = $row->g19;
            $oldCase[$i][20] = $row->g20;
            $oldCase[$i][21] = $row->g21;
            $i++;
        }

        $knn   = new knn($oldCase, $newCase[$disease], 1);
        $index = $knn->get_nn();
        $nearestCase = $query[$index]->kode_kasus;

        echo json_encode(array('nearestCluster'=>$nearestCluster, 'nearestCase'=> $nearestCase, 'row'=>$query[$index], 'indexing'=>$indexing));
    }

    private function get_centroids_som(){
        $query  = $this->centroid_som->fields('umur, g1, g2, g3, g4, g5, g6, g7, g8, g9, g10, g11, g12, g13, g14, g15, g16, g17, g18, g19, g20, g21')->get_all();

        $i = 0;
        foreach ($query as $row) {
            $centroids[$i][0] = $row->umur;
            $centroids[$i][1] = $row->g1;
            $centroids[$i][2] = $row->g2;
            $centroids[$i][3] = $row->g3;
            $centroids[$i][4] = $row->g4;
            $centroids[$i][5] = $row->g5;
            $centroids[$i][6] = $row->g6;
            $centroids[$i][7] = $row->g7;
            $centroids[$i][8] = $row->g8;
            $centroids[$i][9] = $row->g9;
            $centroids[$i][10] = $row->g10;
            $centroids[$i][11] = $row->g11;
            $centroids[$i][12] = $row->g12;
            $centroids[$i][13] = $row->g13;
            $centroids[$i][14] = $row->g14;
            $centroids[$i][15] = $row->g15;
            $centroids[$i][16] = $row->g16;
            $centroids[$i][17] = $row->g17;
            $centroids[$i][18] = $row->g18;
            $centroids[$i][19] = $row->g19;
            $centroids[$i][20] = $row->g20;
            $centroids[$i][21] = $row->g21;
            $i++;
        }

        return $centroids;
    }

    private function get_centroids_dbscan(){
        $query  = $this->centroid_dbscan->fields('umur, g1, g2, g3, g4, g5, g6, g7, g8, g9, g10, g11, g12, g13, g14, g15, g16, g17, g18, g19, g20, g21')->get_all();

        $i = 0;
        foreach ($query as $row) {
            $centroids[$i][0] = $row->umur;
            $centroids[$i][1] = $row->g1;
            $centroids[$i][2] = $row->g2;
            $centroids[$i][3] = $row->g3;
            $centroids[$i][4] = $row->g4;
            $centroids[$i][5] = $row->g5;
            $centroids[$i][6] = $row->g6;
            $centroids[$i][7] = $row->g7;
            $centroids[$i][8] = $row->g8;
            $centroids[$i][9] = $row->g9;
            $centroids[$i][10] = $row->g10;
            $centroids[$i][11] = $row->g11;
            $centroids[$i][12] = $row->g12;
            $centroids[$i][13] = $row->g13;
            $centroids[$i][14] = $row->g14;
            $centroids[$i][15] = $row->g15;
            $centroids[$i][16] = $row->g16;
            $centroids[$i][17] = $row->g17;
            $centroids[$i][18] = $row->g18;
            $centroids[$i][19] = $row->g19;
            $centroids[$i][20] = $row->g20;
            $centroids[$i][21] = $row->g21;
            $i++;
        }

        return $centroids;
    }

    private function norm_age($age){
        return (60-$age)/60;
    }

    
}
