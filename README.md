基于CI的RBAC访问控制
=======
*2014-04-14更新:修复节点授权BUG,引入Memcache

框架：CI 2.1.4
前端：bootstrap3.0
模型：RBAC0（甚至更简单）

1、RBAC基本配置，application/config/rbac.php
<pre>
$config['rbac_auth_on']              = TRUE;                //是否开启认证
$config['rbac_auth_type']            = '2';                 //认证方式1,登录认证;2,实时认证
$config['rbac_auth_key']             = 'MyAuth';            //SESSION标记
$config['rbac_auth_gateway']         = 'Index/login';       //默认认证网关
$config['rbac_default_index']        = 'manage/Role/index'; //成功登录默认跳转模块
$config['rbac_manage_menu_hidden']   = array('后台管理');   //后台管理导航中不显示的菜单
$config['rbac_manage_node_hidden']   = array('manage');     //后台管理节点中不显示的菜单
$config['rbac_notauth_dirc']         = array('');           //默认无需认证目录array("public","manage")
</pre>

2、钩子 application/config/hooks.php
<pre>
$hook['post_controller_constructor'] = array(
        'class'    => 'Rbac',
        'function' => 'aoto_verify',
        'filename' => 'rbac_hook.php',
        'filepath' => 'hooks',
        'params'   => '',
);
$hook['display_override'] = array(
        'class'    => 'Rbac',
        'function' => 'view_override',
        'filename' => 'rbac_hook.php',
        'filepath' => 'hooks',
        'params'   => '',
);
 
$hook['pre_system'] = array(
        'class'    => '',
        'function' => 'session_start',
        'filename' => '',
        'filepath' => '',
        'params'   => '',
);
</pre>

3、ACL核心验证 application/hooks/rbac_hook.php
<pre>
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
                        die();
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
</pre>

4、左侧菜单根据权限显示 application/hooks/rbac_hook.php
<pre>
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
</pre>

6、数据库(一共5张表，4张表实现权限的控制，1张表主要是左侧的菜单,各表之间的关系还是比较明了简洁的)
<pre>
CREATE TABLE IF NOT EXISTS `rbac_auth` (
  `node_id` int(11) NOT NULL COMMENT '节点ID',
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  UNIQUE KEY `nid_rid` (`node_id`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色与节点对应表';
 
CREATE TABLE IF NOT EXISTS `rbac_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL COMMENT '导航名称',
  `node_id` int(11) DEFAULT NULL COMMENT '节点ID',
  `p_id` int(11) DEFAULT NULL COMMENT '导航父id',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` int(11) DEFAULT '1' COMMENT '状态(1:正常,0:停用)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='菜单表' AUTO_INCREMENT=20 ;
 
CREATE TABLE IF NOT EXISTS `rbac_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dirc` varchar(20) NOT NULL COMMENT '目录',
  `cont` varchar(10) NOT NULL COMMENT '控制器',
  `func` varchar(10) NOT NULL COMMENT '方法',
  `memo` varchar(25) DEFAULT NULL COMMENT '备注',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态(1:正常,0:停用)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `d_c_f` (`dirc`,`cont`,`func`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='节点表' AUTO_INCREMENT=24 ;
 
CREATE TABLE IF NOT EXISTS `rbac_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(25) NOT NULL COMMENT '角色名',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态(1:正常,0停用)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `rolename` (`rolename`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='角色表' AUTO_INCREMENT=4 ;
 
CREATE TABLE IF NOT EXISTS `rbac_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `nickname` varchar(20) NOT NULL COMMENT '昵称',
  `email` varchar(25) NOT NULL COMMENT 'Email',
  `role_id` int(11) DEFAULT NULL COMMENT '角色ID',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态(1:正常,0:停用)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=6 ;
</pre>