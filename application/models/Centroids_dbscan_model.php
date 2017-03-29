<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Centroids_dbscan_model extends MY_Model
{
    public $table = 'centroids_dbscan';
    public $primary_key = 'id';
    
    public function __construct()
	{
		parent::__construct();
	}

	public function drop_data()
	{
		$this->db->from($this->table); 
		return $this->db->truncate(); 
	}
}