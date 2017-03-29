<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reasoning extends CI_Controller {


 	protected $page_header = 'Reasoning';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('data_model' => 'data', 'centroid_model' => 'centroid'));
        $this->load->library('cluster_lib');
    }

    public function index()
    {
    	$data['page_header']   = $this->page_header;
       	$data['panel_heading'] = 'Input New Case';
       	$data['page'] = 'index';
       	$this->frontend->view('reasoning_v', $data);
    }

    public function similaritas()
    {
    	$var  = $this->input->post('var');
    	//$var  = array(0=>0.32,1=>0.43,2=>0.79,3=>0.28,4=>0.09);
    	$rows = $this->centroid->fields('v1, v2, v3, v4, v5')->get_all();

    	for($i=0, $centroid = array(); $i < count($rows); $i++){            
            $centroid[$i][0] = $rows[$i]->v1;
            $centroid[$i][1] = $rows[$i]->v2;
            $centroid[$i][2] = $rows[$i]->v3;
            $centroid[$i][3] = $rows[$i]->v4;
            $centroid[$i][4] = $rows[$i]->v5;
        }

        for ($i=0, $newData = array(); $i < count($var) ; $i++) { 
        	$newData[$i] = $var[$i];
        }

    	$knn  = new knn($centroid, $newData, 1);
        $nearestCluster = $knn->get_nn() + 1;

        $rows = $this->data->fields('id, v1, v2, v3, v4, v5')->where('cluster', $nearestCluster)->get_all();
        
        for($i=0, $data = array(); $i < count($rows); $i++){            
            $data[$i][0] = $rows[$i]->v1;
            $data[$i][1] = $rows[$i]->v2;
            $data[$i][2] = $rows[$i]->v3;
            $data[$i][3] = $rows[$i]->v4;
            $data[$i][4] = $rows[$i]->v5;
        }

        $knn   = new knn($data, $newData, 1);
        $index = $knn->get_nn();
        $nearestData = $rows[$index]->id;

    	echo json_encode(array('nearestCluster'=>$nearestCluster, 'nearestData'=> $nearestData, 'row'=>$rows[$index]));
    }

    
}
