<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project_Model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function dt_project($params)
	{
		$draw = $this->db->escape_str($params['draw']);
		$order_column = $this->db->escape_str($params['order_column']);
		$order_mode = $this->db->escape_str($params['order_mode']);
		$start = $this->db->escape_str($params['start']);
		$length = $this->db->escape_str($params['length']);
		$search = $this->db->escape_str($params['search']);
		$username = $this->session->userdata('username');
		$id_menu = 3;

		$arrPrivilege = [];
		$privilege = $this->db->where([
			'id_menu' => $id_menu,
			'username' => $username
		])->get('tb_privilege')->result_array();

		if ($privilege) {
			foreach ($privilege as $row) {
				$arrPrivilege[] = $row['tools'];
			}
		}

		$condition = '';
		$order = '';
		$limit = '';
		$data = [];

		$kolom_search = ['type', 'brand', 'kontrak', 'item', 'style', 'no_pattern', '`order`', 'size', 'qty', 'price', 'format_tec_sheet_plan', 'format_tec_sheet_actual', 'format_pattern_plan', 'format_pattern_actual', 'format_fabric_plan', 'format_fabric_actual', 'format_aksesories_plan', 'format_aksesories_actual', 'due_date', 'tujuan_sample', 'master_code', 'line', 'persiapan_plan', 'persiapan_actual', 'cutting_plan', 'cutting_actual', 'cad_plan', 'cad_actual', 'sewing_plan', 'sewing_actual', 'fg_plan', 'fg_actual', 'kirim_plan', 'kirim_actual', 'keterangan'];
		$kolom_order = ['id', 'type', 'brand', 'kontrak', 'item', 'style', 'no_pattern', '`order`', 'size', 'qty', 'price', 'tec_sheet_plan', 'tec_sheet_actual', 'pattern_plan', 'pattern_actual', 'fabric_plan', 'fabric_actual', 'aksesories_plan', 'aksesories_actual', 'due_date', 'tujuan_sample', 'master_code', 'line', 'persiapan_plan', 'persiapan_actual', 'cutting_plan', 'cutting_actual', 'cad_plan', 'cad_actual', 'sewing_plan', 'sewing_actual', 'fg_plan', 'fg_actual', 'kirim_plan', 'kirim_actual', 'keterangan'];

		$condition .= dt_searching($kolom_search, $search);
		$order = dt_order($kolom_order, $order_column, $order_mode);

		if ($length > 0) {
			$limit = " LIMIT $start, $length ";
		}

		$sql = "
			SELECT *, DATE_FORMAT(a.tec_sheet_plan, '%d/%m/%Y') AS format_tec_sheet_plan,
			DATE_FORMAT(a.tec_sheet_actual, '%d/%m/%Y') AS format_tec_sheet_actual,
			DATE_FORMAT(a.pattern_plan, '%d/%m/%Y') AS format_pattern_plan,
			DATE_FORMAT(a.pattern_actual, '%d/%m/%Y') AS format_pattern_actual,
			DATE_FORMAT(a.fabric_plan, '%d/%m/%Y') AS format_fabric_plan,
			DATE_FORMAT(a.fabric_actual, '%d/%m/%Y') AS format_fabric_actual,
			DATE_FORMAT(a.aksesories_plan, '%d/%m/%Y') AS format_aksesories_plan,
			DATE_FORMAT(a.aksesories_actual, '%d/%m/%Y') AS format_aksesories_actual,
			DATE_FORMAT(a.due_date, '%d/%m/%Y') AS format_due_date,
			DATE_FORMAT(a.persiapan_plan, '%d/%m/%Y') AS format_persiapan_plan,
			DATE_FORMAT(a.persiapan_actual, '%d/%m/%Y') AS format_persiapan_actual,
			DATE_FORMAT(a.cutting_plan, '%d/%m/%Y') AS format_cutting_plan,
			DATE_FORMAT(a.cutting_actual, '%d/%m/%Y') AS format_cutting_actual,
			DATE_FORMAT(a.cad_plan, '%d/%m/%Y') AS format_cad_plan,
			DATE_FORMAT(a.cad_actual, '%d/%m/%Y') AS format_cad_actual,
			DATE_FORMAT(a.sewing_plan, '%d/%m/%Y') AS format_sewing_plan,
			DATE_FORMAT(a.sewing_actual, '%d/%m/%Y') AS format_sewing_actual,
			DATE_FORMAT(a.fg_plan, '%d/%m/%Y') AS format_fg_plan,
			DATE_FORMAT(a.fg_actual, '%d/%m/%Y') AS format_fg_actual,
			DATE_FORMAT(a.kirim_plan, '%d/%m/%Y') AS format_kirim_plan,
			DATE_FORMAT(a.kirim_actual, '%d/%m/%Y') AS format_kirim_actual
			FROM project_h a 
			WHERE a.finish IS NULL";

		$view = $this->db->query(" SELECT * FROM ( $sql ) AS tb WHERE 1 = 1 $condition $order $limit ")->result();
		$count = $this->db->query(" SELECT COUNT(*) AS jumlah FROM ( $sql ) AS tb WHERE 1 = 1 $condition ")->row();
		$jumlah = isset($count->jumlah) ? $count->jumlah : 0;

		if ($view) {
			$no = 1;
			foreach ($view as $row) {
				$btn_history = '<a href="javascript:;" class="btn btn-success btn-xs btn-history" data-id="'.$row->id.'"><i class="fa fa-history"></i></a>';

				$btn_finish = '';
				if (in_array('finish-btn', $arrPrivilege) && $row->format_fabric_plan != '' && $row->format_aksesories_plan != '' && $row->format_persiapan_actual != '' && $row->format_cad_actual != '' && $row->format_cutting_actual != '' && $row->format_sewing_actual != '' && $row->format_fg_actual != '' && $row->format_kirim_actual != '') {
					$btn_finish = '<a href="javascript:;" class="btn btn-primary btn-xs btn-finish" data-id="'.$row->id.'"><i class="fa fa-check"></i></a>';
				}

				$btn_tec_sheet_plan = $row->format_tec_sheet_plan;
				if (in_array('tec-sheet-plan-kirim', $arrPrivilege)) {
					$btn_tec_sheet_plan = ($row->format_tec_sheet_plan != '') ? '<a href="javascript:;" data-action="input-tec-sheet-plan" data-id="'.$row->id.'" class="click-to-update">'.$row->format_tec_sheet_plan.'</a>' : '<a href="javascript:;" data-action="input-tec-sheet-plan" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_tec_sheet_actual = $row->format_tec_sheet_actual;
				if (in_array('tec-sheet-actual-kirim', $arrPrivilege)) {
					$btn_tec_sheet_actual = ($row->format_tec_sheet_actual != '') ? '<a href="javascript:;" data-action="input-tec-sheet-actual" data-id="'.$row->id.'" class="click-to-update">'.$row->format_tec_sheet_actual.'</a>' : '<a href="javascript:;" data-action="input-tec-sheet-actual" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_pattern_plan = $row->format_pattern_plan;
				if (in_array('pattern-plan-kirim', $arrPrivilege)) {
					$btn_pattern_plan = ($row->format_pattern_plan != '') ? '<a href="javascript:;" data-action="input-pattern-plan" data-id="'.$row->id.'" class="click-to-update">'.$row->format_pattern_plan.'</a>' : '<a href="javascript:;" data-action="input-pattern-plan" data-id="'.$row->id.'" class="click-to-update">'.lang('btn_input').'</a>';
				}

				$btn_pattern_actual = $row->format_pattern_actual;
				if (in_array('pattern-actual-kirim', $arrPrivilege)) {
					$btn_pattern_actual = ($row->format_pattern_actual != '') ? '<a href="javascript:;" data-action="input-pattern-actual" data-id="'.$row->id.'" class="click-to-update">'.$row->format_pattern_actual.'</a>' : '<a href="javascript:;" data-action="input-pattern-actual" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_fabric_plan = $row->format_fabric_plan;
				if (in_array('fabric-kirim', $arrPrivilege)) {
					$btn_fabric_plan = ($row->format_fabric_plan != '') ? '<a href="javascript:;" data-action="input-fabric-plan" data-id="'.$row->id.'" class="click-to-update">'.$row->format_fabric_plan.'</a>' : '<a href="javascript:;" data-action="input-fabric-plan" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_fabric_actual = $row->format_fabric_actual;
				if (in_array('fabric-kedatangan', $arrPrivilege) && $row->format_fabric_plan != '') {
					$btn_fabric_actual = ($row->format_fabric_actual != '') ? '<a href="javascript:;" data-action="input-fabric-actual" data-id="'.$row->id.'" class="click-to-update">'.$row->format_fabric_actual.'</a>' : '<a href="javascript:;" data-action="input-fabric-actual" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_aksesories_plan = $row->format_aksesories_plan;
				if (in_array('aksesories-kirim', $arrPrivilege)) {
					$btn_aksesories_plan = ($row->format_aksesories_plan != '') ? '<a href="javascript:;" data-action="input-aksesories-plan" data-id="'.$row->id.'" class="click-to-update">'.$row->format_aksesories_plan.'</a>' : '<a href="javascript:;" data-action="input-aksesories-plan" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_aksesories_actual = $row->format_aksesories_actual;
				if (in_array('aksesories-kedatangan', $arrPrivilege) && $row->format_aksesories_plan != '') {
					$btn_aksesories_actual = ($row->format_aksesories_actual != '') ? '<a href="javascript:;" data-action="input-aksesories-actual" data-id="'.$row->id.'" class="click-to-update">'.$row->format_aksesories_actual.'</a>' : '<a href="javascript:;" data-action="input-aksesories-actual" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_mastercode = $row->master_code;
				if (in_array('master-code', $arrPrivilege)) {
					$btn_mastercode = ($row->master_code != '') ? '<a href="javascript:;" data-action="input-mastercode" data-id="'.$row->id.'" class="click-to-update">'.$row->master_code.'</a>' : '<a href="javascript:;" data-action="input-mastercode" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_line = $row->line;
				if (in_array('line', $arrPrivilege)) {
					$btn_line = ($row->line != '') ? '<a href="javascript:;" data-action="input-line" data-id="'.$row->id.'" class="click-to-update">'.$row->line.'</a>' : '<a href="javascript:;" data-action="input-line" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_persiapan_plan = $row->format_persiapan_plan;
				if (in_array('persiapan-finish-plan', $arrPrivilege)) {
					$btn_persiapan_plan = ($row->format_persiapan_plan != '') ? '<a href="javascript:;" data-action="input-persiapan-plan" data-id="'.$row->id.'" class="click-to-update">'.$row->format_persiapan_plan.'</a>' : '<a href="javascript:;" data-action="input-persiapan-plan" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_persiapan_actual = $row->format_persiapan_actual;
				if (in_array('persiapan-finish-actual', $arrPrivilege) && $row->format_fabric_plan != '' && $row->format_aksesories_plan != '') {
					$btn_persiapan_actual = ($row->format_persiapan_actual != '') ? '<a href="javascript:;" data-action="input-persiapan-actual" data-id="'.$row->id.'" class="click-to-update">'.$row->format_persiapan_actual.'</a>' : '<a href="javascript:;" data-action="input-persiapan-actual" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_cutting_plan = $row->format_cutting_plan;
				if (in_array('cutting-finish-plan', $arrPrivilege)) {
					$btn_cutting_plan = ($row->format_cutting_plan != '') ? '<a href="javascript:;" data-action="input-cutting-plan" data-id="'.$row->id.'" class="click-to-update">'.$row->format_cutting_plan.'</a>' : '<a href="javascript:;" data-action="input-cutting-plan" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_cutting_actual = $row->format_cutting_actual;
				if (in_array('cutting-finish-actual', $arrPrivilege) && $row->format_fabric_plan != '' && $row->format_aksesories_plan != '' && $row->format_persiapan_actual != '' && $row->format_cad_actual != '') {
					$btn_cutting_actual = ($row->format_cutting_actual != '') ? '<a href="javascript:;" data-action="input-cutting-actual" data-id="'.$row->id.'" class="click-to-update">'.$row->format_cutting_actual.'</a>' : '<a href="javascript:;" data-action="input-cutting-actual" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_cad_plan = $row->format_cad_plan;
				if (in_array('cad-finish-plan', $arrPrivilege)) {
					$btn_cad_plan = ($row->format_cad_plan != '') ? '<a href="javascript:;" data-action="input-cad-plan" data-id="'.$row->id.'" class="click-to-update">'.$row->format_cad_plan.'</a>' : '<a href="javascript:;" data-action="input-cad-plan" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_cad_actual = $row->format_cad_actual;
				if (in_array('cad-finish-actual', $arrPrivilege) && $row->format_fabric_plan != '' && $row->format_aksesories_plan != '' && $row->format_persiapan_actual != '') {
					$btn_cad_actual = ($row->format_cad_actual != '') ? '<a href="javascript:;" data-action="input-cad-actual" data-id="'.$row->id.'" class="click-to-update">'.$row->format_cad_actual.'</a>' : '<a href="javascript:;" data-action="input-cad-actual" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_sewing_plan = $row->format_sewing_plan;
				if (in_array('sewing-finish-plan', $arrPrivilege)) {
					$btn_sewing_plan = ($row->format_sewing_plan != '') ? '<a href="javascript:;" data-action="input-sewing-plan" data-id="'.$row->id.'" class="click-to-update">'.$row->format_sewing_plan.'</a>' : '<a href="javascript:;" data-action="input-sewing-plan" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_sewing_actual = $row->format_sewing_actual;
				if (in_array('sewing-finish-actual', $arrPrivilege) && $row->format_fabric_plan != '' && $row->format_aksesories_plan != '' && $row->format_persiapan_actual != '' && $row->format_cad_actual != '' && $row->format_cutting_actual != '') {
					$btn_sewing_actual = ($row->format_sewing_actual != '') ? '<a href="javascript:;" data-action="input-sewing-actual" data-id="'.$row->id.'" class="click-to-update">'.$row->format_sewing_actual.'</a>' : '<a href="javascript:;" data-action="input-sewing-actual" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_fg_plan = $row->format_fg_plan;
				if (in_array('finish-goods-plan', $arrPrivilege)) {
					$btn_fg_plan = ($row->format_fg_plan != '') ? '<a href="javascript:;" data-action="input-fg-plan" data-id="'.$row->id.'" class="click-to-update">'.$row->format_fg_plan.'</a>' : '<a href="javascript:;" data-action="input-fg-plan" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_fg_actual = $row->format_fg_actual;
				if (in_array('finish-goods-actual', $arrPrivilege) && $row->format_fabric_plan != '' && $row->format_aksesories_plan != '' && $row->format_persiapan_actual != '' && $row->format_cad_actual != '' && $row->format_cutting_actual != '' && $row->format_sewing_actual != '') {
					$btn_fg_actual = ($row->format_fg_actual != '') ? '<a href="javascript:;" data-action="input-fg-actual" data-id="'.$row->id.'" class="click-to-update">'.$row->format_fg_actual.'</a>' : '<a href="javascript:;" data-action="input-fg-actual" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_kirim_plan = $row->format_kirim_plan;
				if (in_array('kirim-plan', $arrPrivilege)) {
					$btn_kirim_plan = ($row->format_kirim_plan != '') ? '<a href="javascript:;" data-action="input-kirim-plan" data-id="'.$row->id.'" class="click-to-update">'.$row->format_kirim_plan.'</a>' : '<a href="javascript:;" data-action="input-kirim-plan" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_kirim_actual = $row->format_kirim_actual;
				if (in_array('kirim-actual', $arrPrivilege) && $row->format_fabric_plan != '' && $row->format_aksesories_plan != '' && $row->format_persiapan_actual != '' && $row->format_cad_actual != '' && $row->format_cutting_actual != '' && $row->format_sewing_actual != '' && $row->format_fg_actual != '') {
					$btn_kirim_actual = ($row->format_kirim_actual != '') ? '<a href="javascript:;" data-action="input-kirim-actual" data-id="'.$row->id.'" class="click-to-update">'.$row->format_kirim_actual.'</a>' : '<a href="javascript:;" data-action="input-kirim-actual" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$btn_keterangan = $row->keterangan;
				if (in_array('keterangan', $arrPrivilege)) {
					$btn_keterangan = ($row->keterangan != '') ? '<a href="javascript:;" data-action="input-keterangan" data-id="'.$row->id.'" class="click-to-update">'.$row->keterangan.'</a>' : '<a href="javascript:;" data-action="input-keterangan" data-id="'.$row->id.'" class="click-to-update"><i>'.lang('btn_input').'</i></a>';
				}

				$data[] = [
					'no' => $row->id,
					'type' => $row->type,
					'brand' => $row->brand,
					'kontrak' => $row->kontrak,
					'item' => $row->item,
					'style' => $row->style,
					'no_pattern' => $row->no_pattern,
					'order' => $row->order,
					'size' => $row->size,
					'qty' => $row->qty,
					'price' => $row->price,
					'tec_sheet_plan' => $btn_tec_sheet_plan,
					'tec_sheet_actual' => $btn_tec_sheet_actual,
					'pattern_plan' => $btn_pattern_plan,
					'pattern_actual' => $btn_pattern_actual,
					'fabric_plan' => $btn_fabric_plan,
					'fabric_actual' => $btn_fabric_actual,
					'aksesories_plan' => $btn_aksesories_plan,
					'aksesories_actual' => $btn_aksesories_actual,
					'due_date' => $row->format_due_date,
					'tujuan_sample' => $row->tujuan_sample,
					'master_code' => $btn_mastercode,
					'line' => $btn_line,
					'persiapan_plan' => $btn_persiapan_plan,
					'persiapan_actual' => $btn_persiapan_actual,
					'cutting_plan' => $btn_cutting_plan,
					'cutting_actual' => $btn_cutting_actual,
					'cad_plan' => $btn_cad_plan,
					'cad_actual' => $btn_cad_actual,
					'sewing_plan' => $btn_sewing_plan,
					'sewing_actual' => $btn_sewing_actual,
					'fg_plan' => $btn_fg_plan,
					'fg_actual' => $btn_fg_actual,
					'kirim_plan' => $btn_kirim_plan,
					'kirim_actual' => $btn_kirim_actual,
					'keterangan' => $btn_keterangan,
					'tools' => $btn_history.'&nbsp;&nbsp;'.$btn_finish
				];
			}
		}

		$response = [
			'draw' => $draw,
			'recordsTotal' => $jumlah,
			'recordsFiltered' => $jumlah,
			'data' => $data
		];

		return $response;
	}
}

/* End of file Project_Model.php */
/* Location: ./application/models/Project_Model.php */ ?>