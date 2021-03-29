<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class M_sales extends CI_Model
{
  public function invoice_no()
  {
    $sql = "SELECT MAX(MID(invoice,15,4)) AS invoice_no
            FROM t_sales
            WHERE MID(invoice,9,2) = DATE_FORMAT(CURDATE(), '%m')
            AND MID(invoice,12,2) = DATE_FORMAT(CURDATE(), '%y')";
    $query = $this->db->query($sql);
    if($query->num_rows() > 0){
      $row = $query->row();
      $n = ((int)$row->invoice_no) + 1;
      $no = sprintf("%'.04d",$n);
    }else {
      $no = "0001";
    }
    $invoice = "HAI/INV/".date('m')."/".date('y')."/".$no;
    return $invoice;

  }
  function get_cart($params=null){
    $this->db->select('*, b.name as item_name, a.price as cart_price');
    $this->db->from('t_cart as a');
    $this->db->join('t_item as b', 'a.id_item = b.id_item');
    if($params != null){
      $this->db->where($params);
    }
    $this->db->where('id_user', $this->session->userdata('id_user'));
    $query = $this->db->get();
    return $query;

  }
  public function add_cart($post){
    $query = $this->db->query("SELECT MAX(id_cart) AS cart_no from t_cart");
    if($query->num_rows() > 0){
      $row = $query->row();
      $cart_no = ((int)$row->cart_no)+1;
    }else{
      $car_no = "1";
    }
    $params = array(
      'id_cart'       => $cart_no,
      'id_item'       => $post['id_item'],
      'price'         => $post['fob'],
      'qty'           => $post['qty'],
      'discount_item' => 0,
      'total'         =>$post['fob'] * $post['qty'],
      'id_user'       =>$this->session->userdata('id_user')
    );
    $this->db->insert('t_cart',$params);
  }

  function update_cart_qty($post){
    $sql = "UPDATE t_cart SET price = '$post[fob]',
    qty = qty + '$post[qty]',
    total = '$post[fob]'*qty
    WHERE id_item = '$post[id_item]'";

    $this->db->query($sql);
  }

  public function del_cart($params = null)
  {
      $this->db->where($params);
      $this->db->delete('t_cart');
  }

  public function edit_cart($post){
    $params = array(
      'price'         => $post['price'],
      'qty'           => $post['qty'],
      'discount_item' => $post['discount'],
      'total'         => $post['total'],
    );
    $this->db->where('id_cart', $post['id']);
    $this->db->update('t_cart', $params);

  }
  public function add_sale($post){
    $params = array(
      'invoice'     => $this->invoice_no(),
      'id_customer' =>$post['id_customer'] == "" ? null : $post['id_customer'],
      'total_price' =>$post['subtotal'],
      'discount'    =>$post['discount'],
      'final_price' =>$post['grandtotal'],
      'cash'        =>$post['cash'],
      'remaining'   =>$post['change'],
      'note'        =>$post['note'],
      'ongkir'      =>$post['ongkir'],
      'biaya_lain'  =>$post['biaya_lain'],
      'ref'         =>$post['ref'],
      'date'        =>$post['date'],
      'id_user'     =>$this->session->userdata('id_user')
    );
    $this->db->insert('t_sales',$params);
    return $this->db->insert_id();
  }

  function add_sale_detail($params){
    $this->db->insert_batch('t_sales_detail', $params);

  }

  function add_save($params){
    $this->db->insert_batch('t_cart_copy', $params);

  }
  public function get_ref($id = null){
    $this->db->from('t_jobref');
    if($id !=null) {
      $this->db->where('id_jobref',$id);
    }
    $query = $this->db->get();
    return $query;

  }


  public function get_sales($id= null)
  {
    $this->db->select('*, b.name_customer as customername,b.address as alamat, b.phone as tlp, c.username as user_name');
    $this->db->from('t_sales a');
    $this->db->join('t_customer b','a.id_customer = b.id_customer','left');
    $this->db->join('t_user c','a.id_user = c.id_user');
    $this->db->join('t_jobref d','a.ref = d.id_jobref');
    if($id != null){
      $this->db->where('id_sales', $id);
    }
    $this->db->order_by('sales_created','desc');
    $query = $this->db->get();
    return $query;
  }

  public function get_sales_detail($id_sales= null)
  {
    $this->db->from('t_sales_detail a');
    $this->db->join('t_item b','a.id_item = b.id_item');
    if($id_sales != null){
      $this->db->where('a.id_sales', $id_sales);
    }
    $query = $this->db->get();
    return $query;
  }

  public function get_totqty($id=null)
  {
    $this->db->select('SUM(qty) as tot')
      ->from('t_sales_detail')
      ->where('id_sales', $id);
      $result=$this->db->get();
      return $result;
  }

  public function get_sales_customer($id_customer= null)
  {
    $this->db->from('t_sales');
    $this->db->where('id_customer', $id_customer);
    $query = $this->db->get();
    return $query;
  }

  public function get_history_item($id= null)
  {
    $this->db->SELECT('a.id_sales,b.invoice, b.date, SUM(qty) as t')
      ->FROM ('t_sales_detail a')
      ->JOIN('t_sales b','a.id_sales = b.id_sales')
      ->WHERE(' a.id_item',$id)
      ->GROUP_BY('id_sales');
    $query = $this->db->get();
    return $query;
  }

  public function get_history_item_sum($id= null)
  {
    $this->db->SELECT('SUM(qty) as tq')
      ->FROM ('t_sales_detail a')
      ->JOIN('t_sales b','a.id_sales = b.id_sales')
      ->WHERE(' a.id_item',$id)
      ->GROUP_BY('a.id_item');
    $query = $this->db->get();
    return $query;
  }


  public function get_history_item_count($id= null)
  {
    $this->db->select('COUNT(qty)');
    $this->db->from('t_sales_detail a');
    $this->db->join('t_sales b','a.id_sales = b.id_sales');
    $this->db->join('t_sales_detail c','a.id_item = c.id_item');
    $this->db->where('a.id_item', $id);
    $query = $this->db->get();
    return $query;
  }


  function get_sum_sales($id_sales = null){
    $this->db->select_sum('qty');
    $this->db->from('t_sales_detail');
    $this->db->Where('id_sales',$id_sales);
    return $this->db->get();
  }

  public function del_sales($id)
  {
    $this->db->where('id_sales', $id);
    $this->db->delete('t_sales');
  }

  //report
  public function get_sales_bydate()
  {
    $jobref = $this->input->post('jobref');
    $tgl_awal = $this->input->post('tgl_awal');
    $tgl_akhir = $this->input->post('tgl_akhir');
    $this->db->select('b.date,c.barcode, c.name, a.qty, a.discount_item, a.price, a.total');
    $this->db->from('t_sales_detail a');
    $this->db->join('t_sales b','a.id_sales = b.id_sales');
    $this->db->join('t_item c','a.id_item = c.id_item');
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

  public function get_sales_bydate2()
  {
    $jobref = $this->input->post('jobref');
    $tgl_awal = $this->input->post('tgl_awal');
    $tgl_akhir = $this->input->post('tgl_akhir');
    $this->db->select('b.date,b.note, b.invoice,c.name_customer, e.nama_jobref,d.barcode, d.name, a.price,a.qty, a.discount_item ,b.discount');
    $this->db->from('t_sales_detail a');
    $this->db->join('t_sales b','a.id_sales=b.id_sales');
    $this->db->join('t_customer c','b.id_customer=c.id_customer');
    $this->db->join('t_item d','a.id_item=d.id_item');
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
    $this->db->select('SUM(a.discount_item) discount_item, SUM(a.total) total');
    $this->db->from('t_sales_detail a');
    $this->db->join('t_sales b','a.id_sales=b.id_sales');
    $this->db->join('t_customer c','b.id_customer=c.id_customer');
    $this->db->join('t_item d','a.id_item=d.id_item');
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
    $this->db->select('SUM(discount) discount, SUM(final_price) final');
    $this->db->from('t_sales');
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


}


?>
