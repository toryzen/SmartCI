<style>
.table td:first-child{width:30%}
.table td:nth-child(2){width:40%}
</style>
<?php 
//print_r($node);
foreach($node as $key=>$mn){
	echo '<table class="table well">';
	echo '<tr>
		  	<td><span class="glyphicon glyphicon-folder-open"></span> <b>'.$key.'</b></td>
		  	<td></td>
			<td></td>
		  	<td><div class="btn-group  btn-group-xs pull-right">
				  <a class="btn btn-success" href="'.site_url("manage/node/add/".$key).'">新增控制器</a>
		  		  <a class="btn btn-danger" href="'.site_url("manage/node/delete/".$key).'">删除目录</a>
				</div>
			</td>
		  </tr>';
	foreach($mn as $mn_key=>$cmn){
		echo '<tr>
			  	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-list-alt"></span> <b>'.$mn_key.'</b></td>
			  	<td></td>
			  	<td></td>
			  	<td><div class="btn-group  btn-group-xs pull-right">
					  <a class="btn btn-success" href="'.site_url("manage/node/add/".$key."/".$mn_key).'">新增方法</a>
			  		  <a class="btn btn-danger" href="'.site_url("manage/node/delete/".$key."/".$mn_key).'">删除控制器</a>
					</div>
				</td>
			  </tr>';
		foreach($cmn as $cmn_key=>$gcmn){
			echo '<tr>
				  	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus"></span> <b>'.$cmn_key.'</b></td>
				  	<td>'.$gcmn->memo.'</td>
				  	<td>'.($gcmn->status==1?"启用":"停用").'</td>
				  	<td><div class="btn-group  btn-group-xs pull-right">
				  		  <a class="btn btn-success" href="'.site_url("manage/node/edit/".$gcmn->id).'">修改</a>
						  <a class="btn btn-danger" href="'.site_url("manage/node/delete/".$key."/".$mn_key."/".$cmn_key).'">删除方法</a>
					</div>
			  	</td>
			  	</tr>';
		}
	}
	echo '</table>';
}
?>
<hr/>
<?php echo '<a class="btn btn-success pull-right" href="'.site_url("manage/node/add").'">新增目录</a>'; ?>
