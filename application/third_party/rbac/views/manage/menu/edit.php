<h1>修改子菜单</h1>
<form role="form" action="" method="post">
  <div class="form-group">
    <label>标题</label>
    <input name="title" type="text" class="form-control" placeholder="在此输入标题" value="<?php echo $data['title']; ?>">
  </div>
  <div class="form-group">
    <label>挂接节点</label>
    <select name="node"  class="form-control" >
    	<option value=''>不进行挂接</option>
    	<?php 
    		foreach($node as $vo){
				$select = $data["node_id"]==$vo->id?"selected":"";
    			echo "<option value='{$vo->id}' {$select} >{$vo->memo} [{$vo->dirc}/{$vo->cont}/{$vo->func}]</option>";
    		}
    	?>
    	
    </select>
  </div>
  <div class="form-group">
    <label>排序</label>
    <input name="sort" type="number" class="form-control" placeholder="在此输入排序" value="<?php echo $data['sort'];?>">
  </div>
  <div class="checkbox">
    <label>
      <input value="1" name="status" type="checkbox" <?php if($data["status"]){echo "checked";}?>> 是否显示
    </label>
  </div>
  <div class="checkbox pull-right">
  	<label>
      	友情提示：
    </label>
    <ul>
    	<li>一级菜单建议不挂接节点，只当标题使用！</li>
    	<li>二级当标题时其下需有三级节点，否则将不显示！</li>
  		<li>三级菜单请挂接节点，否则将不会显示！</li>
  	</ul>
  </div>
  <input type="hidden" name="level" value="<?php echo $level;?>">
  <input type="hidden" name="id" value="<?php echo $data['id'];?>">
  <input type="hidden" name="p_id" value="<?php echo $p_id;?>">
  <button type="submit" class="btn btn-success">确认修改</button>
  <a class="btn btn-danger" href="<?php echo site_url('manage/menu/index'); ?>">取消修改</a>
</form>