<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Gejala_model extends MY_Model
{
    public $table = 'gejala';
    public $primary_key = 'kode_gejala';
    
    public function __construct()
	{
		parent::__construct();

		$this->has_many['bobot_gejala'] = array('Bobot_gejala_model', 'kode_gejala', 'kode_gejala');
	}

	public function drop_data()
	{
		$this->db->from($this->table); 
		return $this->db->truncate(); 
	}

}