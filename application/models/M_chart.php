<?php
class M_chart extends CI_Model{
 
  //get data from database
  function get_data(){
      $this->db->select('c.name_jenis, SUM(a.qty) as total');
      $this->db->join('t_item b','b.id_item=a.id_item');
      $this->db->join('t_jenis c','b.jenis=c.id_jenis');
      $this->db->group_by('b.jenis');
      $this->db->order_by('total','desc');
      $this->db->limit(5,0);
      $result = $this->db->get('t_sales_detail a');
      return $result;
  }
 
  public function get_stock(){
    $this->db->select_sum('stock');
    $query = $this->db->get('t_item');
    return $query;
  }
  public function get_totalsales(){
    $currentdate = date('y-m-d');
    $this->db->select_sum('final_price');
    $this->db->from('t_sales');
    $this->db->where('date',$currentdate);
    $query = $this->db->get();
    return $query;
  }

  public function get_totalsales_month(){
    $currentdate = date('m');
    $sql = "SELECT SUM(final_price)
            FROM t_sales AS a
            WHERE MID(a.date,6,2) = $currentdate";
    $query = $this->db->query($sql);
    return $query;
  }

  function get_data_item(){
    $this->db->select('b.name, c.name_jenis, d.name_merk, SUM(a.qty) as total');
    $this->db->join('t_item b','b.id_item=a.id_item');    
    $this->db->join('t_jenis c','b.jenis=c.id_jenis');     
    $this->db->join('t_merk d','b.merk=d.id_merk');        
    $this->db->where('b.merk',1);
    $this->db->group_by('a.id_item');
    $this->db->order_by('total','desc');
    $this->db->limit(5,0);
    $result = $this->db->get('t_sales_detail a');
    return $result;
    
  }
  function getstockplus(){
    $this->db->select('a.name, b.name_jenis, c.name_merk, stock');
    $this->db->join('t_jenis b','a.jenis=b.id_jenis');     
    $this->db->join('t_merk c','a.merk=c.id_merk');  
    $this->db->where('a.merk',1);
    $this->db->order_by('stock','desc');
    $this->db->limit(5,0);
    $result = $this->db->get('t_item a');
    return $result;
    
  }
  function getstockminus(){
    $this->db->select('a.name, b.name_jenis, c.name_merk, stock');
    $this->db->join('t_jenis b','a.jenis=b.id_jenis');     
    $this->db->join('t_merk c','a.merk=c.id_merk');  
    $this->db->where('a.merk',1);
    $this->db->order_by('stock','asc');
    $this->db->limit(5,0);
    $result = $this->db->get('t_item a');
    return $result;
    
  }

  public function get_qtyitem($id=null)
  {
    $this->db->select('SUM(a.qty) tot')
      ->from('t_sales_detail a')
      ->join('t_item b','b.id_item = a.id_item')
      ->join('t_koleksi c','b.koleksi = c.id_koleksi')
      ->where('b.koleksi', $id);
    $result = $this->db->get();
    return $result;
  }

  public function get_qtyitem_daily($id=null)
  {
    $currentdate = date('y-m-d');
    $this->db->select('SUM(a.qty) tot')
      ->from('t_sales_detail a')
      ->join('t_item b','b.id_item = a.id_item')
      ->join('t_koleksi c','b.koleksi = c.id_koleksi')
      ->join('t_sales d','d.id_sales = a.id_sales')
      ->where('b.koleksi', $id)
      ->where('d.date',$currentdate);
    $result = $this->db->get();
    return $result;
  }

  public function get_seller($id){
    $this->db->select('b.name, SUM(a.qty) tq')
    ->from('t_sales_detail a')
    ->join('t_item b','a.id_item = b.id_item')
    ->where('b.koleksi',$id)
    ->group_by('a.id_item')
    ->order_by('tq','DESC')
    ->limit(5,0);
    $result = $this->db->get();
    return $result;
  }

}