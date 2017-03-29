<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hierarchical_learning extends CI_Controller {

 	protected $page_header = 'Hierarchical Agglomerative Learning';

    public function __construct()
    {
        parent::__construct();

        $this->module = 'hierarchical_learning/';
        $this->url    = array('training'        => $this->module . 'training/',
                                'delete'        => $this->module . 'delete/',
                                'status'        => $this->module . 'status/',
                                'print'         => $this->module . 'print/');

        $this->load->model('data_model', 'data');
        $this->load->library('cluster_lib');
    }

	public function index()
	{
	   
       $data['page_header']   = $this->page_header;
       $data['panel_heading'] = 'Inisiasi Hierarchical Learning';
       $data['page'] = 'list';
       $this->frontend->view('hierarchical_v', $data);
	}

    public function training()
    {
        $row  = $this->data->fields('id, v1, v2, v3, v4, v5')->get_all();

        for($i=0, $data = array(); $i < count($row); $i++){            
            $data[$i][0] = $row[$i]->v1;
            $data[$i][1] = $row[$i]->v2;
            $data[$i][2] = $row[$i]->v3;
            $data[$i][3] = $row[$i]->v4;
            $data[$i][4] = $row[$i]->v5;
        }

        $numCluster = $this->input->post('numCluster');
        if(empty($numCluster)) $numCluster = 3;

        $methode = $this->input->post('methode');

        $hierarchical = new Hierarchical($data, true);

        $proximity_matrix = $hierarchical->get_proximity_matrix();
        
        for ($i=1, $cluster = array(); $i <= count($proximity_matrix); $i++) $cluster[$i-1] = 'D'.$i;

        $iterasi_min = count($proximity_matrix);
        $iterasi = 1;
 
        while (true) {         
            $minimum     = $hierarchical->get_minimum();
            $key_minimum = $hierarchical->get_key_minimum($minimum);

            $x = $key_minimum['x'];
            $y = $key_minimum['y'];

            $merge_a = $proximity_matrix[$x];
            $merge_b = $proximity_matrix[$y];

            if ($x < $y) {
                $key_merge = $x;
                $unset_key = $y;
            } else {
                $key_merge = $y;
                $unset_key = $x;
            }

            $cluster[$key_merge] = $cluster[$key_merge].', '.$cluster[$unset_key];
            unset($cluster[$unset_key]);
            $cluster = array_values($cluster); 
            

            $new_merge = ($methode == 'single') ? $hierarchical->single_linkage($merge_a, $merge_b) : $hierarchical->complete_linkage($merge_a, $merge_b);
            $proximity_matrix = $hierarchical->iterasi_array($new_merge, $key_merge, $unset_key);
            
            if ($iterasi_min == $numCluster+1) {
                break;
            }
            $iterasi_min--;
            $iterasi++;
        }
        
        $data['table'] = $this->lihat_hasil_hierarchical($proximity_matrix, $cluster);
        $data['cluster'] = $cluster;
        $data['page_header'] = $this->page_header;
        $data['panel_heading'] = 'Training With '.$iterasi.' iterasi and '.$numCluster.' Cluster';
        $data['page'] = 'training';

        $this->frontend->view('hierarchical_v', $data);
    }
    
    private function lihat_hasil_hierarchical($array, $cluster) {
        $table = '<table class="table table-striped table-bordered table-hover"><tr><th></th>';
        for ($i=1; $i <= count($cluster); $i++) $table .= '<th>C '.$i.'</th>';
        $table .= '</tr>';

        for ($a = 0; $a < count($array); $a++) {
            $table .= '<tr><td><b>C '.($a+1).'</b></td>';
            for ($b = 0; $b < count($array[$a]); $b++) $table .= '<td>'.$array[$a][$b].'</td>';
            $table .= '</tr>';
        }
        $table .= '</table>';
        return $table;
    }

}
