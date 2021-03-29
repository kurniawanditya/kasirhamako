<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {
  function __construct(){
    parent::__construct();
    check_not_login();
    $this->load->model('M_supplier');
  }

  public function index()
  { 
    $supplier = new stdClass();
    $supplier->id_supplier = null;
    $supplier->name_supplier= null;
    $supplier->address = null;
    $supplier->phone = null;
    $data = array(
      'page' => 'add',
      'row1' => $supplier,
      'row' => $this->M_supplier->get() );
    $this->template->load('template','supplier/supplier_data',$data);
  }

  public function delete($id)
  {
    $this->M_supplier->delete($id);
    if($this->db->affected_rows()>0){
      echo "<script>alert('Data Berhasil Dihapus')</script>";
    }
    echo "<script>window.location='".site_url('Supplier')."'</script>";

  }

  public function add(){
    $supplier = new stdClass();
    $supplier->id_supplier = null;
    $supplier->name_supplier= null;
    $supplier->address = null;
    $supplier->phone = null;
    $data = array(
      'row' => $supplier );
    $this->template->load('template','supplier/supplier_form',$data);
  }

  public function update($id){
    $query = $this->M_supplier->get($id);
    if($query->num_rows()> 0){
      $supplier = $query->row();
      $data = array(
        'page' => 'update',
        'row' => $supplier );

      $this->template->load('template','supplier/supplier_form',$data);
    }else{
      echo "<script>alert('Data Tidak Ditemukan');";
      echo "window.location='".site_url('User')."'</script>";

    }

  }

  public function process(){
    $post = $this->input->post(null, TRUE);
    if(isset($post['add'])){
      $this->M_supplier->add($post);
    }else if(isset($post['update'])){
      $this->M_supplier->update($post);
    }
    if($this->db->affected_rows()>0){
      $data['teks'] = 'Data berhasil disimpan';
      $this->session->set_flashdata($data);
    }
    echo "<script>window.location='".site_url('Supplier')."'</script>";
  }

}
