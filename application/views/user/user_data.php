<section class="content-header">
  <h1>Users
    <small>Pengguna</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href=""></i class="fa fa-dashboard"></i></a></li>
    <li class="active">Users</li>
  </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Users</h3>
      <div class="pull-right">
        <a href="<?=site_url('User/add')?>" class="btn btn-primary btn-flat">
          <i class="fa fa-user-plus"></i> Create</a>
      </div>
    </div>
    <div class="box-body table-resposive">
      <table class="table table-bordered table-striped" id="table1">
        <thead>
          <tr>
            <th>#</th>
            <th>Username</th>
            <th>Name</th>
            <th>Address</th>
            <th>Level</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $no = 1;
            foreach ($user->result() as $key =>$data) {?>
              <tr>
                <td><?=$no?></td>
                <td><?=$data->username?></td>
                <td><?=$data->name?></td>
                <td><?=$data->address?></td>
                <td><?=$data->level == 1 ? 'Superadmin' : ( $data->level == 2 ? 'Kasir' : ( $data->level == 3 ? 'Admin' : 'Stokist') );?></td>
                <td class="text-center" width="160px">
                  <form action="<?=site_url('User/delete')?>" method="post">
                    <a href="<?=site_url('User/update/'.$data->id_user)?>" class="btn btn-primary btn-xs">
                      <i class="fa fa-pencil"></i> Update
                    </a>
                    <input type="hidden" value="<?=$data->id_user?>" name="id_user">
                    <button onclick="return confirm('apakah anda yakin?')" class="btn btn-danger btn-xs">
                      <i class="fa fa-trash"></i> Delete</a>
                  </form>
                </td>
              </tr>
          <?php $no++;
        }?>
        </tbody>

      </table>
    </div>
  </div>
</section>
