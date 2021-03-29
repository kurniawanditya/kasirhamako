<section class="content-header">
  <h1>Supplier
    <small>Pemasok Barang</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">Supplier</li>
  </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title"><?=ucfirst($page)?> Supplier</h3>
      <div class="pull-right">
        <a href="<?=site_url('Supplier')?>" class="btn btn-warning btn-flat">
          <i class="fa fa-undo"></i> Back</a>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <?php //echo validation_errors(); ?>
          <form action="<?=site_url('supplier/process')?>" method="post">
            <div class="form-group">
              <label>Supplier Name *</label>
              <input type="hidden" name="id_supplier" value="<?=$row->id_supplier;?>" class="form-control" required>
              <input type="text" name="name_supplier" value="<?=$row->name_supplier;?>" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Address *</label>
              <textarea name="address" class="form-control" required><?=$row->address;?></textarea>
            </div>
            <div class="form-group">
              <label>Phone *</label>
              <input type="text" name="phone" value="<?=$row->phone;?>" class="form-control" required>
            </div>

            <div class="form-group">
              <button type="submit" name="<?=$page?>" class="btn btn-success btn-flat">Save</button>
              <button type="reset"  class="btn btn-flat">Reset</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
