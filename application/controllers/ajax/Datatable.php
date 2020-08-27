<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datatable extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['Project_Model']);
	}

	public function dt_project()
	{
		$keyword = $this->input->get('keyword', TRUE);
		$draw = $this->input->post('draw', TRUE);
		$order = $this->input->post('order', TRUE);
		$order_columns = isset($order[0]['column']) ? $order[0]['column'] : '';
		$order_mode = isset($order[0]['dir']) ? $order[0]['dir'] : '';
		$start = $this->input->post('start', TRUE);
		$length = $this->input->post('length', TRUE);
		$search = $this->input->post('search', TRUE);
		$search_value = isset($search['value']) ? $search['value'] : '';

		$data = $this->Project_Model->dt_project([
			'draw' => $draw,
			'order_column' => $order_columns,
			'order_mode' => $order_mode,
			'start' => $start,
			'length' => $length,
			'search' => $keyword
		]);

		echo json_encode($data);
	}
}

/* End of file Datatable.php */
/* Location: ./application/controllers/Datatable.php */ ?>