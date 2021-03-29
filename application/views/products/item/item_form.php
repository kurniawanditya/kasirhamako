<section class="content-header">
  <h1>Item
    <small>Item Produk</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">item</li>
  </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title"><?=ucfirst($page)?>item</h3>
      <div class="pull-right">
        <a href="<?=site_url('item')?>" class="btn btn-warning btn-flat">
          <i class="fa fa-undo"></i> Back</a>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <?php //echo validation_errors(); ?>
          <form action="<?=site_url('item/process')?>" method="post">
            <div class="form-group">
              <label>Product Name *</label>
              <input type="hidden" name="id_item" value="<?=$row->id_item;?>" class="form-control" required>
              <input type="text" name="name" value="<?=$row->name;?>" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Barcode *</label>
              <input type="text" name="barcode" value="<?=$row->barcode;?>" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Jenis *</label>
              <?php echo form_dropdown('jenis',$jenis,$selectedjenis,
                    ['class'=>'form-control','required'=>'required']);?>
            </div>
            <div class="form-group">
              <label>Merk *</label>
              <?php echo form_dropdown('merk',$merk,$selectedmerk,
                    ['class'=>'form-control','required'=>'required']);?>
            </div>
            <div class="form-group">
              <label>Koleksi *</label>
              <?php echo form_dropdown('koleksi',$koleksi,$selectedkoleksi,
                    ['class'=>'form-control','required'=>'required']);?>
            </div>
            <div class="form-group">
              <label>HPP *</label>
              <input type="number" name="hpp" value="<?=$row->hpp;?>" class="form-control" required>
            </div>
            <div class="form-group">
              <label>RRP *</label>
              <input type="number" name="fob" value="<?=$row->fob;?>" class="form-control" required>
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
