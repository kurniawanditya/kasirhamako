<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class M_material extends CI_Model
{

  function get_all_item(){
    $this->datatables->select('id_item_acc,barcode,name,warna,jenis_acc,harga,stok,ket');
    $this->datatables->from('t_item_acc');
    $this->datatables->add_column('view', '<a href="javascript:void(0);" class="btn btn-success edit_record" 
    data-kode="$1" data-barcode="$2" data-name="$3" data-warna="$4" 
    data-jenis_acc="$5" data-harga="$6" data-stok="$7" data-ket="$8"><i class="fa fa-pencil"></i> </a>  
    <a href="javascript:void(0);" class="btn btn-danger btn xs" data-kode="$1"><i class="fa fa-trash"></i> </a>',
    'id_item_acc,barcode,name,warna,jenis_acc,harga,stok,ket');
    return $this->datatables->generate();
  }


  public function get($id = null){
    $this->db->from('t_item_acc');
    if($id !=null) {
      $this->db->where('id_item_acc',$id);
    }
    $query = $this->db->get();
    return $query;
  }


  
  public function getbyfilter($merk = null){
    $this->db->from('t_item as A');
    $this->db->join('t_jenis as B','B.id_jenis=A.jenis');
    $this->db->join('t_merk as C','C.id_merk=A.merk');
    $this->db->join('t_koleksi as D','D.id_koleksi=A.koleksi');
    // if($merk == 1){
    //   $this->db->where('A.merk','1');
    // }
    // else if($merk == 2) {
    //   $this->db->where('A.merk','2');
    // }
    if($merk != null){
        $this->db->where('A.merk',$merk);
      }
    $query = $this->db->get();
    return $query;
  }


  public function add($post) {
    $params = [
      'barcode'     => $post['barcode'],
      'name'        => $post['name'],
      'jenis'       => $post['jenis'],
      'merk'        => $post['merk'],
      'koleksi'     => $post['koleksi'],
      'hpp'         => $post['hpp'],
      'fob'         => $post['fob'],
    ];
    $this->db->insert('t_item',$params);
  }

  public function update($post) {
    $params = [
      'barcode'     => $post['barcode'],
      'name'        => $post['name'],
      'jenis'    => $post['jenis'],
      'merk'     => $post['merk'],
      'koleksi'  => $post['koleksi'],
      'hpp'         => $post['hpp'],
      'fob'         => $post['fob'],
      'itemupdated'     => date('Y-m-d H:i:s')
    ];
    $this->db->where('id_item',$post['id_item']);
    $this->db->update('t_item',$params);
  }

  public function delete($id) {
  		$this->db->where('id_item',$id);
  		$this->db->delete('t_item');
  }

  public function update_stock_in($data)
  {
    $qty  = $data['qty'];
    $id   = $data['id_item'];
    $sql  = "UPDATE t_item SET stock = stock + '$qty' WHERE id_item = '$id'";
    $this->db->query($sql);

  }

  public function getdata(){
    $this->db->from('t_item');
    $query = $this->db->get();
    return $query;
  }

}


?>
