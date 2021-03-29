
<section class="content-header">
  <h1>Koleksi
    <small>Koleksi Produk</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">Koleksi</li>
  </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title"><?=ucfirst($page)?>koleksi</h3>
      <div class="pull-right">
        <a href="<?=site_url('koleksi')?>" class="btn btn-warning btn-flat">
          <i class="fa fa-undo"></i> Back</a>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <?php //echo validation_errors(); ?>
          <form action="<?=site_url('koleksi/process')?>" method="post">
            <div class="form-group">
              <label>Name *</label>
              <input type="hidden" name="id_koleksi" value="<?=$row->id_koleksi;?>" class="form-control" required>
              <input type="text" name="name_koleksi" value="<?=$row->name_koleksi;?>" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Merk</label>
              <?php echo form_dropdown('id_merk',$id_merk,$selectedmerk,
                    ['class'=>'form-control','required'=>'required']);?>
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
