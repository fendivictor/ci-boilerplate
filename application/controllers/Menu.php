<?php if ( ! defined('BASEPATH')) { exit('No direct script access allowed'); }

class Menu extends MY_Controller {

	public function index()
	{
		show_404();
	}

	public function user()
	{
		$page = $this->Login_model->isvalid_page();
		if (! $page) {
			show_404();
		}
		
		$header = [];
		
		$body = [
			'content' => 'user/manajemen_menu',
			'title' => lang('menu_manajemen_menu')
		];

		$footer = [
			'js' => ['assets/js/apps/user/manajemen_menu.js']
		];

		$plugins = ['datatables', 'jstree'];

		$this->template($header, $body, $footer, $plugins);
	}
}

/* End of file Menu.php */
/* Location: ./application/controllers/Menu.php */ ?>