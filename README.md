基于CI的RBAC访问控制v1.5
=======

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

* 2014-04-17更新:大更新，整体目录结构变化，目的是为了让RBAC的管理与控制与CI中的各目录隔离,现在基于CI的特性做了部分处理,还有些暂未能隔离，再想办法。V1.5<br/\>
* 2014-04-14更新:修复节点授权BUG,引入Memcache<br/\>
* 2014-03-10更新:修复登录BUG<br/\>
* 2014-03-10更新:错误页与登录页更新 AND Titlebar上的错误字<br/\>
* 2014-03-06更新:修复一个重大BUG，用户ID跟角色ID搞错了，导致无法通过验证,修复URL大小写问题
* 2014-03-03发布:V1.0版本发布