<?php if ( ! defined('BASEPATH')) { exit('No direct script access allowed'); }

class Ajax extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if (! $this->input->is_ajax_request()) {
			show_404();
		}

		$islogin = $this->Login_model->is_login();
		if (! $islogin) {
			redirect(base_url());
		}

		$this->load->library('form_validation');
	}
}

/* End of file Ajax.php */
/* Location: ./application/controllers/Ajax.php */ ?>