
<?php 
foreach($menu as $mn){
	if(@$mn["shown"]){
		echo '<div class="list-group">';
		if($mn["self"]["uri"]=="/"){
			$flist = "<a class='list-group-item active'><span class='glyphicon glyphicon-align-left'></span> ".$mn["self"]["title"]."</a>";
		}else{
			$flist = anchor($mn["self"]["uri"],$mn["self"]["title"], array('class' => 'list-group-item'));
		}
		echo $flist;
		if(isset($mn["child"])){
			foreach($mn["child"] as $cmn){
				
				if(@$cmn["shown"]){
					//echo '<div class="panel-group" id="accordion"><div class="panel panel-default">';
					if($cmn["self"]["uri"]=="/"){
						$slist =  "<a class='list-group-item'>&nbsp;&nbsp;&nbsp;&nbsp;<span class='glyphicon glyphicon-align-left'></span> ".$cmn["self"]["title"]."</a>";
					}else{
						$slist = anchor($cmn["self"]["uri"],'&nbsp;&nbsp;&nbsp;&nbsp;'.$cmn["self"]["title"], array('class' => 'list-group-item'));
					}
					echo $slist;
					if(isset($cmn["child"])){
						//echo '<div id="'.md5($cmn["self"]["uri"]).'" class="panel-collapse collapse">';
						foreach($cmn["child"] as $gcmn){
							if(@$gcmn["shown"]){
								$tlist = anchor($gcmn["self"]["uri"],"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$gcmn["self"]["title"], array('class' => 'list-group-item'));
							}
							echo $tlist;
						}
						//echo '</div>';
					}
					//echo '</div></div>';
				}
				
			}
		}
		echo '</div>';
	}
}

?>