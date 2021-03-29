<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class M_item extends CI_Model
{

  function get_all_item(){
    $this->datatables->select('*,a.id_item, a.barcode, a.name, a.jenis,a.merk,a.koleksi, c.name_merk, a.hpp, a.fob, d.name_koleksi,a.stock');
    $this->datatables->from('t_item as a');
    $this->datatables->join('t_jenis as b','b.id_jenis=a.jenis');
    $this->datatables->join('t_merk as c','c.id_merk=a.merk');
    $this->datatables->join('t_koleksi as d','d.id_koleksi=a.koleksi');
    $this->datatables->where('a.status',1);
    $this->datatables->add_column('view', '
    <button id="detail" data-target="#modal-history" data-toggle="modal" class="btn btn-default" data-item="$1"> <i class="fa fa-history"></i></button>
    <a href="javascript:void(0);" class="btn btn-success edit_record" data-kode="$1" data-barcode="$2" 
    data-name="$3" data-jenis="$4" data-merk="$5" data-hpp="$6" data-fob="$7" data-koleksi="$8" data-stock="$9">  <i class="fa fa-pencil"></i> </a>    
    <a href="Item/delete/$1" onclick="return confirm(Yakin Hapus Data?)" class="btn btn-danger btn xs" data-kode="$1"><i class="fa fa-trash"></i> </a>','id_item,barcode,name,jenis,merk,hpp,fob,koleksi,stock');
    return $this->datatables->generate();
  }


  public function get($id = null){
    $this->db->from('t_item as A');
    $this->db->join('t_jenis as B','B.id_jenis=A.jenis');
    $this->db->join('t_merk as C','C.id_merk=A.merk');
    $this->db->join('t_koleksi as D','D.id_koleksi=A.koleksi');
    if($id !=null) {
      $this->db->where('id_item',$id);
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

  public function getdata($id = null){
    $this->db->from('t_item as A');
    $this->db->join('t_jenis as B','B.id_jenis=A.jenis');
    $this->db->join('t_merk as C','C.id_merk=A.merk');
    $this->db->join('t_koleksi as D','D.id_koleksi=A.koleksi');
    if($id !=null) {
      $this->db->where('koleksi',$id);
    }
    $query = $this->db->get();
    return $query;
  }

}


?>
