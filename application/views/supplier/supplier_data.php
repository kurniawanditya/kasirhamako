<section class="content-header">
  <h1>Suppiler
    <small>Pemasok Barang</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">Suppiler</li>
  </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Suppiler</h3>
      <div class="pull-right">
        <?php
        $a = $this->fungsi->user_login()->level;
        if($a == 1 || $a == 3) { ?>
         <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
          <i class="fa fa-plus"></i> Tambah Data
        </button>
        <?php  } ?>
      </div>
    </div>
    <div class="box-body table-resposive">
      <table class="table table-bordered table-striped display responsive" id="table1" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $no = 1;
            foreach ($row->result() as $key =>$data) {?>
              <tr>
                <td><?=$no?></td>
                <td><?=$data->name_supplier?></td>
                <td><?=$data->address?></td>
                <td><?=$data->phone?></td>
                <td class="text-center" width="160px">
                  <a href="#" class="btn btn-success btn-edit"
                    data-id="<?= $data->id_supplier;?>"
                    data-name="<?= $data->name_supplier;?>"
                    data-address="<?= $data->address;?>"
                    data-phone="<?= $data->phone;?>"><i class="fa fa-pencil"></i></a>
                <?php if($a == 1) { ?>
                  <a href="<?=site_url('Supplier/delete/'.$data->id_supplier)?>"
                    onclick="return confirm('Yakin Hapus Data?')" class="btn btn-danger">
                    <i class="fa fa-trash"></i>
                  </a>
                <?php  } ?>

                </td>
              </tr>
          <?php $no++;
        }?>
        </tbody>

      </table>
    </div>
  </div>
</section>
<!-- new -->

<form action="<?=site_url('supplier/process')?>" method="post">
<div class="modal fade" id="modal-default" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Tambah Data Supplier</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <?php //echo validation_errors(); ?>
              <div class="form-group">
                <label>Supplier Name *</label>
                <input type="hidden" name="id_supplier" class="form-control" required>
                <input type="text" name="name_supplier" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Address *</label>
                <textarea name="address" class="form-control" required></textarea>
              </div>
              <div class="form-group">
                <label>Phone *</label>
                <input type="text" name="phone" class="form-control" required>
              </div>

              <!-- <div class="form-group">
                <button type="submit" class="btn btn-success btn-flat">Save</button>
                <button type="reset"  class="btn btn-flat">Reset</button>
              </div> -->
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" name="add"  class="btn btn-primary">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
</form>

<!-- update -->

<form action="<?=site_url('supplier/process')?>" method="post">
<div class="modal fade" id="editModal" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Edit Data Supplier</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <?php //echo validation_errors(); ?>
              <div class="form-group">
                <label>Supplier Name *</label>
                <input type="hidden" name="id_supplier" value="<?=$row1->id_supplier;?>" class="form-control id" required>
                <input type="text" name="name_supplier" value="<?=$row1->name_supplier;?>" class="form-control name" required>
              </div>
              <div class="form-group">
                <label>Address *</label>
                <textarea name="address" class="form-control address" required><?=$row1->address;?></textarea>
              </div>
              <div class="form-group">
                <label>Phone *</label>
                <input type="text" name="phone" value="<?=$row1->phone;?>" class="form-control phone" required>
              </div>

              <!-- <div class="form-group">
                <button type="submit" class="btn btn-success btn-flat">Save</button>
                <button type="reset"  class="btn btn-flat">Reset</button>
              </div> -->
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" name="update"  class="btn btn-primary">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
</form>

<script>
$(document).ready( function () {
    $('#table1').DataTable( {
    	responsive: true
    } );
} );
    $(document).ready(function(){
        // get Edit Product
        $('.btn-edit').on('click',function(){
            // get data from button edit
            const id = $(this).data('id');
            const name = $(this).data('name');
            const address = $(this).data('address');
            const phone = $(this).data('phone');
            // Set data to Form Edit
            $('.id').val(id);
            $('.name').val(name);
            $('.address').val(address);
            $('.phone').val(phone);
            // Call Modal Edit
            $('#editModal').modal('show');
        });

        // get Delete Product
        $('.btn-delete').on('click',function(){
            // get data from button edit
            const id = $(this).data('id');
            // Set data to Form Edit
            $('.productID').val(id);
            // Call Modal Edit
            $('#deleteModal').modal('show');
        });

    });
</script>
