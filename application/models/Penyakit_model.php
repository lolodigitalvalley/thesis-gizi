<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Penyakit_model extends MY_Model
{
    public $table = 'penyakit';
    public $primary_key = 'kode_penyakit';
    
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