<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
  function __construct(){
    parent::__construct();
    check_not_login();
    $this->load->model(['M_sales','M_stockin','M_item','M_acc','M_accin']);
  }

  public function Rsales()
  {
    $data['ref'] = $this->M_sales->get_ref()->result();
    $data['row'] = $this->M_sales->get_sales();
    $this->template->load('template','report/sale_report',$data);
  }

  public function sale_product($id_sale = null)
  {
      $detail = $this->M_sales->get_sales_detail($id_sale)->result();
      echo json_encode($detail);
  }

  public function totqty($id=null){
    $qty = $this->M_sales->get_totqty($id)->result();
    echo json_encode($qty);
  }

  public function sale_product_customer($id_customer = null)
  {
      $detail = $this->M_sales->get_sales_customer($id_customer)->result();
      echo json_encode($detail);
  }


  public function history_product($id_product = null)
  {
      $detail = $this->M_sales->get_history_item($id_product)->result();
      echo json_encode($detail);
  }
  public function history_product_sum($id_product = null)
  {
      $detail = $this->M_sales->get_history_item_sum($id_product)->result();
      echo json_encode($detail);
  }


  public function export_excel($id_sale = null)
  {
    $data['sales'] = $this->M_sales->get_sales($id_sale)->result();
    $data['detail'] = $this->M_sales->get_sales_detail($id_sale)->result();
    $this->template->load('template','export_excel',$data);
  }

  public function export($id_sale = null){
    // Load plugin PHPExcel nya
    include APPPATH.'third_party/PHPExcel/PHPExcel.php';

    // Panggil class PHPExcel nya
    $excel = new PHPExcel();
    // Settingan awal fil excel
    $excel->getProperties()->setCreator('Invoice')
                 ->setLastModifiedBy('Invoice')
                 ->setTitle("Invoice")
                 ->setSubject("Invoice")
                 ->setDescription("Laporan Invoice")
                 ->setKeywords("Invoice");
    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel

    $styleArray = array(
      'font'  => array(
           'name'  => 'Arial'
       ));
    $phpColor = new PHPExcel_Style_Color();
    $phpColor->setRGB('757171');

    $style_col = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      )

      // 'borders' => array(
      //   'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
      //   'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
      //   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
      //   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      // )
    );
    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $style_row = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    // Menambahkan file gambar pada document excel pada kolom B2
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('HAI');
    $objDrawing->setDescription('Logo HAI');
    $objDrawing->setPath('./assets/dist/img/hai.jpg');
    $objDrawing->setHeight(95);
    $objDrawing->setCoordinates('A1');
    $objDrawing->setWorksheet($excel->getActiveSheet());

    $excel->getDefaultStyle()->applyFromArray($styleArray);
    $excel->setActiveSheetIndex(0)->setCellValue('I1', "PT. HAMAKO APPAREL INDONESIA"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('I3', "www.hamakoecolife. com"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('I4', "www.babybudshop. com"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('I5', "+62811 242 625 6"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('I8', "INVOICE"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('I10', "INV NUMBER"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('A10', "RECIPIENT"); // Set kolom A1 dengan tulisan "DATA SISWA"
    // $excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('I8')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('I8')->getFont()->setSize(18); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('I10')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('I10')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('A10')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('A10')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('I3:I5')->getFont()->setColor( $phpColor );
    $excel->getActiveSheet()->getStyle('I1:I11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); // Set text center untuk kolom A1

    // Buat header tabel nya pada baris ke 3
    $excel->setActiveSheetIndex(0)->setCellValue('A17', "INV DATE"); // Set kolom A3 dengan tulisan "NO"
    $excel->setActiveSheetIndex(0)->setCellValue('C17', "ITEM"); // Set kolom B3 dengan tulisan "NIS"
    $excel->setActiveSheetIndex(0)->setCellValue('E17', "QTY"); // Set kolom C3 dengan tulisan "NAMA"
    $excel->setActiveSheetIndex(0)->setCellValue('G17', "PRICE"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
    $excel->setActiveSheetIndex(0)->setCellValue('I17', "AMOUNT"); // Set kolom E3 dengan tulisan "ALAMAT"
    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    $excel->getActiveSheet()->getStyle('A17')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('C17')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('E17')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('G17')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('I17')->applyFromArray($style_col);

    // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
    $sales  = $this->M_sales->get_sales($id_sale)->result();
    $detail = $this->M_sales->get_sales_detail($id_sale)->result();
    $sumqty = $this->M_sales->get_sum_sales($id_sale)->result();

    foreach($sales as $data){ }
    $excel->setActiveSheetIndex(0)->setCellValue('I11', $data->invoice);
    $excel->setActiveSheetIndex(0)->setCellValue('A12', $data->customername);
    $excel->setActiveSheetIndex(0)->setCellValue('A13', $data->alamat);
    $excel->setActiveSheetIndex(0)->setCellValue('A14', $data->tlp);

    $excel->getActiveSheet()->getStyle('I11')->getFont()->setColor( $phpColor );
    $excel->getActiveSheet()->getStyle('A12:A14')->getFont()->setColor( $phpColor );

    $excel->setActiveSheetIndex(0)->setCellValue('A19', $data->date);
    $excel->setActiveSheetIndex(0)->setCellValue('C19', "HAMAKO");

    $excel->getActiveSheet()->getStyle('C19')->getFont()->setSize(11); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('C19')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('A19:C19')->getFont()->setColor( $phpColor );


    $no = 1; // Untuk penomoran tabel, di awal set dengan 1
    $numrow = 21; // Set baris pertama untuk isi tabel adalah baris ke 4
    $totalqty = 0;
    foreach($detail as $data){ // Lakukan looping pada variabel siswa
      $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->name);
      $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->qty);
      $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data->price);
      $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data->total);
      // $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow++, " ");

        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        // $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
        // $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
        // $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
        // $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
        // $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('C'.$numrow.':I'.$numrow)->getFont()->setColor( $phpColor );
        $excel->getActiveSheet()->getStyle('G'.$numrow)->getNumberFormat()->setFormatCode('#,##');
        $excel->getActiveSheet()->getStyle('I'.$numrow)->getNumberFormat()->setFormatCode('#,##');
        $excel->getActiveSheet()->getStyle('E'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('G'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $no++; // Tambah 1 setiap kali looping
      $numrow++; // Tambah 1 setiap kali looping

      $totalqty=  $totalqty + $data->qty;
    }
    $baristo = $numrow+2;
    $excel->setActiveSheetIndex(0)->setCellValue('E'.$baristo, $totalqty);
    $excel->getActiveSheet()->getStyle('E'.$baristo)->getFont()->setColor( $phpColor );
    $excel->getActiveSheet()->getStyle('E'.$baristo)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $baris = $numrow+4;
    $b1 = $baris + 2;
    $b2 = $baris + 4;
    $b3 = $baris + 6;
    $b4 = $baris + 8;
    $b5 = $baris + 10;
    $excel->getActiveSheet()->getStyle('G'.$baris)->getFont()->setBold(TRUE);
    $excel->getActiveSheet()->getStyle('G'.$b1.':G'.$b4)->getFont()->setBold(TRUE);
    // $excel->getActiveSheet()->getStyle('G'.$b2)->getFont()->setBold(TRUE);
    $excel->setActiveSheetIndex(0)->setCellValue('G'.$baris, "Subtotal");
    $excel->setActiveSheetIndex(0)->setCellValue('G'.$b1, "Discount");
    $excel->setActiveSheetIndex(0)->setCellValue('G'.$b2, "Ongkos Kirim");
    $excel->setActiveSheetIndex(0)->setCellValue('G'.$b3, "Biaya Lainnya");
    $excel->setActiveSheetIndex(0)->setCellValue('G'.$b4, "TOTAL");
    $excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $excel->getActiveSheet()->getStyle('G'.$b1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $excel->getActiveSheet()->getStyle('G'.$b2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $excel->getActiveSheet()->getStyle('G'.$b3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $excel->getActiveSheet()->getStyle('G'.$b4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    foreach($sales as $data){}

    $excel->setActiveSheetIndex(0)->setCellValue('I'.$baris, $data->total_price);
    $excel->setActiveSheetIndex(0)->setCellValue('I'.$b1, $data->discount);
    $excel->setActiveSheetIndex(0)->setCellValue('I'.$b2, $data->ongkir);
    $excel->setActiveSheetIndex(0)->setCellValue('I'.$b3, $data->biaya_lain);
    $excel->setActiveSheetIndex(0)->setCellValue('I'.$b4, $data->final_price);
    $excel->getActiveSheet()->getStyle('I'.$baris)->getNumberFormat()->setFormatCode('#,##');
    $excel->getActiveSheet()->getStyle('I'.$b1)->getNumberFormat()->setFormatCode('#,##');
    $excel->getActiveSheet()->getStyle('I'.$b2)->getNumberFormat()->setFormatCode('#,##');
    $excel->getActiveSheet()->getStyle('I'.$b3)->getNumberFormat()->setFormatCode('#,##');
    $excel->getActiveSheet()->getStyle('I'.$b4)->getNumberFormat()->setFormatCode('#,##');

    $excel->getActiveSheet()->getStyle('I'.$baris.':I'.$b4)->getFont()->setColor( $phpColor );
    // $excel->setActiveSheetIndex(0)->setCellValue('G'.$barisqty, $data->jmlqty);

    // $sum = SUM($data->qty);
    // Set width kolom
    // Set Footer
    $b6 = $b5+1;
    $b7 = $b5+2;
    $b8 = $b5+4;
    $b9 = $b5+5;
    $b10 = $b5+6;
    $b11  = $b5+7;
    $b12  = $b5+8;
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b5, "PAY TO");
    $excel->getActiveSheet()->getStyle('A'.$b5)->getFont()->setSize(11); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('A'.$b5)->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b6, "MARIA MONICA");
    $excel->getActiveSheet()->getStyle('A'.$b6)->getFont()->setSize(11); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('A'.$b6)->getFont()->setColor( $phpColor );
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b7, "BCA/3423307460");
    $excel->getActiveSheet()->getStyle('A'.$b7)->getFont()->setSize(11); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('A'.$b7)->getFont()->setColor( $phpColor );
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b8, "NOTES");
    $excel->getActiveSheet()->getStyle('A'.$b8)->getFont()->setSize(11); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('A'.$b8)->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b9, "Payment should be paid in full no later than 14 calendar days after receiving this debit note.");
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b10, "Have a nice day and Thank you!");
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b11, "Love, Hamako");
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b12, "Hamako Apparel Indonesia @2018  | hamako.ecobabywear@gmail.com");
    $excel->getActiveSheet()->getStyle('A'.$b5.':A'.$b12)->getFont()->setColor( $phpColor );

    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(12); // Set width kolom A
    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(6); // Set width kolom B
    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(34); // Set width kolom C
    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(6); // Set width kolom D
    $excel->getActiveSheet()->getColumnDimension('E')->setWidth(9); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('F')->setWidth(6); // Set width kolom F
    $excel->getActiveSheet()->getColumnDimension('G')->setWidth(12); // Set width kolom G
    $excel->getActiveSheet()->getColumnDimension('H')->setWidth(6); // Set width kolom H
    $excel->getActiveSheet()->getColumnDimension('I')->setWidth(16); // Set width kolom I

    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
    // Set orientasi kertas jadi LANDSCAPE
    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    // Set judul file excel nya
    $excel->getActiveSheet(0)->setTitle("INVOICE");
    $excel->setActiveSheetIndex(0);
    // Proses file excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $date = date("dmyhis");
    header('Content-Disposition: attachment; filename="HAI-INVOICE"'.$date.'".xlsx"'); // Set nama file excel nya
    header('Cache-Control: max-age=0');
    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $write->save('php://output');
  }


  public function proforma($id_sale = null){
    // Load plugin PHPExcel nya
    include APPPATH.'third_party/PHPExcel/PHPExcel.php';

    // Panggil class PHPExcel nya
    $excel = new PHPExcel();
    // Settingan awal fil excel
    $excel->getProperties()->setCreator('Proforma Invoice')
                 ->setLastModifiedBy('Proforma Invoice')
                 ->setTitle("Proforma Invoice")
                 ->setSubject("Proforma Invoice")
                 ->setDescription("Laporan Proforma Invoice")
                 ->setKeywords("Proforma Invoice");
    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel

    $styleArray = array(
      'font'  => array(
           'name'  => 'Arial'
       ));
    $phpColor = new PHPExcel_Style_Color();
    $phpColor->setRGB('757171');

    $style_col = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      )

      // 'borders' => array(
      //   'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
      //   'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
      //   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
      //   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      // )
    );
    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $style_row = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    // Menambahkan file gambar pada document excel pada kolom B2
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('HAI');
    $objDrawing->setDescription('Logo HAI');
    $objDrawing->setPath('./assets/dist/img/hai.jpg');
    $objDrawing->setHeight(95);
    $objDrawing->setCoordinates('A1');
    $objDrawing->setWorksheet($excel->getActiveSheet());

    $excel->getDefaultStyle()->applyFromArray($styleArray);
    $excel->setActiveSheetIndex(0)->setCellValue('I1', "PT. HAMAKO APPAREL INDONESIA"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('I3', "www.hamakoecolife. com"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('I4', "www.babybudshop. com"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('I5', "+62811 242 625 6"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('I8', "PROFORMA INVOICE"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('I10', "PI NUMBER"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('A10', "RECIPIENT"); // Set kolom A1 dengan tulisan "DATA SISWA"
    // $excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('I8')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('I8')->getFont()->setSize(18); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('I10')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('I10')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('A10')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('A10')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('I3:I5')->getFont()->setColor( $phpColor );
    $excel->getActiveSheet()->getStyle('I1:I11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); // Set text center untuk kolom A1

    // Buat header tabel nya pada baris ke 3
    $excel->setActiveSheetIndex(0)->setCellValue('A17', "PI DATE"); // Set kolom A3 dengan tulisan "NO"
    $excel->setActiveSheetIndex(0)->setCellValue('C17', "ITEM"); // Set kolom B3 dengan tulisan "NIS"
    $excel->setActiveSheetIndex(0)->setCellValue('E17', "QTY"); // Set kolom C3 dengan tulisan "NAMA"
    $excel->setActiveSheetIndex(0)->setCellValue('G17', "PRICE"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
    $excel->setActiveSheetIndex(0)->setCellValue('I17', "AMOUNT"); // Set kolom E3 dengan tulisan "ALAMAT"
    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    $excel->getActiveSheet()->getStyle('A17')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('C17')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('E17')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('G17')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('I17')->applyFromArray($style_col);

    // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
    $sales  = $this->M_sales->get_sales($id_sale)->result();
    $detail = $this->M_sales->get_sales_detail($id_sale)->result();
    $sumqty = $this->M_sales->get_sum_sales($id_sale)->result();

    foreach($sales as $data){ }
    $excel->setActiveSheetIndex(0)->setCellValue('I11', $data->invoice);
    $excel->setActiveSheetIndex(0)->setCellValue('A12', $data->customername);
    $excel->setActiveSheetIndex(0)->setCellValue('A13', $data->alamat);
    $excel->setActiveSheetIndex(0)->setCellValue('A14', $data->tlp);

    $excel->getActiveSheet()->getStyle('I11')->getFont()->setColor( $phpColor );
    $excel->getActiveSheet()->getStyle('A12:A14')->getFont()->setColor( $phpColor );

    $excel->setActiveSheetIndex(0)->setCellValue('A19', $data->date);
    $excel->setActiveSheetIndex(0)->setCellValue('C19', "HAMAKO");

    $excel->getActiveSheet()->getStyle('C19')->getFont()->setSize(11); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('C19')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('A19:C19')->getFont()->setColor( $phpColor );


    $no = 1; // Untuk penomoran tabel, di awal set dengan 1
    $numrow = 21; // Set baris pertama untuk isi tabel adalah baris ke 4
    $totalqty = 0;
    foreach($detail as $data){ // Lakukan looping pada variabel siswa
      $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->name);
      $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->qty);
      $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data->price);
      $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data->total);
      // $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow++, " ");

        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        // $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
        // $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
        // $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
        // $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
        // $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('C'.$numrow.':I'.$numrow)->getFont()->setColor( $phpColor );
        $excel->getActiveSheet()->getStyle('G'.$numrow)->getNumberFormat()->setFormatCode('#,##');
        $excel->getActiveSheet()->getStyle('I'.$numrow)->getNumberFormat()->setFormatCode('#,##');
        $excel->getActiveSheet()->getStyle('E'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('G'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $no++; // Tambah 1 setiap kali looping
      $numrow++; // Tambah 1 setiap kali looping

      $totalqty=  $totalqty + $data->qty;
    }

    $baristo = $numrow+2;
    $excel->setActiveSheetIndex(0)->setCellValue('E'.$baristo, $totalqty);
    $excel->getActiveSheet()->getStyle('E'.$baristo)->getFont()->setColor( $phpColor );
    $excel->getActiveSheet()->getStyle('E'.$baristo)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $baris = $numrow+4;
    $b1 = $baris + 2;
    $b2 = $baris + 4;
    $b3 = $baris + 6;
    $b4 = $baris + 8;
    $b5 = $baris + 10;
    $excel->getActiveSheet()->getStyle('G'.$baris)->getFont()->setBold(TRUE);
    $excel->getActiveSheet()->getStyle('G'.$b1.':G'.$b4)->getFont()->setBold(TRUE);
    // $excel->getActiveSheet()->getStyle('G'.$b2)->getFont()->setBold(TRUE);
    $excel->setActiveSheetIndex(0)->setCellValue('G'.$baris, "Subtotal");
    $excel->setActiveSheetIndex(0)->setCellValue('G'.$b1, "Discount");
    $excel->setActiveSheetIndex(0)->setCellValue('G'.$b2, "Ongkos Kirim");
    $excel->setActiveSheetIndex(0)->setCellValue('G'.$b3, "Biaya Lainnya");
    $excel->setActiveSheetIndex(0)->setCellValue('G'.$b4, "TOTAL");
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b4, "Confirmed By");
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b5, "......................");
    foreach($sales as $data){ }
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b5,$data->customername);
    $excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $excel->getActiveSheet()->getStyle('G'.$b1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $excel->getActiveSheet()->getStyle('G'.$b2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $excel->getActiveSheet()->getStyle('G'.$b3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $excel->getActiveSheet()->getStyle('G'.$b4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    foreach($sales as $data){}

    $excel->setActiveSheetIndex(0)->setCellValue('I'.$baris, $data->total_price);
    $excel->setActiveSheetIndex(0)->setCellValue('I'.$b1, $data->discount);
    $excel->setActiveSheetIndex(0)->setCellValue('I'.$b2, $data->ongkir);
    $excel->setActiveSheetIndex(0)->setCellValue('I'.$b3, $data->biaya_lain);
    $excel->setActiveSheetIndex(0)->setCellValue('I'.$b4, $data->final_price);
    $excel->getActiveSheet()->getStyle('I'.$baris)->getNumberFormat()->setFormatCode('#,##');
    $excel->getActiveSheet()->getStyle('I'.$b1)->getNumberFormat()->setFormatCode('#,##');
    $excel->getActiveSheet()->getStyle('I'.$b2)->getNumberFormat()->setFormatCode('#,##');
    $excel->getActiveSheet()->getStyle('I'.$b3)->getNumberFormat()->setFormatCode('#,##');
    $excel->getActiveSheet()->getStyle('I'.$b4)->getNumberFormat()->setFormatCode('#,##');

    $excel->getActiveSheet()->getStyle('I'.$baris.':I'.$b4)->getFont()->setColor( $phpColor );
    // $excel->setActiveSheetIndex(0)->setCellValue('G'.$barisqty, $data->jmlqty);

    $b6 = $b4+8;
    $b7 = $b4+9;
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b6, "NOTES");
    $excel->getActiveSheet()->getStyle('A'.$b6)->getFont()->setSize(11); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('A'.$b6)->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b7, "This is not an invoice. Please sign this proforma invoice and send it back to us to confirm your order.");
    $excel->getActiveSheet()->getStyle('A'.$b7)->getFont()->setColor( $phpColor );

    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(12); // Set width kolom A
    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(6); // Set width kolom B
    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(34); // Set width kolom C
    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(6); // Set width kolom D
    $excel->getActiveSheet()->getColumnDimension('E')->setWidth(9); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('F')->setWidth(6); // Set width kolom F
    $excel->getActiveSheet()->getColumnDimension('G')->setWidth(12); // Set width kolom G
    $excel->getActiveSheet()->getColumnDimension('H')->setWidth(6); // Set width kolom H
    $excel->getActiveSheet()->getColumnDimension('I')->setWidth(16); // Set width kolom I

    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
    // Set orientasi kertas jadi LANDSCAPE
    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    // Set judul file excel nya
    $excel->getActiveSheet(0)->setTitle("PROFORMA INVOICE");
    $excel->setActiveSheetIndex(0);
    // Proses file excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $date = date("dmyhis");
    header('Content-Disposition: attachment; filename="HAI-PI"'.$date.'".xlsx"'); // Set nama file excel nya
    header('Cache-Control: max-age=0');
    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $write->save('php://output');
  }

  public function del_order($id_sale = null){
    // Load plugin PHPExcel nya
    include APPPATH.'third_party/PHPExcel/PHPExcel.php';

    // Panggil class PHPExcel nya
    $excel = new PHPExcel();
    // Settingan awal fil excel
    $excel->getProperties()->setCreator('Delivery Order')
                 ->setLastModifiedBy('Delivery Order')
                 ->setTitle("Delivery Order")
                 ->setSubject("Delivery Order")
                 ->setDescription("Laporan Delivery Order")
                 ->setKeywords("Delivery Order");
    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel

    $styleArray = array(
      'font'  => array(
           'name'  => 'Arial'
       ));
    $phpColor = new PHPExcel_Style_Color();
    $phpColor->setRGB('757171');

    $style_col = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      )

      // 'borders' => array(
      //   'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
      //   'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
      //   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
      //   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      // )
    );
    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $style_row = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    // Menambahkan file gambar pada document excel pada kolom B2
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('HAI');
    $objDrawing->setDescription('Logo HAI');
    $objDrawing->setPath('./assets/dist/img/hai.jpg');
    $objDrawing->setHeight(95);
    $objDrawing->setCoordinates('A1');
    $objDrawing->setWorksheet($excel->getActiveSheet());

    $excel->getDefaultStyle()->applyFromArray($styleArray);
    $excel->setActiveSheetIndex(0)->setCellValue('I1', "PT. HAMAKO APPAREL INDONESIA"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('I3', "www.hamakoecolife. com"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('I4', "www.babybudshop. com"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('I5', "+62811 242 625 6"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('I8', "DELIVERY ORDER"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('I10', "DO NUMBER"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('A10', "RECIPIENT"); // Set kolom A1 dengan tulisan "DATA SISWA"
    // $excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('I8')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('I8')->getFont()->setSize(18); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('I10')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('I10')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('A10')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('A10')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('I3:I5')->getFont()->setColor( $phpColor );
    $excel->getActiveSheet()->getStyle('I1:I11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); // Set text center untuk kolom A1

    // Buat header tabel nya pada baris ke 3
    $excel->setActiveSheetIndex(0)->setCellValue('A17', "DO DATE"); // Set kolom A3 dengan tulisan "NO"
    $excel->setActiveSheetIndex(0)->setCellValue('C17', "ITEM"); // Set kolom B3 dengan tulisan "NIS"
    $excel->setActiveSheetIndex(0)->setCellValue('E17', "ITEM CODE"); // Set kolom C3 dengan tulisan "NAMA"
    $excel->setActiveSheetIndex(0)->setCellValue('G17', "QTY"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
    $excel->setActiveSheetIndex(0)->setCellValue('I17', "COMMENT"); // Set kolom E3 dengan tulisan "ALAMAT"
    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    $excel->getActiveSheet()->getStyle('A17')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('C17')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('E17')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('G17')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('I17')->applyFromArray($style_col);

    // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
    $sales  = $this->M_sales->get_sales($id_sale)->result();
    $detail = $this->M_sales->get_sales_detail($id_sale)->result();
    $sumqty = $this->M_sales->get_sum_sales($id_sale)->result();

    foreach($sales as $data){ }
    $excel->setActiveSheetIndex(0)->setCellValue('I11', $data->invoice);
    $excel->setActiveSheetIndex(0)->setCellValue('A12', $data->customername);
    $excel->setActiveSheetIndex(0)->setCellValue('A13', $data->alamat);
    $excel->setActiveSheetIndex(0)->setCellValue('A14', $data->tlp);

    $excel->getActiveSheet()->getStyle('I11')->getFont()->setColor( $phpColor );
    $excel->getActiveSheet()->getStyle('A12:A14')->getFont()->setColor( $phpColor );

    $excel->setActiveSheetIndex(0)->setCellValue('A19', $data->date);
    $excel->setActiveSheetIndex(0)->setCellValue('C19', "HAMAKO");

    $excel->getActiveSheet()->getStyle('C19')->getFont()->setSize(11); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('C19')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('A19:C19')->getFont()->setColor( $phpColor );


    $no = 1; // Untuk penomoran tabel, di awal set dengan 1
    $numrow = 21; // Set baris pertama untuk isi tabel adalah baris ke 4
    $totalqty = 0;
    foreach($detail as $data){ // Lakukan looping pada variabel siswa
      $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->name);
      $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->barcode);
      $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data->qty);
      // $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow++, " ");

        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        // $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
        // $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
        // $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
        // $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
        // $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('C'.$numrow.':I'.$numrow)->getFont()->setColor( $phpColor );
        $excel->getActiveSheet()->getStyle('G'.$numrow)->getNumberFormat()->setFormatCode('#,##');
        $excel->getActiveSheet()->getStyle('I'.$numrow)->getNumberFormat()->setFormatCode('#,##');
        $excel->getActiveSheet()->getStyle('E'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('G'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $no++; // Tambah 1 setiap kali looping
      $numrow++; // Tambah 1 setiap kali looping

      $totalqty=  $totalqty + $data->qty;
    }
    $baristo = $numrow+2;
    $excel->setActiveSheetIndex(0)->setCellValue('G'.$baristo, $totalqty);
    $excel->getActiveSheet()->getStyle('G'.$baristo)->getFont()->setColor( $phpColor );
    $excel->getActiveSheet()->getStyle('G'.$baristo)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $excel->setActiveSheetIndex(0)->setCellValue('E'.$baristo, "Total");
    $excel->getActiveSheet()->getStyle('E'.$baristo)->getFont()->setBold(TRUE);
    $excel->getActiveSheet()->getStyle('G'.$baristo)->getFont()->setBold(TRUE);
    $excel->getActiveSheet()->getStyle('E'.$baristo)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $baris = $numrow+4;
    $b1 = $baris + 2;
    $b2 = $baris + 7;
    $b3 = $b2 + 1;
    $excel->setActiveSheetIndex(0)->setCellValue('I'.$b1, "RECEIVED BY");
    $excel->getActiveSheet()->getStyle('I'.$b1)->getFont()->setBold(TRUE);
    $excel->setActiveSheetIndex(0)->setCellValue('I'.$b2, "Name:");
    $excel->setActiveSheetIndex(0)->setCellValue('I'.$b3, "Date:");

    $excel->getActiveSheet()->getStyle('I'.$b2)->getFont()->setColor( $phpColor );
    $excel->getActiveSheet()->getStyle('I'.$b3)->getFont()->setColor( $phpColor );

    $b4 = $b3+1;
    $b5 = $b3+2;
    $b6 = $b3+4;
    $b7 = $b3+5;
    $b8 = $b3+6;
    $b9 = $b3+7;
    $b10 = $b3+8;
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b4, "NOTE");
    $excel->getActiveSheet()->getStyle('A'.$b4)->getFont()->setSize(11); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('A'.$b4)->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b5, "Please always check the item with our DO. Any enquires, please contact us via WA  at +62811 242 625 6 ");
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b6, "Have a nice day and Thank you!");
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b7, "Love, Hamako");
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$b8, "Hamako Apparel Indonesia @2018  | hamako.ecobabywear@gmail.com");
    $excel->getActiveSheet()->getStyle('A'.$b5.':A'.$b9)->getFont()->setColor( $phpColor );

    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(12); // Set width kolom A
    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(6); // Set width kolom B
    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(34); // Set width kolom C
    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(6); // Set width kolom D
    $excel->getActiveSheet()->getColumnDimension('E')->setWidth(9); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('F')->setWidth(6); // Set width kolom F
    $excel->getActiveSheet()->getColumnDimension('G')->setWidth(12); // Set width kolom G
    $excel->getActiveSheet()->getColumnDimension('H')->setWidth(6); // Set width kolom H
    $excel->getActiveSheet()->getColumnDimension('I')->setWidth(16); // Set width kolom I

    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
    // Set orientasi kertas jadi LANDSCAPE
    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    // Set judul file excel nya
    $excel->getActiveSheet(0)->setTitle("Debit Note");
    $excel->setActiveSheetIndex(0);
    // Proses file excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $date = date("dmyhis");
    header('Content-Disposition: attachment; filename="HAI-DeliveryOrder"'.$date.'".xlsx"'); // Set nama file excel nya
    header('Cache-Control: max-age=0');
    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $write->save('php://output');
  }



  // Filter By Tanggal dan Jobref

  public function export_sales($id_sale = null){
      // Load plugin PHPExcel nya
    include APPPATH.'third_party/PHPExcel/PHPExcel.php';

    // Panggil class PHPExcel nya
    $excel = new PHPExcel();
    // Settingan awal fil excel
    $excel->getProperties()->setCreator('Sales')
                 ->setLastModifiedBy('Sales')
                 ->setTitle("Sales")
                 ->setSubject("Sales")
                 ->setDescription("Laporan Sales")
                 ->setKeywords("Sales");
    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel

    $styleArray = array(
      'font'  => array(
           'name'  => 'Arial'
       ));
    $phpColor = new PHPExcel_Style_Color();
    $phpColor->setRGB('757171');

    $style_col = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );

    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $style_row = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    // Menambahkan file gambar pada document excel pada kolom B2
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('HAI');
    $objDrawing->setDescription('Logo HAI');
    $objDrawing->setPath('./assets/dist/img/hai.jpg');
    $objDrawing->setHeight(70);
    $objDrawing->setCoordinates('A1');
    $objDrawing->setWorksheet($excel->getActiveSheet());

    $excel->getDefaultStyle()->applyFromArray($styleArray);
    $excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN PENJUALAN HAI");
    $excel->getActiveSheet()->mergeCells('A1:H2');
    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
    $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
    $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

    // Buat header tabel nya pada baris ke 3
    $excel->setActiveSheetIndex(0)->setCellValue('A5', "NO");
    $excel->setActiveSheetIndex(0)->setCellValue('B5', "DATE ORDER");
    $excel->setActiveSheetIndex(0)->setCellValue('C5', "INVOICE");
    $excel->setActiveSheetIndex(0)->setCellValue('D5', "CUSTOMER");
    $excel->setActiveSheetIndex(0)->setCellValue('E5', "REF");
    $excel->setActiveSheetIndex(0)->setCellValue('F5', "BARCODE");
    $excel->setActiveSheetIndex(0)->setCellValue('G5', "NAME PRODUCT");
    $excel->setActiveSheetIndex(0)->setCellValue('H5', "PRICE");
    $excel->setActiveSheetIndex(0)->setCellValue('I5', "QTY");
    $excel->setActiveSheetIndex(0)->setCellValue('J5', "DISCOUNT ITEM");
    $excel->setActiveSheetIndex(0)->setCellValue('K5', "DISCOUNT");
    $excel->setActiveSheetIndex(0)->setCellValue('L5', "NOTE");
    $excel->setActiveSheetIndex(0)->setCellValue('M5', "TOTAL");

    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('H5')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('I5')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('J5')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('K5')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('L5')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('M5')->applyFromArray($style_col);


    $sales      = $this->M_sales->get_sales_bydate2()->result();
    $discount   = $this->M_sales->get_sum()->result();
    $final      = $this->M_sales->get_sum_final()->result();
    $no = 1; // Untuk penomoran tabel, di awal set dengan 1
    $numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 4
    $totalqty = 0;
    foreach($sales as $data){ // Lakukan looping pada variabel siswa
      $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
      $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->date);
      $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->invoice);
      $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->name_customer);
      $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->nama_jobref);
      $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data->barcode);
      $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data->name);
      $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data->price);
      $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data->qty);
      $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data->discount_item);
      $excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data->discount);
      $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $data->note);
      $excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, ($data->price*$data->qty)-$data->discount_item);

      // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
      $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);

      $excel->getActiveSheet()->getStyle('H'.$numrow)->getNumberFormat()->setFormatCode('#,##');
      $excel->getActiveSheet()->getStyle('M'.$numrow)->getNumberFormat()->setFormatCode('#,##');
      $excel->getActiveSheet()->getStyle('J'.$numrow)->getNumberFormat()->setFormatCode('#,##');
      $excel->getActiveSheet()->getStyle('K'.$numrow)->getNumberFormat()->setFormatCode('#,##');


      $no++; // Tambah 1 setiap kali looping
      $numrow++; // Tambah 1 setiap kali looping

      $totalqty=  $totalqty + $data->qty;
    }
    $baristo = $numrow+1;
    $excel->setActiveSheetIndex(0)->setCellValue('I'.$baristo, $totalqty);
    $excel->getActiveSheet()->getStyle('I'.$baristo)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    foreach($discount as $data){
      $excel->setActiveSheetIndex(0)->setCellValue('J'.$baristo, $data->discount_item);
      $excel->setActiveSheetIndex(0)->setCellValue('L'.$baristo, $data->total);

      $excel->getActiveSheet()->getStyle('J'.$baristo)->getNumberFormat()->setFormatCode('#,##');
      $excel->getActiveSheet()->getStyle('L'.$baristo)->getNumberFormat()->setFormatCode('#,##');
    }
    $baris = $numrow+1;
    $b1 = $numrow+2;
    $b2 = $numrow+3;
    $excel->setActiveSheetIndex(0)->setCellValue('L'.$baris, "Subtotal");
    $excel->setActiveSheetIndex(0)->setCellValue('L'.$b1, "Discount");
    $excel->setActiveSheetIndex(0)->setCellValue('L'.$b2, "TOTAL");
    $excel->getActiveSheet()->getStyle('L'.$baris)->getFont()->setBold(TRUE);
    $excel->getActiveSheet()->getStyle('L'.$b1)->getFont()->setBold(TRUE);
    $excel->getActiveSheet()->getStyle('L'.$b2)->getFont()->setBold(TRUE);
    $excel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $excel->getActiveSheet()->getStyle('L'.$b1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $excel->getActiveSheet()->getStyle('L'.$b2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    foreach($final as $data){
      $excel->setActiveSheetIndex(0)->setCellValue('M'.$b1, $data->discount);
      $excel->setActiveSheetIndex(0)->setCellValue('M'.$b2, $data->final);

      $excel->getActiveSheet()->getStyle('M'.$b1)->getNumberFormat()->setFormatCode('#,##');
      $excel->getActiveSheet()->getStyle('M'.$b2)->getNumberFormat()->setFormatCode('#,##');
    }


    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(6); // Set width kolom A
    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(12); // Set width kolom B
    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(12); // Set width kolom C
    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(12); // Set width kolom D
    $excel->getActiveSheet()->getColumnDimension('E')->setWidth(12); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('F')->setWidth(12); // Set width kolom F
    $excel->getActiveSheet()->getColumnDimension('G')->setWidth(30); // Set width kolom G
    $excel->getActiveSheet()->getColumnDimension('H')->setWidth(12); // Set width kolom H
    $excel->getActiveSheet()->getColumnDimension('I')->setWidth(6); // Set width kolom H
    $excel->getActiveSheet()->getColumnDimension('J')->setWidth(12); // Set width kolom H\
    $excel->getActiveSheet()->getColumnDimension('K')->setWidth(12); // Set width kolom H

    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
    // Set orientasi kertas jadi LANDSCAPE
    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    // Set judul file excel nya
    $excel->getActiveSheet(0)->setTitle("Laporan Penjualan");
    $excel->setActiveSheetIndex(0);
    // Proses file excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $date = date("dmyhis");
    header('Content-Disposition: attachment; filename="Laporan Penjualan"'.$date.'".xlsx"'); // Set nama file excel nya
    header('Cache-Control: max-age=0');
    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $write->save('php://output');
  }

  public function export_item(){
    // Load plugin PHPExcel nya
  include APPPATH.'third_party/PHPExcel/PHPExcel.php';

  // Panggil class PHPExcel nya
  $excel = new PHPExcel();
  // Settingan awal fil excel
  $excel->getProperties()->setCreator('Item')
               ->setLastModifiedBy('Item')
               ->setTitle("Item")
               ->setSubject("Item")
               ->setDescription("Laporan Item")
               ->setKeywords("Item");
  // Buat sebuah variabel untuk menampung pengaturan style dari header tabel

  $styleArray = array(
    'font'  => array(
         'name'  => 'Arial'
     ));
  $phpColor = new PHPExcel_Style_Color();
  $phpColor->setRGB('757171');

  $style_col = array(
    'font' => array('bold' => true), // Set font nya jadi bold
    'alignment' => array(
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ),
    'borders' => array(
      'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
      'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
      'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
      'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    )
  );

  // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
  $style_row = array(
    'alignment' => array(
      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ),
    'borders' => array(
      'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
      'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
      'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
      'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    )
  );
  // Menambahkan file gambar pada document excel pada kolom B2
  $objDrawing = new PHPExcel_Worksheet_Drawing();
  $objDrawing->setName('HAI');
  $objDrawing->setDescription('Logo HAI');
  $objDrawing->setPath('./assets/dist/img/hai.jpg');
  $objDrawing->setHeight(70);
  $objDrawing->setCoordinates('A1');
  $objDrawing->setWorksheet($excel->getActiveSheet());

  $excel->getDefaultStyle()->applyFromArray($styleArray);
  $excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN STOK HAI");
  $excel->getActiveSheet()->mergeCells('A1:I2');
  $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
  $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
  $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

  // Buat header tabel nya pada baris ke 3
  $excel->setActiveSheetIndex(0)->setCellValue('A5', "NO");
  $excel->setActiveSheetIndex(0)->setCellValue('B5', "BARCODE");
  $excel->setActiveSheetIndex(0)->setCellValue('C5', "NAMA");
  $excel->setActiveSheetIndex(0)->setCellValue('D5', "JENIS");
  $excel->setActiveSheetIndex(0)->setCellValue('E5', "MERK");
  $excel->setActiveSheetIndex(0)->setCellValue('F5', "HPP");
  $excel->setActiveSheetIndex(0)->setCellValue('G5', "FOB");
  $excel->setActiveSheetIndex(0)->setCellValue('H5', "KOLEKSI");
  $excel->setActiveSheetIndex(0)->setCellValue('I5', "STOK");

  // Apply style header yang telah kita buat tadi ke masing-masing kolom header
  $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('H5')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('I5')->applyFromArray($style_col);
  $merk = $this->input->post('merk');
  $item = $this->M_item->getbyfilter($merk)->result();

  $no = 1; // Untuk penomoran tabel, di awal set dengan 1
  $numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 4

  foreach($item as $data){ // Lakukan looping pada variabel siswa
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
    $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->barcode);
    $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->name);
    $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->name_jenis);
    $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->name_merk);
    $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data->hpp);
    $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data->fob);
    $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data->name_koleksi);
    $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data->stock);

    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
    $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('F'.$numrow)->getNumberFormat()->setFormatCode('#,##');
    $excel->getActiveSheet()->getStyle('G'.$numrow)->getNumberFormat()->setFormatCode('#,##');


    $no++; // Tambah 1 setiap kali looping
    $numrow++; // Tambah 1 setiap kali looping

  }

  $excel->getActiveSheet()->getColumnDimension('A')->setWidth(6); // Set width kolom A
  $excel->getActiveSheet()->getColumnDimension('B')->setWidth(12); // Set width kolom B
  $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30); // Set width kolom C
  $excel->getActiveSheet()->getColumnDimension('D')->setWidth(12); // Set width kolom D
  $excel->getActiveSheet()->getColumnDimension('E')->setWidth(12); // Set width kolom E
  $excel->getActiveSheet()->getColumnDimension('F')->setWidth(12); // Set width kolom F
  $excel->getActiveSheet()->getColumnDimension('G')->setWidth(12); // Set width kolom G
  $excel->getActiveSheet()->getColumnDimension('H')->setWidth(12); // Set width kolom H
  $excel->getActiveSheet()->getColumnDimension('I')->setWidth(12); // Set width kolom H

  // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
  $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
  // Set orientasi kertas jadi LANDSCAPE
  $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
  // Set judul file excel nya
  $excel->getActiveSheet(0)->setTitle("Laporan Penjualan");
  $excel->setActiveSheetIndex(0);
  // Proses file excel
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  $date = date("dmyhis");
  header('Content-Disposition: attachment; filename="Laporan Stok"'.$date.'".xlsx"'); // Set nama file excel nya
  header('Cache-Control: max-age=0');
  $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
  $write->save('php://output');
}

