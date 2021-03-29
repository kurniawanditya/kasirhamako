<style>
  .scroll{
  background-color:#fff;
  width:100%;
  overflow-y: auto;
  max-height: 400px;
  }
</style>
<section class="content-header">
  <h1>Aksesoris Masuk
    <small>Data Aksesoris Masuk</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">Data Aksesoris Masuk</li>

  </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Aksesoris Masuk</h3>
      <div class="pull-right">
      <?php
      $a = $this->fungsi->user_login()->level;
      if($a == 1 || $a == 3) { ?>
        <a href="<?=site_url('Aksesorisin/add')?>" class="btn btn-success btn-flat">
          Tambah Data Masuk</a>
        <button data-target="#modal-tanggal" data-toggle="modal" class="btn btn-default">Laporan Data Masuk</button>
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
            <th>Supplier</th>
            <th>Ref</th>
            <th>User</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $no = 1;
            foreach ($accin as $key =>$data) {?>
              <tr>
                <td><?=$no?></td>
                <td><?=$data->date?></td>
                <td><?=$data->surat_jalan?></td>
                <td><?=$data->name_supplier?></td>
                <td><?=$data->ref?></td>
                <td><?=$data->name?></td>
                <td class="text-center" width="200px">
                  <button id="detail" data-target="#modal-detail" data-toggle="modal" class="btn btn-default"
                  data-id_accin="<?=$data->id_accin?>"
                  data-date="<?=indo_date($data->date)?>"
                  data-sj="<?=$data->surat_jalan?>"
                  data-sp="<?=$data->name_supplier?>"
                  ><i class="fa fa-eye"></i></button>
                  <a href="<?=site_url('Report/report_in/'.$data->id_accin)?>"  class="btn btn-info"><i class="fa fa-print"></i>
                  </a>

                  <?php if($a == 1){ ?>
                  <a href="<?=site_url('Aksesorisin/delete/'.$data->id_accin)?>"
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
<div class="modal fade" id="modal-tanggal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Detail Aksesoris Masuk</h4>
      </div>
      <form action="<?=site_url('Report/lap_allin')?>" method="post">
      <div class="modal-body table-responsive">
      <div class="row">
        <div class="col-lg-12">
          <div class="form-group">
          <label>Tgl Awal</label>
          <div class="input-group date">
            <div class="input-group-addon">
                  <span class="glyphicon glyphicon-th"></span>
              </div>
              <input placeholder="masukkan tanggal Awal" value="<?php echo date('Y-m-d');?>" type="date" class="form-control datepicker" name="tgl_awal">
          </div>
          </div>
          <div class="form-group">
          <label>Tgl Akhir</label>
          <div class="input-group date">
            <div class="input-group-addon">
                  <span class="glyphicon glyphicon-th"></span>
              </div>
              <input placeholder="masukkan tanggal Akhir" value="<?php echo date('Y-m-d');?>" type="date" class="form-control datepicker" name="tgl_akhir">
          </div>
          </div>
          </div>

        </div>
        <div class="row">
          <div class="col-lg-12">
            <div>
              <button type="submit" id="process_saving" class="btn btn-flat btn-success">OK
              </button>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-detail">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Detail Aksesoris Masuk</h4>
        <br>

      </div>
      <div class="modal-body table-responsive">
        <table class="table table-bordered no-margin">
          <tbody>
            <tr>
                <th style="width:20%">Surat Jalan</th>
                <td style="width:30%"><span id="sj"></span></td>
                <th>Supplier</th>
                <td><span id="sp"></span></td>
            </tr>
            <tr>
                <th>Date Time</th>
                <td><span id="datetime"></span></td>
                <th>Total QTY</th>
                <td colspan="3"><span id="qty"></span></td>
            </tr>
            <tr>

                <th colspan="5"><center>Product</center></th>
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
  $(document).on('click','#detail', function () {
    $('#sj').text($(this).data('sj'));
    $('#po').text($(this).data('po'));
    $('#sp').text($(this).data('sp'));
    $('#datetime').text($(this).data('date'));
    $('#modal-detail').modal('hide');

    var qty = '<span>'
    $.getJSON('<?=site_url('Aksesorisin/qtydetail/')?>'+$(this).data('id_accin'), function (data) {
      $.each(data, function (key, val) {
          qty += val.qty
        })
        qty += '</span>'
        $('#qty').html(qty)
     })

    var product = '<div class="scroll"><table class="table no-margin"><tr><th>Item</th><th>Qty</th></tr>'
    $.getJSON('<?=site_url('Aksesorisin/detail_accin/')?>'+$(this).data('id_accin'), function (data) {
      $.each(data, function (key, val) {
          product += '<tr><td>'+val.name+'</td><td>'+val.qty+'</td></tr>'
        })
        product += '</table></div>'
        $('#product').html(product)
     })

  })

</script>
