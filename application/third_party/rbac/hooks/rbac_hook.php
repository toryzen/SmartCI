<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * CI RBAC
 * RBAC钩子,用于权限验证&菜单生成&视图重写
 * @author		toryzen
 * @link		http://www.toryzen.com
 */
class Rbac {
	
	private $ci_obj;
	
	public function __construct(){
		$this->ci_obj = &get_instance();
		$this->ci_obj->load->helper(array('rbac','url'));
		$this->ci_obj->load->config('rbac');
		if(!isset($this->ci_obj->view_override)){
			//默认重写View开
			$this->ci_obj->view_override = TRUE;
		}
	}
	/*
	 * 权限验证(Hook自动加载)
	 */
	public function aoto_verify(){
		//目录
		$directory = substr($this->ci_obj->router->fetch_directory(),0,-1);
		//控制器
		$controller = $this->ci_obj->router->fetch_class();
		//方法
		$function = $this->ci_obj->router->fetch_method();
		//UURI(MD5)
		$this->ci_obj->uuri = md5($directory.$controller.$function);
		if($directory!=""){//当非主目录
			if($this->ci_obj->config->item('rbac_auth_on')){//开启认证
				if(!in_array($directory,$this->ci_obj->config->item('rbac_notauth_dirc'))){//需要验证的目录
					//验证是否登录
					//echo rbac_conf(array('INFO','id'));
					if(!rbac_conf(array('INFO','id'))){
						error_redirct($this->ci_obj->config->item('rbac_auth_gateway'),"请先登录！");
						die();
					}
					if($this->ci_obj->config->item('rbac_auth_type')==2){//若为实时认证
						$this->ci_obj->load->model("rbac_model");
						//检测用户状态
						$STATUS = $this->ci_obj->rbac_model->check_user_by_id(rbac_conf(array('INFO','id')));
						if($STATUS==FALSE){
							error_redirct($this->config->item('rbac_auth_gateway'),$STATUS);
						}
						//ACL重新赋权
						$this->ci_obj->rbac_model->get_acl(rbac_conf(array('INFO','role_id')));
					}
					
					//验证ACL权限
					if(!rbac_conf(array('ACL',$directory,$controller,$function))){
						error_redirct("","无权访问此节点！(".$directory."/".$controller."/".$function.")");
						die();
					}
				}
			}
			//已登录且有权限,获取左侧菜单
			if($this->ci_obj->config->item('rbac_auth_type')==2){//若为实时认证
				$this->ci_obj->get_menu = $this->get_menu();
			}else{
				if(rbac_conf(array('MENU'))){
					$this->ci_obj->get_menu = rbac_conf(array('MENU'));
				}else{
					rbac_conf(array('MENU'),$this->get_menu());
					$this->ci_obj->get_menu = rbac_conf(array('MENU'));
				}
			}
		}
	}
		
	/*
	 * 重写View
	 */
	public function view_override() {
		$directory = substr($this->ci_obj->router->fetch_directory(),0,-1);
		if(@$this->ci_obj->view_override&&$directory!=""){
			$html = $this->ci_obj->load->view('main', null, true);
		}else{
			$html = $this->ci_obj->output->get_output();
		}
		$this->ci_obj->output->_display($html);
	}
	
	/*
	 * 获取左侧菜单
	*/
	private function get_menu(){		
		$this->ci_obj->load->database();
		$query = $this->ci_obj->db->query("SELECT rm.id,rm.title,rm.node_id,rm.p_id,rn.dirc,rn.cont,rn.func FROM rbac_menu rm left join rbac_node rn on rm.node_id = rn.id WHERE rm.status = 1 AND rm.p_id is NULL ORDER BY sort asc");
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
			$query = $this->ci_obj->db->query("SELECT rm.id,rm.title,rm.node_id,rm.p_id,rn.dirc,rn.cont,rn.func FROM rbac_menu rm left join rbac_node rn on rm.node_id = rn.id WHERE rm.status = 1 AND rm.p_id in (".$id_list.") ORDER BY sort asc");
			$menu_data = $query->result();
			$i++;
		}
		$j = 0;
		//按权限进行展示
		foreach($Tmp_menu as $vo){
			foreach($vo as $cvo){
				$menu['list'][md5($cvo->dirc.$cvo->cont.$cvo->func)] = $cvo->title;
				if(rbac_conf(array('ACL',$cvo->dirc,$cvo->cont,$cvo->func))||!$cvo->node_id){
					if($j==0){
						if(rbac_conf(array('ACL',$cvo->dirc,$cvo->cont,$cvo->func))){
							$menu[$cvo->id]["shown"] = 1;
						}
						$menu[$cvo->id]["self"] = array("title"=>$cvo->title,"uri"=>$cvo->dirc?$cvo->dirc."/".$cvo->cont."/".$cvo->func:$cvo->cont."/".$cvo->func);
							
					}elseif($j==1){
						if(rbac_conf(array('ACL',$cvo->dirc,$cvo->cont,$cvo->func))){
							$menu[$cvo->p_id]["shown"] = 1;
							$menu[$cvo->p_id]["child"][$cvo->id]["shown"] = 1;
						}
						$menu[$cvo->p_id]["child"][$cvo->id]["self"] = array("title"=>$cvo->title,"uri"=>$cvo->dirc?$cvo->dirc."/".$cvo->cont."/".$cvo->func:$cvo->cont."/".$cvo->func);
							
					}else{
						if(rbac_conf(array('ACL',$cvo->dirc,$cvo->cont,$cvo->func))){
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
		//print_r($menu);
		return $menu;
	}
}
