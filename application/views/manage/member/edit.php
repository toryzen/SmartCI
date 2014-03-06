<h1>用户编辑</h1>
<form role="form" action="" method="post">
  <div class="form-group">
    <label>用户名</label>
    <input name="username" type="text" class="form-control" disabled value="<?php echo $data['username']; ?>">
  </div>
  <div class="form-group">
    <label>昵称</label>
    <input name="nickname" type="text" class="form-control" placeholder="在此输入昵称" value="<?php echo $data['nickname']; ?>">
  </div>
  <div class="form-group">
    <label>Email</label>
    <input name="email" type="email" class="form-control" placeholder="在此输入Email" value="<?php echo $data['email'];?>">
  </div>
  <div class="form-group">
    <label>角色</label>
    <select name="role"  class="form-control" >
    	<option value=''>暂无角色</option>
    	<?php 
    		foreach($role_data as $vo){
				$select = $data["role_id"]==$vo->id?"selected":"";
    			echo "<option value='{$vo->id}' {$select} >{$vo->rolename}</option>";
    		}
    	?>
    </select>
  </div>
  <div class="form-group">
    <label>新密码</label>
    <input name="password" type="password" class="form-control" placeholder="在此输入密码(留空则不修改)" value="">
  </div>
  <div class="form-group">
    <label>确认密码</label>
    <input name="password2" type="password" class="form-control" placeholder="在此确认密码(留空则不修改)" value="">
  </div>
  <div class="checkbox">
    <label>
      <input value="1" name="status" type="checkbox" <?php if($data["status"]){echo "checked";}?>> 是否启用
    </label>
  </div>
  <input type="hidden" name="id" value="<?php echo $data['id'];?>">
  <button type="submit" class="btn btn-success">确认修改</button>
  <a class="btn btn-danger" href="<?php echo site_url('manage/member/index'); ?>">取消修改</a>
</form>