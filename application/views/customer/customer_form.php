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
      <h3 class="box-title"><?=ucfirst($page)?>Customer</h3>
      <div class="pull-right">
        <a href="<?=site_url('customer')?>" class="btn btn-warning btn-flat">
          <i class="fa fa-undo"></i> Back</a>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <?php //echo validation_errors(); ?>
          <form action="<?=site_url('customer/process')?>" method="post">
            <div class="form-group">
              <label>Customer Name *</label>
              <input type="hidden" name="id_customer" value="<?=$row->id_customer;?>" class="form-control" required>
              <input type="text" name="name_customer" value="<?=$row->name_customer;?>" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Address *</label>
              <textarea name="address" class="form-control" required><?=$row->address;?></textarea>
            </div>
            <div class="form-group">
              <label>Provinsi *</label>
              <select name="prov" id="prov" class="form-select form-control" aria-label="Default select example">
                <?php foreach($prov->result() as $row):?>
                    <option value="<?php echo $row->id_prov;?>"><?php echo $row->nama_prov;?></option>
                <?php endforeach;?>
              </select>
            </div>

            <div class="form-group">
              <label>Kabupaten *</label>
              <select name="kab" id="kab" class="form-select form-control" aria-label="Default select example">
                  <option></option>
              </select>
            </div>

            <div class="form-group">
              <label>Kecamatan *</label>
              <select name="kec" id="kec" class="form-select form-control" aria-label="Default select example">
                <option></option>
              </select>
            </div>

            <!-- <div class="form-group">
              <label>Phone *</label>
              <input type="text" name="phone" value="<?=$row->phone;?>" class="form-control" required>
            </div> -->

            <div class="form-group">
              <button type="submit" name="<?=$page?>" class="btn btn-success btn-flat">Save</button>
              <button type="reset"  class="btn btn-flat">Reset</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $('#prov').change(function(){
            var id=$(this).val();
            $.ajax({
                url : "<?php echo base_url();?>customer/get_kab",
                method : "POST",
                data : {id: id},
                async : false,
                dataType : 'json',
                success: function(data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option>'+data[i].nama_kab+'</option>';
                    }
                    $('#kab').html(html);

                }
            });
        });

        $('#kab').change(function(){
            var id=$(this).val();
            $.ajax({
                url : "<?php echo base_url();?>customer/get_kec",
                method : "POST",
                data : {id: id},
                async : false,
                dataType : 'json',
                success: function(data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option>'+data[i].nama_kec+'</option>';
                    }
                    $('#kec').html(html);

                }
            });
        });
    });
</script>
