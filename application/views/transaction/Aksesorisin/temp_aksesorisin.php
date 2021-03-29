<?php
    $no = 1;
    if($temp->num_rows() > 0){
        foreach ($temp->result() as $c => $data) {?>
            <tr>
                <td><?=$no?>.</td>
                <td><?=$data->barcode?></td>
                <td><?=$data->item_name?></td>
                <td class="text-center"><?=$data->qty?></td>
                <td class="text-center" width="160px">
                    <button id="update_temp" data-toggle="modal" data-target="#modal-item-edit"
                        data-tempid="<?=$data->id_temp_acc?>"
                        data-barcode="<?=$data->barcode?>"
                        data-name="<?=$data->name?>"
                        data-id_supplier="<?=$data->qty?>"
                        data-qty="<?=$data->qty?>"                      
                        class="btn btn-xs btn-primary">
                            <i class="fa fa-pencil"></i> Update
                    </button>
                    <button id="del_temp" data-tempid="<?=$data->id_temp_acc?>" class="btn btn-xs btn-danger">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                </td>
            </tr>
        <?php
        $no++;
         }
    }else{
        echo '<tr>
            <td colspan="8" class="text-center"> Tidak ada Item </td>
            </tr>';
    }?>