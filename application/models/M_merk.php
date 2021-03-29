<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class M_merk extends CI_Model
{
  public function get($id = null){
    $this->db->from('t_merk');
    if($id !=null) {
      $this->db->where('id_merk',$id);
    }
    $query = $this->db->get();
    return $query;

  }

  public function add($post) {
    $params = [
      'name_merk' => $post['name_merk'],
    ];
    $this->db->insert('t_merk',$params);
  }

  public function update($post) {
    $params = [
      'name_merk' => $post['name_merk'],
      'merk_updated' => date('Y-m-d H:i:s')
    ];
    $this->db->where('id_merk',$post['id_merk']);
    $this->db->update('t_merk',$params);
  }

  public function delete($id) {
  		$this->db->where('id_merk',$id);
  		$this->db->delete('t_merk');
  }

}


?>
