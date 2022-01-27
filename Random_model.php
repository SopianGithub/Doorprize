<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Random_model extends CI_Model {

	function get_count(){
		$JMLDATA = $this->db->query('SELECT COUNT(id) JML FROM daftar_peserta');
		$countData = $JMLDATA->row_array();
		return $countData;
	}

	function get_nik_am(){
		$this->db->select('NIK');
		$this->db->select('NAMA');
		$this->db->order_by('RAND()');
		$this->db->where('NIK NOT IN (SELECT NIK FROM WIN_DOORPRIZE) ');
		$this->db->where("NIK!=''");
		#$this->db->where("(POSISI='AM JAKARTA' OR POSISI='AM REGIONAL' OR POSISI='AMEX')");
		#$this->db->where("ATTN!=''");
		$data = $this->db->get('daftar_peserta');
		return $data;
	}

	function setstatusdoor($data){
		$query = $this->db->insert('WIN_DOORPRIZE', $data);
		return $query;
	}

	function get_nama($nik){
		$this->db->select('NAMA');
		$this->db->where('NIK', $nik);
		$data = $this->db->get('daftar_peserta');
		return $data->row_array();
	}
}

/* End of file Random_model.php */
/* Location: ./application/models/Random_model.php */