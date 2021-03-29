<section class="content-header">
  <h1>Aksesoris Masuk
    <small>Aksesoris Masuk</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">Aksesoris Masuk</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-lg-6">
      <div class="box box-widget">
        <div class="box-body">
          <table width="100%">
            <tr>
              <td style="vertical-align:top">
                <label for="date">Date</label>
              </td>
              <td>
                <div class="form-group">
                  <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" readonly>
                </div>
              </td>
            </tr>
            <tr>
              <td style="vertical-align:top; width:30%">
                <label for="sj">Surat Jalan</label>
              </td>
              <td>
                <div class="form-group">
                  <input type="text" name="sj" id="sj" class="form-control">
                </div>
              </td>
            </tr>
            <tr>
              <td style="vertical-align:top; width:30%">
                <label for="ref">Ref</label>
              </td>
              <td>
                <div class="form-group">
                  <input type="text" name="ref" id="ref" class="form-control">
                </div>
              </td>
            </tr>
            <tr>
              <td style="vertical-align:top">
                <label for="supplier">Supplier</label>
              </td>
              <td>
                <div class="form-group">
                  <select id="supplier" name="supplier" class="form-control">
                    <?php foreach ($supplier as $sup => $value){
                      echo"<option value='".$value->id_supplier."'>".$value->name_supplier."</option>";
                    }?>
                  </select>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="box box-widget">
        <div class="box-body">
          <table width="100%">
            <tr>
              <td style="vertical-align:top; width:30%">
                <label for="barcode">Barcode</label>
              </td>
              <td>
                <div class="form-group input-group">
                  <input type="hidden" id="id_item_acc">
                  <input type="hidden" id="stok">
                  <input type="text" id="barcode" class="form-control" autofocus>
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-item">
                      <i class="fa fa-search"></i>
                    </button>
                  </span>
                </div>
              </td>
            </tr>
            <tr>
              <td style="vertical-align:top">
                <label for="qty">Qty</label>
              </td>
              <td>
                <div class="form-group">
                  <input type="number" id="qty" value="1" min="1" class="form-control">
                </div>
              </td>
            </tr>
            <tr>
              <td></td>
              <td>
                <div>
                  <button type="button" id="add_cart" class="btn btn-primary">
                    <i class="fa fa-cart-plus"></i>Add
                  </button>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-widget">
        <div class="box-body table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Barcode</th>
                <th>Product Item</th>
                <th>Qty</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="cart_table">
              <?php $this->view('transaction/Aksesorisin/temp_aksesorisin') ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    
    <div class="col-lg-12">
      <div>
        <button id="cancel_payment" class="btn btn-flat btn-warning">
          <i class=" fa fa-refresh"></i> Cancel
        </button>
        <button id="process_saving" class="btn btn-flat btn-success">
          <i class=" fa fa-paper-plane-o"></i> Saving
        </button>
      </div>
    </div>

  </div>
