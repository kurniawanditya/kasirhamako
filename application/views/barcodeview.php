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
      <div class="pull-right"></div>
    </div>
    <div class="box-body">
        <div class="row">
            
            <?php
                foreach($row->result() as $r){?>
                <div class="col-md-2" style="border:0.1em solid #000">
               <?php $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                    echo $r->name."<br>";
                    echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($r->barcode, $generator::TYPE_CODE_128)) . '">';
                    echo "<br>".$r->barcode." - ".indo_currency($r->fob);
                ?>
                </div>
                <?php } ?>
            
        </div>
    </div>
  </div>
</section>