<?php

Class Fungsi {

  protected $ci;
  function __construct()
  {
    $this->ci =& get_instance();
  }

  function user_login()
  {
    $this->ci->load->model('M_auth');
    $id_user = $this->ci->session->userdata('id_user');
    $user_data = $this->ci->M_auth->get($id_user)->row();
    return $user_data;
  }

  public function count_item(){
    $this->ci->load->model('M_item');
    return $this->ci->M_item->get()->num_rows();

  }

  public function count_sales(){
    $this->ci->load->model('M_sales');
    return $this->ci->M_sales->get_sales()->num_rows();
    
  }

  public function count_customer(){
    $this->ci->load->model('M_customer');
    return $this->ci->M_customer->get()->num_rows();
    
  }


}

?>
