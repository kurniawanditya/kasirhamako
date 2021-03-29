<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aksesorisout extends CI_Controller {
  function __construct(){
    parent::__construct();
    check_not_login();
    $this->load->model(['M_supplier','M_material','M_sales','M_accout']);
  }

  public function index()
  {
    $accout   = $this->M_accout->get_accout()->result();
    $data = array(
        'accout' => $accout,        
      );
    $this->template->load('template','transaction/Aksesorisout/aksesorisout_data',$data);
  }
  public function add()
  {
    $item     = $this->M_material->get()->result();
    $supplier = $this->M_supplier->get()->result();
    $temp     = $this->M_accout->get_tempout();
    $data = array(
        'supplier' => $supplier,
        'item'     => $item,
        'temp'     => $temp
     );
    $this->template->load('template','transaction/Aksesorisout/aksesorisout_form',$data);   
  }
  public function process()
  { 
    $data = $this->input->post(null, TRUE);
    
    if(isset($_POST['add_tempout'])){

      $id_item_acc = $this->input->post('id_item_acc');
      $check_tempin = $this->M_accout->get_tempout(['a.id_item_acc'=> $id_item_acc])->num_rows();
      if($check_tempin > 0){
        $this->M_accout->update_tempout_qty($data);
      }else{
        $this->M_accout->add_tempout($data);
      }
      if($this->db->affected_rows() > 0){
        $params= array("success" => true);
      }else{
        $params = array("success" => false);
      }
      echo json_encode($params);
    }

    if(isset($_POST['edit_temp'])){
      $this->M_accout->edit_temp($data);

      if($this->db->affected_rows() > 0){
        $params= array("success" => true);
      }else{
        $params = array("success" => false);
      }
      echo json_encode($params);
    }

    if(isset($_POST['process_saving'])){
      $id_accout = $this->M_accout->add_accout($data);
      $bm = $this->M_accout->get_tempout()->result();
      $row = [];
      foreach ($bm as $c => $value){
        array_push($row, array( 
            'id_accout'          => $id_accout,
            'id_item_acc'       => $value->id_item_acc,
            'qty'               => $value->qty,
          )
        ); 
      }
      $this->M_accout->add_accout_detail($row);
      $this->M_accout->del_temp(['id_user' => $this->session->userdata('id_user')]);

      if($this->db->affected_rows() > 0){
        $params= array("success" => true);
      }else{
        $params = array("success" => false);
      }
      echo json_encode($params);
    }

  }
  function temp_data(){
    $temp     = $this->M_accout->get_tempout();
    $data['temp'] = $temp;
    $this->load->view('transaction/Aksesorisout/temp_aksesorisout',$data);
    }

  public function del_tempout()
  {
    if(isset($_POST['cancel_payment'])){
      $this->M_accout->del_temp(['id_user' => $this->session->userdata('id_user')]);
    }else{
      $id_temp = $this->input->post('id_temp_accout');
      $this->M_accout->del_temp(['id_temp_accout' => $id_temp]);
    }
    if($this->db->affected_rows() > 0){
      $params= array("success" => true);
    }else{
      $params = array("success" => false);
    }
    echo json_encode($params);
  }
  
  

  public function delete($id)
  {
    $this->M_accout->del_accout($id);
    if($this->db->affected_rows()>0){
      echo "<script>alert('Data penjualan berhasil dihapus')</script>";
      redirect('Aksesorisout', 'refresh');
      
    }else{
      echo "<script>alert('Data penjualan gagal dihapus')";
      echo "window.location='".site_url('Aksesorisout')."'</script>";
    }
  }

  

  public function detail_bm($id_accin = null)
  {
      $detail = $this->M_accout->get_acc_detail($id_accin)->result();
      echo json_encode($detail);
  }

  public function qtydetail($id_accin = null)
  {    
      $qtydetail = $this->M_accout->qtydetail($id_accin)->result();
      echo json_encode($qtydetail);
  }


}
