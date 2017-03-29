<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Data_som_model extends MY_Model
{
    public $table = 'data_som';
    public $primary_key = 'kode_kasus';
    
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