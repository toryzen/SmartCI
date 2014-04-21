<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "memcached" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/memcached.html
|
*/
//是否开启
$config['flag'] = FALSE;
//memcached权限验证
$config['config'] = array(
               'servers' => array('192.168.4.37:11211'),
               'debug'   => false
             );

/* End of file memcached.php */
/* Location: ./application/config/memcached.php */