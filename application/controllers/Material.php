<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material extends CI_Controller {
  function __construct(){
    parent::__construct();
    check_not_login();
    $this->load->library('datatables');
    $this->load->model(['M_material']);
  }

  public function json()
  {
    header('Content-Type: application/json');
    echo $this->M_material->get_all_item();
  }


  public function index()
  {
    $data = array(
      'row'     => $this->M_material->get(),
    );
    if($this->fungsi->user_login()->level  == 4 || $this->fungsi->user_login()->level == 3) {
      $this->template->load('template','products/material/material_data2',$data);
    }else{
      $this->template->load('template','products/material/material_data',$data);
    }
    // $this->template->load('template','products/item/item_data',$data);
  }


  public function add(){
    $item = new stdClass();
    $item->id_item = null;
    $item->name= null;
    $item->barcode= null;
    $item->hpp= null;
    $item->fob= null;

    $query_jenis = $this->M_jenis->get();
    $jenis[null] ='-pilih-';
    foreach ($query_jenis->result() as $jns) {
      $jenis[$jns->id_jenis] = $jns->name_jenis;
    }

    $query_merk = $this->M_merk->get();
    $merk[null] ='-pilih-';
    foreach ($query_merk->result() as $mrk) {
      $merk[$mrk->id_merk] = $mrk->name_merk;
    }

    $query_koleksi = $this->M_koleksi->get();
    $koleksi[null] ='-pilih-';
    foreach ($query_koleksi->result() as $klk) {
      $koleksi[$klk->id_koleksi] = $klk->name_koleksi;
    }


    $data = array(
      'page'  => 'add',
      'row'   => $item,
      'jenis' =>$jenis,'selectedjenis'=>null,
      'merk'  =>$merk,'selectedmerk'=>null,
      'koleksi'=>$koleksi,'selectedkoleksi'=>null);
    $this->template->load('template','products/item/item_form',$data);
  }

  function update(){ //function update data
    $kode=$this->input->post('kode');
    $data=array(
      'name'     => $this->input->post('name'),
      'warna'=> $this->input->post('warna'),
      'jenis_acc' => $this->input->post('jenis_acc'),
      'harga' => $this->input->post('harga'),
      'stok' => $this->input->post('stok'),
      'ket' => $this->input->post('ket'),
    );
    $this->db->where('id_item_acc',$kode);
    $this->db->update('t_item_acc', $data);
    echo "<script>alert('Data Berhasil di Update');";
        redirect('Material');
  }

  public function process(){
    $post = $this->input->post(null, TRUE);
    if(isset($post['add'])){
      $this->M_material->add($post);
    }else if(isset($post['update'])){
      $this->M_material->update($post);
    }
    if($this->db->affected_rows()>0){
      $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
    }
    redirect('item');
  }


  public function delete($id)
  {
    $this->M_material->delete($id);
    if($this->db->affected_rows()>0){
      $this->session->set_flashdata('success', 'Data Berhasil Dihapus');
    }
    redirect('item');

  }

  public function import()
  {
    $this->template->load('template','products/material/item_form_import');
  }
  public function prosesimport()
  {
    // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';

        $config['upload_path'] = realpath('excel');
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size'] = '10000';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {

            //upload gagal
            $this->session->set_flashdata('notif', '<div class="alert alert-danger"><b>Proses Upload Gagal</b> '.$this->upload->display_errors().'</div>');
            //redirect halaman
            redirect('Material');

        } else {

            $data_upload = $this->upload->data();

            $excelreader     = new PHPExcel_Reader_Excel2007();
            $loadexcel         = $excelreader->load('excel/'.$data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet             = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

            $data = array();

            $numrow = 1;
            foreach($sheet as $row){
                  if($numrow > 1){
                      array_push($data, array(
                          'id_item_acc' => $row['A'],
                          'barcode'     => $row['B'],
                          'name'        => $row['C'],
                          'warna'       => $row['D'],
                          'jenis_acc'   => $row['E'],
                          'harga'       => $row['F'],
                          'stok'        => $row['G'],
                          'ket'         => $row['H'],
                      ));
                    }
                $numrow++;
            }
            $this->db->insert_batch('t_item_acc', $data);
            //delete file from server
            unlink(realpath('excel/'.$data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>Proses Input Berhasil</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect('Material');

        }
    }


    // side server
    public function show(){
      $draw = intval($this->input->post('draw'));
      $start = intval($this->input->post('start'));
      $length = intval($this->input->post('length'));
      $order = $this->input->post('order');
      $col = 0;
      $dir = "";
      $search = $this->input->post('search');
      $search = $search['value'];
      if(!empty($order)){
        foreach($order as $o){
          $col = $o['column'];
          $dir = $o['dir'];
        }
      }
      if($dir!='asc' && $dir!='desc'){
         $dir = 'desc';
      }
      $valid_columns = array(
        0=>'id_item',
        1=>'barcode',
        2=>'name',
        3=>'name_jenis',
        4=>'name_merk',
        5=>'hpp',
        6=>'fob',
        7=>'name_koleksi',
        8=>'stock'
      );
      if(!isset($valid_columns[$col])){
        $order = null;
      }else{
        $order = $valid_columns[$col];
      }

      if(!empty($search)){
        $x = 0;
        foreach($valid_columns as $sterm){
          if($x == 0){
            $this->db->like($sterm,$search);
          }else{
            $this->db->or_like($sterm,$search);
          }
          $x++;
        }
      }
      $this->db->from('t_item as A');
      $this->db->join('t_koleksi as B','A.koleksi=B.id_koleksi');
      $this->db->join('t_jenis as C','A.jenis=C.id_jenis');
      $this->db->join('t_merk as D','A.merk=D.id_merk');
      if($order!=null){
        $this->db->order_by($order,$dir);
      }
      $this->db->limit($length,$start);
      $query = $this->db->get();
      if($query->num_rows()>0){
        foreach($query->result() as $rows){
          $json[]=array(
            $rows->id_item,
            $rows->barcode,
            $rows->name,
            $rows->name_jenis,
            $rows->name_merk,
            $rows->hpp,
            $rows->fob,
            $rows->name_koleksi,
            $rows->stock,
            '<a href="#" class="btn btn-warning">Delete</div>'
          );
        }
          $total_records=$this->db->count_all_results('t_item');
          $response = array(
            'draw'=>$draw,
            'recordsTotal'=>$total_records,
            'recordsFiltered'=>$total_records,
            'data'=>$json
          );
          echo json_encode($response);
        }else{
          $response = array();
          $response['sEcho'] =0;
          $response['iTotalRecords'] = 0;
          $response['iTotalDisplayRecords'] = 0;
          $response['aaData'] = [];
          echo json_encode($response);

        }
      }

    public function barcodeitem(){
      $id=$this->input->post('koleksi');
      $data['row'] = $this->M_material->getdata($id);
      // $this->load->view('barcodeview',$data);

      $this->load->view('barcodeview',$data);
      // $this->template->load('template',);
    }

    public function printbarcode($id=null){
      $id=$this->input->post('koleksi');
      $data['row'] = $this->M_material->getdata($id);
      $html = $this->load->view('barcodeview',$data,true);
      // $this->load->view('barcodeview',$data);
      $this->fungsi->PdfGenerator($html,'barcode','A4','potrait');
    }

}
