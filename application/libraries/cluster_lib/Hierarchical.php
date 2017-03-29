<?php
require_once('Distance.php');

class Hierarchical extends Distance{

    public $proximity_matrix = array();

    public function __construct(array $data, $convert = true)
    {
        if($convert == true)
        {
            for ($a = 0; $a < count($data); $a++) {
                for ($b = $a; $b < count($data); $b++) {
                    if($a == $b) $this->proximity_matrix[$a][$b] = INF;
                    else{
                        $this->proximity_matrix[$a][$b] = $this->manhattan($data[$a], $data[$b]);
                        $this->proximity_matrix[$b][$a] = $this->proximity_matrix[$a][$b];
                    }
                }
            } 
        }
        else
           $this->proximity_matrix = $data; 
    }

    /*convert data to proximity_matrix */
    public function get_proximity_matrix() {
        return $this->proximity_matrix;
    }


    public function get_minimum() {
        for ($a = 0; $a < count($this->proximity_matrix); $a++) {
            $min[$a] = min($this->proximity_matrix[$a]);
        }
        return min($min);
    }

    public function get_key_minimum($minimum) {
        for ($x = 0; $x < count($this->proximity_matrix); $x++) {
            $y = array_search($minimum, $this->proximity_matrix[$x]);
            if ($y !== false) {
                $result['x'] = $x;
                $result['y'] = $y;
                break;
            } else {
                continue;
            }
        }
        return $result;
    }

    //Single linkage (Cari Yang Minimum)
    public function single_linkage($merge_a, $merge_b) {
        for ($a = 0; $a < count($merge_a); $a++) {
            if($merge_a[$a] == INF || $merge_b[$a] == INF) $new_merge[$a] = INF;
            else{
                if ($merge_a[$a] < $merge_b[$a]) {
                    $new_merge[$a] = $merge_a[$a];
                } else {
                    $new_merge[$a] = $merge_b[$a];
                } 
            }
        }
        return $new_merge;
    }


    public function complete_linkage($merge_a, $merge_b) {
        for ($a = 0; $a < count($merge_a); $a++) {
            if($merge_a[$a] == INF || $merge_b[$a] == INF) $new_merge[$a] = INF;
            else{
                if ($merge_a[$a] > $merge_b[$a]) {
                    $new_merge[$a] = $merge_a[$a];
                } else {
                    $new_merge[$a] = $merge_b[$a];
                } 
            }
        }
        return $new_merge;
    }
    

    //transpose array multidimensional
    private function transpose() {
        $out = array();
        foreach ($this->proximity_matrix as $key => $subarr) {
            foreach ($subarr as $subkey => $subvalue) {
                $out[$subkey][$key] = $subvalue;
            }
        }
        return $out;
    }

    public function get_cluster(array $cluster, $key_merge = 0, $unset_key = 0)
    {
        $cluster[$key_merge] = $cluster[$key_merge].','.$cluster[$unset_key];
        unset($cluster[$unset_key]);            
        return array_values($cluster);
    }

    public function iterasi_array($new_merge, $key_merge = 0, $unset_key = 0) {
        //print_r($new_merge);
        $this->proximity_matrix[$key_merge] = $new_merge;
        //echo '------------ Awal';print_r($this->proximity_matrix);
        $this->proximity_matrix = $this->transpose($this->proximity_matrix);
        //echo '------------Akhir';print_r($this->proximity_matrix);
        $this->proximity_matrix[$key_merge] = $new_merge;
        unset($this->proximity_matrix[$unset_key]);
        $this->proximity_matrix = array_values($this->proximity_matrix); // Menata Index array nyz
        $this->proximity_matrix = $this->transpose($this->proximity_matrix);
        unset($this->proximity_matrix[$unset_key]);
        $this->proximity_matrix = array_values($this->proximity_matrix);
        return $this->proximity_matrix;
    }    
}