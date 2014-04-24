<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Rbac config
|--------------------------------------------------------------------------
*/

$config['rbac_auth_on']	             = TRUE;			      	//是否开启认证
$config['rbac_auth_type']	         = '2';			     		//认证方式1,登录认证;2,实时认证
$config['rbac_auth_key']	         = 'MyAuth';		 		//SESSION标记
$config['rbac_auth_gateway']         = 'Index/login';    		//默认认证网关
$config['rbac_default_index']        = 'product/index/index';   //成功登录默认跳转模块
$config['rbac_manage_menu_hidden']   = array('后台管理');		//后台管理导航中不显示的菜单
$config['rbac_manage_node_hidden']   = array('manage');			//后台管理节点中不显示的菜单
$config['rbac_notauth_dirc']         = array('');	     	    //默认无需认证目录array("public","manage")


/* End of file rbac.php */
/* Location: ./application/third_party/rbac/config/rbac.php */
