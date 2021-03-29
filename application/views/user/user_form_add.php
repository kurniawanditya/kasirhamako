<section class="content-header">
  <h1>Users
    <small>Pengguna</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">Users</li>
  </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Add Users</h3>
      <div class="pull-right">
        <a href="<?=site_url('User')?>" class="btn btn-warning btn-flat">
          <i class="fa fa-undo"></i> Back</a>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <?php //echo validation_errors(); ?>
          <form action="" method="post" name="myform">
            <div class="form-group <?=form_error('fullname')? 'has-error' :null?>">
              <label>Name *</label>
              <input type="text" name="fullname" value="<?=set_value('fullname');?>" class="form-control">
              <span class="help-block"><?=form_error('fullname');?></span>
            </div>
            <div class="form-group <?=form_error('username')? 'has-error' :null?>">
              <label>Username *</label>
              <input type="text" name="username" value="<?=set_value('username');?>" class="form-control">
              <?=form_error('username');?>
            </div>
            <div class="form-group <?=form_error('password')? 'has-error' :null?>">
              <label>Password *</label>
              <input type="password" name="password" value="<?=set_value('password');?>" class="form-control">
              <?=form_error('password');?>
            </div>
            <div class="form-group <?=form_error('passconf')? 'has-error' :null?>">
              <label>Password Confirmation *</label>
              <input type="password" name="passconf" value="<?=set_value('passconf');?>" class="form-control">
              <?=form_error('passconf');?>
            </div>
            <div class="form-group">
              <label>Address</label>
              <textarea name="address" class="form-control"><?=set_value('address') ?></textarea>
            </div>
            <div class="form-group">
              <label>Level *</label>
              <select name="level" class="form-control" required>
                <option>--Pilih--</option>
                <option value="1" <?=set_value('level') == 1 ? "selected" : null?>>Super Admin</option>
                <option value="2" <?=set_value('level') == 2 ? "selected" : null?>>Kasir</option>
                <option value="3" <?=set_value('level') == 2 ? "selected" : null?>>Admin</option>
                <option value="4" <?=set_value('level') == 2 ? "selected" : null?>>Stock</option>
              </select>
              <?=form_error('level');?>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-success btn-flat">Save</button>
              <button type="reset"  class="btn btn-flat">Reset</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