public function report_barang_masuk($id_bm = null){
  // Load plugin PHPExcel nya
include APPPATH.'third_party/PHPExcel/PHPExcel.php';

// Panggil class PHPExcel nya
$excel = new PHPExcel();
// Settingan awal fil excel
$excel->getProperties()->setCreator('Barang Masuk')
             ->setLastModifiedBy('Barang Masuk')
             ->setTitle("Barang Masuk")
             ->setSubject("Barang Masuk")
             ->setDescription("Laporan Barang Masuk")
             ->setKeywords("Barang Masuk");
// Buat sebuah variabel untuk menampung pengaturan style dari header tabel

$styleArray = array(
  'font'  => array(
       'name'  => 'Arial'
   ));
$phpColor = new PHPExcel_Style_Color();
$phpColor->setRGB('757171');

$style_col = array(
  'font' => array('bold' => true), // Set font nya jadi bold
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
  ),
  'borders' => array(
    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
  )
);

// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
$style_row = array(
  'alignment' => array(
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
  ),
  'borders' => array(
    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
  )
);
// Menambahkan file gambar pada document excel pada kolom B2
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('HAI');
$objDrawing->setDescription('Logo HAI');
$objDrawing->setPath('./assets/dist/img/hai.jpg');
$objDrawing->setHeight(70);
$objDrawing->setCoordinates('A1');
$objDrawing->setWorksheet($excel->getActiveSheet());

