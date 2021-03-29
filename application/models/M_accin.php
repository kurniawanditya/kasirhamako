<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class M_accin extends CI_Model
{

  public function get_accin($id= null)
  {
    $this->db->select('*');
    $this->db->from('t_accin a');
    $this->db->join('t_supplier b','a.supplier = b.id_supplier','left');
    $this->db->join('t_user c','a.id_user = c.id_user');
    if($id != null){
      $this->db->where('id_accin', $id);
    }
    $this->db->order_by('a.date','desc');
    $query = $this->db->get();
    return $query;
  }


  public function get_accin_detail($id= null)
  {
    $this->db->select('b.barcode,b.name,a.qty');
    $this->db->from('t_detail_accin a');
    $this->db->join('t_item_acc b','a.id_item_acc = b.id_item_acc');
    if($id != null){
      $this->db->where('a.id_accin', $id);
    }
    $query = $this->db->get();
    return $query;
  }

  
  public function get_accinbydate()
  { 
    $tgl_awal = $this->input->post('tgl_awal');
    $tgl_akhir = $this->input->post('tgl_akhir');
    $this->db->select('barcode, c.name,Count(b.qty) total');
    $this->db->from('t_accin a');
    $this->db->join('t_detail_accin b','a.id_accin=b.id_accin');
    $this->db->join('t_item_acc c',' b.id_item_acc=c.id_item_acc');
    
    if($tgl_awal != null && $tgl_akhir != null){
      $this->db->where('date >=',$tgl_awal);
      $this->db->where('date <=',$tgl_akhir);
    }
   
    $this->db->group_by('barcode');
    $query = $this->db->get();
    return $query;
  }

  public function get_tempin($params=null){
    $this->db->select('*, b.name as item_name');
    $this->db->from('t_temp_accin a');
    $this->db->join('t_item_acc b', 'b.id_item_acc = a.id_item_acc');
    $this->db->join('t_supplier c', 'c.id_supplier = a.id_supplier');
    if($params != null){
      $this->db->where($params);
    }
    $this->db->where('id_user', $this->session->userdata('id_user'));
    $query = $this->db->get();
    return $query;

  }

  function update_tempin_qty($post){
    $sql = "UPDATE t_temp_accin SET qty = qty + '$post[qty]'
    WHERE id_item_acc = '$post[id_item_acc]'";

    $this->db->query($sql);
  }


  public function add_tempin($post){
    $query = $this->db->query("SELECT MAX(id_temp_acc) AS temp_no from t_temp_accin");
    // echo json_encode($query);
    if($query->num_rows() > 0){
      $row = $query->row();
      $temp_no = ((int)$row->temp_no)+1;
    }else{
      $temp_no = "1";
    }
    $params = array(
      'id_temp_acc' => $temp_no,
      'id_item_acc' => $post['id_item_acc'],
      'qty'     => $post['qty'],
      'id_user' =>$this->session->userdata('id_user'),
      'id_supplier' =>$post['supplier']

    );
    $this->db->insert('t_temp_accin',$params);
  }
  public function del_tempin($params = null)
  {
      $this->db->where($params);
      $this->db->delete('t_temp_accin');
  }


  public function edit_temp($post){
    $params = array(
      'qty' => $post['qty']
    );
    $this->db->where('id_temp_acc', $post['id']);
    $this->db->update('t_temp_accin', $params);

  }
  public function add_accin($post){
    $params = array(
      'date'        =>$post['date'],
      'surat_jalan' =>$post['sj'],
      'ref'         =>$post['ref'],
      'supplier'    =>$post['supplier'],
      'id_user'     => $this->session->userdata('id_user')
    );
    $this->db->insert('t_accin',$params);
    return $this->db->insert_id();
  }

  function add_accin_detail($params){
    $this->db->insert_batch('t_detail_accin', $params);

  }

  public function del_accin($id)
  {
    $this->db->where('id_accin', $id);
    $this->db->delete('t_accin');
  }
// //   public function get_ref($id = null){
// //     $this->db->from('t_jobref');
// //     if($id !=null) {
// //       $this->db->where('id_jobref',$id);
// //     }
// //     $query = $this->db->get();
// //     return $query;

// //   }




//   // public function get_sales($id= null)
//   // {
//   //   $this->db->select('*, b.name_customer as customername,b.address as alamat, b.phone as tlp, c.username as user_name');
//   //   $this->db->from('t_sales a');
//   //   $this->db->join('t_customer b','a.id_customer = b.id_customer','left');
//   //   $this->db->join('t_user c','a.id_user = c.id_user');
//   //   $this->db->join('t_jobref d','a.ref = d.id_jobref');
//   //   if($id != null){
//   //     $this->db->where('id_sales', $id);
//   //   }
//   //   $this->db->order_by('invoice','desc');
//   //   $query = $this->db->get();
//   //   return $query;
//   // }

  public function get_acc_detail($id= null)
  {
    $this->db->select('b.barcode,b.name,a.qty');
    $this->db->from('t_detail_accin a');
    $this->db->join('t_item_acc b','a.id_item_acc = b.id_item_acc');
    if($id != null){
      $this->db->where('a.id_accin', $id);
    }
    $query = $this->db->get();
    return $query;
  }
  public function qtydetail($id= null)
  {
    $this->db->select_sum('a.qty');
    $this->db->from('t_detail_accin a');
    $this->db->join('t_item_acc b','a.id_item_acc = b.id_item_acc');
    if($id != null){
      $this->db->where('a.id_accin', $id);
    }
    $this->db->group_by('a.id_accin');
    $query = $this->db->get();
    return $query;
  }
}

?>
