<section class="content-header">
  <h1>Item
    <small>Item Produk</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">Item</li>

  </ol>
</section>

<section class="content">
  <?php if($this->session->has_userdata('success')) { ?>
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="icon fa fa-check"></i> <?=$this->session->flashdata('success');?>
  </div>
  <?php } ?>

  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data item</h3>
      <div class="pull-right">
        <a href="<?=site_url('item/add')?>" class="btn btn-primary btn-flat">Tambah Produk</a>
        <!-- <a href="<?=site_url('Report/export_item')?>" class="btn btn-primary btn-flat">Export Data</a> -->
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">Export Data
        </button>
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalbarcode">Barcode
        </button>
        <a href="<?=site_url('item/import')?>" class="btn btn-primary btn-flat">Import File</a>
      </div>
    </div>
    <div class="box-body table-resposive">
      <table class="table table-bordered table-striped display responsive" id="mytable">
        <thead>
          <tr>
            <th>#</th>
            <th>Barcode</th>
            <th>Nama</th>
            <th>Jenis</th>
            <th>Merk</th>
            <th>HPP</th>
            <th>RRP</th>
            <th>Koleksi</th>
            <th>Stok</th>
            <th width="100px">Action</th>
          </tr>
        </thead>
        <tbody>

        </tbody>

      </table>
    </div>
  </div>

  <div class="modal fade" id="modal-history">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Item History</h4>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-bordered no-margin">
          <tbody>
            <tr>
              <?php foreach ($row->result() as $key =>$data) {}?>
              <td colspan="3">Qty : <span id="sumqty"></span></td>
            </tr>
            <tr>
              <td colspan="3"><span id="product"></span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

  <form id="add-row-form" action="<?php echo base_url().'Item/update/'?>" method="post">
    <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Update Produk</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-lg-12">
                  <label>Barcode</label>
                  <input type="text" name="kode" class="hidden align-rightform-control" required readonly>
                  <input type="text" name="barcode" class="form-control" required readonly>
                </div>
                <div class="form-group col-lg-12">
                  <label>Item Name </label>
                  <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group col-lg-6">
                  <label>Jenis</label>
                  <select name="jenis" class="form-control" placeholder="Kode Barang" required>
                    <?php foreach ($jenis->result() as $row) :?>
                      <option value="<?php echo $row->id_jenis;?>"><?php echo $row->name_jenis;?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group col-lg-6">
                  <label>Merk</label>
                  <select name="merk" class="form-control" placeholder="Kode Barang" required>
                    <?php foreach ($merk->result() as $row) :?>
                      <option value="<?php echo $row->id_merk;?>"><?php echo $row->name_merk;?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group col-lg-6">
                  <label>FOB</label>
                  <input type="text" name="fob" class="form-control" required>
                </div>
                <div class="form-group col-lg-6">
                  <label>HPP</label>
                  <input type="text" name="hpp" class="form-control" required>
                </div>
                <div class="form-group col-lg-6">
                  <label>Koleksi</label>
                  <select name="koleksi" class="form-control" placeholder="Kode Barang" required>
                    <?php foreach ($koleksi->result() as $row) :?>
                      <option value="<?php echo $row->id_koleksi;?>"><?php echo $row->name_koleksi;?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group col-lg-6">
                  <label>Stock</label>
                  <input type="text" name="stock" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="add-row" class="btn btn-success">Update</button>
            </div>
          </div>
      </div>
    </div>
</form>

<div class="modal fade" id="modal-default" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title col-md-6">Filter</h4>
      </div>
      <div class="modal-body">
      <form action="<?=site_url('Report/export_item')?>" method="post">
          <div class="form-group">
            <label for="Ref">Merk</label>
            <select name="merk" id="merk" class="form-control">
              <option value=NULL>All</option>
              <?php foreach ($merk->result() as $row) {?>
                <option value="<?php echo $row->id_merk; ?>"><?=$row->name_merk;?></option>
              <?php }?>
            </select>
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

