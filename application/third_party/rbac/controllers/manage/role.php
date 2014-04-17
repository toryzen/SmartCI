<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CI RBAC
 * RBAC后台管理中角色模块
 * @author		toryzen
 * @link		http://www.toryzen.com
 */
class Role extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	/**
	 * 角色首页
	 * @param number $page
	 */
	public function index($page=1)
	{
		$query = $this->db->query("SELECT COUNT(1) as cnt FROM rbac_role");
		$cnt_data = $query->row_array();
		//分页
		$this->load->library('pagination');
		$config['base_url'] = site_url("manage/role/index");
		$config['total_rows'] = $cnt_data['cnt'];
		$config['per_page']   = 35;
		$config['uri_segment']= '4';
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		
		$query = $this->db->query("SELECT * FROM rbac_role LIMIT ".(($page-1)*$config['per_page']).",".$config['per_page']."");
		$data = $query->result();
		$this->load->view("manage/role",array("data"=>$data));
	}
	
	/**
	 * 角色修改
	 * @param number $id
	 */
	public function edit($id){
		$query = $this->db->query("SELECT * FROM rbac_role WHERE id = ".$id);
		$data = $query->row_array();
		if($data){
			if($this->input->post()){
				$rolename = $this->input->post("rolename");
				$status = $this->input->post("status")?1:0;
				if($rolename){
					$sql = "UPDATE rbac_role set `rolename`='{$rolename}',`status`='{$status}' WHERE id = {$id}";
					$this->db->query($sql);
					success_redirct("manage/role/index","角色信息修改成功！");
				}else{
					error_redirct("","信息填写不全！");
				}
			}
			$this->load->view("manage/role/edit",array("data"=>$data));
		}else{
			error_redirct("manage/role/index","未找到此角色");
		}
	}
	
	/**
	 * 角色新增
	 * @param number $id
	 */
	public function add(){
		if($this->input->post()){
			$rolename = $this->input->post("rolename");
			$status = $this->input->post("status")?1:0;
			if($rolename){
				$query = $this->db->query("SELECT * FROM rbac_role WHERE rolename = '".$rolename."'");
				$data = $query->row_array();
				if(!$data){
					$sql = "INSERT INTO rbac_role (`rolename`,`status`) values('{$rolename}','{$status}')";
					$this->db->query($sql);
					success_redirct("manage/role/index","角色新增成功！");
				}else{
					error_redirct("","此角色名已存在！");
				}
				
			}else{
				error_redirct("","信息填写不全！");
			}
		}
		$this->load->view("manage/role/add");
	}
	
	/**
	 * 角色删除
	 * @param number $id
	 */
	public function delete($id){
		$query = $this->db->query("SELECT * FROM `rbac_role` WHERE id = ".$id);
		$data = $query->row_array();
		if($data){
			if($this->input->post()){
				$verfiy = $this->input->post("verfiy");
				if($verfiy){
					$sql = "DELETE FROM `rbac_role` WHERE id = ".$id." ";
					$this->db->query($sql);
					$sql = "DELETE FROM `rbac_auth` WHERE role_id = ".$id." ";
					$this->db->query($sql);
					success_redirct("manage/role/index","角色删除成功");
				}else{
					error_redirct("manage/role/index","操作失败");
				}
	
			}
			$this->load->view("manage/role/delete",array("data"=>$data));
		}else{
			error_redirct("manage/role/index","未找到此角色");
		}
	}
	
	/**
	 * 角色赋权
	 * @param number $id
	 */
	public function action($id,$node_id=NULL){
		if(!$id){error_redirct("manage/role/index","未找到此角色");}
		if($node_id!=NULL){
			$query = $this->db->query("SELECT node_id FROM rbac_auth WHERE node_id= {$node_id} AND role_id={$id}");
			$data = $query->row_array();
			if($data){
				$sql = "DELETE FROM rbac_auth WHERE node_id= {$node_id} AND role_id={$id}";
			}else{
				$sql = "INSERT INTO rbac_auth (`node_id`,`role_id`) values('{$node_id}','{$id}')";
			}
			$this->db->query($sql);
			success_redirct("","节点操作成功",1);
			
		}
		$rbac_where = "";
		$node_hidden_array = $this->config->item('rbac_manage_node_hidden');
		if(!empty($node_hidden_array)){
			$rbac_where = "WHERE ";
			foreach($node_hidden_array as $node_hidden){
				$rbac_where.= "dirc != '$node_hidden' AND ";
			}
			$rbac_where = substr($rbac_where,0,-4);
		}
		$query = $this->db->query("SELECT * FROM rbac_node {$rbac_where} ORDER BY dirc,cont,func");
		$data = $query->result();
		foreach($data as $vo){
			$node_list[$vo->dirc][$vo->cont][$vo->func] = $vo;
		}
		$query = $this->db->query("SELECT id,dirc,cont,func FROM `rbac_node` WHERE id in (SELECT node_id FROM `rbac_auth` WHERE role_id = ".$id.")");
		$role_data = $query->result();
		foreach($role_data as $vo){
			$role_node_list[$vo->dirc][$vo->cont][$vo->func] = TRUE;
		}
		$this->load->view('manage/role/action',array('role_id'=>$id,'node'=>$node_list,'rnl'=>$role_node_list));
	}
	
}
