<?php $this->load->view("head");?>
   
	<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#"><?php echo $this->config->item('project_name'); ?></a>
        </div>
      </div><!-- /.container -->
    </div><!-- /.navbar -->

	<div class="container">
		<div class="row" style="padding-top:100px">
		
			<div class="col-sm-offset-4 col-sm-4">
					<div class="panel panel-primary">
						<div class="panel-heading">登录</div>
						<div class="panel-body">
						
						<form class="form-horizontal" role="form"  action="" method="post">
							<div class="form-group">
								<label for="inputUsername" class="col-sm-2 control-label"></label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="inputUsername" placeholder="请输入用户名" name="username" >
								</div>
								<!-- <div class="col-sm-3"></div> -->
							</div>
							<div class="form-group">
								<label for="inputPasswd" class="col-sm-2 control-label"></label>
								<div class="col-sm-8">
									<input type="password" class="form-control" id="inputPasswd" placeholder="请输入密码" name="password" >
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-8">
									<input type="hidden" name="foward" value="null"/>
									<button type="submit" class="btn btn-primary btn-block" data-loading-text="正在登录">登录</button>
								</div>
							</div>
							</form>
						</div>
					</div>
					</div>
				</div>
			</div>
			
<?php $this->load->view("foot");?>