<?php 
if ( ! defined('BASEPATH')) {
	exit('No direct script access allowed');
}

require('./phpspreadsheet/vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class MY_Model extends CI_Model {

	public function __construct()
	{
		parent::__construct();	

		$this->table = 'table';
		$this->select = '*';
		$this->order = '';
		$this->join = [];
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

	public function selection()
	{
		$this->db->select($this->select);

		return $this;
	}

	public function join_table($join)
	{
		if ($join) {
			foreach ($join as $row) {
				$this->db->join($row['table'], $row['on'], $row['join']);
			}
		}

		return $this;
	}

	public function define_condition($condition)
	{
		$arrayKeys = array_keys($condition);

		if (! $arrayKeys) {
			return false;
		}

		foreach ($arrayKeys as $row) {
			if (is_array($condition[$row])) {
				$this->db->where_in($row, $condition[$row]);
			} else {
				if (strpos($condition[$row], '%') !== false) {
					$this->db->like($row, str_replace('%', '', $condition[$row]));
				} else {
					$this->db->where($row, $condition[$row]);
				}
			}
		}

		return $this;
	}

	public function find($condition = [], $multiple = true)
	{
		$this->selection();
		if ($this->join) {
			$this->join_table($this->join);	
		}

		if ($condition) {
			$this->define_condition($condition);
		}

		if ($this->order) {
			$this->db->order_by($this->order);
		}

		$result = $this->db->get($this->table);

		return ($multiple) ? $result->result() : $result->row();
	}

	public function dropdown($id, $text, $condition = [], $placeholder = '')
	{
		$dropdownResult = [];

		$data = $this->find($condition);

		if ($placeholder != '') {
			$dropdownResult[null] = $placeholder;
		}

		if ($data) {
			foreach ($data as $row => $val) {
				$dropdownResult[$val->$id] = $val->$text;
			}
		}

		return $dropdownResult;
	}

	public function get_time($format = '%Y-%m-%d %H:%i:%s')
	{
		$sql = $this->db->query("SELECT DATE_FORMAT(NOW(), ?) AS hasil ", [$format])->row();

		return isset($sql->hasil) ? $sql->hasil : '';
	}

	public function remove($condition)
	{
		$table = explode(' ', $this->table);
		$this->db->delete($table[0], $condition);

		return $this->db->affected_rows();
	}

	public function count($condition = [])
	{
		$this->selection();
		if ($this->join) {
			$this->join_table($this->join);	
		}
		
		$this->db->where($condition);
		$result = $this->db->get($this->table);

		return $result->num_rows();
	}

	public function store($data, $condition = [], $bulk = false)
    {   
        $this->db->trans_begin();
        if ($condition) {
            $this->db->update($this->table, $data, $condition);
        } else {
            if ($bulk) {
                $this->db->insert_batch($this->table, $data);
            } else {
                $this->db->insert($this->table, $data);
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

    public function storeWithReturnId($data, $condition = [])
    {   
        $this->db->trans_begin();
        if ($condition) {
            $this->db->update($this->table, $data, $condition);
            $id = $condition['id'];
        } else {
            $this->db->insert($this->table, $data);
            $id = $this->db->insert_id();
        }

        if ($this->db->trans_status()) {
            $this->db->trans_commit();

            return [
            	'status' => true,
            	'id' => $id
            ];
        } else {
            $this->db->trans_rollback();

            return [
            	'status' => false,
            	'id' => $id
            ];
        }
    }

    public function replace_invalid_character($string)
	{
		$invalidCharacters = array('*', ':', '/', '\\', '?', '[', ']');

		for ($i = 0; $i < count($invalidCharacters); $i++) {
			if (strpos($string, $invalidCharacters[$i])) {
				$string = str_replace($invalidCharacters[$i], ' ', $string);
			}
		}

		return $string;
	}

    /*
		Export to Excel File
	*/
    public function export($title, $header, $data)
    {
    	$spreadsheet = new Spreadsheet();
    	$title = $this->replace_invalid_character($title);

    	$sheet = $spreadsheet->setActiveSheetIndex(0);
    	$spreadsheet->getActiveSheet()->setTitle($title);
    	$spreadsheet->setActiveSheetIndex(0);

    	$table_border = [
		    'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
		        ],
		    ],
		];

    	foreach ($header as $key => $val) {
    		$sheet->setCellValueByColumnAndRow($key + 1, 1, $val);
    	}

    	foreach ($data as $key => $val) {
    		if ($data[$key]) {
    			foreach ($data[$key] as $row => $content) {
    				$sheet->setCellValueByColumnAndRow($row + 1, $key + 2, $content);
					
					if (is_numeric($content) || substr($content, 0, 1) == "=") {
						$sheet->getStyle(number_to_alphabet($row + 1) . ($key + 2))->getNumberFormat()->setFormatCode('#,##0.00');
					}	

						if (validateDate($content, 'Y-m-d')) {
							$time = gmmktime(0, 0, 0, custom_date_format($content, 'Y-m-d', 'm'), custom_date_format($content, 'Y-m-d', 'd'), custom_date_format($content, 'Y-m-d', 'Y'));

							$sheet->setCellValue(number_to_alphabet($row + 1) . ($key + 2), \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($time));
							$sheet->getStyle(number_to_alphabet($row + 1) . ($key + 2))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
						}

						if (validateDate($content, 'Y-m-d H:i:s')) {
							$time = gmmktime(custom_date_format($content, 'Y-m-d H:i:s', 'H'), custom_date_format($content, 'Y-m-d H:i:s', 'i'), custom_date_format($content, 'Y-m-d H:i:s', 's'), custom_date_format($content, 'Y-m-d H:i:s', 'm'), custom_date_format($content, 'Y-m-d H:i:s', 'd'), custom_date_format($content, 'Y-m-d H:i:s', 'Y'));

							$sheet->setCellValue(number_to_alphabet($row + 1) . ($key + 2), \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($time));
							$sheet->getStyle(number_to_alphabet($row + 1) . ($key + 2))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DATETIME);
						}
					
    				if (substr($content, 0, 1) == "'") {
    					$sheet->setCellValueExplicitByColumnAndRow($row + 1, $key + 2, substr($content, 1, (strlen($content) - 1)), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    				}
    			}
    		}
    	}

    	foreach (range(number_to_alphabet(1), number_to_alphabet(count($header))) as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		$sheet->getStyle('A1:' . number_to_alphabet(count($header)) . (count($data) + 1))->applyFromArray($table_border);

    	$filename = str_replace(' ', '_', strtolower($title));
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

    /*
		Read File Excel to Array
    */
    public function read_excel_file($file)
    {
			if (strtolower(substr($file, -1, 4)) == 'xlsx') {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			}
    	
    	$spreadsheet = $reader->load($file);

    	return $spreadsheet->getActiveSheet()->toArray();
    }

	public function readExcelSheetFile($file)
	{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
	    $info = finfo_file($finfo, $file);

	    $ext = 'xls';
	   	if (in_array($info, ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])) {
	   		$ext = 'xlsx';
	   	}

		if ($ext == 'xlsx') {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		} else {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
		}
		
		$spreadsheet = $reader->load($file);
		$jumlahSheet = $spreadsheet->getSheetCount();

		$response = [];

		for ($i = 0; $i < $jumlahSheet; $i++) {
			$sheet = $spreadsheet->getSheet($i);
			$response['sheet'][] = $spreadsheet->getSheetNames()[$i];
			$response['content'][] = $sheet->toArray(null, true, true, true);
		}

		return $response;
	}
}

/* End of file MY_Model.php */
/* Location: ./application/models/MY_Model.php */ ?>