<div class="modal fade" id="modalbarcode" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title col-md-6">Filter</h4>
      </div>
      <div class="modal-body">
      <form action="<?=site_url('Item/printbarcode')?>" method="post">
          <div class="form-group">
            <label for="Ref">Koleksi</label>
            <select name="koleksi" id="koleksi" class="form-control">
              <option value=NULL>All</option>
              <?php foreach ($koleksi->result() as $row) {?>
                <option value="<?php echo $row->id_koleksi; ?>"><?=$row->name_koleksi;?></option>
              <?php }?>
            </select>
          </div>

      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Buat Barcode</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

</section>


<script>
  $(document).ready(function(){
    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings){
      return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
    };
    var php = "<?php if(!$this->fungsi->user_login()->level  == 4 || $this->fungsi->user_login()->level == 3) { ?>";
    var php2 ="<?php }?>";
    var t = $("#mytable").dataTable({


        initComplete: function(){
          var api = this.api();


          $("#mytable_filter input")
            .off('.DT')
            .on('input.DT', function() {
                api.search(this.value).draw();
            });
        },
          oLanguage: {
            sProcessing: "Loading. . . ."
          },

          rowReorder: {selector: 'td:nth-child(2)'},
          responsive: true,
          processing: true,
          serverside: true,
          ajax: {"url":"Item/json","type": "POST"},

            columns:[
              {"data": "id_item"},
              {"data": "barcode"},
              {"data": "name"},
              {"data": "name_jenis"},
              {"data": "name_merk"},
              {"data": "hpp",render: $.fn.dataTable.render.number(',', '.', '')},
              {"data": "fob",render: $.fn.dataTable.render.number(',', '.', '')},
              {"data": "name_koleksi"},
              {"data": "stock"},
              {"data": "view"}
            ],
            columnDefs: [
               {
                   render: function (data, type, full, meta) {
                       return "<div style='white-space:normal'>" + data + "</div>";
                   },
                   targets: 2
               }
            ],
            order: [[0, 'asc']],
            rowCallback: function(row, data, iDisplayIndex){
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              var index = page * length + (iDisplayIndex + 1);
              $('td:eq(0)', row).html(index);
          }
    });
    $('#mytable').on('click','.edit_record',function(){
      var kode=$(this).data('kode');
      var barcode=$(this).data('barcode');
      var nama=$(this).data('name');
      var jenis=$(this).data('jenis');
      var merk=$(this).data('merk');
      var hpp=$(this).data('hpp');
      var fob=$(this).data('fob');
      var koleksi=$(this).data('koleksi');
      var stock=$(this).data('stock');
      $('#ModalUpdate').modal('show');
        $('[name="kode"]').val(kode);
        $('[name="barcode"]').val(barcode);
        $('[name="name"]').val(nama);
        $('[name="jenis"]').val(jenis);
        $('[name="merk"]').val(merk);
        $('[name="hpp"]').val(hpp);
        $('[name="fob"]').val(fob);
        $('[name="koleksi"]').val(koleksi);
        $('[name="stock"]').val(stock);

      });

  });
</script>
<script>
  $(document).on('click','#detail', function () {
    $('#item').text($(this).data('item'));
    $('#modal-history').modal('hide');
    var dt = new Date();
    $.getJSON('<?=site_url('Report/history_product_sum/')?>'+$(this).data('item'), function (data) {
      $.each(data, function (key, val) {
        sumqty = val.tq
          })
        $('#sumqty').html(sumqty)
     })
    var product = '<div class="scroll"><table class="table no-margin"><tr><th>No Invoice</th><th>Date</th><th>Qty</th></tr>'
    $.getJSON('<?=site_url('Report/history_product/')?>'+$(this).data('item'), function (data) {
      $.each(data, function (key, val) {
          product += '<tr><td>'+val.invoice+'</td><td>'+val.date+'</td><td>'+val.t+'</td>'
        })
        product += '</table></div>'
        $('#product').html(product)
     })
  })

</script>
