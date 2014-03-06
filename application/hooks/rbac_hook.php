<?php 
class Rbac {

	/*
	 * 权限验证(Hook自动加载)
	 */
	public function aoto_verify(){
		$ci_obj = &get_instance();
		//目录
		$directory = substr($ci_obj->router->fetch_directory(),0,-1);
		//控制器
		$controller = $ci_obj->router->fetch_class();
		//方法
		$function = $ci_obj->router->fetch_method();
		//echo "(".$directory."/".$controller."/".$function.")";	
		if($directory!=""){//当非主目录
			if($ci_obj->config->item('rbac_auth_on')){//开启认证
				if(!in_array($directory,$ci_obj->config->item('rbac_notauth_dirc'))){//需要验证的目录
					//验证是否登录
					if(!isset($_SESSION[$ci_obj->config->item('rbac_auth_key')]["INFO"]["id"])){
						error_redirct($ci_obj->config->item('rbac_auth_gateway'),"请先登录！");
						die();
					}
					if($ci_obj->config->item('rbac_auth_type')==2){//若为实时认证
						$ci_obj->load->model("rbac_model");
						//检测用户状态
						$STATUS = $ci_obj->rbac_model->check_user_by_id($_SESSION[$ci_obj->config->item('rbac_auth_key')]["INFO"]["id"]);
						if($STATUS==FALSE){
							error_redirct($this->config->item('rbac_auth_gateway'),$STATUS);
						}
						//ACL重新赋权
						$ci_obj->rbac_model->get_acl($_SESSION[$ci_obj->config->item('rbac_auth_key')]["INFO"]["role_id"]);
					}
					//验证ACL权限
					if(@!$_SESSION[$ci_obj->config->item('rbac_auth_key')]["ACL"][$directory][$controller][$function]){
						error_redirct("","无权访问此节点！(".$directory."/".$controller."/".$function.")");
						die();
					}
				}
			}
			//已登录且有权限,获取左侧菜单
			if($ci_obj->config->item('rbac_auth_type')==2){//若为实时认证
				$ci_obj->get_menu = $this->get_menu();
			}else{
				if(isset($_SESSION[$ci_obj->config->item('rbac_auth_key')]["MENU"])){
					$ci_obj->get_menu = $_SESSION[$ci_obj->config->item('rbac_auth_key')]["MENU"];
				}else{
					$_SESSION[$ci_obj->config->item('rbac_auth_key')]["MENU"] = $this->get_menu();
					$ci_obj->get_menu = $_SESSION[$ci_obj->config->item('rbac_auth_key')]["MENU"];
				}
			}
			//默认重写View开
			$ci_obj->view_override = TRUE;
		}
	}
		
	/*
	 * 重写View
	 */
	public function view_override() {
		$ci_obj = &get_instance();
		$directory = substr($ci_obj->router->fetch_directory(),0,-1);
		if(@$ci_obj->view_override&&$directory!=""){
			$html = $ci_obj->load->view('main', null, true);
		}else{
			$html = $ci_obj->output->get_output();
		}
		$ci_obj->output->_display($html);
	}
	
	/*
	 * 获取左侧菜单
	*/
	public function get_menu(){
		$ci_obj = &get_instance();
		
		$ci_obj->load->database();
		$query = $ci_obj->db->query("SELECT rm.id,rm.title,rm.node_id,rm.p_id,rn.dirc,rn.cont,rn.func FROM rbac_menu rm left join rbac_node rn on rm.node_id = rn.id WHERE rm.status = 1 AND rm.p_id is NULL ORDER BY sort asc");
		$menu_data = $query->result();
		$i = 0;
		while(count($menu_data)>0){
			$id_list = "";
			foreach($menu_data as $vo){
				if($i==2){
					$vo->p_p_id = $Tmp_menu[1][$vo->p_id]->p_id;
				}
				$Tmp_menu[$i][$vo->id] = $vo;
				$id_list .= $vo->id.",";
			}
			$id_list = substr($id_list,0,-1);
			$query = $ci_obj->db->query("SELECT rm.id,rm.title,rm.node_id,rm.p_id,rn.dirc,rn.cont,rn.func FROM rbac_menu rm left join rbac_node rn on rm.node_id = rn.id WHERE rm.status = 1 AND rm.p_id in (".$id_list.") ORDER BY sort asc");
			$menu_data = $query->result();
			$i++;
		}
		$j = 0;
		//按权限进行展示
		foreach($Tmp_menu as $vo){
			foreach($vo as $cvo){
				if(@$_SESSION[$ci_obj->config->item('rbac_auth_key')]["ACL"][$cvo->dirc][$cvo->cont][$cvo->func]||!$cvo->node_id){
					if($j==0){
						if(@$_SESSION[$ci_obj->config->item('rbac_auth_key')]["ACL"][$cvo->dirc][$cvo->cont][$cvo->func]){
							$menu[$cvo->id]["shown"] = 1;
						}
						$menu[$cvo->id]["self"] = array("title"=>$cvo->title,"uri"=>$cvo->dirc?$cvo->dirc."/".$cvo->cont."/".$cvo->func:$cvo->cont."/".$cvo->func);
							
					}elseif($j==1){
						if(@$_SESSION[$ci_obj->config->item('rbac_auth_key')]["ACL"][$cvo->dirc][$cvo->cont][$cvo->func]){
							$menu[$cvo->p_id]["shown"] = 1;
							$menu[$cvo->p_id]["child"][$cvo->id]["shown"] = 1;
						}
						$menu[$cvo->p_id]["child"][$cvo->id]["self"] = array("title"=>$cvo->title,"uri"=>$cvo->dirc?$cvo->dirc."/".$cvo->cont."/".$cvo->func:$cvo->cont."/".$cvo->func);
							
					}else{
						if(@$_SESSION[$ci_obj->config->item('rbac_auth_key')]["ACL"][$cvo->dirc][$cvo->cont][$cvo->func]){
							$menu[$cvo->p_p_id]["shown"] = 1;
							$menu[$cvo->p_p_id]["child"][$cvo->p_id]["shown"] = 1;
							$menu[$cvo->p_p_id]["child"][$cvo->p_id]["child"][$cvo->id]["shown"] = 1;
						}
						$menu[$cvo->p_p_id]["child"][$cvo->p_id]["child"][$cvo->id]["self"] = array("title"=>$cvo->title,"uri"=>$cvo->dirc?$cvo->dirc."/".$cvo->cont."/".$cvo->func:$cvo->cont."/".$cvo->func);
					}
				}
			}
			$j++;
		}
		return $menu;
	}
}
