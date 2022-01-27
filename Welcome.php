<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('random_model');
	}

	public function index()
	{
		$data['count'] = $this->random_model->get_count();
		$data['peserta'] = $this->random_model->get_nik_am();
		$this->load->view('page_random', $data);
	}

	function random(){
		$data['count'] = $this->random_model->get_count();
		$data['peserta'] = $this->random_model->get_nik_am();
		$this->load->view('page_rand2', $data);
	}

	function setstatus($nikam){
		$data = array(
				'ID'		=> '',
				'NIK'		=> $nikam,
				'STATUS'	=> '1'
			);
		$insertData = $this->random_model->setstatusdoor($data);
		$nama 		= $this->random_model->get_nama($nikam); 
		echo $nama['NAMA'];
	}
}
