<?php 
class Rbac_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	/*
	 * 获取权限列表
	*/
	public function get_acl($role_id){
		//$query = $this->db->query("SELECT role_id FROM `rbac_role_user` WHERE user_id = ".$userid." LIMIT 1");
		//$data = $query->row_array();
		//if($data['role_id']>0){
		$query = $this->db->query("SELECT id,dirc,cont,func FROM `rbac_node` WHERE id in (SELECT node_id FROM `rbac_auth` WHERE role_id = ".$role_id.")");
		$role_data = $query->result();
		foreach($role_data as $vo){
			$Tmp_role[$vo->dirc][$vo->cont][$vo->func] = TRUE;
		}
		$_SESSION[$this->config->item('rbac_auth_key')]["ACL"] = $Tmp_role;
		//}
	}
	
	/*
	 * 用户登录检测
	*/
	public function check_user($username,$password){
		$query = $this->db->query("SELECT id,password,nickname,email,role_id,status FROM `rbac_user` WHERE username = '".$username."' LIMIT 1");
		$data  = $query->row_array();
		if($data){
			if($data['status']==1){
				if($data['password']==$password){
					$_SESSION[$this->config->item('rbac_auth_key')]["INFO"]["id"]      = $data['id'];
					$_SESSION[$this->config->item('rbac_auth_key')]["INFO"]["role_id"] = $data['role_id'];
					$_SESSION[$this->config->item('rbac_auth_key')]["INFO"]["email"]   = $data['email'];
					$_SESSION[$this->config->item('rbac_auth_key')]["INFO"]["nickname"] = $data['nickname'];
					$this->get_acl($data['role_id']);
					return TRUE;
				}
				else{
					return "用户密码错误！";
				}
			}else{
				return "该用户已禁用！";
			}
		}else{
			return "该用户不存！";
		}
	}
	
	/*
	 * 用户登录检测 By id
	*/
	public function check_user_by_id($id){
		$query = $this->db->query("SELECT id,password,nickname,email,role_id,status FROM `rbac_user` WHERE id = '".$id."' LIMIT 1");
		$data = $query->row_array();
		if($data){
			if($data['status']==1){
				$_SESSION[$this->config->item('rbac_auth_key')]["INFO"]["id"] = $data['id'];
				$_SESSION[$this->config->item('rbac_auth_key')]["INFO"]["role_id"] = $data['role_id'];
				$_SESSION[$this->config->item('rbac_auth_key')]["INFO"]["email"] = $data['email'];
				$_SESSION[$this->config->item('rbac_auth_key')]["INFO"]["nickname"] = $data['nickname'];
				$this->get_acl($data['role_id']);
				return TRUE;
			}else{
				return "该用户已禁用！";
			}
		}else{
			return "该用户不存！";
		}
	}
	
}
