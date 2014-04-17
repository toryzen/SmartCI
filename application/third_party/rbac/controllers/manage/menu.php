<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CI RBAC
 * RBAC管理后台中菜单模块
 * @author		toryzen
 * @link		http://www.toryzen.com
 */
class Menu extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * 菜单主页
	 */
	public function index()
	{
		$menu_data = $this->get_menu_list();
		$this->load->view("manage/menu",$menu_data);
	}
	
	/**
	 * 菜单删除
	 */
	public function delete($id){
		$query = $this->db->query("SELECT rm.id,rm.title,rm.node_id,rm.p_id,rm.sort,rm.status,rn.memo FROM rbac_menu rm left join rbac_node rn on rm.node_id = rn.id WHERE rm.id =".$id);
		$data = $query->row_array();
		if($data){
			//获取当前节点及其子节点
			$menu_data = $this->get_menu_list($id);
			if($this->input->post()){
				$verfiy = $this->input->post("verfiy");
				$sql = "DELETE FROM rbac_menu WHERE id in (".$menu_data["id_list"].") ";
				$this->db->query($sql);
				success_redirct("manage/menu/index","菜单删除成功");
			}
			$this->load->view("manage/menu/delete",$menu_data);
		}else{
			error_redirct("manage/menu/index","未找到此菜单");
		}
	}
	/**
	 * 菜单新增
	*/
	public function add($id,$level,$p_id="NULL"){
		if($this->input->post()){
			$title = $this->input->post("title");
			$sort = $this->input->post("sort");
			$node = $this->input->post("node");
			$level = $this->input->post("level");
			if($id&&$level){
				if($title){
					$p_id   = $this->input->post("p_id");
					$status = $this->input->post("status")==""?"0":"1";
					$sql = "INSERT INTO rbac_menu (`status`,`title`,`sort`,`node_id`,`p_id`) values( '{$status}','{$title}','{$sort}','{$node}',{$p_id})";
					$this->db->query($sql);
					success_redirct("manage/menu/index","新增菜单成功！");
				}else{
					error_redirct("","标题不能为空！");
				}
			}else{
				error_redirct("","参数不正确！");
			}
		}
		$rbac_where = "";
		$node_hidden_array = $this->config->item('rbac_manage_node_hidden');
		if(!empty($node_hidden_array)){
			foreach($node_hidden_array as $node_hidden){
				$rbac_where.= "AND dirc != '$node_hidden' ";
			}
		}
		$node_query = $this->db->query("SELECT * FROM rbac_node WHERE status = 1 {$rbac_where} ORDER BY dirc,cont");
		$node_data = $node_query->result();
		$this->load->view("manage/menu/add",array("node"=>$node_data,"level"=>$level,"p_id"=>$p_id));
	}
	/**
	 * 菜单修改
	 */
	public function edit($id,$level,$p_id="NULL"){
		if($this->input->post()){
			$id = $this->input->post("id");
			$title = $this->input->post("title");
			$sort = $this->input->post("sort");
			$node = $this->input->post("node");
			$level = $this->input->post("level");
			if($id&&$level){
				if($title){
					$p_id   = $this->input->post("p_id")=="NULL"?"p_id = NULL":"p_id='{$p_id}'";
					$status = $this->input->post("status")==""?"status='0'":"status='1'";
					$sql = "UPDATE rbac_menu SET {$status},title='{$title}',sort='{$sort}',node_id='{$node}',{$p_id} WHERE id = '{$id}'";
					$this->db->query($sql);
					success_redirct("manage/menu/index","菜单修改成功！");
				}else{
					error_redirct("","标题不能为空！");
				}
			}else{
				error_redirct("","参数不正确！");
			}
		}
		$query = $this->db->query("SELECT rm.id,rm.title,rm.node_id,rm.p_id,rm.sort,rm.status,rn.memo FROM rbac_menu rm left join rbac_node rn on rm.node_id = rn.id WHERE rm.id =".$id);
		$data = $query->row_array();
		if($data){
			$rbac_where = "";
			$node_hidden_array = $this->config->item('rbac_manage_node_hidden');
			if(!empty($node_hidden_array)){
				foreach($node_hidden_array as $node_hidden){
					$rbac_where.= "AND dirc != '$node_hidden' ";
				}
			}
			$node_query = $this->db->query("SELECT * FROM rbac_node WHERE status = 1 {$rbac_where} ORDER BY dirc,cont");
			$node_data = $node_query->result();
			$this->load->view("manage/menu/edit",array("data"=>$data,"node"=>$node_data,"level"=>$level,"p_id"=>$p_id));
		}else{
			error_redirct("manage/menu/index","未找到此菜单");
		}
	}
	
	/**
	 * 获取菜单页
	 * @param string $id
	 * @return array($id_list,$menu)
	 */
	private function get_menu_list($id = NULL){
		$rbac_where = "";
		$menu_hidden_array = $this->config->item('rbac_manage_menu_hidden');
		if(!empty($menu_hidden_array)){
			foreach($menu_hidden_array as $menu_hidden){
				$rbac_where.= "AND title != '$menu_hidden' ";
			}
		}
		$query = $this->db->query("SELECT rm.*,rn.memo,concat(' [',rn.dirc,'/',rn.cont,'/',rn.func,']') as dcf  FROM rbac_menu rm left join rbac_node rn on rm.node_id = rn.id WHERE ".($id==NULL?"rm.p_id  is NULL":"rm.id  = '".$id."'")." {$rbac_where} ORDER BY sort asc");
		$menu_data = $query->result();
		$i = 0;
		$all_id_list = "";
		while(count($menu_data)>0){
			$id_list = "";
			foreach($menu_data as $vo){
				if($i==2){
					$vo->p_p_id = $Tmp_menu[1][$vo->p_id]->p_id;
				}
				$Tmp_menu[$i][$vo->id] = $vo;
				$id_list .= $vo->id.",";
				$all_id_list .= $vo->id.",";
			}
			$id_list = substr($id_list,0,-1);
			$query = $this->db->query("SELECT rm.*,rn.memo,concat(' [',rn.dirc,'/',rn.cont,'/',rn.func,']') as dcf FROM rbac_menu rm left join rbac_node rn on rm.node_id = rn.id WHERE rm.p_id in (".$id_list.") ORDER BY sort asc");
			$menu_data = $query->result();
			$i++;
		}
		$j = 0;
		foreach($Tmp_menu as $vo){
			foreach($vo as $cvo){
				if($j==0){
					$menu[$cvo->id]["self"] = $cvo;
				}elseif($j==1){
					$menu[$cvo->p_id]["child"][$cvo->id]["self"] = $cvo;
				}else{
					$menu[$cvo->p_p_id]["child"][$cvo->p_id]["child"][$cvo->id]["self"] =$cvo;
				}
			}
			$j++;
		}
		$return["id_list"] = substr($all_id_list,0,-1);
		$return["menu"]    = $menu;
		return $return;
	}

}
