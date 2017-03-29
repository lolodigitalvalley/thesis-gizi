<?php

class Nearestneighbors
{

    protected $newCase   = array();
    protected $oldCase   = array();
    protected $distances = array();
    protected $R_Usia;

    public function __construct(array $oldCase, array $newCase, $k = 1, $similarity = 'NEAREST_NEIGHBORS', array $local_sim)
    {
        $num          = count($oldCase);
        $this->R_Usia = $local_sim['max_usia'] - $local_sim['min_usia'];

        switch ($similarity) {
            case 'NEAREST_NEIGHBORS':
                for ($i = 0; $i < $num; $i++) {
                    $this->distances['D' . $i] = $this->nearest_neighbors($oldCase[$i], $newCase);
                }

                break;
            case 'EUCLIDEAN_NEIGHBORS':
                for ($i = 0; $i < $num; $i++) {
                    $this->distances['D' . $i] = $this->euclidean_neighbors($oldCase[$i], $newCase);
                }

                break;
            case 'MINKOWSKI':
                for ($i = 0; $i < $num; $i++) {
                    $this->distances['D' . $i] = $this->minkowski($oldCase[$i], $newCase);
                }

                break;
        }
        asort($this->distances); //Sort Dari kecil ke besar

        $start           = count($this->distances) - $k;
        $this->distances = array_slice($this->distances, $start, $k); //ambil K terbaik dari bawah
    }

    public function get_distance()
    {
        if (count($this->distances) > 1) {
            $distance = array();
            foreach ($this->distances as $key => $value) {
                $distance = $value;
            }

        } else {
            $distance = max($this->distances);
        }

        return $distance;
    }

    private function minkowski(array $oldCase, array $newCase)
    {
        if (($n = count($newCase)) !== count($oldCase)) {
            return false;
        }

        $age        = 0.2 * (1 - (abs($oldCase[0] - $newCase[0]) / $this->R_Usia));
        $sum        = pow($age, 3);
        $sumOldcase = pow(0.2, 3);

        for ($i = 1; $i < $n; $i++) {
            $sum += pow($oldCase[$i] * $newCase[$i], 3);
            $sumOldcase += pow($oldCase[$i], 3);
        }
        $euclidean = ($sum / $sumOldcase);

        return pow($euclidean, 1 / 3);
    }

    private function euclidean_neighbors(array $oldCase, array $newCase)
    {
        if (($n = count($newCase)) !== count($oldCase)) {
            return false;
        }

        $age        = 0.2 * (1 - (abs($oldCase[0] - $newCase[0]) / $this->R_Usia));
        $sum        = pow($age, 2);
        $sumOldcase = pow(0.2, 2);

        for ($i = 1; $i < $n; $i++) {
            $sum += pow($oldCase[$i] * $newCase[$i], 2);
            $sumOldcase += pow($oldCase[$i], 2);
        }
        $euclidean = ($sum / $sumOldcase);

        return sqrt($euclidean);
    }

    private function nearest_neighbors(array $oldCase, array $newCase)
    {

        if (($n = count($newCase)) !== count($oldCase)) {
            return false;
        }

        $sum        = 0.2 * (1 - (abs($oldCase[0] - $newCase[0]) / $this->R_Usia));
        $sumOldcase = 0.2;

        for ($i = 1; $i < $n; $i++) {
            $sum += $oldCase[$i] * $newCase[$i];
            $sumOldcase += $oldCase[$i];
        }

        $euclidean = ($sum / $sumOldcase);

        return $euclidean;
    }

    public function get_nn()
    {
        $rank = max($this->distances);
        $rank = array_search($rank, $this->distances);
        return substr($rank, 1);
    }
}