</section>
<!--modal additem -->
<div class="modal fade" id="modal-item">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Item Aksesoris</h4>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-bordered table-striped" id="table1">
          <thead>
            <tr>
              <th>Barcode</th>
              <th>Nama</th>
              <th>Stock</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($item as $i => $data) {?>
              <tr>
                <td><?=$data->barcode?></td>
                <td><?=$data->name?></td>
                <td class="text-right"><?=$data->stok?></td>
                <td class="text-right">
                  <button class="btn btn-xs btn-info" id="select"
                    data-id="<?=$data->id_item_acc?>"
                    data-barcode="<?=$data->barcode?>"
                    data-name="<?=$data->name?>"
                    data-stok="<?=$data->stok?>">
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
<!-- edit item -->
<div class="modal fade" id="modal-item-edit">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Update Product Item</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="tempt_iditem">
        <div class="form-group">
          <label for="product_item">Product Item</label>
          <div class="row">
              <div class="col-md-5">
                <input type="text" id="barcode_item" class="form-control" readonly>
              </div>
              <div class="col-md-7">
              <input type="text" id="product_item" class="form-control" readonly>
              </div>
          </div>
        </div>
     
        <div class="form-group">
          <label for="qty_item">QTY</label>
          <input type="number" id="qty_item" min="1" class="form-control">
        </div>
      
      </div>
      <div class="modal-footer">
          <div class="pull-right">
              <button type="button" id="edit_temp" class="btn btn-flat btn-success">
                Save Update
              </button>
          </div>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).on('click','#select', function(){
    $('#id_item_acc').val($(this).data('id'));
    $('#barcode').val($(this).data('barcode'));
    $('#stok').val($(this).data('stok'));
    $('#modal-item').modal('hide');
  })
  $(document).on('click','#add_cart', function() {
    var id_item_acc = $('#id_item_acc').val()
    var stock = $('#stock').val()
    var supplier = $('#supplier').val()
    var ref = $('#ref').val()
    var qty = $('#qty').val()
    if(id_item_acc == ''){
      alert('Product belum dipilih')
      $('#barcode').focus()
    }else{
      $.ajax({
        type : 'POST',
        url  : '<?=site_url('Aksesorisin/process')?>',
        data : {'add_tempin':true, 'id_item_acc':id_item_acc, 'qty':qty, 'supplier':supplier, 'ref':ref},
        dataType: 'json',
        success: function(result) {
          if(result.success == true){
            $('#cart_table').load('<?=site_url('Aksesorisin/temp_data')?>', function(){

              });
            $('#id_item_acc').val('')
            $('#barcode').val('')
            $('#qty').val(1)
            $('#barcode').focus()
          }else {
            alert('gagal tambah item cart')
          }
        }
      })
    }
  })

  $(document).on('click','#del_temp', function(){
    if(confirm('Apakah anda yakin')){
      var id_temp = $(this).data('tempid')
      $.ajax({
        type:'POST',
        url: '<?=site_url('Aksesorisin/del_temp')?>',
        dataType: 'json',
        data:{'id_temp_acc':id_temp},
        success: function(result){
          if(result.success == true){
            $('#cart_table').load('<?=site_url('Aksesorisin/temp_data')?>', function(){
            }) 
          }else{
            alert('Gagal hapus item cart');
          }
        }
      })
    }
  })

  $(document).on('click','#update_temp', function(){
    $('#tempt_iditem').val($(this).data('tempid'));
    $('#barcode_item').val($(this).data('barcode'));
    $('#product_item').val($(this).data('name'));
    $('#qty_item').val($(this).data('qty'));
  })

  
  $(document).on('click','#edit_temp', function() {
    var id = $('#tempt_iditem').val()
    var qty = $('#qty_item').val()

  
    if(qty == '' || qty <1 ){
      alert('QTY tidak boleh kosong')
      ('#qty_item').focus()
    }else{
      $.ajax({
        type : 'POST',
        url  : '<?=site_url('Aksesorisin/process')?>',
        data : {'edit_temp':true, 'id':id, 'qty':qty},
        dataType: 'json',
        success: function(result) {
          if(result.success == true){
            $('#cart_table').load('<?=site_url('Aksesorisin/temp_data')?>', function(){
            });
            $('#modal-item-edit').modal('hide')
          }else {
            alert('gagal tambah item cart')
          }
        }
      })

    }
  })

  // saving
   $(document).on('click', '#process_saving', function () {
    var date        = $('#date').val() 
    var sj          = $('#sj').val()
    var ref          = $('#ref').val()
    var supplier    = $('#supplier').val()
       if(confirm(' Yakin proses transaksi ini ?')){
         $.ajax({
           type : 'POST',
           url  : '<?=site_url('Aksesorisin/process') ?>',
           data : {'process_saving' : true, 'date':date, 'sj':sj, 'supplier':supplier,'ref':ref},
           dataType : 'json',
           success  : function (result) {
              if(result.success){
                alert("Transaksi Berhasil")
              }else{
                alert("Transaksi Gagal")
              }
              location.href='<?=site_url('Aksesorisin')?>'
             }
         })
       }
    })

  //cancel

$(document).on('click','#cancel_payment', function(){
  if(confirm('Apakah anda yakin ?')){
    $.ajax({
      type:'POST',
      url:'<?=site_url('sales/cart_del')?>',
      dataType: 'json',
      data : {cancel_payment:true},
      success:function(result){
        if(result.success == true){
          $('#cart_table').load('<?=site_url('Barangmasuk/temp_barangmasuk')?>', function(){
          })
        }
      }
    })
    $('#discount').val(0)
    $('#cash').val(0)
    $('#customer').val(0).change()
    $('#barcode').val('')
    $('#barcode').focus()

  }
})
</script>
