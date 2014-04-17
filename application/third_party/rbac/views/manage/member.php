<style>
.table td:first-child{width:10%}
.table td:nth-child(2){width:20%}
</style>
<table class="table  table-bordered well">
	<thead>
          <tr>
            <th>ID</th>
            <th>用户名</th>
            <th>昵称</th>
            <th>Email</th>
            <th>角色</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
        </thead>
   <tbody>
	<?php 
	foreach($data as $mb){
		printf('<tr>
					<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					<td>
						<div class="btn-group  btn-group-xs">
						  <a class="btn btn-default btn-xs" href="%s">编辑</a>
						  <a class="btn btn-danger" href="%s">删除</a>
						</div>
					</td>
				</tr>',$mb->id,$mb->username,$mb->nickname,$mb->email,($mb->rolename?$mb->rolename:"暂无角色"),($mb->status==1?"正常":"停用"),site_url("manage/member/edit/".$mb->id),site_url("manage/member/delete/".$mb->id));
	}
	?>
  </tbody>
</table>
<hr/>

<?php echo '<a class="btn btn-success pull-right" href="'.site_url("manage/member/add").'">新增用户</a>'; ?>
<?php echo $this->pagination->create_links(); ?>
