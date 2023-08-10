<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Test_Login extends CI_Controller {
	public function index() {
		$data = "";

		$this->load->view('template/ext_template');
        $this->load->view('test_login/index');
	}
}