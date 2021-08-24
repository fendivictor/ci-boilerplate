<?php

class Authentication {
    public function __construct()
	{
		parent::__construct();
        // Load CI instances
        $this->ci =& get_instance();
        // Load Model
        $this->ci->load->model([
            'Users'
        ]);
	}

    public function doLogin($username, $password)
    {
        // Check username
        $isValidUsername = $this->Users->find(['username' => $username], false);

        // If username not exists
        if (! $isValidUsername) {
            return [
                'status' => false,
                'message' => 'Username not exists'
            ];
        }

        // Check Username & Password
        $isValidLogin = $this->Users->find(['username' => $username, 'password' => $password], false);

        // If combination between password and username wrong
        if (! $isValidLogin) {
            return [
                'status' => false,
                'message' => 'Invalid Username & password'
            ];
        }  

        // Create Session 
        $this->createSession([
            'username' => $isValidLogin->username,
            'token' => $this->createLoginToken()
        ]);

        // If everything was OK
        return [
            'status' => true,
            'message' => 'OK'
        ];
    }

    public function createSession($arrSession)
    {
        // Set session
        $this->ci->session->set_userdata($arrSession);
    }

    public function createLoginToken()
    {
        // Generate token
        $random = rand();

        return md5($random);
    }
}