<?php  
function arrbulan()
{
	return [
		1 => 'Jan',
		2 => 'Feb',
		3 => 'Mar',
		4 => 'Apr',
		5 => 'Mei', 
		6 => 'Jun',
		7 => 'Jul',
		8 => 'Aug',
		9 => 'Sep',
		10 => 'Oct',
		11 => 'Nop',
		12 => 'Dec'
	];
}

function arrtahun()
{
	$year = date('Y');

	return [ 
		$year,
		($year - 1)
	];
}

function get_last_day_of_month($date)
{
	$ci =& get_instance();

	$q = $ci->db->query("SELECT LAST_DAY('$date') AS tgl")->row();

	return isset($q->tgl) ? $q->tgl : '';
}

function format_tgl($date)
{
	$date = date_create($date);
	$date = date_format($date, 'd/m/Y');

	return $date;
}

function dt_searching($kolom, $keyword)
{
	$condition = '';
	if ($keyword <> '') {
		$condition .= " AND ( ";
		for ($i = 0; $i < count($kolom); $i++) {
			$condition .= " $kolom[$i] LIKE '%$keyword%' ";

			if (end($kolom) <> $kolom[$i]) {
				$condition .= " OR ";
			}
		}
		$condition .= " ) ";
	}

	return $condition;
}

function dt_order($kolom, $order_column, $order_mode)
{
	$order = " ORDER BY $kolom[$order_column] $order_mode ";

	return $order;
}

function to_sql_date($date, $format)
{
	$date = date_create_from_format($format, $date);
	$date = date_format($date, 'Y-m-d');

	return $date;
}

function custom_date_format($date, $from, $to)
{
	if ($date <> '') {
		$date = date_create_from_format($from, $date);
		$date = date_format($date, $to);
	}

	return $date;
}

function sage_date($date)
{
	$date = explode('.', $date);
	$date = $date[0];
	$date = explode(' ', $date);
	$date = $date[0];

	return custom_date_format($date, 'Y-m-d', 'd/m/Y');
}

function barcode_to_lotnumber($barcode)
{
	$lot_results = '';
	$item_code = '';
	$lotnumber_value = '';

	if (substr($barcode, 0, 5) == ']d291') {
		$lot_results = substr_replace($barcode, '', 0, 5);
	} else if (substr($barcode, 0, 2) == '91') {	
		$lot_results = substr_replace($barcode, '', 0, 2);
	}

	if ($lot_results <> '') {
		$item_code = substr($lot_results, 0, 17);
		$lotnumber_value = substr($lot_results, 19, 35);
	}

	return [
		'item_code' => $item_code,
		'lotnumber' => $lotnumber_value
	];
}

function excel_number_to_column_name($number) {
    $numeric = ($number - 1) % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval(($number - 1) / 26);
    if ($num2 > 0) {
        return excel_number_to_column_name($num2) . $letter;
    } else {
        return $letter;
    }
}

function remove_special_characters($string) {
	if (strpos($string, '/')) {
		$string = str_replace('/', '1', $string);
	}

	if (strpos($string, '?')) {
		$string = str_replace('?', '2', $string);
	}

	if (strpos($string, '(')) {
		$string = str_replace('(', '3', $string);
	}

	if (strpos($string, ')')) {
		$string = str_replace(')', '4', $string);
	}

	return $string;
}

function kode_to_jenis($kode)
{
	$data = [
		'MJ' => 'MEN JAS',
		'LJ' => 'LADIES JAS',
		'MP' => 'MEN PANTS',
		'MV' => 'MEN VEST',
		'LP' => 'LADIES PANTS',
		'LS' => 'LADIES SKIRT',
		'FG' => 'FINISH GOOD'
	];	

	return isset($data[$kode]) ? $data[$kode] : '';
}

function kode_jenis($kode)
{
	$data = [
		'MJ' => 'JAS',
		'LJ' => 'JAS',
		'MP' => 'PANTS',
		'MV' => 'VEST',
		'LP' => 'PANTS',
		'LS' => 'SKIRT',
		'FG' => 'FINISH GOOD'
	];	

	return isset($data[$kode]) ? $data[$kode] : '';
}

function tgl_indo($date)
{
	if ($date != '') {
		$hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
		$week = date('w', strtotime($date));

		return $hari[$week].', '.custom_date_format($date, 'Y-m-d', 'd/m/Y');
	} 

	return '-';
}

function split_string_number($string) 
{
	return preg_split('#(?<=\d)(?=[a-z])#i', $string);
}

function generate_barcode($text)
{
	$ci =& get_instance();
	$ci->load->library('zend');
    $ci->zend->load('Zend/Barcode');

    $image_resource = Zend_Barcode::factory('code128', 'image', ['text' => $text, 'drawText' => false], [])->draw();
	$image_name     = str_replace('/', '', $text).'.jpg';
    $image_dir      = './assets/qrcode/';

    imagejpeg($image_resource, $image_dir.$image_name);
}

function img_to_base64($img)
{
	$type = pathinfo($img, PATHINFO_EXTENSION);
	$data = file_get_contents($img);
	$base64 = 'data:image/'. $type .';base64,' . base64_encode($data);

	return $base64;
}

function generate_qrcode($teks)
{
	$ci =& get_instance();

	$ci->load->library('ciqrcode');
	$config['cacheable'] = true; //boolean, the default is true
    $config['cachedir'] = './assets/'; //string, the default is application/cache/
    $config['errorlog'] = './assets/'; //string, the default is application/logs/
    $config['imagedir'] = './assets/qrcode/'; //direktori penyimpanan qr code
    $config['quality'] = true; //boolean, the default is true
    $config['size'] = '1024'; //interger, the default is 1024
    $config['black'] = array(224,255,255); // array, default is array(255,255,255)
    $config['white'] = array(70,130,180); // array, default is array(0,0,0)
    $ci->ciqrcode->initialize($config);

    $image_name = md5($teks).'.png';
    $params['data'] = $teks;
    $params['level'] = 'H'; //H=High
    $params['size'] = 10;
    $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/

    $ci->ciqrcode->generate($params); // fungsi untuk generate QR CODE

    return $image_name;
}

function ws_time($date)
{
	$dt = new DateTime($date);
	$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
	return $dt->format('Y-m-d\TH:i:s.\0\0\0\Z');
}