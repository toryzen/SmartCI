<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	}

	public function index()
	{
		//取消重写VIEW
		//$this->view_override = FALSE;
		$header = array(
			'header_title'=>'测试系统页面'
		);
		$this->load->view("product/index",$header);
	}

}
