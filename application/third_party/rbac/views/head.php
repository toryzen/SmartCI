<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
   		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="<?php echo base_url();?>static/bootstrap/css/bootstrap.min.css">
		<link href="<?php echo base_url();?>static/offcanvas.css" rel="stylesheet">
        <title><?php echo isset($header_title)?$header_title:isset($this->get_menu['list'][$this->uuri])?$this->get_menu['list'][$this->uuri]:""; ?></title>
        <script src="<?php echo base_url();?>static/jquery.1102.min.js"></script>
		<script src="<?php echo base_url();?>static/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>static/bootstrap/js/respond.min.js"></script>
    </head>
    <body>
    <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#"><?php echo isset($header_title)?$header_title:isset($this->get_menu['list'][$this->uuri])?$this->get_menu['list'][$this->uuri]:""; ?></a>
        </div>
        <ul class="nav navbar-nav navbar-right">
          <li id="fat-menu" class="dropdown">
              <a href="#" id="user_action" role="button" class="dropdown-toggle" data-toggle="dropdown">欢迎您:<?php echo rbac_conf(array('INFO','nickname'));?><b class="caret"></b></a>
              <ul class="dropdown-menu" role="menu" aria-labelledby="user_action">
                <li> <?php echo anchor("Index/logout","<span class='glyphicon glyphicon-log-out'></span> 退出"); ?></li>
              </ul>
          </li>
        </ul>
      </div><!-- /.container -->
    </div><!-- /.navbar -->


