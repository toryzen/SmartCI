
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

<!-- 
<?php 
foreach($menu as $mn){
	if(@$mn["shown"]){
		echo '<div class="list-group">';
		if($mn["self"]["uri"]=="/"){
			$flist = $mn["self"]["title"];
		}else{
			$flist = anchor($mn["self"]["uri"],$mn["self"]["title"]);
		}
		echo '<a href="#" class="list-group-item active">'.$flist.'</a>';
		if(isset($mn["child"])){
			foreach($mn["child"] as $cmn){
				
				if(@$cmn["shown"]){
					echo '<div class="panel-group" id="accordion"><div class="panel panel-default">';
					if($cmn["self"]["uri"]=="/"){
						$slist =  "\t".$cmn["self"]["title"];
					}else{
						$slist = "\t".anchor($cmn["self"]["uri"],$cmn["self"]["title"]);
					}
					echo '<div class="panel-heading">
					      <h4 class="panel-title">
					        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#'.md5($cmn["self"]["uri"]).'">
					          	&nbsp;&nbsp;'.$slist.'
					        </a>
					      </h4>
					    </div>';
					if(isset($cmn["child"])){
						echo '<div id="'.md5($cmn["self"]["uri"]).'" class="panel-collapse collapse">';
						foreach($cmn["child"] as $gcmn){
							if(@$gcmn["shown"]){
								$tlist = anchor($gcmn["self"]["uri"],$gcmn["self"]["title"]);
							}
							echo '<div class="panel-body">
							        	&nbsp;&nbsp;&nbsp;&nbsp;'.$tlist.'
							      </div>';
						}
						echo '</div>';
					}
					echo '</div></div>';
				}
				
			}
		}
		echo '</div>';
	}
}

?>
 -->
