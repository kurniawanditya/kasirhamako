<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis extends CI_Controller {
  function __construct(){
    parent::__construct();
    check_not_login();
    $this->load->model('M_jenis');
  }

  public function index()
  {
    $data['row'] = $this->M_jenis->get();
    $this->template->load('template','products/jenis/jenis_data',$data);
  }


  public function add(){
    $jenis = new stdClass();
    $jenis->id_jenis = null;
    $jenis->name_jenis= null;
    $data = array(
      'page' => 'add',
      'row' => $jenis );
    $this->template->load('template','products/jenis/jenis_form',$data);
  }

  public function update($id){
    $query = $this->M_jenis->get($id);
    if($query->num_rows()> 0){
      $jenis = $query->row();
      $data = array(
        'page' => 'update',
        'row' => $jenis );

      $this->template->load('template','products/jenis/jenis_form',$data);
    }else{
      echo "<script>alert('Data Tidak Ditemukan');";
      redirect('jenis');

    }

  }

  public function process(){
    $post = $this->input->post(null, TRUE);
    if(isset($post['add'])){
      $this->M_jenis->add($post);
    }else if(isset($post['update'])){
      $this->M_jenis->update($post);
    }
    if($this->db->affected_rows()>0){
      $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
    }
    redirect('jenis');
  }


  public function delete($id)
  {
    $this->M_jenis->delete($id);
    if($this->db->affected_rows()>0){
      $this->session->set_flashdata('success', 'Data Berhasil Dihapus');
    }
    redirect('jenis');

  }


}
