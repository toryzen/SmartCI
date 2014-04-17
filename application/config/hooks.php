<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
//RBAC权限验证
$hook['post_controller_constructor'] = array(
		'class'    => 'Rbac',
		'function' => 'aoto_verify',
		'filename' => 'rbac_hook.php',
		'filepath' => 'third_party/rbac/hooks',
		'params'   => '',
);

$hook['display_override'] = array(
		'class'    => 'Rbac',
		'function' => 'view_override',
		'filename' => 'rbac_hook.php',
		'filepath' => 'third_party/rbac/hooks',
		'params'   => '',
);

//默认开启SESSION
$hook['pre_system'] = array(
		'class'    => '',
		'function' => 'session_start',
		'filename' => '',
		'filepath' => '',
		'params'   => '',
);
/* End of file hooks.php */
/* Location: ./application/config/hooks.php */