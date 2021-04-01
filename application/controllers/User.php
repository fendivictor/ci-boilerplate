<?php if ( ! defined('BASEPATH')) { exit('No direct script access allowed'); }

class User extends MY_Controller {

	public function index()
	{
		$page = $this->Login_model->isvalid_page();
		if (! $page) {
			show_404();
		}

		$header = [];

		$body = [
			'content' => 'user/management_user',
			'title' => lang('menu_management_user')
		];

		$footer = [
			'js' => ['assets/js/apps/user/management_user.js']
		];

		$plugins = ['datatables'];

		$this->template($header, $body, $footer, $plugins);
	}

	public function change_password()
	{
		$page = $this->Login_model->isvalid_page();
		if (! $page) {
			show_404();
		}

		$header = [];

		$body = [
			'content' => 'user/change_password',
			'title' => lang('menu_change_password')
		];

		$footer = [
			'js' => ['assets/js/apps/user/change_password.js']
		];

		$this->template($header, $body, $footer);
	}

	public function privilege()
	{
		$page = $this->Login_model->isvalid_page();
		if (! $page) {
			show_404();
		}

		$header = [];

		$body = [
			'content' => 'user/privilege',
			'title' => lang('menu_privilege')
		];

		$footer = [
			'js' => ['assets/js/apps/user/privilege.js']
		];

		$this->template($header, $body, $footer);
	}
}

/* End of file User.php */
/* Location: ./application/controllers/User.php */ ?>