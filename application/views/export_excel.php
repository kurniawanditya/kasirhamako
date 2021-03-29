<section class="content-header">
  <h1>Export Excel
  </h1>
</section>

<section class="content">
  <div class="box">
    <div class="box-header">
      <div class="pull-right">
        <div class="btn-group">
          <button type="button" class="btn btn-success">Export</button>
          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <li>
            <?php foreach ($detail as $key => $value) {} ?>
              <a href="<?=site_url('Report/export/').$value->id_sales;?>" > <i class="fa fa-print"></i> INVOICE</a>
              <a href="<?=site_url('Report/proforma/').$value->id_sales;?>" > <i class="fa fa-print"></i>PROFORMA INVOICE</a>
              <a href="<?=site_url('Report/del_order/').$value->id_sales;?>" > <i class="fa fa-print"></i> DELIVERY ORDER</a>

            </li>
          </ul>
        </div>

        <a href="<?=site_url('Report/Rsales')?>" class="btn btn-warning btn-flat">
        <i class="fa fa-undo"></i> Back</a>
      </div>
      <div class="row" style="font-family: Arial;">
          <div class="col-md-12">
              <div class="col-md-6">
                  <img src="<?=base_url();?>/assets/dist/img/hai.jpg" height="150px">
              </div>
              <div class="col-md-6">
                  <table class="no-border" width="100%">
                      <tr><td class="text-right"><h4>PT. HAMAKO APPAREL INDONESIA</h4></td></tr>
                      <tr><td class="text-right">www.hamakoecolife.com</td></tr>
                      <tr><td class="text-right">www.babybudshop.com</td></tr>
                      <tr><td class="text-right">+62811 242 625 6</td></tr>
                      <tr><td class="text-right"><b><h1>INVOICE</h1></b></td></tr>
                  </table>

              </div>
          </div>
          <div class="col-md-12">
              <div class="col-md-6">
                <table class="no-border" width="100%">
                    <tr><td class="text-left"><h4><b>RECIPIENT</b></h4></td></tr>
                    <?php foreach ($sales as $key => $value) { ?>
                    <tr><td class="text-left"><?php echo $value->customername; ?></td></tr>
                    <tr><td class="text-left"><?php echo $value->alamat; ?> </td></tr>
                    <tr><td class="text-left"><?php echo $value->tlp; ?></td></tr>
                    <?php } ?>
                </table>
              </div>
              <div class="col-md-6">
                <table class="no-border" width="100%">
                    <tr><td class="text-right"><h4><b>Invoice Number</b></h4></td></tr>
                    <?php foreach ($sales as $key => $value) {?>
                    <tr><td class="text-right"><?php echo $value->invoice; ?></td></tr>
                    <?php } ?>
                </table>
              </div>
          </div>
      </div>
    </div>
    <div class="box-body table-resposive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>NO</th>
            <th>ITEM</th>
            <th>QTY</th>
            <th>PRICE</th>
            <th>AMOUNT</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $sum = 0;
          $id = 1;
          foreach ($detail as $key => $value) {?>
            <tr>
              <td><?php echo$id;?></td>
              <td><?php echo$value->name;?></td>
              <td class="text-right"><?php echo$value->qty;?></td>
              <td class="text-right"><?php echo indo_currency($value->price);?></td>
              <td class="text-right"><?php echo indo_currency($value->total);?></td>
            </tr>
          <?php
            $sum = $sum + $value->qty;
          $id++;}?>
          <tr><td class="text-right" colspan="3"><?php echo $sum;?></td></tr>
          <?php foreach ($sales as $key => $value ){?>
          <tr><td class="text-right" colspan="4"><b>Subtotal</b></td><td class="text-right"><?php echo indo_currency($value->total_price);?></td></tr>
          <tr><td class="text-right" colspan="4"><b>Discount</b></td><td class="text-right"><?php echo indo_currency($value->discount);?></td></tr>
          <tr><td class="text-right" colspan="4"><b>Ongkos Kirim</b></td><td class="text-right"><?php echo indo_currency($value->ongkir);?></td></tr>
          <tr><td class="text-right" colspan="4"><b>Biaya Lainnya</b></td><td class="text-right"><?php echo indo_currency($value->biaya_lain);?></td></tr>
          <tr><td class="text-right" colspan="4"><b>TOTAL</b></td><td class="text-right"><?php echo indo_currency($value->final_price);?></td></tr>
          <?php } ?>
        </tbody>

      </table>
      <!-- <div class="row" style="font-family: Arial;">
          <div class="col-md-12">
              <div class="col-md-6">
                <table class="no-border" width="100%">
                    <tr><td class="text-left"><h4><b>PAYTO</b></h4></td></tr>
                    <tr><td class="text-left">MARIA MONICA</td></tr>
                    <tr><td class="text-left">BCA / 3423307460 </td></tr>.
                    <tr><td class="text-left"><h4><b>NOTES</b></h4></td></tr>
                    <tr><td class="text-left">Payment should be paid in full no later than 14 calendar days after receiving this debit note.</td></tr>
                    <tr><td class="text-left">Have a nice day and Thank you! </td></tr>
                    <tr><td class="text-left">Love, Hamako </td></tr>
                    <tr><td class="text-left">Hamako Apparel Indonesia @2018  | hamako.ecobabwear@gmail.com </td></tr>
                </table>
              </div>
              <div class="col-md-6">
                <table class="no-border" width="100%">

                </table>
              </div>
          </div>
      </div> -->
    </div>
  </div>
</section>
