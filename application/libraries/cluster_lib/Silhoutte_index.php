<?php
require_once 'distance.php';

class Silhoutte_index extends Distance
{

    protected $distances = array();

    
    public function __construct()
    {

    }


    public function getValue(array $clusters)
    {

        $silhoutte_index = 0;

        $numCluster = count($clusters);
        $first = key($clusters);
        $point = reset($clusters[$first]);    
        
        $distance   = 0;
        $numPoint   = 0;      
        foreach ($clusters[$first] as $key => $value) {
            $distance += $this->euclidean($point, $value);
            $numPoint++;
        }
        $a = $distance / ($numPoint - 1);

        for ($i = 0; $i < $numCluster; $i++) {
            if ($i == $first) continue; 
            
            $distance = 0;
            $numPoint = 0;
            foreach ($clusters[$i] as $key => $value) {
                $distance += $this->euclidean($point, $value);
                $numPoint++;
            }
            $average[$i] = $distance / $numPoint;
        }
        $b = min($average);
    
        $silhoutte_index = ($b - $a) / max($a, $b);

        return $silhoutte_index;
    }
}
