<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Data extends CI_Controller {
        function __construct(){  
            parent::__construct();
            $this->load->model('M_Datatables');
            $this->load->library('datatables');
        }

        public function index()
        {
            $this->load->view('products/datatables/datatable');
        }


        public function tablequery()
        {
            $this->load->view('products/datatables/tablequery');

        }

        function view_data_query()
        {   
            $query  = "SELECT a.id_item, a.barcode, a.name, a.hpp, a.fob, a.stock, b.name_merk FROM t_item as a
                       JOIN t_merk as b ON a.merk=b.id_merk";
            $search = array('name', 'fob');
            $where  = null; 
            // $where  = array('nama_kategori' => 'Tutorial');
            header('Content-Type: application/json');
            echo $this->M_Datatables->get_tables_query($query,$search,$where);
        }
    }
?>