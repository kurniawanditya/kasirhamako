<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class M_acc extends CI_Model
{
  public function invoice_no()
  {
    $sql = "SELECT MAX(MID(invoice,17,4)) AS invoice_no
            FROM t_sales_acc 
            WHERE MID(invoice,11,2) = DATE_FORMAT(CURDATE(), '%m') 
            AND MID(invoice,14,2) = DATE_FORMAT(CURDATE(), '%y')";
    $query = $this->db->query($sql);
    if($query->num_rows() > 0){
      $row = $query->row();
      $n = ((int)$row->invoice_no) + 1;
      $no = sprintf("%'.04d",$n);
    }else {
      $no = "0001";
    }
    $invoice = "HAI/M/INV/".date('m')."/".date('y')."/".$no;
    return $invoice;

  }
  function get_cart_acc($params=null){
    $this->db->select('*, b.name as item_name, a.harga as cart_harga');
    $this->db->from('t_cart_acc as a');
    $this->db->join('t_item_acc as b', 'a.id_item_acc = b.id_item_acc');
    if($params != null){
      $this->db->where($params);
    }
    $this->db->where('id_user', $this->session->userdata('id_user'));
    $query = $this->db->get();
    return $query;

  }
  public function add_cart($post){
    $query = $this->db->query("SELECT MAX(id_cart_acc) AS cart_no from t_cart_acc");
    if($query->num_rows() > 0){
      $row = $query->row();
      $cart_no = ((int)$row->cart_no)+1;
    }else{
      $car_no = "1";
    }
    $params = array(
      'id_cart_acc' => $cart_no,
      'id_item_acc' => $post['id_item_acc'],
      'harga'   => $post['harga'],
      'qty'   => $post['qty'],
      'total'   =>$post['harga'] * $post['qty'],
      'id_user' =>$this->session->userdata('id_user')
    );
    $this->db->insert('t_cart_acc',$params);
  }

  function update_cart_qty($post){
    $sql = "UPDATE t_cart_acc SET harga = '$post[harga]', 
    qty = qty + '$post[qty]',
    total = '$post[harga]'*qty
    WHERE id_item_acc = '$post[id_item_acc]'";

    $this->db->query($sql);
  }

  public function del_cart($params = null)
  {
      $this->db->where($params);
      $this->db->delete('t_cart_acc');
  }

  public function edit_cart_acc($post){
    $params = array(
      'harga' => $post['harga'],
      'qty' => $post['qty'],
      'total' => $post['total'],
    );
    $this->db->where('id_cart_acc', $post['id']);
    $this->db->update('t_cart_acc', $params);

  }
  public function add_sale($post){
    $params = array(
      'invoice'     => $this->invoice_no(),
      'supplier'    =>$post['id_supplier'] == "" ? null : $post['id_supplier'],
      'total_price' =>$post['subtotal'],
      'final_price' =>$post['grandtotal'],
      'cash'        =>$post['cash'],
      'remaining'   =>$post['change'],
      'note'        =>$post['note'],
      'ref'         =>$post['ref'],
      'date'        =>$post['date'],
      'id_user'     => $this->session->userdata('id_user')
    );
    $this->db->insert('t_sales_acc',$params);
    return $this->db->insert_id();
  }

  function add_sale_detail($params){
    $this->db->insert_batch('t_sales_detail_acc', $params);

  }

  function add_save($params){
    $this->db->insert_batch('t_cart_acc_copy', $params);

  }
  public function get_ref($id = null){
    $this->db->from('t_jobref');
    if($id !=null) {
      $this->db->where('id_jobref',$id);
    }
    $query = $this->db->get();
    return $query;

  }
  

  public function get_accout($id= null)
  {
    $this->db->select('*');
    $this->db->from('t_sales_acc a');
    $this->db->join('t_supplier b','a.supplier = b.id_supplier','left');
    $this->db->join('t_user c','a.id_user = c.id_user');
    if($id != null){
      $this->db->where('id_accout', $id);
    }
    $this->db->order_by('sales_created','desc');
    $query = $this->db->get();
    return $query;
  }

  public function get_accout_detail($id_sales= null)
  {
    $this->db->from('t_sales_detail_acc a');
    $this->db->join('t_item_acc b','a.id_item_acc = b.id_item_acc');
    if($id_sales != null){
      $this->db->where('a.id_accout', $id_sales);
    }
    $query = $this->db->get();
    return $query;
  }

  public function get_accout_supplier($id_supplier= null)
  {
    $this->db->from('t_accout');
    $this->db->where('supplier', $id_supplier);
    $query = $this->db->get();
    return $query;
  }

  public function get_history_item($id= null)
  {
    $this->db->select('*');
    $this->db->from('t_accout_detail a');
    $this->db->join('t_accout b','a.id_sales = b.id_sales');
    $this->db->join('t_accout_detail c','a.id_item_acc = c.id_item_acc');
    $this->db->where('a.id_item_acc', $id);
    $this->db->group_by('b.invoice');
    $query = $this->db->get();
    return $query;
  }

  public function get_history_item_count($id= null)
  {
    $this->db->select('COUNT(qty)');
    $this->db->from('t_accout_detail a');
    $this->db->join('t_accout b','a.id_sales = b.id_sales');
    $this->db->join('t_accout_detail c','a.id_item_acc = c.id_item_acc');
    $this->db->where('a.id_item_acc', $id);
    $query = $this->db->get();
    return $query;
  }


  function get_sum_sales($id_sales = null){
    $this->db->select_sum('qty');
    $this->db->from('t_accout_detail');
    $this->db->Where('id_sales',$id_sales);
    return $this->db->get();
  }

  public function del_sales($id)
  {
    $this->db->where('id_sales', $id);
    $this->db->delete('t_accout');
  }

  //report
  public function get_accout_bydate()
  {
    $jobref = $this->input->post('jobref');   
    $tgl_awal = $this->input->post('tgl_awal');
    $tgl_akhir = $this->input->post('tgl_akhir');
    $this->db->select('b.date,c.barcode, c.name, a.qty, a.harga, a.total');
    $this->db->from('t_accout_detail a');
    $this->db->join('t_accout b','a.id_sales = b.id_sales');
    $this->db->join('t_item_acc c','a.id_item_acc = c.id_item_acc');
    if($jobref != null){
      $this->db->where('ref',$jobref);
    }
    if($tgl_awal != null && $tgl_akhir != null){
      $this->db->where('date >=',$tgl_awal);
      $this->db->where('date <=',$tgl_akhir);
    }
   
    $this->db->order_by('date','asc');
    $query = $this->db->get();
    return $query;
  }

  public function get_accout_bydate2()
  {
    $jobref = $this->input->post('jobref');   
    $tgl_awal = $this->input->post('tgl_awal');
    $tgl_akhir = $this->input->post('tgl_akhir');
    $this->db->select('b.date,b.note, b.invoice,c.name_supplier, e.nama_jobref,d.barcode, d.name, a.harga,a.qty');
    $this->db->from('t_accout_detail a');
    $this->db->join('t_accout b','a.id_sales=b.id_sales');
    $this->db->join('t_supplier c','b.supplier=c.id_supplier');
    $this->db->join('t_item_acc d','a.id_item_acc=d.id_item_acc');
    $this->db->join('t_jobref e','b.ref=e.id_jobref');
    if($jobref != null){
      $this->db->where('ref',$jobref);
    }
    if($tgl_awal != null && $tgl_akhir != null){
      $this->db->where('date >=',$tgl_awal);
      $this->db->where('date <=',$tgl_akhir);
    }
   
    $this->db->order_by('date','asc');
    $query = $this->db->get();
    return $query;
  }

  public function get_sum()
  {
    $jobref = $this->input->post('jobref');   
    $tgl_awal = $this->input->post('tgl_awal');
    $tgl_akhir = $this->input->post('tgl_akhir');
    $this->db->select('SUM(a.total) total');
    $this->db->from('t_accout_detail a');
    $this->db->join('t_accout b','a.id_sales=b.id_sales');
    $this->db->join('t_supplier c','b.id_supplier=c.id_supplier');
    $this->db->join('t_item_acc d','a.id_item_acc=d.id_item_acc');
    $this->db->join('t_jobref e','b.ref=e.id_jobref');
    if($jobref != null){
      $this->db->where('ref',$jobref);
    }
    if($tgl_awal != null && $tgl_akhir != null){
      $this->db->where('date >=',$tgl_awal);
      $this->db->where('date <=',$tgl_akhir);
    }
   
    $this->db->order_by('date','asc');
    $query = $this->db->get();
    return $query;
  }
  public function get_sum_final()
  {
    $jobref = $this->input->post('jobref');   
    $tgl_awal = $this->input->post('tgl_awal');
    $tgl_akhir = $this->input->post('tgl_akhir');
    $this->db->select('SUM(final_harga) final');
    $this->db->from('t_accout');
    if($jobref != NULL){
      $this->db->where('ref',$jobref);
    }
    if($tgl_awal != null && $tgl_akhir !=null){
      $this->db->where('date >=',$tgl_awal);
      $this->db->where('date <=',$tgl_akhir);
    }
    $this->db->order_by('date','asc');
    $query = $this->db->get();
    return $query;
  }

  public function get_acc_detail($id_bm= null)
  {
    $this->db->select('*');
    $this->db->from('t_sales_detail_acc a');
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
    $this->db->from('t_sales_detail_acc a');
    $this->db->join('t_item_acc b','a.id_item_acc = b.id_item_acc');
    if($id_bm != null){
      $this->db->where('a.id_accout', $id_bm);
    }
    $this->db->group_by('a.id_accout');
    $query = $this->db->get();
    return $query;
  }  

  
  public function get_accoutbydate()
  { 
    $tgl_awal = $this->input->post('tgl_awal');
    $tgl_akhir = $this->input->post('tgl_akhir');
    $this->db->select('barcode, c.name,Count(b.qty) total');
    $this->db->from('t_accout a');
    $this->db->join('t_detail_accout b','a.id_accout=b.id_accout');
    $this->db->join('t_item_acc c',' b.id_item_acc=c.id_item_acc');
    
    if($tgl_awal != null && $tgl_akhir != null){
      $this->db->where('date >=',$tgl_awal);
      $this->db->where('date <=',$tgl_akhir);
    }
   
    $this->db->group_by('barcode');
    $query = $this->db->get();
    return $query;
  }


}


?>
