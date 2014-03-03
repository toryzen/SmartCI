<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	}

	public function index()
	{
		//验证是否登录
		if(!isset($_SESSION[$this->config->item('rbac_auth_key')]["INFO"]["id"])){
			error_redirct($this->config->item('rbac_auth_gateway'),"请先登录！");
		}else{
			success_redirct($this->config->item('rbac_default_index'),"您已成功登录,正在跳转请稍候！","1");
		}
	}
	/*
	 * 用户登录
	 */
	public function login(){
		
		$this->load->model("rbac_model");
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		if($username&&$password){
			$STATUS = $this->rbac_model->check_user($username,md5($password));
			if($STATUS===TRUE){
				success_redirct($this->config->item('rbac_default_index'),"登录成功！");
				//die();
			}else{
				error_redirct($this->config->item('rbac_auth_gateway'),$STATUS);
				die();
			}
			
		}else{
			session_destroy();
			$this->load->view("login");
		}
		
	}
	/*
	 * 用户退出
	 */
	public function logout(){
		session_destroy();
		success_redirct($this->config->item('rbac_auth_gateway'),"登出成功！",2);
	}

}
