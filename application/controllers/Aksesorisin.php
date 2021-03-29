<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aksesorisin extends CI_Controller {
  function __construct(){
    parent::__construct();
    check_not_login();
    $this->load->model(['M_supplier','M_material','M_accin']);
  }

  public function index()
  {
    $accin     = $this->M_accin->get_accin()->result();
    $data = array(
        'accin' => $accin,
      );
    $this->template->load('template','transaction/Aksesorisin/aksesorisin_data',$data);
  }
  public function add()
  {
    $item     = $this->M_material->get()->result();
    $supplier = $this->M_supplier->get()->result();
    $temp     = $this->M_accin->get_tempin();
    $data = array(
        'supplier' => $supplier,
        'item'     => $item,
        'temp'     => $temp
     );
    $this->template->load('template','transaction/Aksesorisin/aksesorisin_form',$data);
  }
  public function process()
  {
    $data = $this->input->post(null, TRUE);

    if(isset($_POST['add_tempin'])){

      $id_item_acc = $this->input->post('id_item_acc');
      $check_tempin = $this->M_accin->get_tempin(['a.id_item_acc'=> $id_item_acc])->num_rows();
      if($check_tempin > 0){
        $this->M_accin->update_tempin_qty($data);
      }else{
        $this->M_accin->add_tempin($data);
      }
      if($this->db->affected_rows() > 0){
        $params= array("success" => true);
      }else{
        $params = array("success" => false);
      }
      echo json_encode($params);
    }

    if(isset($_POST['edit_temp'])){
      $this->M_accin->edit_temp($data);

      if($this->db->affected_rows() > 0){
        $params= array("success" => true);
      }else{
        $params = array("success" => false);
      }
      echo json_encode($params);
    }

    if(isset($_POST['process_saving'])){
      $id_accin = $this->M_accin->add_accin($data);
      $bm = $this->M_accin->get_tempin()->result();
      $row = [];
      foreach ($bm as $c => $value){
        array_push($row, array(
            'id_accin'          => $id_accin,
            'id_item_acc'       => $value->id_item_acc,
            'qty'               => $value->qty,
          )
        );
      }
      $this->M_accin->add_accin_detail($row);
      $this->M_accin->del_tempin(['id_user' => $this->session->userdata('id_user')]);

      if($this->db->affected_rows() > 0){
        $params= array("success" => true);
      }else{
        $params = array("success" => false);
      }
      echo json_encode($params);
    }

  }
  function temp_data(){
    $temp     = $this->M_accin->get_tempin();
    $data['temp'] = $temp;
    $this->load->view('transaction/Aksesorisin/temp_aksesorisin',$data);
    }

  public function del_tempin()
  {
    if(isset($_POST['cancel_payment'])){
      $this->M_accin->del_temp(['id_user' => $this->session->userdata('id_user')]);
    }else{
      $id_temp = $this->input->post('id_temp_acc');
      $this->M_accin->del_temp(['id_temp_acc' => $id_temp]);
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
    $this->M_accin->del_accin($id);
    if($this->db->affected_rows()>0){
      echo "<script>alert('Data penjualan berhasil dihapus')</script>";
      redirect('Aksesorisin', 'refresh');

    }else{
      echo "<script>alert('Data penjualan gagal dihapus')";
      echo "window.location='".site_url('Aksesorisin')."'</script>";
    }
  }



  public function detail_accin($id = null)
  {
      $detail = $this->M_accin->get_acc_detail($id)->result();
      echo json_encode($detail);
  }

  public function qtydetail($id_accin = null)
  {
      $qtydetail = $this->M_accin->qtydetail($id_accin)->result();
      echo json_encode($qtydetail);
  }


}
