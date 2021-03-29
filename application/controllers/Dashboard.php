<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
		parent::__construct();
		//load chart_model dari model
		$this->load->model('M_chart');
	}
	public function index()
	{
		check_not_login();
		$x['data'] = $this->M_chart->get_data();
		$x['stock'] =$this->M_chart->get_stock();
		$x['item'] =$this->M_chart->get_data_item();
		$x['stockplus'] =$this->M_chart->getstockplus();
		$x['stockminus'] =$this->M_chart->getstockminus();
		$x['totalsales'] =$this->M_chart->get_totalsales();
		$x['totalsalesmo'] =$this->M_chart->get_totalsales_month();
		// $x['qtyitem'] = $this->M_chart->get_qtyitem($id=null)->result();
		// $x['qtyitemd'] = $this->M_chart->get_qtyitem_daily($id=null)->result();
		$this->template->load('template','dashboard',$x);
	}

	public function get_qtyitem($id=null){
		$detail = $this->M_chart->get_qtyitem($id)->result();
		echo json_encode($detail);
	}

	public function get_qtyitemd($id=null){
		$detail = $this->M_chart->get_qtyitem_daily($id)->result();
		echo json_encode($detail);
	}

	public function get_seller($id=null){
		$detail = $this->M_chart->get_seller($id)->result();
		echo json_encode($detail);
	}

}