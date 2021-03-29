<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stockin extends CI_Controller {
  function __construct(){
    parent::__construct();
    check_not_login();
    $this->load->model(['M_supplier','M_item','M_stock']);
  }

  public function index()
  {
    $supplier = $this->M_supplier->get()->result();
    $item     = $this->M_item->get()->result();
    $data = array(
        'supplier' => $supplier,
        'item' => $item,
      );
    $this->template->load('template','transaction/stockin/stockin_form',$data);
  }
  public function stock_in_add()
  {
    $this->template->load('template','transaction/stockin/stockin_form');   
  }
  public function process()
  {
    if(isset($_POST['in_add'])){
        $post = $this->input->post(null, TRUE);
        $this->M_stock->add_stock_in($post);
        $this->M_item->update_stock_in($post);

        if($this->db->affected_rows()>0){
            $this->session->set_flashdata('success', 'Data berhasil disimpan');
        }
        redirect('Stockin');
    }
  }

}
