<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Cluster_lib {

    function Cluster_lib()
    {
        require_once('cluster_lib/Hierarchical.php');
        require_once('cluster_lib/Som.php');
        require_once('cluster_lib/Knn.php');
        require_once('cluster_lib/Dbscan.php');
        require_once('cluster_lib/Kmeans.php');
        require_once('cluster_lib/Nearestneighbors.php');
        require_once('cluster_lib/Nearestneighbors2.php');
        require_once('cluster_lib/Silhoutte_index.php');
        require_once('cluster_lib/Distance.php');
        require_once('cluster_lib/Pca.php');
    }
    
}

/* End of file Cluster_lib.php */