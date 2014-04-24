<?php $this->load->view("head");?>

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

<?php $this->load->view("foot");?>