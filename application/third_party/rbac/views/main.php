<?php $this->load->view("head");?>

	<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#"><?php echo $this->config->item('project_name'); ?></a>
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

    <div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation">
		  <?php $this->load->view("menu",array("menu"=>$this->get_menu));?>
        </div><!--/span-->
        <div class="col-xs-12 col-sm-10">
          <?php echo $this->output->get_output();?>
        </div><!--/span-->
      </div><!--/row-->
      <hr>
      <footer>
        <p><?php echo $this->config->item('project_copyright'); ?></p>
      </footer>
    </div><!--/.container-->


<?php $this->load->view("foot");?>