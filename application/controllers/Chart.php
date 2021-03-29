<?php
class Chart extends CI_Controller{
    function __construct(){
      parent::__construct();
      //load chart_model dari model
      $this->load->model('M_chart');
    }
 
    function index(){
      $data = $this->M_chart->get_data()->result();
      $x['data'] = json_encode($data);
      $this->load->view('dashboard',$x);
    }
}