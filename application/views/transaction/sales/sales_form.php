<section class="content-header">
  <h1>Sales
    <small>Penjualan Item</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">Sales</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-lg-4">
      <div class="box box-widget">
        <div class="box-body">
          <table width="100%">
            <tr>
              <td style="vertical-align:top">
                <label for="date">Date</label>
              </td>
              <td>
                <div class="form-group">
                  <input type="date" id="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" require readonly>
                </div>
              </td>
            </tr>
            <tr>
              <td style="vertical-align:top; width:30%">
                <label for="user">Kasir</label>
              </td>
              <td>
                <div class="form-group">
                  <input type="text" id="kasir" value="<?=$this->fungsi->user_login()->name?>" class="form-control" readonly>
                </div>
              </td>
            </tr>
            <tr>
              <td style="vertical-align:top">
                <label for="customer">Customer</label>
              </td>
              <td>
                <div class="form-group">
                  <select id="customer" class="form-control">
                    <?php foreach ($customer as $cust => $value){
                      echo"<option value='".$value->id_customer."'>".$value->name_customer."</option>";
                    }?>
                  </select>
                </div>
              </td>
            </tr>
            <tr>
              <td style="vertical-align:top">
                <label for="customer">Ref</label>
              </td>
              <td>
                <div class="form-group">
                  <select id="jobref" class="form-control">
                    <?php foreach ($jobref as $ref => $value){
                      echo"<option value='".$value->id_jobref."'>".$value->nama_jobref."</option>";
                    }?>
                  </select>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="box box-widget">
        <div class="box-body">
          <table width="100%">
            <tr>
              <td style="vertical-align:top; width:30%">
                <label for="barcode">Barcode</label>
              </td>
              <td>
                <div class="form-group input-group">
                  <input type="hidden" id="id_item">
                  <input type="hidden" id="fob">
                  <input type="hidden" id="stock">
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
    <div class="col-lg-4">
      <div class="box box-widget">
        <div class="box-body">
          <div align="right">
            <h4>Invoice <b><span id="invoice"><?= $invoice?></span></b></h4>
            <h1><b><span id="grand_total2" style="font-size:50pt">0</span></b></h1>
          </div>
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
                <th>Price</th>
                <th>Qty</th>
                <th width="10%">Discount Item</th>
                <th width="15%">Total</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="cart_table">
              <?php $this->view('transaction/sales/cart_data') ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-3">
      <div class="box box-widget">
        <div class="box-body">
          <table width="100%">
            <tr>
              <td style="vertical-align:top; width:30%">
                <label for="sub_total">Sub Total</label>
              </td>
              <td>
                <div class="form-group">
                  <input type="number" id="sub_total" value="" class="form-control" readonly>
                </div>
              </td>
            </tr>
            <tr>
              <td style="vertical-align:top">
                <label for="discount">Discount</label>
              </td>
              <td>
                <div class="form-group">
                <div class="input-group">
                  <input type="number" id="discount" value="0" min="0" class="form-control">
                  <span class="input-group-addon"><i>%</i></span>
                </div>

                </div>
              </td>
            </tr>
            <tr>
              <td style="vertical-align:top">
                <label for="discount">Grand Total</label>
              </td>
              <td>
                <div class="form-group">
                  <input type="number" id="grand_total" class="form-control">
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="box box-widget">
        <div class="box-body">
          <table width="100%">
            <tr>
              <td style="vertical-align:top">
                <label for="ongkir">Ongkir</label>
              </td>
              <td>
                <div class="form-group">
                  <input type="number" id="ongkir" value="0" class="form-control" >
                </div>
              </td>
            </tr>
            <tr>
              <td style="vertical-align:top">
                <label for="biaya_lain">Biaya Lainnya</label>
              </td>
              <td>
                <div class="form-group">
                  <input type="number" id="biaya_lain" value="0" class="form-control" >
                </div>
              </td>
            </tr>
            <tr>
              <td style="vertical-align:top">
                <label for="note">Note</label>
              </td>
              <td>
                <div class="form-group">
                  <textarea id="note" row="3" class="form-control" ></textarea>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="box box-widget">
        <div class="box-body">
          <table width="100%">
            <tr>
              <td style="vertical-align:top; width:30%">
                <label for="cash">Cash</label>
              </td>
              <td>
                <div class="form-group">
                  <input type="number" id="cash" value="0" min="0" class="form-control" >
                </div>
              </td>
            </tr>
            <tr>
              <td style="vertical-align:top">
                <label for="discount">Change</label>
              </td>
              <td>
                <div class="form-group">
                  <input type="number" id="change" class="form-control" readonly>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>


    <div class="col-lg-3">
      <div>
        <button id="cancel_payment" class="btn btn-flat btn-warning">
          <i class=" fa fa-refresh"></i> Cancel
        </button>
        <button id="process_payment" class="btn btn-flat btn-success">
          <i class=" fa fa-paper-plane-o"></i> Process Payment
        </button><br><br>
        <!-- <button id="save" class="btn btn-flat btn-default">
          <i class=" fa fa-save"></i> Save
        </button> -->
        <!-- <button id="process_payment" class="btn btn-flat btn-default">
          <i class=" fa fa-archive"></i> Daftar Save
        </button> -->
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
        <h4 class="modal-title">Add Product Item</h4>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-bordered table-striped" id="table1">
          <thead>
            <tr>
              <th>Merk</th>
              <th>Nama</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($item as $i => $data) {?>
              <tr>

                <td><?=$data->name_merk?></td>
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
        <input type="hidden" id="cartid_item">
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
          <label for="price_item">Price</label>
          <input type="number" id="price_item" min="0" class="form-control">
        </div>
        <div class="form-group">
          <label for="qty_item">QTY</label>
          <input type="number" id="qty_item" min="1" class="form-control">
        </div>
        <div class="form-group">
          <label for="total_before">Total Before Discount</label>
          <input type="number" id="total_before" class="form-control" readonly>
        </div>

        <div class="form-group">
          <label for="discount_item">Discount perItem</label>
          <div class="input-group">
            <input type="number" id="discount_item" class="form-control">
            <span class="input-group-addon"><i>%</i></span>
          </div>
        </div>
        <div class="form-group">
          <label for="price_item">Total After Discount</label>
          <input type="number" id="total_item" class="form-control" readonly>
        </div>
      </div>
      <div class="modal-footer">
          <div class="pull-right">
              <button type="button" id="edit_cart" class="btn btn-flat btn-success">
                <i class="fa fa-paper-plane"></i> Save Update
              </button>
          </div>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).on('click','#select', function(){
    $('#id_item').val($(this).data('id'));
    $('#barcode').val($(this).data('barcode'));
    $('#fob').val($(this).data('fob'));
    $('#stock').val($(this).data('stock'));
    $('#modal-item').modal('hide');
  })
  $(document).on('click','#add_cart', function() {
    var id_item = $('#id_item').val()
    var fob = $('#fob').val()
    var stock = $('#stock').val()
    var qty = $('#qty').val()
    if(id_item == ''){
      alert('Product belum dipilih')
      $('#barcode').focus()
    }else if(parseInt(qty) > parseInt(stock)){
      alert('stok tidak mencukupi')
      ('#id_item').val('')
      ('#barcode').val('')
      ('#barcode').focus()
    }else{
      $.ajax({
        type : 'POST',
        url  : '<?=site_url('sales/process')?>',
        data : {'add_cart':true, 'id_item':id_item, 'fob':fob, 'qty':qty},
        dataType: 'json',
        success: function(result) {
          if(result.success == true){
            $('#cart_table').load('<?=site_url('sales/cart_data')?>', function(){
              calculate()
            });
            $('#id_item').val('')
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

  $(document).on('click','#del_cart', function(){
    if(confirm('Apakah anda yakin')){
      var id_cart = $(this).data('cartid')
      $.ajax({
        type:'POST',
        url: '<?=site_url('Sales/cart_del')?>',
        dataType: 'json',
        data:{'id_cart':id_cart},
        success: function(result){
          if(result.success == true){
            $('#cart_table').load('<?=site_url('sales/cart_data')?>', function(){
              calculate()
            })
          }else{
            alert('Gagal hapus item cart');
          }
        }
      })
    }
  })

  $(document).on('click','#update_cart', function(){
    $('#cartid_item').val($(this).data('cartid'));
    $('#barcode_item').val($(this).data('barcode'));
    $('#product_item').val($(this).data('product'));
    $('#price_item').val($(this).data('price'));
    $('#qty_item').val($(this).data('qty'));
    $('#total_before').val($(this).data('qty') * $(this).data('price'));
    $('#discount_item').val($(this).data('discount'));
    $('#total_item').val($(this).data('total'));
  })

  function count_edit_modal() {
    var price = $('#price_item').val()
    var qty   = $('#qty_item').val()
    var discount = $('#discount_item').val()

    total_before = price * qty
    $('#total_before').val(total_before)

    total = total_before - (total_before *(discount/100)) * qty
    $('#total_item').val(total)

    if(discount == ''){
      ('#discount_item').val(0)
    }

  }

  $(document).on('keyup mouseup', '#price_item, #qty_item, #discount_item', function () {
    count_edit_modal()
  })


  $(document).on('click','#edit_cart', function() {
    var id = $('#cartid_item').val()
    var price = $('#price_item').val()
    var qty = $('#qty_item').val()
    var discount = $('#discount_item').val()
    var total = $('#total_item').val()
    var dis = (price*(discount/100))

    if(price == '' || price < 1){
      alert('Harga tidak boleh kosong')
      $('#price_item').focus()
    } else if(qty == '' || qty <1 ){
      alert('QTY tidak boleh kosong')
      ('#qty_item').focus()
    }else{
      $.ajax({
        type : 'POST',
        url  : '<?=site_url('sales/process')?>',
        data : {'edit_cart':true, 'id':id, 'price':price, 'qty':qty,
               'discount': dis, 'total':total},
        dataType: 'json',
        success: function(result) {
          if(result.success == true){
            $('#cart_table').load('<?=site_url('sales/cart_data')?>', function(){
              calculate()
            });
            $('#modal-item-edit').modal('hide')
          }else {
            alert('gagal update item cart')
          }
        }
      })

    }
  })

  function calculate(){
    var subtotal = 0;
    var ongkir = 0;
    var biaya_lain = 0;
    $('#cart_table tr').each(function(){
      subtotal += parseInt($(this).find('#total').text())
    })
    isNaN(subtotal) ? $('#sub_total').val(0) : $('#sub_total').val(subtotal)
    var ongkir = $('#ongkir').val()
    var biaya_lain = $('#biaya_lain').val()
    var discount = $('#discount').val()
    var grand_total = parseInt(ongkir) + parseInt(biaya_lain) + parseInt(subtotal) - (parseInt(subtotal)*(parseInt(discount)/100))
    if(isNaN(grand_total)){
      $('#grand_total').val(0)
      $('#grand_total2').text(0)
    }else{
      $('#grand_total').val(grand_total)
      $('#grand_total2').text(grand_total)
    }
    var cash = $('#cash').val()
    cash != 0 ? $('#change').val(cash - grand_total) : $('#change').val(0)

    // if(discount == ''){
    //   ('#discount').val(0)
    // }

  }

  $(document).on('keyup mouseup', '#discount, #cash, #ongkir, #biaya_lain', function () {
    calculate()
  })

  $(document).ready(function(){
    calculate()
  })

  // payment
   $(document).on('click', '#process_payment', function () {
     var id_customer = $('#customer').val()
     var subtotal    = $('#sub_total').val()
     var discount    = $('#discount').val()
     var grandtotal  = $('#grand_total').val()
     var cash        = $('#cash').val()
     var change      = $('#change').val()
     var note        = $('#note').val()
     var date        = $('#date').val()
     var ongkir      = $('#ongkir').val()
     var biaya_lain  = $('#biaya_lain').val()
     var ref         = $('#jobref').val()
     var dis         = (subtotal*discount/100)

     if(subtotal < 1){
       alert('Belum ada product item yang dipilih')
       $('#barcode').focus()
     }else if(cash < 0){
       alert('Jumlah uang belum diinput')
       $('#cash').focus()
     }else {
       if(confirm(' Yakin proses transaksi ini ?')){
         $.ajax({
           type : 'POST',
           url  : '<?=site_url('Sales/process') ?>',
           data : {'process_payment' : true, 'id_customer':id_customer, 'subtotal':subtotal,
                    'discount':dis, 'grandtotal':grandtotal, 'cash':cash, 'change':change,
                    'note':note, 'date':date, 'ongkir':ongkir, 'biaya_lain':biaya_lain,'ref':ref},
           dataType : 'json',
           success  : function (result) {
              if(result.success){
                alert("Transaksi Berhasil")
              }else{
                alert("Transaksi Gagal")
              }
              location.href='<?=site_url('Sales')?>'
             }
         })
       }
     }
    })


    // Save
   $(document).on('click', '#save', function () {
     var id_customer = $('#customer').val()
     var subtotal    = $('#sub_total').val()
     var discount    = $('#discount').val()
     var grandtotal  = $('#grand_total').val()
     var cash        = $('#cash').val()
     var change      = $('#change').val()
     var note        = $('#note').val()
     var date        = $('#date').val()
     var ongkir      = $('#ongkir').val()
     var ref         = $('#jobref').val()
     var dis         = (subtotal*discount/100)

     if(subtotal < 1){
       alert('Belum ada product item yang dipilih')
       $('#barcode').focus()
     }else if(cash < 0){
       alert('Jumlah uang belum diinput')
       $('#cash').focus()
     }else {
       if(confirm(' Yakin simpan transaksi ini ?')){
         $.ajax({
           type : 'POST',
           url  : '<?=site_url('Sales/process') ?>',
           data : {'save' : true, 'id_customer':id_customer,'note':note, 'date':date,'ref':ref},
           dataType : 'json',
           success  : function (result) {
              if(result.success){
                alert("Simpan Berhasil")
              }else{
                alert("Simpan Gagal")
              }
              location.href='<?=site_url('Sales')?>'
             }
         })
       }
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
          $('#cart_table').load('<?=site_url('sales/cart_data')?>', function(){
            calculate()
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
