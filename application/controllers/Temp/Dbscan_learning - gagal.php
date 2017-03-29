<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dbscan_learning extends CI_Controller {

 	protected $page_header = 'DBSCAN';
    protected $visited = array();

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('data_dbscan_model' => 'data', 'centroid_dbscan_model' => 'centroid'));
        $this->load->library('cluster_lib');
    }

	public function index()
	{
	   $data['page_header']   = $this->page_header;
       $data['panel_heading'] = 'Inisiasi DBSCAN';
       $data['page'] = 'index';
       $this->frontend->view('dbscan_v', $data);
	}

    public function training()
    {
        $epsilon       = $this->input->post('epsilon');
        $minimumPoints = $this->input->post('minimumPoints');

        
        if(empty($epsilon)){
            $this->session->set_flashdata('error', 'You must fill epsilon');
            redirect(site_url('dbscan_learning'), 'refresh');
        }

        if(empty($minimumPoints)) $minimumPoints = 10;                

        $rows  = $this->data->fields('kode_kasus, umur, g1, g2, g3, g4, g5, g6, g7, g8, g9, g10, g11, g12, g13, g14, g15, g16, g17, g18, g19, g20, g21')->get_all();

        for($i=0, $records = array(), $primary = array(); $i < count($rows); $i++){            
            $primary[$i]    = $rows[$i]->kode_kasus;
            $records[$i][0] = $rows[$i]->umur;
            $records[$i][1] = $rows[$i]->g1;
            $records[$i][2] = $rows[$i]->g2;
            $records[$i][3] = $rows[$i]->g3;
            $records[$i][4] = $rows[$i]->g4;
            $records[$i][5] = $rows[$i]->g5;
            $records[$i][6] = $rows[$i]->g6;
            $records[$i][7] = $rows[$i]->g7;
            $records[$i][8] = $rows[$i]->g8;
            $records[$i][9] = $rows[$i]->g9;
            $records[$i][10] = $rows[$i]->g10;
            $records[$i][11] = $rows[$i]->g11;
            $records[$i][12] = $rows[$i]->g12;
            $records[$i][13] = $rows[$i]->g13;
            $records[$i][14] = $rows[$i]->g14;
            $records[$i][15] = $rows[$i]->g15;
            $records[$i][16] = $rows[$i]->g16;
            $records[$i][17] = $rows[$i]->g17;
            $records[$i][18] = $rows[$i]->g18;
            $records[$i][19] = $rows[$i]->g19;
            $records[$i][20] = $rows[$i]->g20;
            $records[$i][21] = $rows[$i]->g21;
        }


        //$dbscan = new Dbscan($primary, $records, 1, 5);
        $dbscan = $this->ll_dbscan($records, 1, 5);
        print_r($dbscan);
        exit;

        $data['clusters']      = $dbscan->getClusters();
        $data['noises']        = $dbscan->getNoises();
        $data['means']         = $dbscan->getMeans();

        $data['page_header']   = $this->page_header;
        $data['panel_heading'] = 'Training With epsilon '.$epsilon.' AND Minimum Points '. $minimumPoints;
        $data['table']         = $this->lihat_hasil_dbscan($data['means']);
        $data['page']          = 'training';

        $this->frontend->view('dbscan_v', $data);
    }

    public function save_training()
    {
        $clusters  = unserialize($this->input->post('clusters'));
        $newWeight = unserialize($this->input->post('newWeight'));

        ksort($clusters);        
        for ($i=0; $i < count($clusters) ; $i++) { 
            $cluster = array();
            $cluster = explode(', D', $clusters[$i]);
            $cluster[0] = substr($cluster[0], 1);

            $this->data->where('id', $cluster)->update(array('cluster' => ($i+1)));           
        }

        for ($i=0, $row = array(); $i < count($newWeight); $i++) { 
            $row[$i]['id'] = $i+1;
            $row[$i]['v1'] = $newWeight[$i][0];
            $row[$i]['v2'] = $newWeight[$i][1];
            $row[$i]['v3'] = $newWeight[$i][2];
            $row[$i]['v4'] = $newWeight[$i][3];
            $row[$i]['v5'] = $newWeight[$i][4]; 
        }
        $this->centroid->drop_data();
        $this->centroid->insert($row); 

        echo array("status" => true);      
    }

    function lihat_hasil_dbscan($means)
    {
        $table = '<table class="table table-striped table-bordered table-hover"><tr><th></th>';
        for ($i=1; $i <= count($means[0]); $i++) $table .= '<th>Var '.$i.'</td>';
        $table .= '</tr>';
        
        for ($a = 0; $a < count($means); $a++) {
            $table .= '<tr><td><b>C '.($a+1).'</b></td>';
            for ($b = 0; $b < count($means[0]); $b++) $table .= '<td>'.round($means[$a][$b], 4).'</td>';
            $table .= '</tr>';
        }
        $table .= '</table>';

        return $table;
    }

    private function ll_dbscan($data, $e, $minimumPoints) {
       $clusters = array();

       foreach($data as $index=>$datum) {
          if(in_array($index, $this->visited))
             continue;
          
          $this->visited[] = $index;

          $regionPoints = $this->_ll_points_in_region(array($index=>$datum), $data, $e);
          if(count($regionPoints) >= $minimumPoints) {
             $clusters[] = $this->_ll_expand_cluster(array($index=>$datum), $regionPoints, $data, $e, $minimumPoints);
          }
       }
       
       return $clusters;
    }
    function _ll_points_in_region($point, $data, $epsilon) {
       $region = array();
       foreach($data as $index=>$datum) {
          if($this->ll_euclidian_distance($point, $datum) < $epsilon) {
             $region[$index] = $datum;
          }
       }
       return $region;
    }

    function _ll_expand_cluster($point, $regionPoints, $data, $epsilon, $minimumPoints) {
       $cluster = $point;

       foreach($regionPoints as $index=>$datum) {
          if(!in_array($index, $this->visited)) {
             $this->visited[] = $index;
             $regionPoints = $this->_ll_points_in_region(array($index=>$datum), $data, $epsilon);

             if(count($regionPoints) > $minimumPoints) {
                $cluster = $this->_ll_join_clusters($regionPoints, $cluster);
             }
          }

          // supposed to check if it belongs to any clusters here.
          // only add the point if it isn't clustered yet.
          $cluster[] = array($index=>$datum);
       }
       return $cluster;
    }

    function _ll_join_clusters($one, $two) {
       return $one + $two;
    }

    function ll_euclidian_distance($a, $b) {
       if(count($a) != count($b))
          return false;

       $distance = 0;
       for($i=0;$i<count($a);$i++)
       {
          $distance += pow($a[$i] - $b[$i], 2);
       }

       return sqrt($distance);
    }
}