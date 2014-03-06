<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
   		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="<?php echo base_url();?>static/bootstrap/css/bootstrap.min.css">
		<link href="<?php echo base_url();?>static/signin.css" rel="stylesheet">
        <title><?php echo $this->config->item('project_name'); ?></title>

  </head>

  <body>

    <div class="container">
    
      <form class="form-signin" role="form"  action="" method="post">
        <h2 class="form-signin-heading"><?php echo $this->config->item('project_name'); ?></h2>
        <input type="text" name="username" class="form-control" placeholder="帐号" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="密码" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
      </form>
      
    </div> <!-- /container -->

  </body>
</html>

