<section class="content-header">
  <h1>Import 
    <small>Import Material</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">Import Material</li>
    
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
      <h3 class="box-title">Unggah File Excel</h3>
    </div>
    <div class="box-body table-resposive">
      <?php echo $this->session->flashdata('notif') ?>
      <form method="POST" action="<?=site_url('material/prosesimport')?>" enctype="multipart/form-data">
        <div class="form-group">
          <input type="file" name="userfile" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">UPLOAD</button>
      </form>
    </div>
  </div>
</section>