$excel->getDefaultStyle()->applyFromArray($styleArray);
$excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN BARANG MASUK");
$excel->getActiveSheet()->mergeCells('A1:D3');
$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

$excel->setActiveSheetIndex(0)->setCellValue('A5', "No PO : ");
$excel->setActiveSheetIndex(0)->setCellValue('A6', "No SJ : ");
$excel->setActiveSheetIndex(0)->setCellValue('A7', "Supplier : ");
$excel->getActiveSheet()->getStyle('A5:A7')->getFont()->setBold(TRUE);
$bm = $this->M_stockin->get_bm($id_bm)->result();
foreach($bm as $topbm){}
$excel->setActiveSheetIndex(0)->setCellValue('B5', $topbm->no_po);
$excel->setActiveSheetIndex(0)->setCellValue('B6', $topbm->surat_jalan);
$excel->setActiveSheetIndex(0)->setCellValue('B7', $topbm->name_supplier);
// Buat header tabel nya pada baris ke 3
$excel->setActiveSheetIndex(0)->setCellValue('A9', "NO");
$excel->setActiveSheetIndex(0)->setCellValue('B9', "BARCODE");
$excel->setActiveSheetIndex(0)->setCellValue('C9', "NAME PRODUCT");
$excel->setActiveSheetIndex(0)->setCellValue('D9', "QTY");
// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$excel->getActiveSheet()->getStyle('A9')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('B9')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('C9')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('D9')->applyFromArray($style_col);


