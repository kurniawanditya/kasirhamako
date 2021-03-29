<section class="content-header">
  <h1>Merk
    <small>Merk Produk</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">merk</li>
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
      <h3 class="box-title">Data merk</h3>
      <div class="pull-right">
        <?php $a = $this->fungsi->user_login()->level;
         if($a == 1 || $a == 3){ ?>
        <a href="<?=site_url('merk/add')?>" class="btn btn-success">
          <i class="fa fa-user-plus"></i> Tambah Data</a>
         <?php } ?>
      </div>
    </div>
    <div class="box-body table-resposive">
      <table class="table table-bordered table-striped" id="table1">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $no = 1;
            foreach ($row->result() as $key =>$data) {?>
              <tr>
                <td width:"5%"><?=$no?></td>
                <td><?=$data->name_merk?></td>
                <td class="text-center" width="160px">
                  <a href="<?=site_url('merk/update/'.$data->id_merk)?>" class="btn btn-success">
                    <i class="fa fa-pencil"></i> 
                  </a>
                  <?php if($a == 1){ ?>
                  <a href="<?=site_url('merk/delete/'.$data->id_merk)?>"
                    onclick="return confirm('Yakin Hapus Data?')" class="btn btn-success">
                    <i class="fa fa-trash"></i> 
                  </a>
                  <?php } ?>
                </td>
              </tr>
          <?php $no++;
        }?>
        </tbody>

      </table>
    </div>
  </div>
</section>
