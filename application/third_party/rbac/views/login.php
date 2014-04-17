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
						<div class="panel-heading">用户登录</div>
						<div class="panel-body">
						
						<form class="form-horizontal" role="form"  action="" method="post">
							<div class="input-group">
							  <span class="input-group-addon">用户</span>
							  <input type="text" class="form-control" placeholder="请输入用户" name="username">
							</div>
							<br/>
							<div class="input-group">
							  <span class="input-group-addon">密码</span>
							  <input type="password" class="form-control" placeholder="请输入密码" name="password">
							</div>
							<br/>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-8">
									<input type="hidden" name="foward" value="null"/>
									<button type="submit" class="btn btn-primary btn-block" data-loading-text="正在登录">登录</button>
								</div>
							</div>
							</form>
						</div>
					</div>
					<div class="alert alert-success">测试用帐号（用户:admin 密码:admin）</div>
					</div>
				</div>
			</div>
			
<?php $this->load->view("foot");?>