$dbm     = $this->M_stockin->get_bm_detail($id_bm)->result();
$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$numrow = 10; // Set baris pertama untuk isi tabel adalah baris ke 4

foreach($dbm as $data){ // Lakukan looping pada variabel siswa
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
  $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->barcode);
  $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->name);
  $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->qty);

  // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
  $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);


  $no++; // Tambah 1 setiap kali looping
  $numrow++; // Tambah 1 setiap kali looping
}
// $baristo = $numrow+1;
// $excel->setActiveSheetIndex(0)->setCellValue('I'.$baristo, $totalqty);
// $excel->getActiveSheet()->getStyle('I'.$baristo)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// foreach($discount as $data){
//   $excel->setActiveSheetIndex(0)->setCellValue('J'.$baristo, $data->discount_item);
//   $excel->setActiveSheetIndex(0)->setCellValue('L'.$baristo, $data->total);

//   $excel->getActiveSheet()->getStyle('J'.$baristo)->getNumberFormat()->setFormatCode('#,##');
//   $excel->getActiveSheet()->getStyle('L'.$baristo)->getNumberFormat()->setFormatCode('#,##');
// }
// $baris = $numrow+1;
// $b1 = $numrow+2;
// $b2 = $numrow+3;
// $excel->setActiveSheetIndex(0)->setCellValue('L'.$baris, "Subtotal");
// $excel->setActiveSheetIndex(0)->setCellValue('L'.$b1, "Discount");
// $excel->setActiveSheetIndex(0)->setCellValue('L'.$b2, "TOTAL");
// $excel->getActiveSheet()->getStyle('L'.$baris)->getFont()->setBold(TRUE);
// $excel->getActiveSheet()->getStyle('L'.$b1)->getFont()->setBold(TRUE);
// $excel->getActiveSheet()->getStyle('L'.$b2)->getFont()->setBold(TRUE);
// $excel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// $excel->getActiveSheet()->getStyle('L'.$b1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// $excel->getActiveSheet()->getStyle('L'.$b2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

