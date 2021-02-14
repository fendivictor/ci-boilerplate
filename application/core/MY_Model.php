<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require('./phpspreadsheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class MY_Model extends CI_Model {

	public function __construct()
	{
		parent::__construct();	

		$this->table = 'table';
	}

	public function create_counter($kolom, $periode, $prefix)
	{
		$last = $this->db->where(['periode' => $periode])
					->get($this->table)
					->row();

		$number = 1;
		if ($last) {
			$number = $last->$kolom + 1;
			$this->db->update($this->table, [
				$kolom => $number
			], [
				'periode' => $periode
			]);
		} else {
			$this->db->insert($this->table, [
				$kolom => 1,
				'periode' => $periode
			]);
		}

		$autonumber = '';
		if (strlen($number) <= 4) {
			for ($i = 0; $i < (4 - strlen($number)); $i++) {
				$autonumber .= '0';
			}
		}

		$number = $autonumber.$number;

		return $number.$prefix;
	}

	public function find($condition = [], $multiple = true)
	{
		$result = $this->db->where($condition)->get($this->table);

		return ($multiple) ? $result->result() : $result->row();
	}

	public function get_time($format = '%Y-%m-%d %H:%i:%s')
	{
		$sql = $this->db->query("SELECT DATE_FORMAT(NOW(), ?) AS hasil ", [$format])->row();

		return isset($sql->hasil) ? $sql->hasil : '';
	}

	public function remove($condition)
	{
		$this->db->where($condition)
			->delete($this->table);

		return $this->db->affected_rows();
	}

	public function store_data($table, $data, $condition = [], $bulk = false)
    {   
        $this->db->trans_begin();
        if ($condition) {
            $this->db->update($table, $data, $condition);
        } else {
            if ($bulk) {
                $this->db->insert_batch($table, $data);
            } else {
                $this->db->insert($table, $data);
            }
        }

        if ($this->db->trans_status()) {
            $this->db->trans_commit();

            return true;
        } else {
            $this->db->trans_rollback();

            return false;
        }
    }

    public function export($title, $header, $data)
    {
    	$spreadsheet = new Spreadsheet();

    	$sheet = $spreadsheet->setActiveSheetIndex(0);
    	$spreadsheet->getActiveSheet()->setTitle($title);
    	$spreadsheet->setActiveSheetIndex(0);

    	foreach ($header as $key => $val) {
    		$sheet->setCellValueByColumnAndRow($key, 1, $val);
    	}

    	$rows = 3;

    	foreach ($data as $key => $val) {
    		$sheet->setCellValueByColumnAndRow($key, $rows, $val);

    		$rows++;
    	}

    	$filename = str_replace(' ', '_', strtolower(replace_invalid_character($title)));
    	// Redirect output to a client’s web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		exit;
    }
}

/* End of file MY_Model.php */
/* Location: ./application/models/MY_Model.php */ ?>