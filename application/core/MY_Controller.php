<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$islogin = $this->Login_model->is_login();

		if ($islogin == FALSE) {
			redirect(base_url());
		}
	}

	public function template($header = [], $body = [], $footer = [], $plugins = [])
	{
		$selected_plugins = $this->plugin_packages($plugins);

		if ($selected_plugins) {
			foreach ($selected_plugins as $row) {
				$header['style'] = $row['css'];
				$footer['plugin'] = $row['js'];
			}
		}

		$header['menu'] = $this->Menu_Model->create_menu();
		$header['current_menu'] = $current_menu = $this->Menu_Model->current_menu();

		$username = $this->session->userdata('username');
    	$header['data_user'] = $this->Login_model->get_user_profile($username);

		$this->load->view('template/header', $header);
		$this->load->view('template/body', $body);
		$this->load->view('template/footer', $footer);
	}

	public function plugin_packages($selected = [])
	{
		$plugins = [
			'datatables' => [
				'css' => [
					'assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css',
					'assets/plugins/datatables-buttons/css/buttons.bootstrap.min.css',
					'assets/plugins/datatables-fixedcolumns/css/fixedColumns.bootstrap4.min.css'
				], 
				'js' => [
					'assets/plugins/datatables-buttons/js/dataTables.buttons.min.js',
					'assets/plugins/datatables-buttons/js/buttons.jzip.min.js',
					'assets/plugins/datatables-buttons/js/pdfmake.min.js',
					'assets/plugins/datatables-buttons/js/vfs_font.min.js',
					'assets/plugins/datatables-buttons/js/buttons.html5.min.js',
					'assets/plugins/datatables-fixedcolumns/js/dataTables.fixedColumns.min.js',
					'assets/plugins/datatables-buttons/js/buttons.colVis.min.js'
				]
			]
		];

		$selected_plugins = [];
		if ($selected) {
			foreach ($selected as $row) {
				$selected_plugins[] = [
					'css' => $plugins[$row]['css'],
					'js' => $plugins[$row]['js']
				];
			}
		}

		return $selected_plugins;
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/controllers/MY_Controller.php */ ?>