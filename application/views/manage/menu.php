<style>
.table td:first-child{width:30%}
.table td:nth-child(2){width:40%}
</style>
<?php 
foreach($menu as $mn){
	$nochild = "<span class='glyphicon glyphicon-align-left'></span> " ;
	$havechild = "<span class='glyphicon glyphicon-link'></span> " ;
	echo '<table class="table well">';
	echo '<tr>
		  	<td><b>'.($mn["self"]->node_id?$havechild:$nochild).$mn["self"]->title.'</b></td>
		  	<td>'.($mn["self"]->memo?$mn["self"]->memo.$mn["self"]->dcf:"未挂接").'</td>
		  	<td>'.$mn["self"]->sort.'</td>
		  	<td>'.($mn["self"]->status==1?"显示":"隐藏").'</td>
		  	<td><div class="btn-group  btn-group-xs pull-right">
				  <a class="btn btn-default" href="'.site_url("manage/menu/edit/".$mn["self"]->id."/1/NULL").'">修改</a>
				  <a class="btn btn-danger" href="'.site_url("manage/menu/delete/".$mn["self"]->id).'">删除</a>
				  <a class="btn btn-success" href="'.site_url("manage/menu/add/".$mn["self"]->id."/1/".$mn["self"]->id).'">新增子菜单</a>
				</div>
			</td>
		  </tr>';
	if(isset($mn["child"])){
		foreach($mn["child"] as $cmn){
			echo '<tr>
			  	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.($cmn["self"]->node_id?$havechild:$nochild).$cmn["self"]->title.'</b></td>
			  	<td>'.($cmn["self"]->memo?$cmn["self"]->memo.$cmn["self"]->dcf:"未挂接").'</td>
			  	<td>'.$cmn["self"]->sort.'</td>
			  	<td>'.($cmn["self"]->status==1?"显示":"隐藏").'</td>
			  	<td><div class="btn-group  btn-group-xs pull-right">
					  <a class="btn btn-default" href="'.site_url("manage/menu/edit/".$cmn["self"]->id."/2/".$mn["self"]->id).'">修改</a>
					  <a class="btn btn-danger" href="'.site_url("manage/menu/delete/".$cmn["self"]->id).'">删除</a>
					  <a class="btn btn-success" href="'.site_url("manage/menu/add/".$cmn["self"]->id."/2/".$cmn["self"]->id).'">新增子菜单</a>
					</div>
				</td>
			  </tr>';
			
			if(isset($cmn["child"])){
				foreach($cmn["child"] as $gcmn){
					echo '<tr>
						  	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  					<b>'.($gcmn["self"]->node_id?$havechild:"").$gcmn["self"]->title.'</b></td>
						  	<td>'.($gcmn["self"]->memo?$gcmn["self"]->memo.$gcmn["self"]->dcf:"未挂接").'</td>
			  				<td>'.$gcmn["self"]->sort.'</td>
						  	<td>'.($gcmn["self"]->status==1?"显示":"隐藏").'</td>
						  	<td><div class="btn-group  btn-group-xs pull-right">
								  <a class="btn btn-default" href="'.site_url("manage/menu/edit/".$gcmn["self"]->id."/3/".$cmn["self"]->id).'">修改</a>
								  <a class="btn btn-danger" href="'.site_url("manage/menu/delete/".$gcmn["self"]->id).'">删除</a>
								</div>
							</td>
						  </tr>';
				}
			}
		}
	}
	echo '</table>';
}
?>
<hr/>
<?php echo '<a class="btn btn-success  pull-right" href="'.site_url("manage/menu/add/".$mn["self"]->id."/1/NULL").'">新增一级菜单</a>'; ?>
