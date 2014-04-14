<?php
/**
 * 设置或获取配置（SESSION&MEMCACHED?）
 */

//MEMCACHED
if(!function_exists('mem_inst')){
	function mem_inst(){
		$ci_obj = &get_instance();
		$ci_obj->config->load('memcached',TRUE);
		//if($ci_obj->config->item('flag','memcached')){
		if($static_memc)return $static_memc;
		static $static_memc;
		$memc = new memcached($ci_obj->config->item('config','memcached'));
		$static_memc = $memc;
		return $static_memc;
	}
}

//获取&设置RBAC数据
if(!function_exists('rbac_conf')){
	function rbac_conf($arr_key,$value=NULL){
		$ci_obj = &get_instance();
		//获取
		if(!$config = mem_inst()->get(md5(session_id()))){
			$config = $_SESSION[$ci_obj->config->item('rbac_auth_key')];
		}
		$conf[-1] = &$config;
		foreach($arr_key as $k=>$ar){
			$conf[$k] = &$conf[$k-1][$ar];
		}
		if($value !==NULL){
			$conf[count($arr_key)-1] = $value;
		}
		//设置
		if(!mem_inst()->set(md5(session_id()),$config)){
			$_SESSION[$ci_obj->config->item('rbac_auth_key')] = $config;
		}
		return isset($conf[count($arr_key)-1])?$conf[count($arr_key)-1]:FALSE;
	}
}

if(!function_exists('rbac_logout')){
	function rbac_logout($arr_key,$value=NULL){
		session_destroy();
	}
}
/**
 * 错误跳转
 */
if(!function_exists("error_redirct")){
	function error_redirct($url="",$contents="操作失败",$time = 3){
		
		$ci_obj = &get_instance();
		if($url!=""){
			$url = base_url("index.php/".$url);
		}else{
			$url = isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:site_url();
		}
		$data['url'] = $url;
		$data['time'] = $time;
		$data['type'] = "error";
		$data['contents'] = $contents;
		$ci_obj->load->view("redirect",$data);
		$ci_obj->output->_display($ci_obj->output->get_output());
		die();
	}
}
/**
 * 正确跳转
 */
if(!function_exists("success_redirct")){
	function success_redirct($url,$contents="操作成功",$time = 3){
		$ci_obj = &get_instance();
		if($url!=""){
			$url = base_url("index.php/".$url);
		}else{
			$url = isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:site_url();
		}
		$data['url'] = $url;
		$data['time'] = $time;
		$data['type'] = "success";
		$data['contents'] = $contents;
		$ci_obj->load->view("redirect",$data);
		$ci_obj->output->_display($ci_obj->output->get_output());
		die();
	}
}
