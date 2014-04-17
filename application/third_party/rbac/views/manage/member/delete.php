<style>
.table td:first-child{width:30%}
.table td:nth-child(2){width:40%}
</style>
<h1>您确定要删除此用户(<?php echo $data["nickname"]; ?>)？</h1>

<form method="POST" action="">
	<input type="hidden" name="verfiy" value="1" >
	<input class="btn btn-success"  type="submit" value="确定删除">
	<a class="btn btn-danger" href="<?php echo site_url('manage/member/index'); ?>">取消修改</a>
</form>
