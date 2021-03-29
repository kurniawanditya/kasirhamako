<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accout extends CI_Controller {
  function __construct(){
    parent::__construct();
    check_not_login();
    $this->load->model(['M_acc','M_supplier','M_material']);
  }


  public function index()
  {
    $accout   = $this->M_acc->get_accout()->result();
    $data = array(
        'accout' => $accout,        
      );
    $this->template->load('template','transaction/Aksesorisout/aksesorisout_data',$data);
  }


  public function add()
  {
    $supplier = $this->M_supplier->get()->result();
    $item     = $this->M_material->get()->result();
    $cart     = $this->M_acc->get_cart_acc();
    $data = array(
        'supplier' => $supplier,
        'item' => $item,
        'cart' => $cart,
        'invoice' => $this->M_acc->invoice_no(),
      );
    $this->template->load('template','transaction/Aksesorisout/sales_acc',$data);
  }



  public function process()
  {
    $data = $this->input->post(null, TRUE);
    
    if(isset($_POST['add_cart'])){

      $id_item_acc = $this->input->post('id_item_acc');
      $check_cart = $this->M_acc->get_cart_acc(['a.id_item_acc'=> $id_item_acc])->num_rows();
      if($check_cart > 0){
        $this->M_acc->update_cart_qty($data);
      }else{
        $this->M_acc->add_cart($data);
      }
      if($this->db->affected_rows() > 0){
        $params= array("success" => true);
      }else{
        $params = array("success" => false);
      }
      echo json_encode($params);
    }
    
    if(isset($_POST['edit_cart'])){
      $this->M_acc->edit_cart($data);

      if($this->db->affected_rows() > 0){
        $params= array("success" => true);
      }else{
        $params = array("success" => false);
      }
      echo json_encode($params);
    }

    if(isset($_POST['process_payment'])){
      $id_sale = $this->M_acc->add_sale($data);
      $cart = $this->M_acc->get_cart_acc()->result();
      $row = [];
      foreach ($cart as $c => $value){
        array_push($row, array( 
            'id_accout'     => $id_sale,
            'id_item_acc'   => $value->id_item_acc,
            'harga'         => $value->harga,
            'qty'           => $value->qty,
            'total'         => $value->total,
          )
        );
      }
      $this->M_acc->add_sale_detail($row);
      $this->M_acc->del_cart(['id_user' => $this->session->userdata('id_user')]);

      if($this->db->affected_rows() > 0){
        $params= array("success" => true);
      }else{
        $params = array("success" => false);
      }
      echo json_encode($params);
    }


    if(isset($_POST['save'])){
      // $id_sale = $this->M_acc->add_sale($data);
      $cart = $this->M_acc->get_cart_acc()->result();
      $row = [];
      foreach ($cart as $c => $value){
        array_push($row, array( 
            'id_item_acc'   => $value->id_item_acc,
            'price'     => $value->price,
            'qty'       => $value->qty,
            'total'   => $value->total,
            'id_user' =>$this->session->userdata('id_user'),
          )
        );
      }
      $this->M_acc->add_save($row);
      $this->M_acc->del_cart(['id_user' => $this->session->userdata('id_user')]);

      if($this->db->affected_rows() > 0){
        $params= array("success" => true);
      }else{
        $params = array("success" => false);
      }
      echo json_encode($params);
    }

  }

  function cart_data(){
    $cart         = $this->M_acc->get_cart_acc();
    $data['cart'] = $cart;
    $this->load->view('transaction/Aksesorisout/temp_aksesorisout',$data);
  }

  public function cart_del()
  {
    if(isset($_POST['cancel_payment'])){
      $this->M_acc->del_cart(['id_user' => $this->session->userdata('id_user')]);
    }else{
      $id_cart = $this->input->post('id_cart');
      $this->M_acc->del_cart(['id_cart' => $id_cart]);
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
    $this->M_acc->del_sales($id);
    if($this->db->affected_rows()>0){
      echo "<script>alert('Data penjualan berhasil dihapus')</script>";
      redirect('Report/Rsales', 'refresh');
      
    }else{
      echo "<script>alert('Data penjualan gagal dihapus')";
      echo "window.location='".site_url('Report/Rsales')."'</script>";
    }
  }
  public function detail_cc($id_accin = null)
  {
      $detail = $this->M_acc->get_acc_detail($id_accin)->result();
      echo json_encode($detail);
  }

  public function qtydetail($id_accin = null)
  {    
      $qtydetail = $this->M_acc->qtydetail($id_accin)->result();
      echo json_encode($qtydetail);
  }
  public function export_excel($id_accin = null)
  {
    $data['sales'] = $this->M_acc->get_accout($id_accin)->result();
    $data['detail'] = $this->M_acc->get_acc_detail($id_accin)->result();
    $this->template->load('template','export_accout',$data);
  }
}
