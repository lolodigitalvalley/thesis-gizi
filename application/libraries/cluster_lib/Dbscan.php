<?php
require_once 'Distance.php';

class Dbscan extends Distance
{

    protected $visited    = array();
    protected $data       = array();
    protected $clusters   = array();
    protected $noises     = array();
    protected $corePoints = array();
    protected $c_value    = array();
    protected $primary    = array();
    protected $epsilon;
    protected $minimumPoints;

    public function __construct(array $primary, array $data, $epsilon, $minimumPoints)
    {
        $this->primary       = $primary;
        $this->data          = $data;
        $this->epsilon       = $epsilon;
        $this->minimumPoints = $minimumPoints;

        foreach ($data as $index => $datum) {
            if (in_array($index, $this->visited)) {
                continue;
            }

            $this->visited[] = $index;
            $regionPoints    = $this->points_in_region($datum);
            if (count($regionPoints) >= $minimumPoints) {
                $this->corePoints[] = $index;
                $this->clusters[]   = $this->expand_cluster(array($index => $datum), $regionPoints);
            } else {
                $this->noises[$index] = $datum;
            }
        }
    }

    private function points_in_region($point)
    {
        $region = array();
        foreach ($this->data as $index => $datum) {
            if ($this->euclidean($point, $datum) <= $this->epsilon) {
                $region[$index] = $datum;
            }
        }
        return $region;
    }

    private function expand_cluster($point, $data)
    {
        $cluster = $point;
        foreach ($data as $index => $datum) {
            $indexes[] = $index;
        }

        $datum = reset($data);
        $index = reset($indexes);

        while ($datum) {
            $regionPoints = $this->points_in_region($datum);
            if (count($regionPoints) >= $this->minimumPoints) {
                foreach ($regionPoints as $key => $value) {
                    if (!in_array($key, $this->visited) && !in_array($key, $indexes)) {
                        $indexes[]  = $key;
                        $data[$key] = $value;
                    }
                }
            }
            if (!in_array($index, $this->visited)) {
                $cluster         = $this->join_clusters(array($index => $datum), $cluster);
                $this->visited[] = $index;
            }

            $datum = next($data);
            $index = next($indexes);
        }
        return $cluster;
    }

    private function join_clusters($one, $two)
    {
        return $one + $two;
    }

    public function getClusters()
    {
        $clusters = array();
        for ($i = 0; $i < count($this->clusters); $i++) {
            ksort($this->clusters[$i]);
            foreach ($this->clusters[$i] as $key => $value) {
                $clusters[$i][$key]      = $this->primary[$key];
                $this->c_value[$i][$key] = $value;
            }
        }
        return $clusters;
    }

    public function getNoises()
    {
        $noises = array();
        $i      = count($this->clusters);
        ksort($this->noises);
        foreach ($this->noises as $key => $value) {
            $noises[$key]            = $this->primary[$key];
            $this->c_value[$i][$key] = $value;
        }
        return $noises;
    }

    public function getClustersValue()
    {
        return $this->c_value;
    }

    public function getCorePoints()
    {
        $corePoints = array();
        foreach ($this->corePoints as $key => $value) {
            $corePoints[] = $this->data[$value];
        }
        return $corePoints;
    }

    public function getNoiseCentroids()
    {
        $centroids = array();
        if (!empty($this->noises)) {
            ksort($this->noises);
            $num    = count($this->noises);
            $numVar = count($this->data[0]);
            for ($i = 0; $i < $numVar; $i++) {
                $sum              = array_sum(array_column($this->noises, $i));
                $centroids[0][$i] = $sum / $num;
            }
        }
        return $centroids;
    }

    public function getCentroids()
    {
        $centroids = array();
        $numVar    = count($this->data[0]);

        foreach ($this->clusters as $key => $value) {
            $num = count($value);
            for ($i = 0; $i < $numVar; $i++) {
                $sum = 0;
                foreach ($value as $index => $datum) {
                    $sum += $datum[$i];
                }

                $centroids[$key][$i] = $sum / $num;
            }
        }
        return $centroids;
    }
}
