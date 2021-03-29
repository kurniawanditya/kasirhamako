<div class="row">
        <div class="col-md-8 offset-2">
            <?php echo $this->session->flashdata('notif') ?>
            <form method="POST" action="<?=site_url('item/prosesimport')?>" enctype="multipart/form-data">
              <div class="form-group">
                <label for="exampleInputEmail1">UNGGAH FILE EXCEL</label>
                <input type="file" name="userfile" class="form-control">
              </div>

              <button type="submit" class="btn btn-success">UPLOAD</button>
            </form>
        </div>
    </div>
