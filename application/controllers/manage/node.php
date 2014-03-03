<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Node extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function index()
	{
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
		$this->load->view('manage/node',array('node'=>$node_list));
	}
	
	public function add($dirc=NULL,$cont=NULL,$func=NULL){
		if($this->input->post()){
			$dirc = $this->input->post("dirc")?$this->input->post("dirc"):$dirc;
			$cont = $this->input->post("cont")?$this->input->post("cont"):$cont;
			$func    = $this->input->post("func");
			$memo   = $this->input->post("memo");
			$status   = $this->input->post("status")==1?1:0;
			if($dirc&&$cont&&$func&&$memo){
				$query = $this->db->query("SELECT id FROM rbac_node WHERE dirc = '".$dirc."' AND cont = '".$cont."' AND func = '".$func."'");
				$data = $query->row_array();
				if(!$data){
					$sql = "INSERT INTO rbac_node (`dirc`,`cont`,`func`,`status`,`memo`) values('{$dirc}','{$cont}','{$func}','{$status}','{$memo}')";
					//echo $sql;die();
					$this->db->query($sql);
					success_redirct('manage/Node/index','节点添加成功！');
				}else{
					error_redirct('',"该节点已存在！");
				}
			}else{
				error_redirct('',"信息填写不全！");
			}
		}
		$this->load->view('manage/node/add',array('dirc'=>$dirc,'cont'=>$cont,'func'=>$func));
	}
	
	public function delete($dirc=NULL,$cont=NULL,$func=NULL){
		if($dirc==NULL){error_redirct("manage/Node/index","操作失败");}
		if($this->input->post()){
			$verfiy = $this->input->post("verfiy");
			if($verfiy){
				$where_dirc = "dirc = '{$dirc}'";
				$where_cont = $cont==NULL?"":" AND cont = '{$cont}'";
				$where_func = $func==NULL?"":" AND func = '{$func}'";
				$query = $this->db->query("SELECT GROUP_CONCAT(id) as node_id FROM rbac_node WHERE {$where_dirc} {$where_cont} {$where_func}");
				$node_list = $query->row_array();
				$sql = "UPDATE rbac_menu SET node_id = NULL WHERE node_id in (".$node_list['node_id'].")";
				$this->db->query($sql);
				$sql = "DELETE FROM rbac_node WHERE {$where_dirc} {$where_cont} {$where_func} ";
				$this->db->query($sql);
				success_redirct("manage/Node/index","删除成功");
			}else{
				error_redirct("manage/Node/index","操作失败");
			}
		
		}
		$this->load->view('manage/node/delete',array('dirc'=>$dirc,'cont'=>$cont,'func'=>$func));
	}
	
	public function edit($id){
		$query = $this->db->query("SELECT * FROM rbac_node WHERE id = ".$id);
		$data = $query->row_array();
		if($data){
			if($this->input->post()){
				$memo   = $this->input->post("memo");
				$status   = $this->input->post("status")==1?1:0;
				if($memo){
					$sql = "UPDATE rbac_node set `memo`='{$memo}',`status` = '{$status}' WHERE id = {$id}";
					$this->db->query($sql);
					success_redirct("manage/Node/index","节点修改成功");
				}else{
					error_redirct('',"信息填写不全！");
				}
			}
			$this->load->view("manage/node/edit",array('data'=>$data));
		}else{
			error_redirct("manage/Node/index","未找到此节点");
		}
	}

}
