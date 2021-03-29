<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <!-- <small>Version 2.0</small> -->
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
<?php if($this->session->has_userdata('success')) { ?>
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="icon fa fa-check"></i> <?=$this->session->flashdata('success');?>
  </div>
  <?php } ?>

 <?php if($this->fungsi->user_login()->level  == 4) { 

  }else{?>
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?=$this->fungsi->count_item()?> /  
            <?php
              foreach ($stock->row() as $key => $value) {
                echo $value;
              }
            ?>
            <sup style="font-size: 20px">pcs
          </h3>

          <p>Total Item / pcs</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="<?=base_url();?>Item" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?=$this->fungsi->count_customer()?></sup></h3>

          <p>Customer</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="<?=base_url();?>Customer" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?=$this->fungsi->count_sales()?></sup></h3>  
          <p>Total Sales</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="<?=base_url();?>Report/Rsales" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?php
           foreach ($totalsales->row() as $key => $sales) {
           echo indo_currency($sales);
              }
             
          ?><sup style="font-size: 20px"> /today</sup><br>
           <?php
           foreach ($totalsalesmo->row() as $key => $sales) {
           echo indo_currency($sales);
              }
            
          ?>
          <sup style="font-size: 20px"> /month</sup>
              
          </h3>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="<?=base_url();?>Report/Rsales" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>
  <?php  }  ?>
<hr>
  <div class="row">   
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow" style="font-size:20pt">AW20</span>          
        <div class="info-box-content">
          <span class="info-box-number">PENJUALAN</span>
          <span class="info-box-number">TOTAL : <span id="tot"></span></span>
          <span class="info-box-number">DAILY : <span id="totd"></span></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Best Seller</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <span id="product"></span>
        </div>
        <!-- /.box-body -->
      </div>

      <!-- /.info-box -->
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red" style="font-size:15pt">PRE SS21</span>          
        <div class="info-box-content">
          <span class="info-box-number">PENJUALAN</span>
          <span class="info-box-number">TOTAL : <span id="tot2"></span></span>
          <span class="info-box-number">DAILY : <span id="totd2"></span></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Best Seller</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <span id="product2"></span>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.info-box -->
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-blue" style="font-size:20pt">SS21</span>
        <div class="info-box-content">
          <span class="info-box-number">PENJUALAN</span>
          <span class="info-box-number">TOTAL : <span id="tot3"></span></span>
          <span class="info-box-number">DAILY : <span id="totd3"></span></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Best Seller</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <span id="product3"></span>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.info-box -->
    </div>
  </div>

  <hr>
  <div class="row">
    <div class="col-md-3">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Best Seller Hamako</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-condensed">
            <tbody>
            <?php $no = 1;
            foreach ($item->result() as $key => $value) {?>
            <tr>
              <td><?=$no;?></td>
              <td><?=$value->name;?></td>
              <td><span class="badge bg-green"><?=$value->total;?></span></td>
            </tr>
            <?php $no++; }?>
          </tbody></table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-3">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Most Stock Hamako</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-condensed">
            <tbody>
            <?php $no = 1;
            foreach ($stockplus->result() as $key => $value) {?>
            <tr>
              <td><?=$no;?></td>
              <td><?=$value->name;?></td>
              <td><span class="badge bg-green"><?=$value->stock;?></span></td>
            </tr>
            <?php $no++; }?>
          </tbody></table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-3">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Least Stock Hamako</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-condensed">
            <tbody>
            <?php $no = 1;
            foreach ($stockminus->result() as $key => $value) {?>
            <tr>
              <td><?=$no;?></td>
              <td><?=$value->name;?></td>
              <td><span class="badge bg-green"><?=$value->stock;?></span></td>
            </tr>
            <?php $no++; }?>
          </tbody></table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-3">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Best Style Hamako</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-condensed">
            <tbody>
            <?php $no = 1;
            foreach ($data->result() as $key => $value) {?>
            <tr>
              <td><?=$no;?></td>
              <td><?=$value->name_jenis;?></td>
              <td><span class="badge bg-green"><?=$value->total;?></span></td>
            </tr>
            <?php $no++; }?>
          </tbody></table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>

</section>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script type='text/javascript'>
  $.getJSON('<?=site_url('Dashboard/get_qtyitem/14')?>', function (data) { 
  $.each(data, function (key, val) {
    var a = val.tot
    if(a == null){a=0}
    totqty = a+' pcs'
  })
    $('#tot').html(totqty)
  })
  $.getJSON('<?=site_url('Dashboard/get_qtyitemd/14')?>', function (data) { 
  $.each(data, function (key, val) {
    var a = val.tot
    if(a == null){a=0}
    totqty = a+' pcs'
  })
    $('#totd').html(totqty)
  })

  $.getJSON('<?=site_url('Dashboard/get_qtyitem/17')?>', function (data) { 
  $.each(data, function (key, val) {
    var a = val.tot
    if(a == null){a=0}
    totqty = a+' pcs'
  })
    $('#tot2').html(totqty)
  })
  $.getJSON('<?=site_url('Dashboard/get_qtyitemd/17')?>', function (data) { 
  $.each(data, function (key, val) {
    var a = val.tot
    if(a == null){a=0}
    totqty = a+' pcs'
  })
    $('#totd2').html(totqty)
  })

  $.getJSON('<?=site_url('Dashboard/get_qtyitem/18')?>', function (data) { 
  $.each(data, function (key, val) {
    var a = val.tot
    if(a == null){a=0}
    totqty = a+' pcs'
  })
    $('#tot3').html(totqty)
  })
  $.getJSON('<?=site_url('Dashboard/get_qtyitemd/18')?>', function (data) { 
  $.each(data, function (key, val) {
    var a = val.tot
    if(a == null){a=0}
    totqty = a+' pcs'
  })
    $('#totd3').html(totqty)
  })


    var product = '<table class=table table-condensed><tbody><tr><th>Item</th><th>Qty</th></tr>'
    $.getJSON('<?=site_url('Dashboard/get_seller/14')?>', function (data) { 
      $.each(data, function (key, val) {
          product += '<tr><td>'+val.name+'</td><td>'+val.tq+'</td><td>'
        })
        product += '</table>'
        $('#product').html(product)
     })

    var product2 = '<table class=table table-condensed><tbody><tr><th>Item</th><th>Qty</th></tr>'
    $.getJSON('<?=site_url('Dashboard/get_seller/17')?>', function (data) { 
      $.each(data, function (key, val) {
          product2 += '<tr><td>'+val.name+'</td><td>'+val.tq+'</td><td>'
        })
        product2 += '</table>'
        $('#product2').html(product2)
     })

    var product3 = '<table class=table table-condensed><tbody><tr><th>Item</th><th>Qty</th></tr>'
    $.getJSON('<?=site_url('Dashboard/get_seller/18')?>', function (data) { 
      $.each(data, function (key, val) {
          product3 += '<tr><td>'+val.name+'</td><td>'+val.tq+'</td><td>'
        })
        product3 += '</table>'
        $('#product3').html(product3)
     })


</script>