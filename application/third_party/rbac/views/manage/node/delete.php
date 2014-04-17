<style>
.table td:first-child{width:30%}
.table td:nth-child(2){width:40%}
</style>
<h1>您确定要删除？</h1>
<h4>请慎重操作！</h4>
友情提示：
<ul>
    	<li>删除目录时将删除目录下多有控制器与方法！</li>
    	<li>删除控制器时将删除其下所有方法！</li>
    	<li>删除同时将取消其挂接的导航菜单</li>
  	</ul>
<hr/>
<form method="POST" action="">
	<input type="hidden" name="verfiy" value="1" >
	<input class="btn btn-success"  type="submit" value="确定删除">
	<a class="btn btn-danger" href="<?php echo site_url('manage/node/index'); ?>">取消操作</a>
</form>
