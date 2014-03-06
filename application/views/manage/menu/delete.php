<style>
.table td:first-child{width:30%}
.table td:nth-child(2){width:40%}
</style>
<h1>您确定要删除下列菜单？</h1>

<?php 
foreach($menu as $mn){
	$nochild = "<span class='glyphicon glyphicon-align-left'></span> " ;
	$havechild = "<span class='glyphicon glyphicon-link'></span> " ;
	echo '<table class="table well">';
	echo '<tr>
		  	<td>'.($mn["self"]->node_id?$havechild:$nochild).$mn["self"]->title.'</td>
		  	<td>'.($mn["self"]->memo?$mn["self"]->memo:"未挂接").'</td>
		  	<td>'.$mn["self"]->sort.'</td>
		  	<td>'.($mn["self"]->status==1?"显示":"隐藏").'</td>
		  </tr>';
	if(isset($mn["child"])){
		foreach($mn["child"] as $cmn){
			echo '<tr>
			  	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.($cmn["self"]->node_id?$havechild:$nochild).$cmn["self"]->title.'</td>
			  	<td>'.($cmn["self"]->memo?$cmn["self"]->memo:"未挂接").'</td>
			  	<td>'.$cmn["self"]->sort.'</td>
			  	<td>'.($cmn["self"]->status==1?"显示":"隐藏").'</td>
			  </tr>';
			
			if(isset($cmn["child"])){
				foreach($cmn["child"] as $gcmn){
					echo '<tr>
						  	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  					'.($gcmn["self"]->node_id?$havechild:"").$gcmn["self"]->title.'</td>
						  	<td>'.($gcmn["self"]->memo?$gcmn["self"]->memo.$gcmn["self"]->dcf:"未挂接").'</td>
			  				<td>'.$gcmn["self"]->sort.'</td>
						  	<td>'.($gcmn["self"]->status==1?"显示":"隐藏").'</td>
						  </tr>';
				}
			}
		}
	}
	echo '</table>';
}
?>
<form method="POST" action="">
	<input type="hidden" name="verfiy" value="1" >
	<input class="btn btn-success"  type="submit" value="确定删除">
	<a class="btn btn-danger" href="<?php echo site_url('manage/menu/index'); ?>">取消修改</a>
</form>