// foreach($final as $data){
//   $excel->setActiveSheetIndex(0)->setCellValue('M'.$b1, $data->discount);
//   $excel->setActiveSheetIndex(0)->setCellValue('M'.$b2, $data->final);

//   $excel->getActiveSheet()->getStyle('M'.$b1)->getNumberFormat()->setFormatCode('#,##');
//   $excel->getActiveSheet()->getStyle('M'.$b2)->getNumberFormat()->setFormatCode('#,##');
// }


$excel->getActiveSheet()->getColumnDimension('A')->setWidth(10); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(12); // Set width kolom D

// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
// Set orientasi kertas jadi LANDSCAPE
$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
// Set judul file excel nya
$excel->getActiveSheet(0)->setTitle("Laporan Barang Masuk");
$excel->setActiveSheetIndex(0);
// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
$date = date("dmyhis");
$sj = $topbm->surat_jalan;
header('Content-Disposition: attachment; filename="Laporan Barang Masuk/"'.$sj.'"/"'.$date.'".xlsx"'); // Set nama file excel nya
header('Cache-Control: max-age=0');
$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$write->save('php://output');
}



public function export_acc($id_sale = null){
  // Load plugin PHPExcel nya
  include APPPATH.'third_party/PHPExcel/PHPExcel.php';

  // Panggil class PHPExcel nya
  $excel = new PHPExcel();
  // Settingan awal fil excel
  $excel->getProperties()->setCreator('Invoice')
               ->setLastModifiedBy('Invoice')
               ->setTitle("Invoice")
               ->setSubject("Invoice")
               ->setDescription("Laporan Invoice")
               ->setKeywords("Invoice");
  // Buat sebuah variabel untuk menampung pengaturan style dari header tabel

  $styleArray = array(
    'font'  => array(
         'name'  => 'Arial'
     ));
  $phpColor = new PHPExcel_Style_Color();
  $phpColor->setRGB('757171');

  $style_col = array(
    'font' => array('bold' => true), // Set font nya jadi bold
    'alignment' => array(
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    )

    // 'borders' => array(
    //   'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
    //   'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
    //   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
    //   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    // )
  );
  // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
  $style_row = array(
    'alignment' => array(
      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ),
    'borders' => array(
      'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
      'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
      'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
      'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    )
  );
  // Menambahkan file gambar pada document excel pada kolom B2
  $objDrawing = new PHPExcel_Worksheet_Drawing();
  $objDrawing->setName('HAI');
  $objDrawing->setDescription('Logo HAI');
  $objDrawing->setPath('./assets/dist/img/hai.jpg');
  $objDrawing->setHeight(95);
  $objDrawing->setCoordinates('A1');
  $objDrawing->setWorksheet($excel->getActiveSheet());

  $excel->getDefaultStyle()->applyFromArray($styleArray);
  $excel->setActiveSheetIndex(0)->setCellValue('I1', "PT. HAMAKO APPAREL INDONESIA"); // Set kolom A1 dengan tulisan "DATA SISWA"
  $excel->setActiveSheetIndex(0)->setCellValue('I3', "www.hamakoecolife.com"); // Set kolom A1 dengan tulisan "DATA SISWA"
  $excel->setActiveSheetIndex(0)->setCellValue('I4', "www.babybudshop.com"); // Set kolom A1 dengan tulisan "DATA SISWA"
  $excel->setActiveSheetIndex(0)->setCellValue('I5', "+62811 242 625 6"); // Set kolom A1 dengan tulisan "DATA SISWA"
  $excel->setActiveSheetIndex(0)->setCellValue('I8', "INVOICE"); // Set kolom A1 dengan tulisan "DATA SISWA"
  $excel->setActiveSheetIndex(0)->setCellValue('I10', "INV NUMBER"); // Set kolom A1 dengan tulisan "DATA SISWA"
  $excel->setActiveSheetIndex(0)->setCellValue('A10', "RECIPIENT"); // Set kolom A1 dengan tulisan "DATA SISWA"
  // $excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
  $excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(TRUE); // Set bold kolom A1
  $excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
  $excel->getActiveSheet()->getStyle('I8')->getFont()->setBold(TRUE); // Set bold kolom A1
  $excel->getActiveSheet()->getStyle('I8')->getFont()->setSize(18); // Set font size 15 untuk kolom A1
  $excel->getActiveSheet()->getStyle('I10')->getFont()->setBold(TRUE); // Set bold kolom A1
  $excel->getActiveSheet()->getStyle('I10')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
  $excel->getActiveSheet()->getStyle('A10')->getFont()->setBold(TRUE); // Set bold kolom A1
  $excel->getActiveSheet()->getStyle('A10')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
  $excel->getActiveSheet()->getStyle('I3:I5')->getFont()->setColor( $phpColor );
  $excel->getActiveSheet()->getStyle('I1:I11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); // Set text center untuk kolom A1

  // Buat header tabel nya pada baris ke 3
  $excel->setActiveSheetIndex(0)->setCellValue('A17', "INV DATE"); // Set kolom A3 dengan tulisan "NO"
  $excel->setActiveSheetIndex(0)->setCellValue('C17', "ITEM"); // Set kolom B3 dengan tulisan "NIS"
  $excel->setActiveSheetIndex(0)->setCellValue('E17', "QTY"); // Set kolom C3 dengan tulisan "NAMA"
  $excel->setActiveSheetIndex(0)->setCellValue('G17', "PRICE"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
  $excel->setActiveSheetIndex(0)->setCellValue('I17', "AMOUNT"); // Set kolom E3 dengan tulisan "ALAMAT"
  // Apply style header yang telah kita buat tadi ke masing-masing kolom header
  $excel->getActiveSheet()->getStyle('A17')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('C17')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('E17')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('G17')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('I17')->applyFromArray($style_col);

  // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
  $sales  = $this->M_acc->get_accout($id_sale)->result();
  $detail = $this->M_acc->get_accout_detail($id_sale)->result();

  foreach($sales as $data){ }
  $excel->setActiveSheetIndex(0)->setCellValue('I11', $data->invoice);
  $excel->setActiveSheetIndex(0)->setCellValue('A12', $data->name_supplier);
  $excel->setActiveSheetIndex(0)->setCellValue('A13', $data->address);
  $excel->setActiveSheetIndex(0)->setCellValue('A14', $data->phone);

  $excel->getActiveSheet()->getStyle('I11')->getFont()->setColor( $phpColor );
  $excel->getActiveSheet()->getStyle('A12:A14')->getFont()->setColor( $phpColor );

  $excel->setActiveSheetIndex(0)->setCellValue('A19', $data->date);
  $excel->setActiveSheetIndex(0)->setCellValue('C19', "MATERIAL/ACCESSORIES");

  $excel->getActiveSheet()->getStyle('C19')->getFont()->setSize(11); // Set font size 15 untuk kolom A1
  $excel->getActiveSheet()->getStyle('C19')->getFont()->setBold(TRUE); // Set bold kolom A1
  $excel->getActiveSheet()->getStyle('A19:C19')->getFont()->setColor( $phpColor );


  $no = 1; // Untuk penomoran tabel, di awal set dengan 1
  $numrow = 21; // Set baris pertama untuk isi tabel adalah baris ke 4
  $totalqty = 0;
  foreach($detail as $data){ // Lakukan looping pada variabel siswa
    $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->name);
    $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->qty);
    $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data->harga);
    $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data->total);
    // $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow++, " ");

      // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
      // $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
      // $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
      // $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
      // $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
      // $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('C'.$numrow.':I'.$numrow)->getFont()->setColor( $phpColor );
      $excel->getActiveSheet()->getStyle('G'.$numrow)->getNumberFormat()->setFormatCode('#,##');
      $excel->getActiveSheet()->getStyle('I'.$numrow)->getNumberFormat()->setFormatCode('#,##');
      $excel->getActiveSheet()->getStyle('E'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $excel->getActiveSheet()->getStyle('G'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $no++; // Tambah 1 setiap kali looping
    $numrow++; // Tambah 1 setiap kali looping

    $totalqty=  $totalqty + $data->qty;
  }
  $baristo = $numrow+2;
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$baristo, $totalqty);
  $excel->getActiveSheet()->getStyle('E'.$baristo)->getFont()->setColor( $phpColor );
  $excel->getActiveSheet()->getStyle('E'.$baristo)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $baris = $numrow+4;
  $b1 = $baris + 2;
  $b2 = $baris + 4;
  $b3 = $baris + 7;
  $excel->getActiveSheet()->getStyle('G'.$baris)->getFont()->setBold(TRUE);
  $excel->getActiveSheet()->getStyle('G'.$b1)->getFont()->setBold(TRUE);
  $excel->getActiveSheet()->getStyle('G'.$b2)->getFont()->setBold(TRUE);
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$baris, "Subtotal");
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$b2, "TOTAL");
  $excel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $excel->getActiveSheet()->getStyle('G'.$b1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $excel->getActiveSheet()->getStyle('G'.$b2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  foreach($sales as $data){
  }

  $excel->setActiveSheetIndex(0)->setCellValue('I'.$baris, $data->total_price);

  $excel->setActiveSheetIndex(0)->setCellValue('I'.$b2, $data->final_price);
  $excel->getActiveSheet()->getStyle('I'.$baris)->getNumberFormat()->setFormatCode('#,##');
  $excel->getActiveSheet()->getStyle('I'.$b2)->getNumberFormat()->setFormatCode('#,##');

  $excel->getActiveSheet()->getStyle('I'.$baris.':I'.$b2)->getFont()->setColor( $phpColor );
  // $excel->setActiveSheetIndex(0)->setCellValue('G'.$barisqty, $data->jmlqty);

  // $sum = SUM($data->qty);
  // Set width kolom
  // Set Footer
  $b4 = $b3+1;
  $b5 = $b3+2;
  $b6 = $b3+4;
  $b7 = $b3+5;
  $b8 = $b3+6;
  $b9 = $b3+7;
  $b10 = $b3+8;
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$b3, "PAY TO");
  $excel->getActiveSheet()->getStyle('A'.$b3)->getFont()->setSize(11); // Set font size 15 untuk kolom A1
  $excel->getActiveSheet()->getStyle('A'.$b3)->getFont()->setBold(TRUE); // Set bold kolom A1
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$b4, "MARIA MONICA");
  $excel->getActiveSheet()->getStyle('A'.$b4)->getFont()->setSize(11); // Set font size 15 untuk kolom A1
  $excel->getActiveSheet()->getStyle('A'.$b4)->getFont()->setColor( $phpColor );
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$b5, "BCA/3423307460");
  $excel->getActiveSheet()->getStyle('A'.$b5)->getFont()->setSize(11); // Set font size 15 untuk kolom A1
  $excel->getActiveSheet()->getStyle('A'.$b5)->getFont()->setColor( $phpColor );
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$b6, "NOTES");
  $excel->getActiveSheet()->getStyle('A'.$b6)->getFont()->setSize(11); // Set font size 15 untuk kolom A1
  $excel->getActiveSheet()->getStyle('A'.$b6)->getFont()->setBold(TRUE); // Set bold kolom A1
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$b7, "Payment should be paid in full no later than 14 calendar days after receiving this debit note.");
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$b8, "Have a nice day and Thank you!");
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$b9, "Love, Hamako");
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$b10, "Hamako Apparel Indonesia @2018  | hamako.ecobabywear@gmail.com");
  $excel->getActiveSheet()->getStyle('A'.$b7.':A'.$b10)->getFont()->setColor( $phpColor );

  $excel->getActiveSheet()->getColumnDimension('A')->setWidth(12); // Set width kolom A
  $excel->getActiveSheet()->getColumnDimension('B')->setWidth(6); // Set width kolom B
  $excel->getActiveSheet()->getColumnDimension('C')->setWidth(34); // Set width kolom C
  $excel->getActiveSheet()->getColumnDimension('D')->setWidth(6); // Set width kolom D
  $excel->getActiveSheet()->getColumnDimension('E')->setWidth(9); // Set width kolom E
  $excel->getActiveSheet()->getColumnDimension('F')->setWidth(6); // Set width kolom F
  $excel->getActiveSheet()->getColumnDimension('G')->setWidth(12); // Set width kolom G
  $excel->getActiveSheet()->getColumnDimension('H')->setWidth(6); // Set width kolom H
  $excel->getActiveSheet()->getColumnDimension('I')->setWidth(16); // Set width kolom I

  // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
  $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
  // Set orientasi kertas jadi LANDSCAPE
  $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
  // Set judul file excel nya
  $excel->getActiveSheet(0)->setTitle("INVOICE");
  $excel->setActiveSheetIndex(0);
  // Proses file excel
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  $date = date("dmyhis");
  header('Content-Disposition: attachment; filename="HAI-INVOICE"'.$date.'".xlsx"'); // Set nama file excel nya
  header('Cache-Control: max-age=0');
  $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
  $write->save('php://output');
}

