<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class M_stockin extends CI_Model
{

  public function get_temp($params=null){
    $this->db->select('*, b.name as item_name');
    $this->db->from('t_temp a');
    $this->db->join('t_item b', 'b.id_item = a.id_item');
    $this->db->join('t_supplier c', 'c.id_supplier = a.id_supplier');
    if($params != null){
      $this->db->where($params);
    }
    $this->db->where('id_user', $this->session->userdata('id_user'));
    $query = $this->db->get();
    return $query;

  }

  public function add_temp($post){
    $query = $this->db->query("SELECT MAX(id_temp) AS temp_no from t_temp");
    // echo json_encode($query);
    if($query->num_rows() > 0){
      $row = $query->row();
      $temp_no = ((int)$row->temp_no)+1;
    }else{
      $temp_no = "1";
    }
    $params = array(
      'id_temp' => $temp_no,
      'id_item' => $post['id_item'],
      'qty'     => $post['qty'],
      'id_user' =>$this->session->userdata('id_user'),
      'id_supplier' =>$post['supplier']
      
    );
    $this->db->insert('t_temp',$params);
  }

  function update_temp_qty($post){
    $sql = "UPDATE t_temp SET qty = qty + '$post[qty]'
    WHERE id_item = '$post[id_item]'";

    $this->db->query($sql);
  }

  public function del_temp($params = null)
  {
      $this->db->where($params);
      $this->db->delete('t_temp');
  }

  public function edit_temp($post){
    $params = array(
      'qty' => $post['qty']
    );
    $this->db->where('id_temp', $post['id']);
    $this->db->update('t_temp', $params);

  }
  public function add_bm($post){
    $params = array(
      'date'        =>$post['date'],
      'surat_jalan' =>$post['sj'],
      'supplier'    =>$post['supplier'],
      'no_po'       =>$post['no_po'],
      'id_user'     => $this->session->userdata('id_user')
    );
    $this->db->insert('t_bm',$params);
    return $this->db->insert_id();
  }

  function add_bm_detail($params){
    $this->db->insert_batch('t_detail_bm', $params);

  }
//   public function get_ref($id = null){
//     $this->db->from('t_jobref');
//     if($id !=null) {
//       $this->db->where('id_jobref',$id);
//     }
//     $query = $this->db->get();
//     return $query;

//   }
  

  public function get_bm($id= null)
  {
    $this->db->select('*');
    $this->db->from('t_bm a');
    $this->db->join('t_supplier b','a.supplier = b.id_supplier','left');
    $this->db->join('t_user c','a.id_user = c.id_user');
    if($id != null){
      $this->db->where('id_bm', $id);
    }    
    $this->db->order_by('a.date','desc');
    $query = $this->db->get();
    return $query;
  }

  // public function get_sales($id= null)
  // {
  //   $this->db->select('*, b.name_customer as customername,b.address as alamat, b.phone as tlp, c.username as user_name');
  //   $this->db->from('t_sales a');
  //   $this->db->join('t_customer b','a.id_customer = b.id_customer','left');
  //   $this->db->join('t_user c','a.id_user = c.id_user');
  //   $this->db->join('t_jobref d','a.ref = d.id_jobref');
  //   if($id != null){
  //     $this->db->where('id_sales', $id);
  //   }
  //   $this->db->order_by('invoice','desc');
  //   $query = $this->db->get();
  //   return $query;
  // }

  public function get_bm_detail($id_bm= null)
  {
    $this->db->select('b.barcode,b.name,a.qty');
    $this->db->from('t_detail_bm a');
    $this->db->join('t_item b','a.id_item = b.id_item');
    if($id_bm != null){
      $this->db->where('a.id_bm', $id_bm);
    }
    $query = $this->db->get();
    return $query;
  }
  public function qtydetail($id_bm= null)
  {
    $this->db->select_sum('a.qty');
    $this->db->from('t_detail_bm a');
    $this->db->join('t_item b','a.id_item = b.id_item');
    if($id_bm != null){
      $this->db->where('a.id_bm', $id_bm);
    }
    $this->db->group_by('a.id_bm');
    $query = $this->db->get();
    return $query;
  }
}

?>
