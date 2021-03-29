<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
  function __construct(){
    parent::__construct();
    check_not_login();
    $this->load->model('M_customer');
  }

  public function index()
  {
    $data['row'] = $this->M_customer->get();
    $this->template->load('template','customer/customer_data',$data);
  }


  function get_kab(){
    $id=$this->input->post('id');
    $data=$this->M_customer->get_kab($id);
    echo json_encode($data);
  }

  function get_kec(){
    $id=$this->input->post('id');
    $data=$this->M_customer->get_kec($id);
    echo json_encode($data);
  }

  public function delete($id)
  {
    $this->M_customer->delete($id);
    if($this->db->affected_rows()>0){
      echo "<script>alert('Data Berhasil Dihapus')</script>";
    }
    echo "<script>window.location='".site_url('customer')."'</script>";

  }

  public function add(){
    $customer = new stdClass();
    $customer->id_customer = null;
    $customer->name_customer= null;
    $customer->address = null;
    $customer->phone = null;
    $data = array(
      'page' => 'add',
      'prov' => $this->M_customer->get_prov(),
      'row' => $customer,
     );
    $this->template->load('template','customer/customer_form',$data);
  }

  public function update($id){
    $query = $this->M_customer->get($id);
    if($query->num_rows()> 0){
      $customer = $query->row();
      $data = array(
        'page' => 'update',
        'row' => $customer );

      $this->template->load('template','customer/customer_form',$data);
    }else{
      echo "<script>alert('Data Tidak Ditemukan');";
      echo "window.location='".site_url('Customer')."'</script>";

    }

  }

  public function process(){
    $post = $this->input->post(null, TRUE);
    if(isset($post['add'])){
      $this->M_customer->add($post);
    }else if(isset($post['update'])){
      $this->M_customer->update($post);
    }
    if($this->db->affected_rows()>0){
      echo "<script>alert('Data Berhasil disimpan')</script>";
    }
    echo "<script>window.location='".site_url('customer')."'</script>";
  }

}
