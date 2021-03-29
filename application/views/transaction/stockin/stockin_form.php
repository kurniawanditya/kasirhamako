<section class="content-header">
  <h1>Stock In
    <small>Barang Masuk / Pembelian Barang</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">Transaction</li>
  </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">   Add Stock In</h3>
      <div class="pull-right">
        <a href="<?=site_url('Stockin')?>" class="btn btn-warning btn-flat">
          <i class="fa fa-undo"></i> Back</a>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <?php //echo validation_errors(); ?>
          <form action="<?=site_url('Stockin/process')?>" method="post">
            <div class="form-group">
              <label>Date *</label>
              <input type="date" name="date" value="<?=date('Y-m-d');?>" class="form-control" required>
            </div>
            <div>
              <label for="barcode">Barcode *</label>
            </div>
            <div class="form-group input-group">
              <!-- <label for="barcode">Barcode *</label> -->
              <input type="hidden" name="id_item" id="id_item">
              <input type="text" name="barcode" id="barcode" class="form-control" require autofocus>
              <span class="input-group-btn">
                <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-item">
                    <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
            <div class="form-group">
              <label>Item Name *</label>
              <input type="text" name="item_name" id="item_name" class="form-control" readonly>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <label for="stock">Initial Stock</label>
                        <input type="text" name="stock" id="stock" value="-" class="form-control" readonly> 
                    </div>
                </div>
            </div>
            <div class="form-group">
              <label>Detail *</label>
              <input type="text" name="detail" class="form-control" placeholder="isi detail" required>
            </div>
            <div class="form-group">
              <label>Supplier *</label>
              <select name="supplier" class="form-control">
                <option value="0">--PILIH--</option>
                <?php foreach ($supplier as $cust => $value){
                    echo"<option value='".$value->id_supplier."'>".$value->name_supplier."</option>";
                }?>
                </select>
            </div>

            <div class="form-group">
              <label>Qty *</label>
              <input type="number" name="qty" class="form-control" require>
            </div>

            <div class="form-group">
              <button type="submit" name="in_add" class="btn btn-success btn-flat">Save</button>
              <button type="reset"  class="btn btn-flat">Reset</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="modal-item">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Add Product Item</h4>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-bordered table-striped" id="table1">
          <thead>
            <tr>
              <th>Barcode</th>
              <th>Nama</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($item as $i => $data) {?>
              <tr>
                <td><?=$data->barcode?></td>
                <td><?=$data->name?></td>
                <td class="text-right"><?=indo_currency($data->fob)?></td>
                <td class="text-right"><?=$data->stock?></td>
                <td class="text-right">
                  <button class="btn btn-xs btn-info" id="select"
                    data-id="<?=$data->id_item?>"
                    data-barcode="<?=$data->barcode?>"
                    data-name="<?=$data->name?>"
                    data-fob="<?=$data->fob?>"
                    data-stock="<?=$data->stock?>">
                      <i class="fa fa-check"> select </i>
                    </button>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on('click','#select', function(){
    $('#id_item').val($(this).data('id'));
    $('#item_name').val($(this).data('name'));
    $('#barcode').val($(this).data('barcode'));
    $('#fob').val($(this).data('fob'));
    $('#stock').val($(this).data('stock'));
    $('#modal-item').modal('hide');
  })
  </script>