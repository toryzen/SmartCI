<style>
.table td:first-child{width:30%}
.table td:nth-child(2){width:40%}
</style>
<h1>您确定要删除此角色(<?php echo $data["rolename"]; ?>)？</h1>
<h4>删除角色将同时删除角色的所有授权，请慎重操作！</h4>

<form method="POST" action="">
	<input type="hidden" name="verfiy" value="1" >
	<input class="btn btn-success"  type="submit" value="确定删除">
	<a class="btn btn-danger" href="<?php echo site_url('manage/role/index'); ?>">取消修改</a>
</form>
