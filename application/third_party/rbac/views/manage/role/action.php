<style>
	.table td:first-child{width:30%}
	.table td:nth-child(2){width:40%}
</style>
<?php 
foreach($node as $key=>$mn){
	echo '<table class="table well">';
	printf('<tr>
		  	<td><span class="glyphicon glyphicon-folder-open"></span> %s</td>
		  	<td></td>
		  	<td></td>
		  </tr>',$key);
	foreach($mn as $mn_key=>$cmn){
		printf('<tr>
			  	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-list-alt"></span> %s</td>
			  	<td></td>
			  	<td></td>
			  </tr>',$mn_key);
		foreach($cmn as $cmn_key=>$gcmn){
			printf('<tr>
				  	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus"></span> '.$cmn_key.'</td>
				  	<td>%s</td>
				  	<td><div class="btn-group  btn-group-xs pull-right">
				  		  <a class="btn btn-default btn-%s" href="%s">%s</a>
					</div>
			  	</td>
			  	</tr>',$gcmn->memo,(@$rnl[$key][$mn_key][$cmn_key]?"danger":"success"),site_url("manage/role/action/".$role_id."/".$gcmn->id),(@$rnl[$key][$mn_key][$cmn_key]?"取消授权":"节点授权"));
		}
	}
	echo '</table>';
}
?>
