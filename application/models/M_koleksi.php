<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class M_koleksi extends CI_Model
{
  public function get($id = null){
    $this->db->from('t_koleksi');
    if($id !=null) {
      $this->db->where('id_koleksi',$id);
    }
    $query = $this->db->get();
    return $query;

  }

  public function add($post) {
    $params = [
      'name_koleksi' => $post['name_koleksi'],
      'koleksi_merk' => $post['id_merk']
    ];
    $this->db->insert('t_koleksi',$params);
  }

  public function update($post) {
    $params = [
      'name_koleksi' => $post['name_koleksi'],
      'koleksi_merk' => $post['id_merk'],
      'koleksi_updated' => date('Y-m-d H:i:s')
    ];
    $this->db->where('id_koleksi',$post['id_koleksi']);
    $this->db->update('t_koleksi',$params);
  }

  public function delete($id) {
  		$this->db->where('id_koleksi',$id);
  		$this->db->delete('t_koleksi');
  }

}


?>
