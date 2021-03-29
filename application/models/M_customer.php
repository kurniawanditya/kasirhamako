<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class M_customer extends CI_Model
{

  public function get($id = null){
    $this->db->from('t_customer');
    if($id !=null) {
      $this->db->where('id_customer',$id);
    }
    $query = $this->db->get();
    return $query;

  }

  public function add($post) {
    $params = [
      'name_customer' => $post['name_customer'],
      'address'=> $post['address'],
      'phone'=> $post['phone'],
    ];
    $this->db->insert('t_customer',$params);
  }

  public function update($post) {
    $params = [
      'name_customer' => $post['name_customer'],
      'address'=> $post['address'],
      'phone'=> $post['phone'],
      'updated' => date('Y-m-d H:i:s')
    ];
    $this->db->where('id_customer',$post['id_customer']);
    $this->db->update('t_customer',$params);
  }

  public function delete($id) {
  		$this->db->where('id_customer',$id);
  		$this->db->delete('t_customer');
  }


  function get_prov(){
    $hasil=$this->db->query("SELECT * FROM wilayah_provinsi");
    return $hasil;
  }

  function get_kab($id){
      $hasil=$this->db->query("SELECT * FROM wilayah_kabupaten WHERE provinsi_id='$id'");
      return $hasil->result();
  }

  function get_kec($id){
      $hasil=$this->db->query("SELECT * FROM wilayah_kecamatan WHERE kabupaten_id='$id'");
      return $hasil->result();
  }

}


?>
