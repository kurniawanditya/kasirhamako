<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Koleksi extends CI_Controller {
  function __construct(){
    parent::__construct();
    check_not_login();
    $this->load->model(['M_koleksi','M_merk']);
  }

  public function index()
  {
    $data['row'] = $this->M_koleksi->get();
    $this->template->load('template','products/koleksi/koleksi_data',$data);
  }


  public function add(){
    $koleksi = new stdClass();
    $koleksi->id_koleksi = null;
    $koleksi->name_koleksi= null;

    $query_merk = $this->M_merk->get();
    $merk[null] ='-pilih-';
    foreach ($query_merk->result() as $mrk) {
      $merk[$mrk->id_merk] = $mrk->name_merk;
    }
    $data = array(
      'page'  => 'add',
      'row'   => $koleksi,
      'id_merk'  =>  $merk,'selectedmerk'=>null, );
    $this->template->load('template','products/koleksi/koleksi_form',$data);
  }

  public function update($id){
    $query = $this->M_koleksi->get($id);
    if($query->num_rows()> 0){
      $koleksi = $query->row();
      $query_merk = $this->M_merk->get();
      $merk[null] ='-pilih-';
      foreach ($query_merk->result() as $mrk) {
        $merk[$mrk->id_merk] = $mrk->name_merk;
      }
      $data = array(
        'page'      => 'update',
        'row'       => $koleksi,
        'id_merk'   =>$merk,'selectedmerk'=>$koleksi->id_merk );

      $this->template->load('template','products/koleksi/koleksi_form',$data);
    }else{
      echo "<script>alert('Data Tidak Ditemukan');";
      redirect('koleksi');

    }

  }

  public function process(){
    $post = $this->input->post(null, TRUE);
    if(isset($post['add'])){
      $this->M_koleksi->add($post);
    }else if(isset($post['update'])){
      $this->M_koleksi->update($post);
    }
    if($this->db->affected_rows()>0){
      $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
    }
    redirect('koleksi');
  }


  public function delete($id)
  {
    $this->M_koleksi->delete($id);
    if($this->db->affected_rows()>0){
      $this->session->set_flashdata('success', 'Data Berhasil Dihapus');
    }
    redirect('koleksi');

  }


}
