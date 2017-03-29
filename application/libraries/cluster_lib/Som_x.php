<?php
require_once('Distance.php');

class SOM extends Distance{

    public $weight = array(), $numCluster;

    public function __construct(array $weight, $numCluster)
    {
        $this->numCluster = $numCluster;
        $this->weight     = $weight;
    }

    public function getSmallestIndex(array $data)
    {
        $shortest = INF;
        $smallestIndex = null;

        for ($k = 0; $k < $this->numCluster; $k++) {
            $distance = $this->squaredEuclidean($this->weight[$k], $data);

            if ($distance < $shortest) {
                $shortest = $distance;
                $smallestIndex = $k;
            }
        }
        return $smallestIndex;
    }
    
    private function calculateWeight($oldWeight, $data, $learningRate)
    {
        $newWeight = $oldWeight + $learningRate*($data-$oldWeight);
        return $newWeight;
    }

    public function calculateNewWeight(array $data, $smallestIndex, $learningRate)
    {
        for ($i = 0; $i < count($this->weight[$smallestIndex]); $i++) {
            $newWeight[$i] = $this->calculateWeight($this->weight[$smallestIndex][$i], $data[$i], $learningRate);
        }
        return $newWeight;
    }

    public function getNewWeight(array $newWeight, $smallestIndex)
    {
        for ($i = 0; $i < count($this->weight[$smallestIndex]); $i++) {
            $this->weight[$smallestIndex][$i] = $newWeight[$i];
        }
        return $this->weight;
    }
}