public function del_order_acc($id_sale = null){
  // Load plugin PHPExcel nya
  include APPPATH.'third_party/PHPExcel/PHPExcel.php';

  // Panggil class PHPExcel nya
  $excel = new PHPExcel();
  // Settingan awal fil excel
  $excel->getProperties()->setCreator('Delivery Order')
               ->setLastModifiedBy('Delivery Order')
               ->setTitle("Delivery Order")
               ->setSubject("Delivery Order")
               ->setDescription("Laporan Delivery Order")
               ->setKeywords("Delivery Order");
  // Buat sebuah variabel untuk menampung pengaturan style dari header tabel

  $styleArray = array(
    'font'  => array(
         'name'  => 'Arial'
     ));
  $phpColor = new PHPExcel_Style_Color();
  $phpColor->setRGB('757171');

  $style_col = array(
    'font' => array('bold' => true), // Set font nya jadi bold
    'alignment' => array(
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    )

    // 'borders' => array(
    //   'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
    //   'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
    //   'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
    //   'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    // )
  );
  // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
  $style_row = array(
    'alignment' => array(
      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ),
    'borders' => array(
      'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
      'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
      'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
      'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    )
  );
  // Menambahkan file gambar pada document excel pada kolom B2
  $objDrawing = new PHPExcel_Worksheet_Drawing();
  $objDrawing->setName('HAI');
  $objDrawing->setDescription('Logo HAI');
  $objDrawing->setPath('./assets/dist/img/hai.jpg');
  $objDrawing->setHeight(95);
  $objDrawing->setCoordinates('A1');
  $objDrawing->setWorksheet($excel->getActiveSheet());

  $excel->getDefaultStyle()->applyFromArray($styleArray);
  $excel->setActiveSheetIndex(0)->setCellValue('I1', "PT. HAMAKO APPAREL INDONESIA"); // Set kolom A1 dengan tulisan "DATA SISWA"
  $excel->setActiveSheetIndex(0)->setCellValue('I3', "www.hamakoecolife.com"); // Set kolom A1 dengan tulisan "DATA SISWA"
  $excel->setActiveSheetIndex(0)->setCellValue('I4', "www.babybudshop.com"); // Set kolom A1 dengan tulisan "DATA SISWA"
  $excel->setActiveSheetIndex(0)->setCellValue('I5', "+62811 242 625 6"); // Set kolom A1 dengan tulisan "DATA SISWA"
  $excel->setActiveSheetIndex(0)->setCellValue('I8', "DELIVERY ORDER"); // Set kolom A1 dengan tulisan "DATA SISWA"
  $excel->setActiveSheetIndex(0)->setCellValue('I10', "DO NUMBER"); // Set kolom A1 dengan tulisan "DATA SISWA"
  $excel->setActiveSheetIndex(0)->setCellValue('A10', "RECIPIENT"); // Set kolom A1 dengan tulisan "DATA SISWA"
  // $excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
  $excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(TRUE); // Set bold kolom A1
  $excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
  $excel->getActiveSheet()->getStyle('I8')->getFont()->setBold(TRUE); // Set bold kolom A1
  $excel->getActiveSheet()->getStyle('I8')->getFont()->setSize(18); // Set font size 15 untuk kolom A1
  $excel->getActiveSheet()->getStyle('I10')->getFont()->setBold(TRUE); // Set bold kolom A1
  $excel->getActiveSheet()->getStyle('I10')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
  $excel->getActiveSheet()->getStyle('A10')->getFont()->setBold(TRUE); // Set bold kolom A1
  $excel->getActiveSheet()->getStyle('A10')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
  $excel->getActiveSheet()->getStyle('I3:I5')->getFont()->setColor( $phpColor );
  $excel->getActiveSheet()->getStyle('I1:I11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); // Set text center untuk kolom A1

  // Buat header tabel nya pada baris ke 3
  $excel->setActiveSheetIndex(0)->setCellValue('A17', "DO DATE"); // Set kolom A3 dengan tulisan "NO"
  $excel->setActiveSheetIndex(0)->setCellValue('C17', "ITEM"); // Set kolom B3 dengan tulisan "NIS"
  $excel->setActiveSheetIndex(0)->setCellValue('E17', "ITEM CODE"); // Set kolom C3 dengan tulisan "NAMA"
  $excel->setActiveSheetIndex(0)->setCellValue('G17', "QTY"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
  $excel->setActiveSheetIndex(0)->setCellValue('I17', "COMMENT"); // Set kolom E3 dengan tulisan "ALAMAT"
  // Apply style header yang telah kita buat tadi ke masing-masing kolom header
  $excel->getActiveSheet()->getStyle('A17')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('C17')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('E17')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('G17')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('I17')->applyFromArray($style_col);

  // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
  $sales  = $this->M_acc->get_accout($id_sale)->result();
  $detail = $this->M_acc->get_accout_detail($id_sale)->result();
  // $sumqty = $this->M_acc->get_sum_sales($id_sale)->result();

  foreach($sales as $data){ }
  $excel->setActiveSheetIndex(0)->setCellValue('I11', $data->invoice);
  $excel->setActiveSheetIndex(0)->setCellValue('A12', $data->name_supplier);
  $excel->setActiveSheetIndex(0)->setCellValue('A13', $data->address);
  $excel->setActiveSheetIndex(0)->setCellValue('A14', $data->phone);

  $excel->getActiveSheet()->getStyle('I11')->getFont()->setColor( $phpColor );
  $excel->getActiveSheet()->getStyle('A12:A14')->getFont()->setColor( $phpColor );

  $excel->setActiveSheetIndex(0)->setCellValue('A19', $data->date);
  $excel->setActiveSheetIndex(0)->setCellValue('C19', "MATERIAL/ACCESSORIES");

  $excel->getActiveSheet()->getStyle('C19')->getFont()->setSize(11); // Set font size 15 untuk kolom A1
  $excel->getActiveSheet()->getStyle('C19')->getFont()->setBold(TRUE); // Set bold kolom A1
  $excel->getActiveSheet()->getStyle('A19:C19')->getFont()->setColor( $phpColor );


  $no = 1; // Untuk penomoran tabel, di awal set dengan 1
  $numrow = 21; // Set baris pertama untuk isi tabel adalah baris ke 4
  $totalqty = 0;
  foreach($detail as $data){ // Lakukan looping pada variabel siswa
    $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->name);
    $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->barcode);
    $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data->qty);
    // $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow++, " ");

      // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
      // $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
      // $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
      // $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
      // $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
      // $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('C'.$numrow.':I'.$numrow)->getFont()->setColor( $phpColor );
      $excel->getActiveSheet()->getStyle('G'.$numrow)->getNumberFormat()->setFormatCode('#,##');
      $excel->getActiveSheet()->getStyle('I'.$numrow)->getNumberFormat()->setFormatCode('#,##');
      $excel->getActiveSheet()->getStyle('E'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $excel->getActiveSheet()->getStyle('G'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $no++; // Tambah 1 setiap kali looping
    $numrow++; // Tambah 1 setiap kali looping

    $totalqty=  $totalqty + $data->qty;
  }
  $baristo = $numrow+2;
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$baristo, $totalqty);
  $excel->getActiveSheet()->getStyle('G'.$baristo)->getFont()->setColor( $phpColor );
  $excel->getActiveSheet()->getStyle('G'.$baristo)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$baristo, "Total");
  $excel->getActiveSheet()->getStyle('E'.$baristo)->getFont()->setBold(TRUE);
  $excel->getActiveSheet()->getStyle('G'.$baristo)->getFont()->setBold(TRUE);
  $excel->getActiveSheet()->getStyle('E'.$baristo)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $baris = $numrow+4;
  $b1 = $baris + 2;
  $b2 = $baris + 7;
  $b3 = $b2 + 1;
  $excel->setActiveSheetIndex(0)->setCellValue('I'.$b1, "RECEIVED BY");
  $excel->getActiveSheet()->getStyle('I'.$b1)->getFont()->setBold(TRUE);
  $excel->setActiveSheetIndex(0)->setCellValue('I'.$b2, "Name:");
  $excel->setActiveSheetIndex(0)->setCellValue('I'.$b3, "Date:");

  $excel->getActiveSheet()->getStyle('I'.$b2)->getFont()->setColor( $phpColor );
  $excel->getActiveSheet()->getStyle('I'.$b3)->getFont()->setColor( $phpColor );

  $b4 = $b3+1;
  $b5 = $b3+2;
  $b6 = $b3+4;
  $b7 = $b3+5;
  $b8 = $b3+6;
  $b9 = $b3+7;
  $b10 = $b3+8;
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$b4, "NOTE");
  $excel->getActiveSheet()->getStyle('A'.$b4)->getFont()->setSize(11); // Set font size 15 untuk kolom A1
  $excel->getActiveSheet()->getStyle('A'.$b4)->getFont()->setBold(TRUE); // Set bold kolom A1
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$b5, "Please always check the item with our DO. Any enquires, please contact us via WA  at +62811 242 625 6 ");
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$b6, "Have a nice day and Thank you!");
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$b7, "Love, Hamako");
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$b8, "Hamako Apparel Indonesia @2018  | hamako.ecobabywear@gmail.com");
  $excel->getActiveSheet()->getStyle('A'.$b5.':A'.$b9)->getFont()->setColor( $phpColor );

  $excel->getActiveSheet()->getColumnDimension('A')->setWidth(12); // Set width kolom A
  $excel->getActiveSheet()->getColumnDimension('B')->setWidth(6); // Set width kolom B
  $excel->getActiveSheet()->getColumnDimension('C')->setWidth(34); // Set width kolom C
  $excel->getActiveSheet()->getColumnDimension('D')->setWidth(6); // Set width kolom D
  $excel->getActiveSheet()->getColumnDimension('E')->setWidth(9); // Set width kolom E
  $excel->getActiveSheet()->getColumnDimension('F')->setWidth(6); // Set width kolom F
  $excel->getActiveSheet()->getColumnDimension('G')->setWidth(12); // Set width kolom G
  $excel->getActiveSheet()->getColumnDimension('H')->setWidth(6); // Set width kolom H
  $excel->getActiveSheet()->getColumnDimension('I')->setWidth(16); // Set width kolom I

  // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
  $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
  // Set orientasi kertas jadi LANDSCAPE
  $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
  // Set judul file excel nya
  $excel->getActiveSheet(0)->setTitle("Debit Note");
  $excel->setActiveSheetIndex(0);
  // Proses file excel
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  $date = date("dmyhis");
  header('Content-Disposition: attachment; filename="HAI-DeliveryOrderMaterial"'.$date.'".xlsx"'); // Set nama file excel nya
  header('Cache-Control: max-age=0');
  $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
  $write->save('php://output');
}



  public function lap_out(){
    // Load plugin PHPExcel nya
  include APPPATH.'third_party/PHPExcel/PHPExcel.php';

  // Panggil class PHPExcel nya
  $excel = new PHPExcel();
  // Settingan awal fil excel
  $excel->getProperties()->setCreator('Aksesoris Keluar')
              ->setLastModifiedBy('Aksesoris Keluar')
              ->setTitle("Aksesoris Keluar")
              ->setSubject("Aksesoris Keluar")
              ->setDescription("Laporan Aksesoris Keluar")
              ->setKeywords("Aksesoris Keluar");
  // Buat sebuah variabel untuk menampung pengaturan style dari header tabel

  $styleArray = array(
    'font'  => array(
        'name'  => 'Arial'
    ));
  $phpColor = new PHPExcel_Style_Color();
  $phpColor->setRGB('757171');

  $style_col = array(
    'font' => array('bold' => true), // Set font nya jadi bold
    'alignment' => array(
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ),
    'borders' => array(
      'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
      'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
      'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
      'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    )
  );

  // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
  $style_row = array(
    'alignment' => array(
      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ),
    'borders' => array(
      'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
      'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
      'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
      'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    )
  );

  // Menambahkan file gambar pada document excel pada kolom B2
  $objDrawing = new PHPExcel_Worksheet_Drawing();
  $objDrawing->setName('HAI');
  $objDrawing->setDescription('Logo HAI');
  $objDrawing->setPath('./assets/dist/img/hai.jpg');
  $objDrawing->setHeight(70);
  $objDrawing->setCoordinates('A1');
  $objDrawing->setWorksheet($excel->getActiveSheet());

  $excel->getDefaultStyle()->applyFromArray($styleArray);
  $excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN AKSESORIS KELUAR");
  $excel->getActiveSheet()->mergeCells('A1:D3');
  $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
  $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
  $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

  $excel->setActiveSheetIndex(0)->setCellValue('A5', "Periode: ");
  $excel->getActiveSheet()->getStyle('A5:A7')->getFont()->setBold(TRUE);
  $tgl_awal = $this->input->post('tgl_awal');
  $tgl_akhir = $this->input->post('tgl_akhir');
  $format = 'dd/mm/yyyy';

  $excel->setActiveSheetIndex(0)->setCellValue('B5', $tgl_awal."-".$tgl_akhir);
  // Buat header tabel nya pada baris ke 3
  $excel->setActiveSheetIndex(0)->setCellValue('A7', "NO");
  $excel->setActiveSheetIndex(0)->setCellValue('B7', "BARCODE");
  $excel->setActiveSheetIndex(0)->setCellValue('C7', "NAME PRODUCT");
  $excel->setActiveSheetIndex(0)->setCellValue('D7', "QTY");
  // Apply style header yang telah kita buat tadi ke masing-masing kolom header
  $excel->getActiveSheet()->getStyle('A7')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('B7')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('C7')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('D7')->applyFromArray($style_col);


  $daccout= $this->M_acc->get_accoutbydate()->result();
  $no = 1; // Untuk penomoran tabel, di awal set dengan 1
  $numrow = 8; // Set baris pertama untuk isi tabel adalah baris ke 4

  foreach($daccout as $data){ // Lakukan looping pada variabel siswa
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
    $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->barcode);
    $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->name);
    $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->total);

    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
    $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);


    $no++; // Tambah 1 setiap kali looping
    $numrow++; // Tambah 1 setiap kali looping
  }

  $excel->getActiveSheet()->getColumnDimension('A')->setWidth(10); // Set width kolom A
  $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
  $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30); // Set width kolom C
  $excel->getActiveSheet()->getColumnDimension('D')->setWidth(12); // Set width kolom D

  // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
  $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
  // Set orientasi kertas jadi LANDSCAPE
  $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
  // Set judul file excel nya
  $excel->getActiveSheet(0)->setTitle("Aksesoris Keluar");
  $excel->setActiveSheetIndex(0);
  // Proses file excel
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  $date = date("dmyhis");
  header('Content-Disposition: attachment; filename="Laporan Aksesoris Keluar"'.$date.'".xlsx"'); // Set nama file excel nya
  header('Cache-Control: max-age=0');
  $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
  $write->save('php://output');
  }



  public function lap_allin(){
    // Load plugin PHPExcel nya
  include APPPATH.'third_party/PHPExcel/PHPExcel.php';

  // Panggil class PHPExcel nya
  $excel = new PHPExcel();
  // Settingan awal fil excel
  $excel->getProperties()->setCreator('Aksesoris Masuk')
              ->setLastModifiedBy('Aksesoris Masuk')
              ->setTitle("Aksesoris Masuk")
              ->setSubject("Aksesoris Masuk")
              ->setDescription("Laporan Aksesoris Masuk")
              ->setKeywords("Aksesoris Masuk");
  // Buat sebuah variabel untuk menampung pengaturan style dari header tabel

  $styleArray = array(
    'font'  => array(
        'name'  => 'Arial'
    ));
  $phpColor = new PHPExcel_Style_Color();
  $phpColor->setRGB('757171');

  $style_col = array(
    'font' => array('bold' => true), // Set font nya jadi bold
    'alignment' => array(
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ),
    'borders' => array(
      'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
      'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
      'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
      'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    )
  );

  // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
  $style_row = array(
    'alignment' => array(
      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ),
    'borders' => array(
      'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
      'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
      'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
      'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    )
  );

  // Menambahkan file gambar pada document excel pada kolom B2
  $objDrawing = new PHPExcel_Worksheet_Drawing();
  $objDrawing->setName('HAI');
  $objDrawing->setDescription('Logo HAI');
  $objDrawing->setPath('./assets/dist/img/hai.jpg');
  $objDrawing->setHeight(70);
  $objDrawing->setCoordinates('A1');
  $objDrawing->setWorksheet($excel->getActiveSheet());

  $excel->getDefaultStyle()->applyFromArray($styleArray);
  $excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN AKSESORIS MASUK");
  $excel->getActiveSheet()->mergeCells('A1:D3');
  $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
  $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
  $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

  $excel->setActiveSheetIndex(0)->setCellValue('A5', "Periode: ");
  $excel->getActiveSheet()->getStyle('A5:A7')->getFont()->setBold(TRUE);
  $tgl_awal = $this->input->post('tgl_awal');
  $tgl_akhir =  $this->input->post('tgl_akhir');



  $excel->setActiveSheetIndex(0)->setCellValue('B5', $tgl_awal);
  $excel->setActiveSheetIndex(0)->setCellValue('c5', $tgl_akhir);
  // Buat header tabel nya pada baris ke 3
  $excel->setActiveSheetIndex(0)->setCellValue('A7', "NO");
  $excel->setActiveSheetIndex(0)->setCellValue('B7', "BARCODE");
  $excel->setActiveSheetIndex(0)->setCellValue('C7', "NAME PRODUCT");
  $excel->setActiveSheetIndex(0)->setCellValue('D7', "QTY");
  // Apply style header yang telah kita buat tadi ke masing-masing kolom header
  $excel->getActiveSheet()->getStyle('A7')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('B7')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('C7')->applyFromArray($style_col);
  $excel->getActiveSheet()->getStyle('D7')->applyFromArray($style_col);
  // $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_row)->getNumberFormat()->setFormatCode('dd-mm-yyyy');


  $daccin= $this->M_accin->get_accinbydate()->result();
  $no = 1; // Untuk penomoran tabel, di awal set dengan 1
  $numrow = 8; // Set baris pertama untuk isi tabel adalah baris ke 4

  foreach($daccin as $data){ // Lakukan looping pada variabel siswa
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
    $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->barcode);
    $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->name);
    $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->total);

    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
    $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);


    $no++; // Tambah 1 setiap kali looping
    $numrow++; // Tambah 1 setiap kali looping
  }

  $excel->getActiveSheet()->getColumnDimension('A')->setWidth(10); // Set width kolom A
  $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
  $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30); // Set width kolom C
  $excel->getActiveSheet()->getColumnDimension('D')->setWidth(12); // Set width kolom D

  // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
  $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
  // Set orientasi kertas jadi LANDSCAPE
  $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
  // Set judul file excel nya
  $excel->getActiveSheet(0)->setTitle("Aksesoris Keluar");
  $excel->setActiveSheetIndex(0);
  // Proses file excel
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  $date = date("dmyhis");
  header('Content-Disposition: attachment; filename="Laporan Aksesoris Masuk"'.$date.'".xlsx"'); // Set nama file excel nya
  header('Cache-Control: max-age=0');
  $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
  $write->save('php://output');
  }


    public function report_in($id = null){
      // Load plugin PHPExcel nya
    include APPPATH.'third_party/PHPExcel/PHPExcel.php';

    // Panggil class PHPExcel nya
    $excel = new PHPExcel();
    // Settingan awal fil excel
    $excel->getProperties()->setCreator('Aksesoris Masuk')
                ->setLastModifiedBy('Aksesoris Masuk')
                ->setTitle("Aksesoris Masuk")
                ->setSubject("Aksesoris Masuk")
                ->setDescription("Laporan Aksesoris Masuk")
                ->setKeywords("Aksesoris Masuk");
    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel

    $styleArray = array(
      'font'  => array(
          'name'  => 'Arial'
      ));
    $phpColor = new PHPExcel_Style_Color();
    $phpColor->setRGB('757171');

    $style_col = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );

    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $style_row = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );

    // Menambahkan file gambar pada document excel pada kolom B2
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('HAI');
    $objDrawing->setDescription('Logo HAI');
    $objDrawing->setPath('./assets/dist/img/hai.jpg');
    $objDrawing->setHeight(70);
    $objDrawing->setCoordinates('A1');
    $objDrawing->setWorksheet($excel->getActiveSheet());

    $excel->getDefaultStyle()->applyFromArray($styleArray);
    $excel->setActiveSheetIndex(0)->setCellValue('A1', "AKSESORIS MASUK");
    $excel->getActiveSheet()->mergeCells('A1:D3');
    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
    $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
    $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

    $excel->setActiveSheetIndex(0)->setCellValue('A5', "Ref : ");
    $excel->setActiveSheetIndex(0)->setCellValue('A6', "No SJ : ");
    $excel->setActiveSheetIndex(0)->setCellValue('A7', "Supplier : ");
    $excel->getActiveSheet()->getStyle('A5:A7')->getFont()->setBold(TRUE);

    $accin = $this->M_accin->get_accin($id)->result();
    foreach($accin as $topbm){}

    $excel->setActiveSheetIndex(0)->setCellValue('B5', $topbm->ref);
    $excel->setActiveSheetIndex(0)->setCellValue('B6', $topbm->surat_jalan);
    $excel->setActiveSheetIndex(0)->setCellValue('B7', $topbm->name_supplier);
    // Buat header tabel nya pada baris ke 3
    $excel->setActiveSheetIndex(0)->setCellValue('A9', "NO");
    $excel->setActiveSheetIndex(0)->setCellValue('B9', "BARCODE");
    $excel->setActiveSheetIndex(0)->setCellValue('C9', "NAME PRODUCT");
    $excel->setActiveSheetIndex(0)->setCellValue('D9', "QTY");
    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    $excel->getActiveSheet()->getStyle('A9')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('B9')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('C9')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('D9')->applyFromArray($style_col);


    $daccin   = $this->M_accin->get_accin_detail($id)->result();
    $no = 1; // Untuk penomoran tabel, di awal set dengan 1
    $numrow = 10; // Set baris pertama untuk isi tabel adalah baris ke 4

    foreach($daccin as $data){ // Lakukan looping pada variabel siswa
      $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
      $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->barcode);
      $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->name);
      $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->qty);

      // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
      $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);


      $no++; // Tambah 1 setiap kali looping
      $numrow++; // Tambah 1 setiap kali looping
    }
    $numrow1 = $numrow+3;
    $qty = $this->M_accin->qtydetail($id)->result();
    $excel->setActiveSheetIndex()->setCellValue('C'.$numrow1,'Total');
    foreach($qty as $qty){}
    $excel->setActiveSheetIndex()->setCellValue('D'.$numrow1,$qty->qty);

    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(10); // Set width kolom A
    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30); // Set width kolom C
    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(12); // Set width kolom D

    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
    // Set orientasi kertas jadi LANDSCAPE
    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    // Set judul file excel nya
    $excel->getActiveSheet(0)->setTitle("Aksesoris Keluar");
    $excel->setActiveSheetIndex(0);
    // Proses file excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $date = date("dmyhis");
    header('Content-Disposition: attachment; filename="Laporan Aksesoris Masuk"'.$date.'".xlsx"'); // Set nama file excel nya
    header('Cache-Control: max-age=0');
    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $write->save('php://output');
    }


}
