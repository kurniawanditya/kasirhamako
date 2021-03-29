<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stockout extends CI_Controller {
  function __construct(){
    parent::__construct();
    check_not_login();
    $this->load->model(['M_stockout','M_merk']);
  }

  public function index()
  {
    $data['row'] = $this->M_stockout->get();
    $this->template->load('template','transaction/stockout/stock_out_data',$data);
  }


  public function add(){
    $stockout = new stdClass();
    $stockout->id_stockout = null;
    $stockout->date = null;
    $stockout->date_delivery = null;
    $stockout->id_stockout = null;
    $stockout->id_stockout = null;
    $stockout->id_stockout = null;

    $query_merk = $this->M_merk->get();
    $merk[null] ='-pilih-';
    foreach ($query_merk->result() as $mrk) {
      $merk[$mrk->id_merk] = $mrk->name_merk;
    }

    $data = array(
      'page' => 'add',
      'row' => $stockout,
      'merk'  =>$merk,'selectedmerk'=>null );
    $this->template->load('template','transaction/stockout/stock_out_form',$data);
  }

  public function update($id){
    $query = $this->M_stockout->get($id);
    if($query->num_rows()> 0){
      $stockout = $query->row();
      $data = array(
        'page' => 'update',
        'row' => $stockout );

      $this->template->load('template','transaction/stockout/stock_out_data',$data);
    }else{
      echo "<script>alert('Data Tidak Ditemukan');";
      redirect('stockout');

    }

  }

  public function process(){
    $post = $this->input->post(null, TRUE);
    if(isset($post['add'])){
      $this->M_stockout->add($post);
    }else if(isset($post['update'])){
      $this->M_stockout->update($post);
    }
    if($this->db->affected_rows()>0){
      $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
    }
    redirect('stockout');
  }


  public function delete($id)
  {
    $this->M_stockout->delete($id);
    if($this->db->affected_rows()>0){
      $this->session->set_flashdata('success', 'Data Berhasil Dihapus');
    }
    redirect('stockout');

  }


}
