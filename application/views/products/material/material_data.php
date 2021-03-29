<section class="content-header">
  <h1>Data Aksesoris
    <small>Data Aksesoris</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">Data Aksesoris Gudang</li>

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
      <h3 class="box-title">Data Aksesoris Gudang</h3>
      <div class="pull-right">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ModalAdd">Tambah Data
        </button>
        <!-- <a href="<?=site_url('Material/add')?>" class="btn btn-primary btn-flat">Tambah Data</a> -->
        <!-- <a href="<?=site_url('Report/export_item')?>" class="btn btn-primary btn-flat">Export Data</a> -->
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">Export Data
        </button>
        <a href="<?=site_url('Material/import')?>" class="btn btn-primary btn-flat">Import File</a>
      </div>
    </div>
    <div class="box-body table-resposive">
      <table class="table table-bordered table-striped" id="mytable">
        <thead>
          <tr>
            
            <th>#</th>
            <th>Barcode</th>
            <th>Nama</th>
            <th>Warna</th>
            <th>Jenis</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Ket</th>
            <th width="60px">Action</th>
          </tr>
        </thead>
        <tbody>

        </tbody>

      </table>
    </div>
  </div>
  <form id="add-row-form" action="<?php echo base_url().'Material/process/'?>" method="post">
      <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    <input type="text" name="kode" class="hidden align-rightform-control" readonly>
                    <input type="text" name="barcode" class="form-control" required>
                  </div>
                  <div class="form-group col-lg-12">
                    <label>Item Name </label>
                    <input type="text" name="name" class="form-control" required>
                  </div>
                  <div class="form-group col-lg-6">
                    <label>Warna</label>
                    <input type="text" name="warna" class="form-control" required>
                  </div>
                  <div class="form-group col-lg-6">
                    <label>Jenis</label>
                    <input type="text" name="jenis_acc" class="form-control" required>
                  </div>
                  <div class="form-group col-lg-6">
                    <label>Harga</label>
                    <input type="text" name="harga" class="form-control" required>
                  </div>
                  <div class="form-group col-lg-6">
                    <label>stok</label>
                    <input type="text" name="stok" class="form-control" required>
                  </div>
                  <div class="form-group col-lg-6">
                    <label>Ket</label>
                    <input type="text" name="ket" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                  <button type="submit" id="add-row" name="add" class="btn btn-success btn-flat">Update</button>
              </div>
            </div>
        </div>
      </div>
  </form>

  <form id="add-row-form" action="<?php echo base_url().'Material/update/'?>" method="post">
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
                  <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="form-group col-lg-6">
                  <label>Warna</label>
                  <input type="text" name="warna" class="form-control" required>
                </div>
                <div class="form-group col-lg-6">
                  <label>Jenis</label>
                  <input type="text" name="jenis_acc" class="form-control" required>
                </div>
                <div class="form-group col-lg-6">
                  <label>Harga</label>
                  <input type="text" name="harga" class="form-control" required>
                </div>
                <div class="form-group col-lg-6">
                  <label>stok</label>
                  <input type="text" name="stok" class="form-control" required>
                </div>
                <div class="form-group col-lg-6">
                  <label>Ket</label>
                  <input type="text" name="ket" class="form-control" required>
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
          ajax: {"url":"Material/json","type": "POST"},

            columns:[
              {"data": "id_item_acc"},
              {"data": "barcode"},
              {"data": "name"},
              {"data": "warna"},
              {"data": "jenis_acc"},
              {"data": "harga",render: $.fn.dataTable.render.number(',', '.', 0,'Rp ')},
              {"data": "stok"},
              {"data": "ket"},
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
      var warna=$(this).data('warna');
      var jenis_acc=$(this).data('jenis_acc');
      var harga=$(this).data('harga');
      var stok=$(this).data('stok');
      var ket=$(this).data('ket');
      $('#ModalUpdate').modal('show');
        $('[name="kode"]').val(kode);
        $('[name="barcode"]').val(barcode);
        $('[name="nama"]').val(nama);
        $('[name="warna"]').val(warna);
        $('[name="jenis_acc"]').val(jenis_acc);
        $('[name="harga"]').val(harga);
        $('[name="stok"]').val(stok);
        $('[name="ket"]').val(ket);
      });
  });
</script>
