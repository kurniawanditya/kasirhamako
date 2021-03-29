<style>
  .scroll{
  background-color:#fff;
  width:100%;
  overflow-y: auto;
  max-height: 400px;
  }
</style>
<section class="content-header">
  <h1>Laporan
    <small>Laporan Penjualan</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">Penjualan</li>
  </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Penjualan</h3>
      <div class="pull-right">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
          Membuat Laporan Penjualan
        </button>
      </div>
    </div>
    <div class="box-body table-resposive">
      <table class="table table-bordered table-striped display responsive" id="tablesales">
        <thead>
          <tr>
            <th>#</th>
            <th>Invoice</th>
            <th>Date</th>
            <th>Ref</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Discount</th>
            <th>Ongkir</th>
            <th>Biaya Lainnya</th>
            <th>Grand Total</th>
            <th>User</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $no = 1;
            foreach ($row->result() as $key =>$data) {?>
              <tr>
                <td><?=$no?></td>
                <td><?=$data->invoice?></td>
                <td><?=$data->date?></td>
                <td><?=$data->nama_jobref?></td>
                <td><?=$data->customername?></td>
                <td class="text-right"><?=$data->total_price?></td>
                <td class="text-right"><?=$data->discount?></td>
                <td class="text-right"><?=$data->ongkir?></td>
                <td class="text-right"><?=$data->biaya_lain?></td>
                <td class="text-right"><?=$data->final_price?></td>
                <td class="text-right"><?=$data->name?></td>
                <td class="text-center" width="200px">
                  <button id="detail" data-target="#modal-detail" data-toggle="modal" class="btn btn-default"
                  data-invoice="<?=$data->invoice?>"
                  data-date="<?=$data->date?>"
                  data-time="<?=substr($data->sales_created,11,5)?>"
                  data-customer="<?=$data->customername?>"
                  data-total="<?=$data->total_price?>"
                  data-discount="<?=$data->discount?>"
                  data-grandtotal="<?=$data->final_price?>"
                  data-cash="<?=$data->cash?>"
                  data-remaining="<?=$data->remaining?>"
                  data-note="<?=$data->note?>"
                  data-ongkir="<?=$data->ongkir?>"
                  data-biaya_lain="<?=$data->biaya_lain?>"
                  data-cashier="<?=$data->username?>"
                  data-id_sales="<?=$data->id_sales?>"
                  ><i class="fa fa-eye"></i></button>
                  <a href="<?=site_url('Report/export_excel/'.$data->id_sales)?>" class="btn btn-info "><i class="fa fa-print"></i>
                  </a>

                  <?php $a = $this->fungsi->user_login()->level;
                  if($a == 1){ ?>
                  <a href="<?=site_url('Sales/delete/'.$data->id_sales)?>"
                    onclick="return confirm('Yakin Hapus Data?')" class="btn btn-danger">
                    <i class="fa fa-trash"></i>
                  </a>
                  <?php } ?>
                </td>
              </tr>
          <?php $no++;
        }?>
        </tbody>

      </table>
    </div>
  </div>
</section>

<div class="modal fade" id="modal-default" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title col-md-6">Filter</h4>
      </div>
      <div class="modal-body">
      <form action="<?=site_url('Report/export_sales')?>" method="post">
          <div class="form-group">
            <label for="Ref">Ref</label>
            <select name="jobref" id="jobref" class="form-control">
              <option value="">All</option>
              <?php foreach ($ref as $key => $value) {?>
                <option value="<?=$value->id_jobref?>"><?=$value->nama_jobref?></option>
              <?php }?>
            </select>
          </div>
          <div class="form-group">
            <label for="tgl_awal">Tgl Awal</label>
            <input type="date" name="tgl_awal" id="tgl_awal" class="form-control">
          </div>
          <div class="form-group">
            <label for="tgl_akhir">Tgl Akhir</label>
            <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control">
          </div>

      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Cetak</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-detail">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Sales Report Detail</h4>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-bordered no-margin">
          <tbody>
            <tr>
                <th style="width:20%">Invoice</th>
                <td style="width:30%"><span id="invoice"></span></td>
                <th>Date Time</th>
                <td><span id="datetime"></span></td>

            </tr>
            <tr>
                <th style="width:20%">Customer</th>
                <td style="width:30%"><span id="cust"></span></td>
                <th>Cashier</th>
                <td><span id="cashier"></span></td>

            </tr>
            <tr>
                <th>Total</th>
                <td><span id="total"></span></td>
                <th>Cash</th>
                <td><span id="cash"></span></td>

            </tr>
            <tr>
                <th>Discount</th>
                <td><span id="discount"></span></td>
                <th>Biaya Lainnya</th>
                <td><span id="biaya_lain"></span></td>
            </tr>
            <tr>
                <th>Grand Total</th>
                <td><span id="grand"></span></td>
                <th>Ongkir</th>
                <td><span id="ongkir"></span></td>

            </tr>
            <tr>
                <th>Note</th>
                <td><span id="note"></span></td>
                <th>Total QTY</th>
                <td><span id="totqty"></span>  pcs</td>

            </tr>
            <tr>
                <th colspan="5">Product</th>
            </tr>
            <tr>
              <td colspan="5"><span id="product"></span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  var myObj = {
    style: "currency",
    currency: "IDR",
    decimal: "0"
  }
  $(document).on('click','#detail', function () {
    $('#invoice').text($(this).data('invoice'));
    $('#cust').text($(this).data('customer'));
    $('#datetime').text($(this).data('date'));
    $('#cashier').text($(this).data('cashier'));
    $('#total').text($(this).data('total').toLocaleString("id-ID",myObj));
    $('#cash').text($(this).data('cash').toLocaleString("id-ID",myObj));
    $('#discount').text($(this).data('discount').toLocaleString("id-ID",myObj));
    $('#grand').text($(this).data('grandtotal').toLocaleString("id-ID",myObj));
    $('#note').text($(this).data('note'));
    $('#ongkir').text($(this).data('ongkir').toLocaleString("id-ID",myObj));
    $('#biaya_lain').text($(this).data('biaya_lain').toLocaleString("id-ID",myObj));
    $('#modal-detail').modal('hide');

    $.getJSON('<?=site_url('report/totqty/')?>'+$(this).data('id_sales'), function (data) {
      $.each(data, function (key, val) {
        totqty = val.tot
        })
        $('#totqty').html(totqty)
     })

    var product = '<div class="scroll"><table class="table no-margin"><tr><th>Item</th><th>Price</th><th>Qty</th><th>Disc</th><th>Total</th></tr>'
    $.getJSON('<?=site_url('report/sale_product/')?>'+$(this).data('id_sales'), function (data) {
      $.each(data, function (key, val) {
          product += '<tr><td>'+val.name+'</td><td>'+val.price +'</td><td>'+val.qty+'</td><td>'+val.discount_item+'</td><td>'+val.total+'</td></tr>'
        })
        product += '</table></div>'
        $('#product').html(product)
     })
  })

</script>
