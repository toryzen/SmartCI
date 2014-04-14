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
//$config['flag'] = TRUE;
//memcached权限验证
$config['config'] = array(
               'servers' => array('192.168.4.37:11211'),
               'debug'   => false,
               'compress_threshold' => 10240,
               'persistant' => true
             );

/* End of file memcached.php */
/* Location: ./application/config/memcached.php */