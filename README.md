基于CI的RBAC访问控制v1.6
=======

框架：CI 2.1.4
前端：bootstrap3.0
模型：RBAC0（甚至更简单）

<h3>在CI上增加的文件</h3>
<pre>
    application->controllers->manage[目录]
    此目录为RBAC的后端管理(不实现方法，只是简单调用,只是简单调用third_party下文件)
</pre>
<pre>
    application->controllers->index.php
    RBAC登录,用户主页(不实现方法,只是简单调用third_party下文件)
</pre>
<pre>
    application->third_party[目录]
    这里面就是整体的RBAC实现了,如果有更新,基本上只更新此目录即可[除非有特殊声明更新其他文件]
</pre>

<h3>在CI上配置的设置</h3>
<pre>
Autoload:
    packages    APPPATH.'third_party/rbac'
</pre>   
<pre>
Hooks:
    post_controller_constructor     RBAC验证
    display_override                重写显示(注意:默认重写view,如果不想重写则在方法中调用$this->view_override = FALSE;)
    pre_system                      开启原生SESSION
</pre>

<h3>RBAC支持的配置</h3>
<pre>
/* Location: ./application/third_party/rbac/config/rbac.php */
$config['rbac_auth_on']	             = TRUE;			      	//是否开启认证
$config['rbac_auth_type']	         = '2';			     		//认证方式1,登录认证;2,实时认证
$config['rbac_auth_key']	         = 'MyAuth';		 		//SESSION标记
$config['rbac_auth_gateway']         = 'Index/login';    		//默认认证网关
$config['rbac_default_index']        = 'product/index/index';   //成功登录默认跳转模块
$config['rbac_manage_menu_hidden']   = array('后台管理');		//后台管理导航中不显示的菜单
$config['rbac_manage_node_hidden']   = array('manage');			//后台管理节点中不显示的菜单
$config['rbac_notauth_dirc']         = array('');	     	    //默认无需认证目录array("public","manage")
</pre>

<h3>更新日志</h3>
* 2014-04-24更新:v160,不好意思返璞归真了,在1.5.0版本基础上做的优化,感觉还是不要动CI的核心,关于RBAC的配置文件放入third_party中,不在使用CI提供的autoload,自己实现。
* 2014-04-21更新:v155,重写了CI的引导文件和Router,对于manage目录做了特殊处理,目的是把rbac全部的放入third_party中,跟整体系统没有关联,这个还在继续中,有更多的好的方法还在实践。原则是尽量少改动CI的核心文件。如果以后有更好思路会把CI引导各文件和Router还原,如果有人有思路,忘提供。
* 2014-04-17更新:大更新，整体目录结构变化，目的是为了让RBAC的管理与控制与CI中的各目录隔离,现在基于CI的特性做了部分处理,还有些暂未能隔离，再想办法。V1.5<br/\>
* 2014-04-14更新:修复节点授权BUG,引入Memcache<br/\>
* 2014-03-10更新:修复登录BUG<br/\>
* 2014-03-10更新:错误页与登录页更新 AND Titlebar上的错误字<br/\>
* 2014-03-06更新:修复一个重大BUG，用户ID跟角色ID搞错了，导致无法通过验证,修复URL大小写问题
* 2014-03-03发布:V1.0版本发布