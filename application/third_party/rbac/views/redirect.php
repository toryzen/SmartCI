<?php $this->load->view('head');?>

	<div class="container">
		<div class="row" style="padding-top:100px">
		
			<div class="col-sm-offset-3 col-sm-6">
					<div class="panel panel-<?php if($type=="error")echo "danger";else echo "success";?>">
						<div class="panel-heading"><?php if($type=="error")echo "错误操作";else echo "操作成功";?></div>
						<div class="panel-body">
						
						<h1><?php echo $contents; ?></h1>
    					<h4><span id="cnt"><?php echo $time; ?></span>秒钟后自动跳转！【<a href="<?php echo $url; ?>">立即跳转</a>】</h4>
						<br/>
						
						</div>
					</div>
					</div>
				</div>
			</div>
			<script>
				window.onload =function() {
				    var i = <?php echo $time-1; ?>;
				            setInterval(function(){                
				                document.getElementById("cnt").innerHTML = i--;
				                if(document.getElementById("cnt").innerHTML=='0'){
									window.location.href='<?php echo $url; ?>';
					            }
				 
				            },1000);
				        };
			</script>
<?php $this->load->view("foot");?>