<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = [];

		$this->load->view('frontend/index', $data, FALSE);
	}

}

/* End of file Page.php */
/* Location: ./application/controllers/Page.php */