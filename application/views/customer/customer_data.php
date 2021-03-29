<section class="content-header">
  <h1>Customer
    <small>Pelanggan</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">Customer</li>
  </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Customer</h3>
      <div class="pull-right">
      <?php
      $a = $this->fungsi->user_login()->level;
      if($a == 1 || $a == 2 || $a == 3) { ?>
         <a href="<?=site_url('customer/add')?>" class="btn btn-success btn-flat">
          <i class="fa fa-user-plus"></i> Tambah Data</a>
      </button>
      <?php  } ?>

      </div>
    </div>
    <div class="box-body table-resposive">
      <table class="table table-bordered table-striped display responsive" id="table1">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $no = 1;
            foreach ($row->result() as $key =>$data) {?>
              <tr>
                <td><?=$no?></td>
                <td><?=$data->name_customer?></td>
                <td><?=$data->address?></td>
                <td><?=$data->phone?></td>
                <td><?=indo_date($data->created)?></td>
                <td class="text-center" width="160px">
                  <button id="detail" data-target="#modal-detail" data-toggle="modal" class="btn btn-default btn-sm"
                    data-customer="<?=$data->id_customer?>"
                    > <i class="fa fa-history" ></i>
                  </button>
                  <a href="<?=site_url('customer/update/'.$data->id_customer)?>" class="btn btn-success btn-sm">
                    <i class="fa fa-pencil"></i>
                  </a>
                  <?php if($a == 1 ){ ?>
                  <a href="<?=site_url('customer/delete/'.$data->id_customer)?>"
                    onclick="return confirm('Yakin Hapus Data?')" class="btn btn-danger btn-sm">
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
        <h4 class="modal-title">Sales Report</h4>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-bordered no-margin">
          <tbody>
            <tr>
              <td colspan="3"><span id="product"></span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready( function () {
    $('#table1').DataTable( {
    	responsive: true
    } );
} );
  $(document).on('click','#detail', function () {
    $('#customer').text($(this).data('customer'));
    $('#modal-detail').modal('hide');

    var product = '<table class="table no-margin"><tr><th>No Invoice</th><th>Date</th><th>Grand Total</th></tr>'
    $.getJSON('<?=site_url('Report/sale_product_customer/')?>'+$(this).data('customer'), function (data) {
      $.each(data, function (key, val) {
          product += '<tr><td>'+val.invoice+'</td><td>'+val.sales_created+'</td><td>Rp.'+val.final_price+'</td></tr>'
        })
        product += '</table>'
        $('#product').html(product)
     })
  })

</script>
