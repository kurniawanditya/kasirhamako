<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class M_accout extends CI_Model
{

  public function get_accout($id= null)
  {
    $this->db->select('*');
    $this->db->from('t_accout a');
    $this->db->join('t_supplier b','a.supplier = b.id_supplier','left');
    $this->db->join('t_user c','a.id_user = c.id_user');
    if($id != null){
      $this->db->where('id_accout', $id);
    }    
    $this->db->order_by('a.date','desc');
    $query = $this->db->get();
    return $query;
  }

  public function get_tempout($params=null){
    $this->db->select('*, b.name as item_name');
    $this->db->from('t_temp_accout a');
    $this->db->join('t_item_acc b', 'b.id_item_acc = a.id_item_acc');
    $this->db->join('t_supplier c', 'c.id_supplier = a.id_supplier');
    if($params != null){
      $this->db->where($params);
    }
    $this->db->where('id_user', $this->session->userdata('id_user'));
    $query = $this->db->get();
    return $query;

  }

  function update_tempout_qty($post){
    $sql = "UPDATE t_temp_accout SET qty = qty + '$post[qty]'
    WHERE id_item_acc = '$post[id_item_acc]'";

    $this->db->query($sql);
  }
    

  public function add_tempout($post){
    $query = $this->db->query("SELECT MAX(id_temp_accout) AS temp_no from t_temp_accout");
    // echo json_encode($query);
    if($query->num_rows() > 0){
      $row = $query->row();
      $temp_no = ((int)$row->temp_no)+1;
    }else{
      $temp_no = "1";
    }
    $params = array(
      'id_temp_accout' => $temp_no,
      'id_item_acc' => $post['id_item_acc'],
      'qty'     => $post['qty'],
      'id_user' =>$this->session->userdata('id_user'),
      'id_supplier' =>$post['supplier']
      
    );
    $this->db->insert('t_temp_accout',$params);
  }
  public function del_temp($params = null)
  {
      $this->db->where($params);
      $this->db->delete('t_temp_accout');
  }


  public function edit_temp($post){
    $params = array(
      'qty' => $post['qty']
    );
    $this->db->where('id_temp_accout', $post['id']);
    $this->db->update('t_temp_accout', $params);

  }
  public function add_accout($post){
    $params = array(
      'date'        =>$post['date'],
      'surat_jalan' =>$post['sj'],      
      'supplier'    =>$post['supplier'],
      // 'ref'         =>$post['ref'],
      'id_user'     => $this->session->userdata('id_user')
    );
    $this->db->insert('t_accout',$params);
    return $this->db->insert_id();
  }

  function add_accout_detail($params){
    $this->db->insert_batch('t_detail_accout', $params);

  }

  public function del_accout($id)
  {
    $this->db->where('id_accout', $id);
    $this->db->delete('t_accout');
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

  public function get_acc_detail($id_bm= null)
  {
    $this->db->select('b.barcode,b.name,a.qty');
    $this->db->from('t_detail_accout a');
    $this->db->join('t_item_acc b','a.id_item_acc = b.id_item_acc');
    if($id_bm != null){
      $this->db->where('a.id_accout', $id_bm);
    }
    $query = $this->db->get();
    return $query;
  }
  public function qtydetail($id_bm= null)
  {
    $this->db->select_sum('a.qty');
    $this->db->from('t_detail_accout a');
    $this->db->join('t_item_acc b','a.id_item_acc = b.id_item_acc');
    if($id_bm != null){
      $this->db->where('a.id_accout', $id_bm);
    }
    $this->db->group_by('a.id_accout');
    $query = $this->db->get();
    return $query;
  }
}

?>
