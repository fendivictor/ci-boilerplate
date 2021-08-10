<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function corejs()
   	{	
   		header('Content-Type: application/javascript');
   		$this->load->view('template/corejs');	
   	}

}

/* End of file Core.php */
/* Location: ./application/controllers/Core.php */ ?>