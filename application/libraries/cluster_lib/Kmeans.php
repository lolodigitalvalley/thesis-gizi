<?php

require_once('Distance.php');

class Kmeans extends Distance
{

    protected $primary = array();
    protected $k;
    protected $data = array();
    protected $clusters  = array();
    protected $centroids = array();

    public function __construct(array $primary, array $data, $k, $iterasi)
    {
        $this->k    = $k;
        $this->data = $data;        
        $this->primary = $primary;

        if ($this->k > count($this->data)) {
            return false;
        }

        $centroids = $this->init_centroids($this->data);

        $continue  = false;
        $n = 0;

        do {
            $belongs_to = array();
            for ($i = 0; $i < count($this->data); $i++) {
                // I reversed the order here (to store the centroids as indexes in the array) for complexity reasons.
                $index                = $this->closest_centroid($this->data[$i], $centroids);
                $belongs_to[$index][] = $i;
            }
            $old_centroids = $centroids;
            $centroids     = $this->reposition_centroids($centroids, $belongs_to);
            $continue      = ($old_centroids == $centroids || $n == $iterasi) ? false : true;
            $n++;
        } while ($continue);

        $this->clusters = $belongs_to;
        $this->centroids = $centroids;
    }

    // initializes the location of the centroids to a random data point.
    private function init_centroids($data)
    {
        if ($this->k > count($data)) {
            return false;
        }

        $centroids = array();
        for ($i = 0; $i < $this->k; $i++) {
            $temp_array = array();
            $random     = rand(0, count($data) - 1); // random row from data.
            $temp_array = $data[$random];
            unset($data[$random]); // don't allow the same centroid to be set twice.
            $data = array_values($data); // renumber the array

            $centroids[] = $temp_array;
        }

        return $centroids;
    }

    private function init_centroids2($data)
    {
        if ($this->k > count($data)) {
            return false;
        }
        $centroids = array();
        $centroids = array_slice($data, 0, $this->k); //ambil K data

        return $centroids;
    }

    private function closest_centroid($x, $centroids)
    {
        $smallest          = null;
        $smallest_distance = PHP_INT_MAX;
        foreach ($centroids as $index => $centroid) {
            $distance = $this->squaredEuclidean($x, $centroid);
            if ($distance < $smallest_distance) {
                $smallest          = $index;
                $smallest_distance = $distance;
            }
        }
        return $smallest;
    }

    // repositions the centroids to the average of all their member elements
    private function reposition_centroids($centroids, $belongs_to)
    {
        for ($index = 0; $index < count($centroids); $index++) {
            $my_observations = $belongs_to[$index];
            $my_obs_values   = array();
            foreach ($my_observations as $obs) {
                $my_obs_values[] = $this->data[$obs];
            }
            $my_obs_values = $this->transpose($my_obs_values);
            $new_position  = array();
            foreach ($my_obs_values as $new_dimension) {
                // compute the average of all the observation's positions for the centroids new position.
                $new_position[] = array_sum($new_dimension) / count($new_dimension);
            }

            $centroids[$index] = $new_position;
        }
        return $centroids;
    }

    private function transpose($rows)
    {
        $columns = array();
        for ($i = 0; $i < count($rows); $i++) {
            for ($k = 0; $k < count($rows[$i]); $k++) {
                $columns[$k][$i] = $rows[$i][$k];
            }
        }
        return $columns;
    }

    public function getClusters()
    {
        $clusters = array();         
        for ($i=0; $i < count($this->clusters) ; $i++) {
            ksort($this->clusters[$i]);
            foreach ($this->clusters[$i] as $value) {
                $clusters[$i][$value] = $this->primary[$value];  
            }
        }
        return $clusters;
    }

    public function getCentroids()
    {
        return $this->centroids;
    }

}
