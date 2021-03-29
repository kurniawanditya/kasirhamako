<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merk extends CI_Controller {
  function __construct(){
    parent::__construct();
    check_not_login();
    $this->load->model('M_merk');
  }

  public function index()
  {
    $data['row'] = $this->M_merk->get();
    $this->template->load('template','products/merk/merk_data',$data);
  }


  public function add(){
    $merk = new stdClass();
    $merk->id_merk = null;
    $merk->name_merk= null;
    $data = array(
      'page' => 'add',
      'row' => $merk );
    $this->template->load('template','products/merk/merk_form',$data);
  }

  public function update($id){
    $query = $this->M_merk->get($id);
    if($query->num_rows()> 0){
      $merk = $query->row();
      $data = array(
        'page' => 'update',
        'row' => $merk );

      $this->template->load('template','products/merk/merk_form',$data);
    }else{
      echo "<script>alert('Data Tidak Ditemukan');";
      redirect('merk');

    }

  }

  public function process(){
    $post = $this->input->post(null, TRUE);
    if(isset($post['add'])){
      $this->M_merk->add($post);
    }else if(isset($post['update'])){
      $this->M_merk->update($post);
    }
    if($this->db->affected_rows()>0){
      $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
    }
    redirect('merk');
  }


  public function delete($id)
  {
    $this->M_merk->delete($id);
    if($this->db->affected_rows()>0){
      $this->session->set_flashdata('success', 'Data Berhasil Dihapus');
    }
    redirect('merk');

  }


}
