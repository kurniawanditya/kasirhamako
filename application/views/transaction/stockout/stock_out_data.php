<section class="content-header">
  <h1>Stock out
    <small>Stock out Produk</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">Stock out</li>
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
      <h3 class="box-title">Data Stock out</h3>
      <div class="pull-right">
        <a href="<?=site_url('Stockout/add')?>" class="btn btn-primary btn-flat">
          <i class="fa fa-user-plus"></i> Create</a>
      </div>
    </div>
    <div class="box-body table-resposive">
      <table class="table table-bordered table-striped" id="table1">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Date Delivery</th>
            <th>Merk</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Ongkir</th>
            <th>Jobref</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $no = 1;
            foreach ($row->result() as $key =>$data) {?>
              <tr>
                <td width:"5%"><?=$no?></td>
                <td><?=$data->date?></td>
                <td><?=$data->date_delivery?></td>
                <td><?=$data->name_merk?></td>
                <td><?=$data->name_customer?></td>
                <td><?=$data->total?></td>
                <td><?=$data->ongkir?></td>
                <td><?=$data->nama_jobref?></td>
                <td class="text-center" width="260px">
                  <a href="<?=site_url('Stock out/update/'.$data->id_stockout)?>" class="btn btn-success btn-xs">
                    <i class="fa fa-eye"></i> Detail
                  </a>
                  <a href="<?=site_url('Stock out/update/'.$data->id_stockout)?>" class="btn btn-primary btn-xs">
                    <i class="fa fa-pencil"></i> Update
                  </a>
                  <a href="<?=site_url('Stock out/delete/'.$data->id_stockout)?>"
                    onclick="return confirm('Yakin Hapus Data?')" class="btn btn-danger btn-xs">
                    <i class="fa fa-trash"></i> Delete
                  </a>
                </td>
              </tr>
          <?php $no++;
        }?>
        </tbody>

      </table>
    </div>
  </div>
</section>
