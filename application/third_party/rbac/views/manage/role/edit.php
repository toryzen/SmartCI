<h1>角色编辑</h1>
<form role="form" action="" method="post">
  <div class="form-group">
    <label>角色名</label>
    <input name="rolename" type="text" class="form-control" value="<?php echo $data['rolename']; ?>">
  </div>
  <div class="checkbox">
    <label>
      <input value="1" name="status" type="checkbox" <?php if($data["status"]){echo "checked";}?>> 是否启用
    </label>
  </div>
  <input type="hidden" name="id" value="<?php echo $data['id'];?>">
  <button type="submit" class="btn btn-success">确认修改</button>
  <a class="btn btn-danger" href="<?php echo site_url('manage/role/index'); ?>">取消修改</a>
</form>