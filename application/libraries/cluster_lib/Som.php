<?php
require_once('Distance.php');

class SOM extends Distance{
 
    protected $weight = array();
    protected $numCluster;
    protected $learningRate;

    protected $cluster = array();
    protected $c_value = array();

    public function __construct(array $primary, array $data, array $weight, $numCluster, $learningRate)
    {
        $this->numCluster   = $numCluster;
        $this->weight       = $weight;
        $this->learningRate = $learningRate;
        $numData = count($data);

        for ($i=0; $i < $numData; $i++) 
        { 
            $smallestIndex       = $this->getSmallestIndex($data[$i]);
            $calculateNewWeight  = $this->newWeight($data[$i], $smallestIndex);
            $this->setNewWeight($calculateNewWeight, $smallestIndex);
            $this->cluster[$smallestIndex][$i] = $primary[$i];
            $this->c_value[$smallestIndex][$i] = $data[$i];

            /*
            if(!empty($this->cluster[$smallestIndex])) 
                $this->cluster[$smallestIndex] .= ', '.$primary[$i];
            else  
                $this->cluster[$smallestIndex] = $primary[$i];
            */
        }            
    }


    private function getSmallestIndex(array $data)
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
    
    private function calculateWeight($oldWeight, $data)
    {
        $newWeight = $oldWeight + $this->learningRate*($data-$oldWeight);
        return $newWeight;
    }

    private function newWeight(array $data, $smallestIndex)
    {
        $num = count($this->weight[$smallestIndex]);
        for ($i = 0; $i < $num; $i++) {
            $newWeight[$i] = $this->calculateWeight($this->weight[$smallestIndex][$i], $data[$i]);
        }
        return $newWeight;
    }

    private function setNewWeight(array $calculateNewWeight, $smallestIndex)
    {
        $num = count($this->weight[$smallestIndex]);
        for ($i = 0; $i < $num; $i++) {
            $this->weight[$smallestIndex][$i] = $calculateNewWeight[$i];
        }
    }

    public function getNewWeight()
    {
        return $this->weight;
    }

    public function getClusters()
    {
        return $this->cluster;
    }

    public function getClustersValue()
    {
        return $this->c_value;
    }
}
