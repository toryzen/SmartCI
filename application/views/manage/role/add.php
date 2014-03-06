<h1>新增角色</h1>
<form role="form" action="" method="post">
  <div class="form-group">
    <label>角色名</label>
    <input name="rolename" type="text" class="form-control"  placeholder="在此输入角色名" value="">
  </div>
  <div class="checkbox">
    <label>
      <input value="1" name="status" type="checkbox" checked > 是否启用
    </label>
  </div>
  <button type="submit" class="btn btn-success">确认新增</button>
  <a class="btn btn-danger" href="<?php echo site_url('manage/role/index'); ?>">取消修改</a>
</form>