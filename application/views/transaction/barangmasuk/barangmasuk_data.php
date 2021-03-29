<style>
  .scroll{
  background-color:#fff;
  width:100%;
  overflow-y: auto;
  max-height: 400px;
  }
</style>
<section class="content-header">
  <h1>Barang Masuk
    <small>Laporan Barang Masuk</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">Barang Masuk</li>
    
  </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Barang Masuk</h3>
      <div class="pull-right">
      <?php 
      $a = $this->fungsi->user_login()->level;
      if($a == 1 || $a == 3) { ?>
        <a href="<?=site_url('Barangmasuk/add')?>" class="btn btn-success">
          <i class="fa fa-user-plus"></i> Tambah Data</a>
      <?php } ?>
      </div>
    </div>
    <div class="box-body table-resposive">
      <table class="table table-bordered table-striped" id="table3">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Surat Jalan</th>
            <th>Ref</th>
            <th>Supplier</th>
            <th>User</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $no = 1;
            foreach ($bm as $key =>$data) {?>
              <tr>
                <td><?=$no?></td>
                <td><?=$data->date?></td>
                <td><?=$data->surat_jalan?></td>
                <td><?=$data->no_po?></td>
                <td><?=$data->name_supplier?></td>
                <td><?=$data->name?></td>
                <td class="text-center" width="200px">
                  <button id="detail" data-target="#modal-detail" data-toggle="modal" class="btn btn-default"
                  data-id_bm="<?=$data->id_bm?>"
                  data-date="<?=indo_date($data->date)?>"
                  data-sj="<?=$data->surat_jalan?>"
                  data-po="<?=$data->no_po?>"
                  data-sp="<?=$data->name_supplier?>"
                  ><i class="fa fa-eye"></i></button>
                  <a href="<?=site_url('Report/report_barang_masuk/'.$data->id_bm)?>" class="btn btn-info"><i class="fa fa-print"></i>
                  </a>
                  <?php if($a == 1){ ?>
                  <a href="<?=site_url('Sales/delete/'.$data->id_bm)?>"
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

<div class="modal fade" id="modal-detail">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Detail Barang Masuk</h4>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-bordered no-margin">
          <tbody>
            <tr>
              <td>
                <th style="width:20%">Surat Jalan</th>
                <td style="width:30%"><span id="sj"></span></td>
                <th style="width:20%">No PO</th>
                <td style="width:30%"><span id="po"></span></td>
              </td>
            </tr>
            <tr>
              <td>
                <th>Date Time</th>
                <td><span id="datetime"></span></td>
                <th>Supplier</th>
                <td><span id="sp"></span></td>
              </td>
            </tr>
            <tr>
              <td> 
                <th>Total QTY</th>
                <td colspan="3"><span id="qty"></span></td>
              </td>
            </tr>
            <tr>
              <td>
                <th>Product</th>
                <td colspan="3"><span id="product"></span></td>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).on('click','#detail', function () {
    $('#sj').text($(this).data('sj'));
    $('#po').text($(this).data('po'));
    $('#sp').text($(this).data('sp'));
    $('#datetime').text($(this).data('date'));
    $('#modal-detail').modal('hide');
    
    var qty = '<span>'
    $.getJSON('<?=site_url('Barangmasuk/qtydetail/')?>'+$(this).data('id_bm'), function (data) { 
      $.each(data, function (key, val) {
          qty = val.qty
        })
        qty += '</span>'
        $('#qty').html(qty)
     })

    var product = '<div class="scroll"><table class="table no-margin"><tr><th>Item</th><th>Qty</th></tr>'
    $.getJSON('<?=site_url('Barangmasuk/detail_bm/')?>'+$(this).data('id_bm'), function (data) { 
      $.each(data, function (key, val) {
          product += '<tr><td>'+val.name+'</td><td>'+val.qty+'</td></tr>'
        })
        product += '</table></div>'
        $('#product').html(product)
     })
     
  })

</script>