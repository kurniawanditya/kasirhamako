<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barangmasuk extends CI_Controller {
  function __construct(){
    parent::__construct();
    check_not_login();
    $this->load->model(['M_supplier','M_item','M_sales','M_stockin']);
  }

  public function index()
  {
    $bm     = $this->M_stockin->get_bm()->result();
    $data = array(
        'bm' => $bm,        
      );
    $this->template->load('template','transaction/barangmasuk/barangmasuk_data',$data);
  }
  public function add()
  {
    $item     = $this->M_item->get()->result();
    $supplier = $this->M_supplier->get()->result();
    $jobref   = $this->M_sales->get_ref()->result();
    $temp     = $this->M_stockin->get_temp();
    $data = array(
        'supplier' => $supplier,
        'jobref'   => $jobref,
        'item'     => $item,
        'temp'     => $temp
     );
    $this->template->load('template','transaction/barangmasuk/barangmasuk_form',$data);   
  }
  public function process()
  { 
    $data = $this->input->post(null, TRUE);
    
    if(isset($_POST['add_temp'])){

      $id_item = $this->input->post('id_item');
      $check_temp = $this->M_stockin->get_temp(['a.id_item'=> $id_item])->num_rows();
      if($check_temp > 0){
        $this->M_stockin->update_temp_qty($data);
      }else{
        $this->M_stockin->add_temp($data);
      }
      if($this->db->affected_rows() > 0){
        $params= array("success" => true);
      }else{
        $params = array("success" => false);
      }
      echo json_encode($params);
    }

    if(isset($_POST['edit_temp'])){
      $this->M_stockin->edit_temp($data);

      if($this->db->affected_rows() > 0){
        $params= array("success" => true);
      }else{
        $params = array("success" => false);
      }
      echo json_encode($params);
    }

    if(isset($_POST['process_saving'])){
      $id_bm = $this->M_stockin->add_bm($data);
      $bm = $this->M_stockin->get_temp()->result();
      $row = [];
      foreach ($bm as $c => $value){
        array_push($row, array( 
            'id_bm'         => $id_bm,
            'id_item'       => $value->id_item,
            'qty'           => $value->qty,
          )
        ); 
      }
      $this->M_stockin->add_bm_detail($row);
      $this->M_stockin->del_temp(['id_user' => $this->session->userdata('id_user')]);

      if($this->db->affected_rows() > 0){
        $params= array("success" => true);
      }else{
        $params = array("success" => false);
      }
      echo json_encode($params);
    }

  }

  public function del_temp()
  {
    if(isset($_POST['cancel_payment'])){
      $this->M_stockin->del_temp(['id_user' => $this->session->userdata('id_user')]);
    }else{
      $id_temp = $this->input->post('id_temp');
      $this->M_stockin->del_temp(['id_temp' => $id_temp]);
    }
    if($this->db->affected_rows() > 0){
      $params= array("success" => true);
    }else{
      $params = array("success" => false);
    }
    echo json_encode($params);
  }
  
  function temp_data(){
    $temp     = $this->M_stockin->get_temp();
    $data['temp'] = $temp;
    $this->load->view('transaction/barangmasuk/temp_barangmasuk',$data);
  }

  public function detail_bm($id_bm = null)
  {
      $detail = $this->M_stockin->get_bm_detail($id_bm)->result();
      echo json_encode($detail);
  }

  public function qtydetail($id_bm = null)
  {    
      $qtydetail = $this->M_stockin->qtydetail($id_bm)->result();
      echo json_encode($qtydetail);
  }


}
