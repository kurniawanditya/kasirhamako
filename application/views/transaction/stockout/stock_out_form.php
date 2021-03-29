
<section class="content-header">
  <h1>Stockout
    <small>Stockout Produk</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">Stockout</li>
  </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title"><?=ucfirst($page)?> Stockout</h3>
      <div class="pull-right">
        <a href="<?=site_url('Stockout')?>" class="btn btn-warning btn-flat">
          <i class="fa fa-undo"></i> Back</a>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <form class="form-horizontal">
          <div class="box-body">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-1 control-label">Date</label>
              <div class="col-sm-8">
                <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-1 control-label">Password</label>

              <div class="col-sm-8">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-1 control-label">Password</label>

              <div class="col-sm-8">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-1 control-label">Password</label>

              <div class="col-sm-8">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-1 control-label">Password</label>

              <div class="col-sm-8">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-1 control-label">Password</label>

              <div class="col-sm-8">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-1 control-label">Password</label>

              <div class="col-sm-8">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-1 control-label">Password</label>

              <div class="col-sm-8">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
              </div>
            </div>

          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-default">Cancel</button>
            <button type="submit" class="btn btn-info pull-right">Sign in</button>
          </div>
          <!-- /.box-footer -->
        </form>
      </div>


      <!-- <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <form action="<?=site_url('Stockout/process')?>" method="post">
            <div class="col-md-6">
              <div class="form-group">
                <label>Date *</label>
                <input type="hidden" name="id_stockout" value="<?=$row->id_stockout;?>" class="form-control" required>
                <input type="date" name="date" value="<?=$row->date;?>" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Delivery Date *</label>
                <input type="date" name="date" value="<?=$row->date_delivery;?>" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">

                <label>Merk</label>
                <?php echo form_dropdown('id_merk',$merk,$selectedmerk,
                      ['class'=>'form-control select2 select2-hidden-accessible','required'=>'required']);?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Customer</label>
                <?php echo form_dropdown('id_merk',$merk,$selectedmerk,
                      ['class'=>'form-control','required'=>'required']);?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Jobref</label>
                <?php echo form_dropdown('id_merk',$merk,$selectedmerk,
                      ['class'=>'form-control','required'=>'required']);?>
              </div>

              <div class="form-group">
                <label>Discount</label>
                <div class="input-group">
                  <input type="number" name="disc" class="form-control">
                  <span class="input-group-addon">%</span>
                </div>
              </div>
              <div class="form-group">
                <label>Ongkos Kirim</label>
                <div class="input-group">
                  <span class="input-group-addon">Rp</span>
                  <input type="number" name="ongkir" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label>Ket</label>
                <textarea name="ket" class="form-control"></textarea>
              </div>
              <div class="form-group">
                <button type="submit" name="<?=$page?>" class="btn btn-success btn-flat">Save</button>
                <button type="reset"  class="btn btn-flat">Reset</button>
              </div>
            </div>
            <div class="col-md-6">

            </div>
          </form>


          <?php //echo validation_errors(); ?>

        </div>
      </div> -->
    </div>
  </div>
</section>
