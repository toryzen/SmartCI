基于CI的RBAC访问控制v1.5
=======

框架：CI 2.1.4
前端：bootstrap3.0
模型：RBAC0（甚至更简单）

1、在CI基础上增加的文件：
application->config->rbac.php
RBAC的基础配置文件,可以设置是否开启,默认网关,无需认证等等(详见文件中备注)

application->config->project.php
项目配置的基本文件，设置项目名称，底部版权等

application->config->memcached.php
Memcache配置文件，本系统内部Memcache不依赖于PHP扩展

application->controllers->manage[目录]
此目录为RBAC的后端管理(不实现方法，只是简单调用,只是简单调用third_party下文件)

application->controllers->index.php
RBAC登录,用户主页(不实现方法,只是简单调用third_party下文件)

application->third_party[目录]
这里面就是整体的RBAC实现了,如果有更新,基本上只更新此目录即可[除非有特殊声明更新其他文件]

2、在CI上增加的设置
Autoload:
    packages    APPPATH.'third_party/rbac'
    helper      'rbac','url'
    config      'rbac','project'
    
Hooks:
    post_controller_constructor     RBAC验证
    display_override                重写显示(注意:默认重写view,如果不想重新在方法中调用$this->view_override = FALSE;)
    pre_system                      开启原生SESSION

* 2014-04-17更新:大更新，整体目录结构变化，目的是为了让RBAC的管理与控制与CI中的各目录隔离,现在基于CI的特性做了部分处理,还有些暂未能隔离，再想办法。V1.5<br/\>
* 2014-04-14更新:修复节点授权BUG,引入Memcache<br/\>
* 2014-03-10更新:修复登录BUG<br/\>
* 2014-03-10更新:错误页与登录页更新 AND Titlebar上的错误字<br/\>
* 2014-03-06更新:修复一个重大BUG，用户ID跟角色ID搞错了，导致无法通过验证,修复URL大小写问题
* 2014-03-03发布:V1.0版本发布