<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {
  function __construct(){
    parent::__construct();
    check_not_login();
    $this->load->model(['M_sales','M_customer','M_item']);
  }

  public function index()
  {
    $customer = $this->M_customer->get()->result();
    $jobref   = $this->M_sales->get_ref()->result();
    $item     = $this->M_item->get()->result();
    $cart     = $this->M_sales->get_cart();
    $data = array(
        'customer' => $customer,
        'jobref' => $jobref,
        'item' => $item,
        'cart' => $cart,
        'invoice' => $this->M_sales->invoice_no(),
      );
    $this->template->load('template','transaction/sales/sales_form',$data);
  }



  public function process()
  {
    $data = $this->input->post(null, TRUE);

    if(isset($_POST['add_cart'])){

      $id_item = $this->input->post('id_item');
      $check_cart = $this->M_sales->get_cart(['a.id_item'=> $id_item])->num_rows();
      if($check_cart > 0){
        $this->M_sales->update_cart_qty($data);
      }else{
        $this->M_sales->add_cart($data);
      }
      if($this->db->affected_rows() > 0){
        $params= array("success" => true);
      }else{
        $params = array("success" => false);
      }
      echo json_encode($params);
    }

    if(isset($_POST['edit_cart'])){
      $this->M_sales->edit_cart($data);

      if($this->db->affected_rows() > 0){
        $params= array("success" => true);
      }else{
        $params = array("success" => false);
      }
      echo json_encode($params);
    }

    if(isset($_POST['process_payment'])){
      $id_sale = $this->M_sales->add_sale($data);
      $cart = $this->M_sales->get_cart()->result();
      $row = [];
      foreach ($cart as $c => $value){
        array_push($row, array(
            'id_sales'      => $id_sale,
            'id_item'       => $value->id_item,
            'price'         => $value->price,
            'qty'           => $value->qty,
            'discount_item' => $value->discount_item,
            'total'         => $value->total,
          )
        );
      }
      $this->M_sales->add_sale_detail($row);
      $this->M_sales->del_cart(['id_user' => $this->session->userdata('id_user')]);

      if($this->db->affected_rows() > 0){
        $params= array("success" => true);
      }else{
        $params = array("success" => false);
      }
      echo json_encode($params);
    }


    if(isset($_POST['save'])){
      // $id_sale = $this->M_sales->add_sale($data);
      $cart = $this->M_sales->get_cart()->result();
      $row = [];
      foreach ($cart as $c => $value){
        array_push($row, array(
            'id_item'         => $value->id_item,
            'price'           => $value->price,
            'qty'             => $value->qty,
            'discount_item'   => $value->discount_item,
            'total'           => $value->total,
            'id_user'         =>$this->session->userdata('id_user'),
          )
        );
      }
      $this->M_sales->add_save($row);
      $this->M_sales->del_cart(['id_user' => $this->session->userdata('id_user')]);

      if($this->db->affected_rows() > 0){
        $params= array("success" => true);
      }else{
        $params = array("success" => false);
      }
      echo json_encode($params);
    }

  }

  function cart_data(){
    $cart         = $this->M_sales->get_cart();
    $data['cart'] = $cart;
    $this->load->view('transaction/sales/cart_data',$data);
  }

  public function cart_del()
  {
    if(isset($_POST['cancel_payment'])){
      $this->M_sales->del_cart(['id_user' => $this->session->userdata('id_user')]);
    }else{
      $id_cart = $this->input->post('id_cart');
      $this->M_sales->del_cart(['id_cart' => $id_cart]);
    }
    if($this->db->affected_rows() > 0){
      $params= array("success" => true);
    }else{
      $params = array("success" => false);
    }
    echo json_encode($params);
  }

  public function cetak($id){
    $this->load->view();
  }

  public function delete($id)
  {
    $this->M_sales->del_sales($id);
    if($this->db->affected_rows()>0){
      echo "<script>alert('Data penjualan berhasil dihapus')</script>";
      redirect('Report/Rsales', 'refresh');

    }else{
      echo "<script>alert('Data penjualan gagal dihapus')";
      echo "window.location='".site_url('Report/Rsales')."'</script>";
    }
  }
}
