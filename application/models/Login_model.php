<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function is_login()
	{
		$username = $this->session->userdata('username');
		$session = $this->session->userdata('session');

		$is_login = FALSE;

		if ($username <> '' && $session <> '') {
			$is_logged_in = $this->db->where([
				'username' => $username, 
				'session' => $session
			])
			->get('tb_user')
			->row();

			if (!empty($is_logged_in)) {
				$is_login = TRUE;
			}
		} else {
			$cookie = get_cookie('auth-login');
			if ($cookie <> '') {
				$cari = $this->db->where([
					'session' => $cookie
				])->get('tb_user')->row();

				if ($cari) {
					$username = isset($cari->username) ? $cari->username : '';
					if ($username != '') {
						$random = rand();
						$session = md5($random);

						$this->db->where(['username' => $username])
							->update('tb_user', ['session' => $session]);

						set_cookie('auth-login', $session, 36000);

						$session_data = array(
							'session' => $session,
							'username' => $username
						);
						
						$this->session->set_userdata( $session_data );
						$is_login = TRUE;
					}
				}
			}
		}

		return ($is_login) ? TRUE : FALSE;
	}

	public function login($username = '', $password = '')
	{
		$password = md5($password.'&fk_project*123#');
		$is_login = $this->db->where([
			'username' => $username, 
			'password' => $password, 
			'status' => 1
		])->get('tb_user')->row();

		if ($is_login) {
			$random = rand();
			$session = md5($random);

			$sql = "UPDATE tb_user SET session = ?, last_login = NOW() WHERE username = ?";
			$this->db->query($sql, [$session, $username]);

			return [
				'language' => $is_login->language,
				'session' => $session,
				'islogin' => TRUE
			];
		}

		return [
			'language' => '',
			'session' => '',
			'islogin' => FALSE
		];
	}

	public function isvalid_page()
	{
		$username = $this->session->userdata('username');

		$fungsi = $this->router->fetch_class();
		$method = $this->router->fetch_method();

		$data = $this->db->query("
			SELECT a.*
			FROM tb_user_menu a
			INNER JOIN tb_menu b ON a.`id_menu` = b.id
			WHERE a.`username` = ?
			AND b.`method` = ?
			AND b.`fungsi` = ? ", 
		[$username, $method, $fungsi])->row();

		return ($data) ? $data : false;
	}

	public function get_user_profile($username)
	{
		$cache = $this->cache->get("$username-profile");
		if ($cache) {
			return $cache;
		}

		$data = $this->db->where([
				'username' => $username
			])
			->get('tb_user')
			->row();

		$this->cache->save("$username-profile", $data);
		return $data;
	}

	public function first_page($username)
	{
		$sql = $this->db->query("
			SELECT b.`url`
			FROM tb_user_menu a
			INNER JOIN tb_menu b ON a.`id_menu` = b.`id`
			WHERE a.`username` = ?
			AND b.`url` <> ''
			ORDER BY b.`urutan` ASC
			LIMIT 1 ", [$username])->row();	

		return isset($sql->url) ? $sql->url : 'Main';
	}
}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */ ?>